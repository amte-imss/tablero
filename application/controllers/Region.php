<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Region extends MY_Controller {

    function __construct() {
        parent::__construct();
//        $this->load->model('Catalogos_model', 'cm');
        $this->load->model('Reportes_model', 'rm');
//        $this->load->model('Login_model', 'lm');
        $this->load->model('Catalogos_model', 'cmm');
    }

    public function index() {
        
    }

    public function resumen($region = null) {
//            $gets = $this->input->get();
//        pr('snbdsnbds');
        $select_adicional['group_by'] = array('regiones.clave_regional', 'regiones.nombre');
        $select_adicional['order_by'] = array('regiones.clave_regional');
        $select_adicional['marge_select'] = true; //Permite traer los valores cpompletos de alumnos inscritos, y alumnos certificados
        $controlador = $this->uri->segment(1);  //Controlador actual o dirección actual
        $accion = $this->uri->segment(2);  //Función que se llama en el controlador
        $array_tipo_unidad = $this->rm->get_aplica_tipo_unidad_resumen($controlador . '/' . $accion);
        if (!is_null($region)) {
            if (!is_null($array_tipo_unidad)) {
                $param = array('regiones.clave_regional' => $region);
                $param = array_merge($param, $array_tipo_unidad);

                $respuesta['alumnos'] = $this->rm->get_resumen_alumnos_regiones_delegacion($param, $select_adicional, TRUE);
                $respuesta['cursos_impartidos'] = $this->rm->get_resumen_cursos_impartidos_regiones_delegacion($param, $select_adicional, TRUE);
                $respuesta['docentes'] = $this->rm->get_resumen_cantidad_docentes_regiones_delegacion($param, $select_adicional, TRUE);
            } else {
                $this->lang->load('interface', 'spanish');
                $str_val = $this->lang->line('interface')['general'];
                $respuesta['acceso'] = TRUE;
                $respuesta['msj'] = $str_val['sn_registros'];
                $respuesta['tp_msg'] = En_tpmsg::INFO;
            }
        } else {
            if (!is_null($array_tipo_unidad)) {
                $select_adicional['select'] = array('regiones.clave_regional', 'regiones.nombre  AS  nombre_region',);
                $respuesta['alumnos'] = $this->rm->get_resumen_alumnos_regiones_delegacion(null, $select_adicional);
                $respuesta['cursos_impartidos'] = $this->rm->get_resumen_cursos_impartidos_regiones_delegacion(null, $select_adicional);
                $respuesta['docentes'] = $this->rm->get_resumen_cantidad_docentes_regiones_delegacion(null, $select_adicional);
            } else {
                $this->lang->load('interface', 'spanish');
                $str_val = $this->lang->line('interface')['general'];
                $respuesta['acceso'] = TRUE;
                $respuesta['msj'] = $str_val['sn_registros'];
                $respuesta['tp_msg'] = En_tpmsg::INFO;
            }
        }
        echo json_encode($respuesta);
    }

    public function acceso() {
//        $data_user = $this->session->userdata('usuario');
        $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario

        $controlador = $this->uri->segment(1);  //Controlador actual o dirección actual
        $accion = $this->uri->segment(2);  //Función que se llama en el controlador
        $respuesta = array();
//        $result = validar_ruta_acceso_user($servicios_user, $controlador, $accion); //Valida acceso del usuario
//        $servicios_user[$controlador . '/' . $accion];
        if (isset($servicios_user[$controlador . '/' . $accion])) {//Valida que el servicio sea valido
            $config = $servicios_user[$controlador . '/' . $accion]; //Configuarcion del servicio actual
            $respuesta = $this->cmm->get_datos_grafico(En_tipomapa::REGION, $config['conf_servicio_acceso']);
        }
//        pr($respuesta);
        echo json_encode($respuesta);
//        pr($servicios_user);
//        pr($respuesta);
//        pr('sssssssss_sssssssss');
//        pr($this->session->userdata('menu'));
//        pr($this->session->userdata('config'));
    }

    public function comparativa($imprime = true) {
//        pr($this->session->userdata('usuario'));
//         $this->load->model('Login_model', 'lm');
//         $datuser = $this->lm->get_genera_info_usuario('99156322');
//         pr($datuser);
//        if ($this->input->post()) {//Validad datos por post
        $data_post = $this->input->post(); //datos de post
//            $data_post['series'] = '4,1';
//        $data_post['dimensión'] = 'mes'; //bimestre, cuatrimestre, trimestres, semestres, anio
//        $data_post['reporte'] = 'alumnos_inscritos'; //Tipos de comparativa que debe mostrar
        //************
//        $data_post['metrica'] = array('alumnos_inscritos', 'alumnos_certificados','cursos_impartidos', 'docentes'); //Tipos de comparativa que debe mostrar
//            $data_post['tipo_filtro_unidad'] = 'tipos_unidad';
//        $propiedades_filtros = $this->rm->get_filtros_reportes(); //Select y group_by
//        $reportes = $this->rm->get_reportes_indexados();


        if (isset($data_post['series'])) {
            $data_post['series'] = explode(',', $data_post['series']); //Convierete
            $params['post'] = $data_post;
            $params['tipo_grafico'] = En_tipomapa::REGION;

            $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
            $controlador = $this->uri->rsegment(1);
            $accion = $this->uri->rsegment(2);
            $params['servicio'] = $servicios_user[$controlador . '/' . $accion];
            //Genera resultados
            $genera_info = $this->rm->get_accesos_comparativa($params); //Obtiene resultado
            if($imprime){
            echo json_encode($genera_info, JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode($genera_info, JSON_UNESCAPED_UNICODE);
            }
            exit();
        }
//        pr($propiedades_filtros);
//        pr($reportes);
//        $respuesta['alumnos'] = $this->rm->get_resumen_alumnos_regiones_delegacion($param, $select_adicional, TRUE);
//        $respuesta['cursos_impartidos'] = $this->rm->get_resumen_cursos_impartidos_regiones_delegacion($param, $select_adicional, TRUE);
//        $respuesta['docentes'] = $this->rm->get_resumen_cantidad_docentes_regiones_delegacion($param, $select_adicional, TRUE);
//        }
//        //Dimensión
//        $scope->labels = ['1997', '1998', '1999', '2000', '2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008',
//            '2009', '2010', '2011', '2012', '2013', '2014', '2015', '2016', '2017'];
//        $scope->series = ['Series A', 'Series B'];
//
//        // Arreglo de datos, por ahora estático  metrica
//        $scope->data = [
//            [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56, 55, 40],
//            [28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86, 27, 90, 28, 48, 40, 19, 86, 27, 90]
//        ];
    }

    public function servicio_comparativa() {
        $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
        $controlador = $this->uri->rsegment(1);
        if (isset($servicios_user[$controlador . '/comparativa'])) {
            $ser_comparativa = $servicios_user[$controlador . '/comparativa']['configuraciones'];
//            pr($ser_comparativa);
            echo $ser_comparativa;
            exit();
//            pr(json_encode($decode));
//            pr(json_encode($decode));
        } else {
            $json_resp['acceso'] = FALSE;
            $json_resp['msj'] = $str_val['servicio_no_acceso'];
            $json_resp['tp_msg'] = En_tpmsg::WARNING;
            echo json_encode($json_resp, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

}
