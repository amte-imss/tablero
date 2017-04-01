<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Reportes_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function get_filtros_reportes($key = null) {
        $array_result = array(
            'select' => array(
                'año' => array("date_part('year',implementaciones.fecha_inicio) as año"),
                'mes' => array("date_part('year',implementaciones.fecha_inicio) as año",
                    "date_part('month'::text, implementaciones.fecha_inicio) as mes_cve",
                    "(select nombre from catalogos.meses where id_mes = date_part('month'::text, implementaciones.fecha_inicio)) mes"
                ),
                'trimestre' => array("date_part('year',implementaciones.fecha_inicio) as año",
                    "date_part('QUARTER'::text, implementaciones.fecha_inicio) as trimestre_cve",
                    "(select periodo trimestre from catalogos.trimestres where id_trimestre = date_part('QUARTER'::text, implementaciones.fecha_inicio)) trimestre"
                ),
            ),
            'group_by' => array(
                'año' => array("date_part('year',implementaciones.fecha_inicio)"),
                'mes' => array("date_part('year',implementaciones.fecha_inicio)",
                    "date_part('month'::text, implementaciones.fecha_inicio)",
                    "mes"
                ),
                'trimestre' => array("date_part('year',implementaciones.fecha_inicio)",
                    "date_part('QUARTER'::text, implementaciones.fecha_inicio)",
                    "trimestre"
                ),
            ),
            'order_by' => array(
                'año' => array('año'),
                'mes' => array('mes_cve'),
                'trimestre' => array('trimestre_cve'),
//                'mes' => array(),
//                'trimestre' => array(),
            ),
        );
        if (is_null($key)) {//Retorna todos los permisos
            return $array_result;
        } else {
            if (isset($array_result[$key])) {//Verifica que exista la llave
                return $array_result[$key]; //Retorna el permiso asociado
            }
            return null; //No existe la llave, retorna null
        }
    }

    /**
     * @author LEAS
     * @fecha 24/03/2016
     * @param type $key
     * @return array
     */
    public function get_reportes_indexados($key = null) {
        $array_result = array(
            'alumnos_inscritos' => array('funcion' => 'get_resumen_alumnos_regiones_delegacion', 'select_especifico' => array('SUM( hechos_implementaciones_alumnos.cantidad_alumnos_inscritos) AS datos')),
            'alumnos_certificados' => array('funcion' => 'get_resumen_alumnos_regiones_delegacion', 'select_especifico' => array('SUM( hechos_implementaciones_alumnos.cantidad_alumnos_certificados) AS  datos')),
            'cursos_impartidos' => array('funcion' => 'get_resumen_cursos_impartidos_regiones_delegacion', 'select_especifico' => array('count(c.id_curso) datos')),
            'docentes' => array('funcion' => 'get_resumen_cantidad_docentes_regiones_delegacion', 'select_especifico' => array('sum(hid.cantidad_profesores) as datos')),
        );

        if (is_null($key)) {//Retorna todos los permisos
            return $array_result;
        } else {
            if (isset($array_result[$key])) {//Verifica que exista la llave
                return $array_result[$key]; //Retorna el permiso asociado
            }
            return null; //No existe la llave, retorna null
        }
    }

    /**
     * 
     * @param type $key tipo de mapa, constante "En_tipomapa", si es null 
     * regresa todo el array de configuraciones 
     * @return propiedades por grafico 
     */
    public function get_propiedades_tipo_grafico($key = null) {
        $array_result = array(
            En_tipomapa::REGION => array('key_default' => 'regiones.clave_regional', 'key_default_alias' => 'clave_regional'),
            En_tipomapa::DELEGACION => array('key_default' => 'delegaciones.clave_delegacional', 'key_default_alias' => 'clave_delegacional'),
            En_tipomapa::UMAE => array('key_default' => 'unidades_instituto.clave_unidad', 'key_default_alias' => 'clave_unidad', 'key_extras' => array('unidades_instituto.umae' => true)),
            En_tipomapa::UNIDAD => array('key_default' => 'unidades_instituto.clave_unidad', 'key_default_alias' => 'clave_unidad', 'key_extras' => array('unidades_instituto.umae' => FALSE)),
        );
        if (is_null($key)) {//Retorna todos los permisos
            return $array_result;
        } else {
            if (isset($array_result[$key])) {//Verifica que exista la llave
                return $array_result[$key]; //Retorna el permiso asociado
            }
            return null; //No existe la llave, retorna null
        }
    }

    /**
     * @author LEAS
     * @param type $param Condiciones para buscar resumen de regiones
     * @return type
     */
    public function get_resumen_alumnos_regiones_delegacion($param = null, $propiedades_query, $is_id = FALSE) {
//        $this->load->model('Reportes_model', 'rm');
//        $this->rm->get
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $this->db->where('((NOT (categorias.id_grupo_categoria  IS NULL)) AND (NOT (hechos_implementaciones_alumnos.id_sexo  IS NULL)))');
        foreach ($propiedades_query['group_by'] as $value) {
            $this->db->group_by($value);
        }
        foreach ($propiedades_query['order_by'] as $value) {
            $this->db->order_by($value);
        }


        if (isset($propiedades_query['marge_select'])) {
            $select = array(
                'SUM( hechos_implementaciones_alumnos.cantidad_alumnos_inscritos) AS  cantidad_alumnos_inscritos',
                'SUM( hechos_implementaciones_alumnos.cantidad_alumnos_certificados) AS  cantidad_alumnos_certificados'
            );
            if (isset($propiedades_query['select'])) {
                $select = array_merge($select, $propiedades_query['select']);
            }
        } else {
            $select = $propiedades_query['select']; //Se vuelve select
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_alumnos hechos_implementaciones_alumnos');
        $this->db->join('catalogos.unidades_instituto unidades_instituto', 'hechos_implementaciones_alumnos.id_unidad_instituto  =  unidades_instituto.id_unidad_instituto');
        $this->db->join('catalogos.categorias categorias', 'hechos_implementaciones_alumnos.id_categoria = categorias.id_categoria');
        $this->db->join('catalogos.implementaciones implementaciones', '(hechos_implementaciones_alumnos.id_implementacion = implementaciones.id_implementacion)');
        $this->db->join('catalogos.delegaciones delegaciones', 'unidades_instituto.id_delegacion = delegaciones.id_delegacion');
        $this->db->join('catalogos.regiones regiones', 'delegaciones.id_region = regiones.id_region');

        $query = $this->db->get();
//        pr($this->db->last_query());
        $res = $query->result_array();
        if ($is_id and ! empty($res)) {
            $res = $res[0];
        }
        return $res;
    }

    /**
     * @author LEAS
     * @param type $param Condiciones para buscar resumen de regiones
     * @return type
     */
    public function get_resumen_cursos_impartidos_regiones_delegacion($param = null, $propiedades_query, $is_id = FALSE) {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        //Importante validar que existan categorias de los docentes
        $this->db->where('(NOT (categorias.id_grupo_categoria IS NULL))', null);

        if (isset($propiedades_query['marge_select'])) {
            $select = array(
                'count(c.id_curso) cantidad_cursos',
            );
            if (isset($propiedades_query['select'])) {
                $select = array_merge($select, $propiedades_query['select']);
            }
        } else {
            $select = $propiedades_query['select']; //Se vuelve select
        }

        foreach ($propiedades_query['group_by'] as $value) {
            $this->db->group_by($value);
        }
        foreach ($propiedades_query['order_by'] as $value) {
            $this->db->order_by($value);
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_alumnos hia');
        $this->db->join('catalogos.implementaciones implementaciones', 'implementaciones.id_implementacion = hia.id_implementacion');
        $this->db->join('catalogos.cursos c', 'c.id_curso = implementaciones.id_curso');
        $this->db->join('catalogos.unidades_instituto unidades_instituto', 'unidades_instituto.id_unidad_instituto = hia.id_unidad_instituto');
        $this->db->join('catalogos.categorias categorias', 'hia.id_categoria = categorias.id_categoria');
        $this->db->join('catalogos.delegaciones delegaciones', 'delegaciones.id_delegacion = unidades_instituto.id_delegacion');
        $this->db->join('catalogos.regiones regiones', 'regiones.id_region = delegaciones.id_region');

        $query = $this->db->get();
//        pr($this->db->last_query());
        $res = $query->result_array();
        if ($is_id and ! empty($res)) {
            $res = $res[0];
        }
        return $res;
    }

    /**
     * @author LEAS
     * @param type $param Condiciones para buscar resumen de regiones
     * @return type
     */
    public function get_resumen_cantidad_docentes_regiones_delegacion($param = null, $propiedades_query, $is_id = FALSE) {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        if (isset($propiedades_query['marge_select'])) {
            $select = array(
                'sum(hid.cantidad_profesores) as cantidad_docentes',
            );
            if (isset($propiedades_query['select'])) {
                $select = array_merge($select, $propiedades_query['select']);
            }
        } else {
            $select = $propiedades_query['select']; //Se vuelve select
        }

        foreach ($propiedades_query['group_by'] as $value) {
            $this->db->group_by($value);
        }
        foreach ($propiedades_query['order_by'] as $value) {
            $this->db->order_by($value);
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_docentes hid');
        $this->db->join('catalogos".implementaciones implementaciones', '(hid.id_implementacion = implementaciones.id_implementacion)');
        $this->db->join('catalogos.unidades_instituto unidades_instituto', 'unidades_instituto.id_unidad_instituto = hid.id_unidad_instituto');
        $this->db->join('catalogos.delegaciones delegaciones', 'delegaciones.id_delegacion = unidades_instituto.id_delegacion');
        $this->db->join('catalogos.regiones regiones', 'regiones.id_region = delegaciones.id_region');

        $query = $this->db->get();
//        pr($this->db->last_query());
        $res = $query->result_array();
        if ($is_id and ! empty($res)) {
            $res = $res[0];
        }
        return $res;
    }

    public function get_accesos_comparativa($parametros) {
        $control_acceso = new Control_acceso();
        return $control_acceso->get_accesos_datos($parametros);
    }

    public function get_aplica_tipo_unidad_resumen($servc) {
        $servicios = $this->session->userdata('servicios');
        if (isset($servicios[$servc])) {
            $serv_config = $servicios[$servc]['conf_servicio_acceso'];
            $reglas_acceso = get_array_config_permisos($serv_config);
            $caracter_configurador = $reglas_acceso['conf'];
            if (isset($reglas_acceso[$caracter_configurador . 'u'])) {//Valida tipo de unidad
//            pr($reglas_acceso);
                $patron_u = $reglas_acceso[$caracter_configurador . 'u'];
                $patron_r = $reglas_acceso[$caracter_configurador . 'r'];
                //Agrega tipo de unidad
                $array_res[$patron_r] = $this->session->userdata('usuario')[$patron_u]; //Agrega condicion para filtrar por delegación, región, umae o unidad
                if (empty($array_res[$patron_r])) {//Valida que el usuario cuente con un tipo de unidad, si es vacia, retorna null  
                    $array_res = null;
                }
            } else {//No valida el tipo
                $array_res = array();
            }
            return $array_res;
//            pr($array_res);
        }
        return null; //Null que indica sin acceso
    }

}

class Control_acceso extends Reportes_model {

    const
            METRICA = 'reporte',
            DIMENSION = 'periodo'

    ;

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_accesos_datos($parametros) {
//        pr($parametros    );
        $servicio = $parametros['servicio']; //Servicio que invoco
//        pr($servicio);
        $propiedades['prop_tipo_mapa'] = $this->get_propiedades_tipo_grafico($parametros['tipo_grafico']); //Claves para consultas por región, delegación, umae o unidad
        $propiedades['filtros'] = $this->get_filtros_reportes(); //Select, group_by y order_by para las consultas
        $propiedades['reportes_indexados'] = $this->get_reportes_indexados(); //Funciones accesos
        $propiedades['permisos'] = get_array_config_permisos($servicio['conf_servicio_acceso']); //Funciones accesos
//        pr($propiedades);
//        pr($propiedades['permisos']);
//        $select_permisos = array();
        $conf = $propiedades['permisos']['conf'];
        $ejecuta_busqueda = TRUE;
//        pr($propiedades['permisos']);
//        pr($this->session->userdata('usuario'));
        if (isset($propiedades['permisos'][$conf . 'u'])) {//Valida tipo de unidad
            $patron_u = $propiedades['permisos'][$conf . 'u'];
            $patron_r = $propiedades['permisos'][$conf . 'r'];
            $param[$patron_r] = $this->session->userdata('usuario')[$patron_u]; //Agrega condicion para filtrar por delegación, región, umae o unidad
//            pr($param);
            if (empty($param[$patron_r])) {
                $ejecuta_busqueda = FALSE;
            }
        }
        if ($ejecuta_busqueda) {
            //Genera los valores a consultar 
            $param_where = '';
            $separador = '';
            foreach ($parametros['post']['series'] as $value) {
                $param_where .= $separador . "'" . $value . "'";
                $separador = ',';
            }
            $cons_consulta = $propiedades['prop_tipo_mapa']['key_default'];
            $where_in = $cons_consulta . " in(" . $param_where . ")";
//                $param[$propiedades['prop_tipo_mapa']['key_default']] = $value; //Agrega condicion para filtrar por delegación, región, umae o unidad
            $param[$where_in] = null; //Agrega condicion para filtrar por delegación, región, umae o unidad
            if (isset($propiedades['prop_tipo_mapa']['key_extras'])) {//Agrega condiciones extra como si es umae o tipo de unidad etc
                $param = array_merge($param, $propiedades['prop_tipo_mapa']['key_extras']); //Agrega condicion para filtrar por delegación, región, umae o unidad
            }
//            $filtros_tmp['select'] = $propiedades_filtros['select'][$data_post['dimension']];
            $filtros_tmp['select'] = array_merge($propiedades['reportes_indexados'][$parametros['post'][Control_acceso::METRICA]]['select_especifico'], $propiedades['filtros']['select'][$parametros['post'][Control_acceso::DIMENSION]]);
            $filtros_tmp['select'][] = $cons_consulta;
            $filtros_tmp['group_by'] = $propiedades['filtros']['group_by'][$parametros['post'][Control_acceso::DIMENSION]];
            $filtros_tmp['group_by'][] = $cons_consulta;
            $filtros_tmp['order_by'] = $propiedades['filtros']['order_by'][$parametros['post'][Control_acceso::DIMENSION]];
//                pr($propiedades['filtros']['order_by'][$parametros['post']['dimension']]);
            //Obtiene el nombre de la funcion
            $funcion = $propiedades['reportes_indexados'][$parametros['post'][Control_acceso::METRICA]]['funcion'];
            //ejecuta la funcion
            $respuesta[$parametros['post'][Control_acceso::METRICA]] = $this->rm->{$funcion}($param, $filtros_tmp, FALSE);
        } else {//Responde con datos vacios
            $respuesta[$parametros['post'][Control_acceso::METRICA]] = array();
        }
//        pr($respuesta);
        return $this->get_formato_respuesta($respuesta, $parametros, $propiedades);
    }

    public function get_formato_respuesta($datos, $param, $propiedades) {
//        pr($propiedades);
//        pr($param['post'][Control_acceso::METRICA]);
//        pr($datos);
//        pr($param);
        if (!empty($datos[$param['post'][Control_acceso::METRICA]])) {
            $array_res = array();
            //Recorre las metricas solicitadas
            $reporte_aux = array(); //Crea la variable de resultados de metrica
            $dimension = array(); //Crea la variable de resultados de metrica
            $dimension_aux = array(); //Crea la variable de resultados de metrica
            foreach ($datos[$param['post'][Control_acceso::METRICA]] as $series_value) {
//            pr($series_value);
                $clave_metrica = $series_value[$propiedades['prop_tipo_mapa']['key_default_alias']];
                $clave_dimension = $series_value[$param['post'][Control_acceso::DIMENSION]];

                if (!isset($dimension_aux[$clave_dimension])) {
                    $dimension_aux[$clave_dimension] = '1';
                    $dimension[] = $clave_dimension; //Obtiene valor de tiempo
                }
                $reporte_aux[$clave_metrica][$clave_dimension] = $series_value['datos'];
            }
            $reporte = array();
            foreach ($reporte_aux as $key => $value) {
                foreach ($dimension as $val_dimencion) {
                    if (isset($value[$val_dimencion])) {
                        $reporte[$key][] = $value[$val_dimencion];
                    } else {
                        $reporte[$key][] = 0;
                    }
                }
            }
            $array_res[Control_acceso::METRICA] = $reporte;
            $array_res[Control_acceso::DIMENSION] = $dimension;
        } else {//Retorna mensaje, que no se encontraron registros
            $this->lang->load('interface', 'spanish');
            $str_val = $this->lang->line('interface')['general'];
            $array_res['acceso'] = TRUE;
            $array_res['msj'] = $str_val['sn_registros'];
            $array_res['tp_msg'] = En_tpmsg::INFO;
        }
        return $array_res;
    }

    public function get_formato_respuesta_2($datos, $propertis) {
//        pr($datos);
//        pr($propertis);
        $array_res = array();
        $tiempos_array = array(); //Crea la variable de resultados de metrica
        //Recorre las metricas solicitadas
        foreach ($datos as $key_serie => $series_value) {
//            pr($series_value);
            $reporte = array(); //Crea la variable de resultados de metrica
            $dimension = array(); //Crea la variable de resultados de metrica
            foreach ($series_value as $datos) {
                $dimension[] = $datos[$propertis['post'][Control_acceso::DIMENSION]]; //Obtiene valor de tiempo
                $reporte[] = $datos['datos'];

                $tiempos_array[$datos[$propertis['post'][Control_acceso::DIMENSION]]][0][$key_serie] = $datos['datos'];
//                }
            }
            $array_res[Control_acceso::METRICA][$key_serie] = $reporte;
            if (!isset($array_res[Control_acceso::DIMENSION])) {
                $array_res[Control_acceso::DIMENSION] = $dimension;
            }
        }
//        pr($tiempos_array);
        return $array_res;
    }

}
