<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Unidad extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Reportes_model', 'rm');
        $this->load->model('Catalogos_model', 'cmm');
    }

    public function index() {
        //echo "SOY UN INDEX....";
    }

    public function detalle($parametro) {
        
    }

    public function resumen($delegacion = null) {
        $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
        $controlador = $this->uri->segment(1);  //Controlador actual o dirección actual
        $accion = $this->uri->segment(2);  //Función que se llama en el controlador
//        $result = validar_ruta_acceso_user($servicios_user, $controlador . '/' . $accion); //Valida acceso del usuario
        $respuesta = array();
//        if ($result['servicio_valido']) {//Valida que el servicio sea valido
        $select_adicional['group_by'] = array('delegaciones.clave_delegacional', 'delegaciones.nombre');
        $select_adicional['order_by'] = array('delegaciones.clave_delegacional');
        $select_adicional['marge_select'] = true; //Permite traer los valores cpompletos de alumnos inscritos, y alumnos certificados

        if (!is_null($delegacion)) {
            $param = array('delegaciones.clave_delegacional' => $delegacion);
            $respuesta['alumnos'] = $this->rm->get_resumen_alumnos_regiones_delegacion($param, $select_adicional, TRUE);
            $respuesta['cursos_impartidos'] = $this->rm->get_resumen_cursos_impartidos_regiones_delegacion($param, $select_adicional, TRUE);
            $respuesta['docentes'] = $this->rm->get_resumen_cantidad_docentes_regiones_delegacion($param, $select_adicional, TRUE);
//            $result = depura_resultados_reporte($respuesta, array('clave_delegacional', 'nombre_delegacion'));
//            echo json_encode($result);
        } else {
            $select_adicional['select'] = array('delegaciones.clave_delegacional', 'delegaciones.nombre AS nombre_delegacion');
            $respuesta['alumnos'] = $this->rm->get_resumen_alumnos_regiones_delegacion(null, $select_adicional);
            $respuesta['cursos_impartidos'] = $this->rm->get_resumen_cursos_impartidos_regiones_delegacion(null, $select_adicional);
            $respuesta['docentes'] = $this->rm->get_resumen_cantidad_docentes_regiones_delegacion(null, $select_adicional);
        }
        echo json_encode($respuesta);
//        }
    }

    public function servicio_comparativa() {
        $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
        $controlador = $this->uri->rsegment(1);
        if (isset($servicios_user[$controlador . '/comparativa'])) {
            $ser_comparativa = $servicios_user[$controlador . '/comparativa']['configuraciones'];
//            pr($ser_comparativa);
            echo $ser_comparativa;
            exit();
        } else {
            $json_resp['acceso'] = FALSE;
            $json_resp['msj'] = $str_val['servicio_no_acceso'];
            $json_resp['tp_msg'] = En_tpmsg::WARNING;
            echo json_encode($json_resp, JSON_UNESCAPED_UNICODE);
            exit();
        }
    }

    public function acceso() {
//        $data_user = $this->session->userdata();
        $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
//        pr($servicios_user);
        $controlador = $this->uri->segment(1);  //Controlador actual o dirección actual
        $accion = $this->uri->segment(2);  //Función que se llama en el controlador
//        $respuesta = array();
        $result = validar_ruta_acceso_user($servicios_user, $controlador, $accion); //Valida acceso del usuario
//        if ($result['servicio_valido']) {//Valida que el servicio sea valido
        $config = $result['servicio_config']; //Configuarcion del servicio actual
        $respuesta = $this->cmm->get_datos_grafico(En_tipomapa::UNIDAD, $config['conf_servicio_acceso']);


        echo json_encode($respuesta);
    }

    public function comparativa($imprime = true) {
        //        if ($this->input->post()) {//Validad datos por post
        $data_post = $this->input->post(); //datos de post
//        $data_post['series'] = '07UA070000,37UA090000,07HD020000,12HD080000'; //región A comparación
//        $data_post['dimensión'] = 'mes'; //trimestre, mes, año
//        $data_post['reporte'] = 'alumnos_inscritos'; //Tipos de comparativa que debe mostrar
//***********************
//        $data_post['metrica'] = array('alumnos', 'cursos_impartidos', 'docentes'); //Tipos de comparativa que debe mostrar
//            $data_post['tipo_filtro_unidad'] = 'tipos_unidad';
//        $propiedades_filtros = $this->rm->get_filtros_reportes(); //Select y group_by
//        $reportes = $this->rm->get_reportes_indexados();
//        pr('sdsdsd');
//        pr($propiedades_filtros);
//        pr($reportes);
        if (isset($data_post['series'])) {

            $data_post['series'] = explode(',', $data_post['series']);
            $params['post'] = $data_post;
            $params['tipo_grafico'] = En_tipomapa::UNIDAD;

            $servicios_user = $this->session->userdata('servicios'); //Obtiene servicios  de acceso del usuario
            $controlador = $this->uri->rsegment(1);
            $accion = $this->uri->rsegment(2);
            $params['servicio'] = $servicios_user[$controlador . '/' . $accion];
            $genera_info = $this->rm->get_accesos_comparativa($params); //Obtiene resultado
            if ($imprime) {
                echo json_encode($genera_info, JSON_UNESCAPED_UNICODE);
            } else {
                return json_encode($genera_info, JSON_UNESCAPED_UNICODE);
            }
        }
    }

}
