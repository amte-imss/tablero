<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Catalogos_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    /**
     * 
     * @param type $param array con las condiciones para generar busqueda 
     * de regiones por los sigueientes indices
     * clave_delegacional   : clave de la delegación
     * clave_regional   : clave de la región
     * @return type
     */
    public function get_delegaciones($param = null) {
        if (isset($param['clave_delegacional'])) {
            $this->db->where('d.clave_delegacional', $param['clave_delegacional']);
        }

        if (isset($param['clave_regional'])) {
            $this->db->where('r.clave_regional', $param['clave_regional']);
        }

        $this->db->where('d.activo', TRUE);
        $this->db->where('d.id_region is not null');
        $select = array(
            'd.id_delegacion', 'd.nombre', 'clave_delegacional', 'r.clave_regional', 'r.configuraciones'
        );

        $this->db->select($select);
        $this->db->from('catalogos.delegaciones d');
        $this->db->join('catalogos.regiones r', 'r.id_region = d.id_region');

        $query = $this->db->get();
//        $result = $query->row();
//        pr($this->db->last_query());
        return $query->result_array();
    }

    /**
     * 
     * @param type $param array con las condiciones para generar busqueda 
     * de regiones por los sigueientes indices
     * clave_regional: clave de la región
     * @return type
     */
    public function get_regiones($param = null) {
        if (isset($param['clave_regional'])) {
            $this->db->where('r.clave_regional', $param['clave_regional']);
        }

        $this->db->where('r.activo', true);
        $select = array(
            'r.id_region', 'r.nombre', 'r.clave_regional', 'r.configuraciones'
        );

        $this->db->select($select);
        $this->db->from('catalogos.regiones r');

        $query = $this->db->get();
//        $result = $query->row();
//        pr($this->db->last_query());
        return $query->result_array();
    }

    /**
     * 
     * @param type $param array para aplicar condiciones para aplicar busqueda 
     * de unidades, es decir, los siguientes filtros
     * "clave_unidad": clave de la unidad
     * "clave_regional": clave de la region
     * "clave_delegacional": clave de la delegacion
     * "umae": Indica que buscará unidades umaes
     * @return type
     */
    public function get_unidades_and_umaes($param = null) {

        if (isset($param['clave_unidad'])) {
            $this->db->where('u.clave_unidad', $param['clave_regional']);
        }

        if (isset($param['clave_delegacional'])) {
            $this->db->where('d.clave_delegacional', $param['clave_delegacional']);
        }

        if (isset($param['clave_regional'])) {
            $this->db->where('r.clave_regional', $param['clave_regional']);
        }

        if (isset($param['umae'])) {
            $this->db->where('u.umae', $param['umae']);
        }

        $this->db->where('u.activa', true);
        $select = array(
            'u.id_unidad_instituto', 'u.clave_unidad', 'u.nombre', 'clave_delegacional',
            'u.umae', 'u.id_tipo_unidad', 'u.nivel_atencion', 'r.clave_regional', 'r.configuraciones'
        );

        $this->db->select($select);
        $this->db->from('catalogos.unidades_instituto u');
        $this->db->join('catalogos.delegaciones d', 'd.id_delegacion = u.id_delegacion');
        $this->db->join('catalogos.regiones r', 'r.id_region = d.id_region');

        $query = $this->db->get();
//        pr($this->db->last_query());

        return $query->result_array();
    }

    function get_filtros_servicio($servicio) {
        
    }

    function get_datos_grafico($tipo_grafico, $configurador) {
        $ctr_cat = new Control_busqueda_catalogos(); //Genera instancia de control catalogo
        switch ($tipo_grafico) {
            case En_tipomapa::REGION:
                return $ctr_cat->get_regiones_acceso($configurador);
            case En_tipomapa::DELEGACION:
                return $ctr_cat->get_delegaciones_acceso($configurador);
            case En_tipomapa::UMAE:
                return $ctr_cat->get_umae_acceso($configurador);
            case En_tipomapa::UNIDAD:
                return $ctr_cat->get_unidades_acceso($configurador);
        }
    }

}

class Control_busqueda_catalogos extends Catalogos_model {

    /**
     * @author LEAS
     * @fecha 09/03/2017
     * @param type $configuarador configurador de permisos de acceso al mapa, donde,
     * "*" indica el permiso de acceso a todos los registros 
     * "+" indica el permiso de acceso a unicamente la región a la que pertenece  
     * "t" unicamente a unidades del mismo tipo
     */
    function get_regiones_acceso($configuarador) {
//        pr($this->session->userdata());
        $regiones = array();
        $conf_permisos = get_array_config_permisos();
        if (isset($conf_permisos[$configuarador])) {
            $conf = $conf_permisos[$configuarador];
        }
//        $referencia_filtros = array('R' => 'clave_regionals');
//        pr($conf);

        $param = null;
        if (isset($conf['filtro']) and ! empty($conf['filtro'])) {
            $filtro = $conf['filtro'];
            $datos_user_ = $this->session->userdata('usuario')[$conf[$filtro . 'u']]; //Muestra la información del usuario
            $campo_filtro = $conf[$filtro . 'r']; //Muestra el campo de filtro por default puede ser alterado 
            $param[$campo_filtro] = $datos_user_; //Genera condiciones
//            pr($datos_user_);
        }
        $regiones = $this->get_regiones($param);

        //Recorre array para generar formato de respuesta
        $array_result = $this->get_formato_regiones_consumo($regiones);

        return $array_result;
    }

    function get_formato_regiones_consumo($array_datos) {
        $resultado = array();
        foreach ($array_datos as $value) {
            $json_decode = (array) json_decode($value['configuraciones']);
            $resultado[$value['clave_regional']] = array('label' => $value['nombre'], 'acceso' => 1, 'estilos' => $json_decode);
        }
        return $resultado;
    }

    function get_delegaciones_acceso($configuarador) {
        $delegaciones = array();
        $conf_permisos = get_array_config_permisos();
        if (isset($conf_permisos[$configuarador])) {
            $conf = $conf_permisos[$configuarador];
        }
        $referencia_filtros = array('R' => 'clave_regionals');
//        pr($conf_permisos);
        $param = null;

        if (isset($conf['filtro']) and ! empty($conf['filtro'])) {
            $filtro = $conf['filtro'];
            $datos_user_ = $this->session->userdata('usuario')[$conf[$filtro . 'u']]; //Muestra la información del usuario
            $campo_filtro = $conf[$filtro . 'r']; //Muestra el campo de filtro por default puede ser alterado 
            $param[$campo_filtro] = $datos_user_; //Genera condiciones
        }
        $delegaciones_tmp = $this->get_delegaciones($param); //Carga la región que le pertenece
        $delegaciones_total = $this->get_delegaciones(null); //Carga la región que le pertenece
        //Obtiene llave como delegacion 
        $delegaciones = array();
        foreach ($delegaciones_tmp as $value) {
            $delegaciones[$value['clave_delegacional']] = $value;
        }
        //Recorre array para generar formato de respuesta
        $array_result = $this->get_formato_delegaciones_consumo($delegaciones, $delegaciones_total);

        return $array_result;
    }

    function get_formato_delegaciones_consumo($array_datos, $total_delegaciones) {
//        pr($array_datos);
        $resultado = array();
        foreach ($total_delegaciones as $value) {
            $json_decode = (array) json_decode($value['configuraciones']);
            $acceso = (isset($array_datos[$value['clave_delegacional']]))?1:0;
            $resultado[$value['clave_delegacional']] = array('label' => $value['nombre'], 'acceso' => $acceso, 'region' => $value['clave_regional'], 'estilos' => $json_decode);
        }
        return $resultado;
    }

    function get_umae_acceso($configuarador) {
        $umae = array();
        $param['umae'] = TRUE;
        $conf_permisos = get_array_config_permisos();
        if (isset($conf_permisos[$configuarador])) {
            $conf = $conf_permisos[$configuarador];
        }

        if (isset($conf['filtro']) and ! empty($conf['filtro'])) {
            $filtro = $conf['filtro'];
            $datos_user_ = $this->session->userdata('usuario')[$conf[$filtro . 'u']]; //Muestra la información del usuario
            $campo_filtro = $conf[$filtro . 'r']; //Muestra el campo de filtro por default puede ser alterado 
            $param[$campo_filtro] = $datos_user_; //Genera condiciones
//            pr($datos_user_);
        }
        $umae = $this->get_unidades_and_umaes($param); //Obtiene todas las umaes del sistema
//        pr($umae);
        $formato = $this->get_formato_umaes($umae);
        return $formato;
    }

    function get_formato_umaes($array_datos) {
        $resultado = array();
//        pr($array_datos);
        foreach ($array_datos as $value) {
            $json_decode = (array) json_decode($value['configuraciones']);
            $resultado[$value['clave_unidad']] = array('label' => $value['nombre'], 'acceso' => 1, 'region' => $value['clave_regional'], 'estilos' => $json_decode);
        }
        return $resultado;
    }

    function get_unidades_acceso($configuarador) {
        $unidad = array();
//        $param = array();
//        pr($configuarador);
        $conf_permisos = get_array_config_permisos();
        if (isset($conf_permisos[$configuarador])) {
            $conf = $conf_permisos[$configuarador];
        }
        $param = null;
        if (isset($conf['filtro']) and ! empty($conf['filtro'])) {
            $filtro = $conf['filtro'];
            $datos_user_ = $this->session->userdata('usuario')[$conf[$filtro . 'u']]; //Muestra la información del usuario
            $campo_filtro = $conf[$filtro . 'r']; //Muestra el campo de filtro por default puede ser alterado 
            $param[$campo_filtro] = $datos_user_; //Genera condiciones
//            pr($datos_user_);
        }
        $unidad = $this->get_unidades_and_umaes($param); //Obtiene todas las umaes del sistema
//        pr($umae);
        $formato = $this->get_formato_unidades($unidad);
        return $formato;
    }

    function get_formato_unidades($array_datos) {
        $resultado = array();
        foreach ($array_datos as $value) {
            $json_decode = (array) json_decode($value['configuraciones']);
            $resultado[$value['clave_unidad']] = array('label' => $value['nombre'], 'delegacion' => $value['clave_delegacional']);
        }
        return $resultado;
    }

}

class Filtros_servicios {

    function get_obtener_filtros_servicio($servicio) {
        
    }

    function get_catalogo_filtros() {
        $array = array(
            'region/comparativa' => array(
                'dimencion' => array(
                    1 => 'Año',
                    2 => 'Semestre',
                    3 => 'Cuatrimestre',
                    4 => 'Trimestre',
                    5 => 'Bimestre',
                    6 => 'Mes',
                )
            ),
            'delegacion/comparativa' => array(),
            'umae/comparativa' => array(),
        );
    }

}
