<?php

if (!defined('BASEPATH'))
    exit('NO DIRECT SCRIPT ACCESS ALLOWED');

class Iniciar_sesion {

    var $CI;

    private function get_modulos_no_session() {
        return array(
            'sesion' => array('index', 'cerrar_sesion', 'recuperar_password'),
//            'registro' => '*',
            'pagina_no_encontrada' => array('index'),
            'recuperar_contrasenia' => '*',
            'captcha' => '*',
        );
    }

    /**
     * Controladores que por ende deberian llevar al inicio de sesión si 
     * @return type void 
     */
    private function get_modulos_mandan_controlador_sesion() {
        return array(
            '', 'Views_driver'
        );
    }

    private function get_modulos_extra_session() {
        return array(
            'sesion' => array('cerrar_sesion'),
            'pagina_no_encontrada' => array('index'),
            'Views_driver' => array('index'),
            'delegacion' => array('servicio_comparativa'),
            'region' => array('servicio_comparativa'),
            'umae' => array('servicio_comparativa'),
            'unidad' => array('servicio_comparativa'),
            'datos_catalogo' => '*',
        );
    }

    function permisos() {
        $CI = & get_instance(); //Obtiene la insatancia del super objeto en codeigniter para su uso directo
//        echo $CI->load->view('template/sin_acceso', $datos_, true);
//        return json_encode($array_result);
        $CI->load->helper('url');
        $CI->load->library('session');
        $is_ajax = $CI->input->is_ajax_request();  //Accion

        $controlador = $CI->uri->rsegment(1);  //Controlador actual o dirección actual
        $accion = $CI->uri->rsegment(2);  //Función que se llama en el controlador
//        $CI->session->sess_destroy();
//        exit();
        $session = $CI->session->userdata('usuario'); ///Obtener datos de sesión
//        pr($session);
        if (!is_null($session)) {//Valida que la sesión existe en verdad
            $servicios_user = $CI->session->userdata('servicios'); ///Obtener datos de sesión
            $result = validar_ruta_acceso_user($servicios_user, $controlador, $accion);
//            print_r($result['servicio_valido']);
            if ($result['servicio_valido'] == 0) {//No Tiene acceso
                //Valida servicio, si requiere acceder a un servicio o un menu, si es un menu devolvera error 404 si no un json con mensaje y tipo de mensaje
                $CI->load->model('Login_model', 'lm');
                $servicio_acceso = $controlador . '/' . $accion;
                $valida_servicio = $CI->lm->get_servicios_rest(array('servicio' => $servicio_acceso));
                if (!empty($valida_servicio)) {//Valida que exista el servicio
                    if ($valida_servicio[0]['menu']) {//Si el servicio al que intenta acceder es un menu, manda página de error 404
//                        echo '$Cssssssssss';
                        echo $CI->load->view('home/error_404', null, true);
                        exit();
                    } else {//Si no es un menu, devolvera un json 
                        $CI->lang->load('interface', 'spanish');
                        $str_val = $CI->lang->line('interface')['hooks'];
                        $json_resp['acceso'] = FALSE;
                        $json_resp['msj'] = $str_val['servicio_no_acceso'];
                        $json_resp['tp_msg'] = En_tpmsg::DANGER;
                        echo json_encode($json_resp);
                        exit();
                    }
                }

                $array_no_session = $this->get_modulos_extra_session();
                $val = validar_ruta_acceso_no_sesion($array_no_session, $controlador, $accion);
                if (!($val == 1)) {//Valida que no tenga acceso para enviar error 404
                    echo $CI->load->view('home/error_404', null, true);
                    exit();
                }
            }
        } else {//Validación para cuando no existe una sesion iniciada actualmente
            //Bloque de validación para session no iniciada
            $array_no_session = $this->get_modulos_no_session();
            $valido = validar_ruta_acceso_no_sesion($array_no_session, $controlador, $accion);
//            echo $valido;
//            exit();
            if (!($valido == 1)) {
                foreach ($this->get_modulos_mandan_controlador_sesion() as $valores) {
                    if ($controlador == $valores) {
                        redirect(base_url() . 'index.php/sesion'); //
                        exit();
                    }
                }
                echo $CI->load->view('home/error_404', null, true);
                exit();
            }
        }

//        $privilegios = $CI->session->userdata('lista_roles_modulos'); //Toma los privilegios de todos los roles, no importa cual selecciono
    }

}
