<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona la entrega de las vistas
 * @version 	: 1.0.0
 * @autor 	: D.P.G
 */
class Views_driver extends MY_Controller {

    /**
     * * @access 	: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();
        if(ENVIRONMENT !== "development"){
            $this->load->database();
        }
        $this->load->library("session");
        $this->load->helper('url');
    }

    public function index() {
        if(ENVIRONMENT === "development"){
            // Configuración de menú
            $menu = array(
                "home" => array( 
                    "label" => "Mi unidad"
                    , "url" => "#/home"
                )
                , "ecp" => array(
                    "label" => "EC presencial"
                    , "url" => null
                    , "childs" => array(
                        "ecp_comparativa" => array(
                            "label" => "Comparativa"
                            , "url" => "#/ecp/comparativa"
                        )
                        , "ecp_regiones" => array(
                            "label" => "Regiones"
                            , "url" => "#/ecp/regionalizacion"
                        )
                        , "ecp_indicadores" => array(
                            "label" => "Indicadores"
                            , "url" => "#/ecp/indicadores"
                        )
                    )
                )
                , "ed" => array(
                    "label" => "ED"
                    , "url" => null
                    , "childs" => array(
                        "ed_comparativa" => array(
                            "label" => "Comparativa"
                            , "url" => "#/ed/comparativa"
                        )
                        , "ed_regiones" => array(
                            "label" => "Regiones"
                            , "url" => "#/ed/regionalizacion"
                        )
                        , "ed_indicadores" => array(
                            "label" => "Indicadores"
                            , "url" => "#/ed/indicadoes"
                    )
                )
                )
                , "admin" => array(
                    "label" => "Administración"
                    , "url" => null
                    , "childs" => array(
                        "admin_registrar" => array(
                            "label" => "Registrar"
                            , "url" => "/gestionUsuario/buscar"
                        )
                        , "admin_buscar" => array(
                            "label" => "Buscar"
                            , "url" => "/gestionUsuario/buscar"
                        )
                        , "admin_catalogos" => array(
                            "label" => "Catálogos"
                            , "url" => "/gestionCatalogos"
                        )
                    )
                )
            );
            // Configuración de routrProvider
            $config = array(
                "1" => array(
                    "controller" => "homeCtrl"
                    , "url_controller" => "assets/app/controllers/home/homeCtrl.js"
                    , "url_template" => "index.php/views_driver/home"
                    , "url_link" => "/home"
                    , "delay" => 250
                    , "main" => true
                )
                , "2" => array(
                    "controller" => "ecpCtrl"
                    , "url_controller" => "assets/app/controllers/ecp/ecpCtrl.js"
                    , "url_template" => "index.php/views_driver/ecp_comparativa"
                    , "url_link" => "/ecp/comparativa"
                    , "delay" => 250
                    , "main" => false
                )
                , "3" => array(
                    "controller" => "ecpCtrl"
                    , "url_controller" => "assets/app/controllers/ecp/ecpCtrl.js"
                    , "url_template" => "index.php/views_driver/ecp_regiones"
                    , "url_link" => "/ecp/regionalizacion"
                    , "delay" => 250
                    , "main" => false
                )
                , "4" => array(
                    "controller" => "ecpCtrl"
                    , "url_controller" => "assets/app/controllers/ecp/ecpCtrl.js"
                    , "url_template" => "index.php/views_driver/ecp_indicadores"
                    , "url_link" => "/ecp/indicadores"
                    , "delay" => 250
                    , "main" => false
                )
                , "5" => array(
                    "controller" => "edCtrl"
                    , "url_controller" => "assets/app/controllers/ed/edCtrl.js"
                    , "url_template" => "index.php/views_driver/ed_regiones"
                    , "url_link" => "/ed/regionalizacion"
                    , "delay" => 250
                    , "main" => false
                )
                , "6" => array(
                    "controller" => "ecpCtrl"
                    , "url_controller" => "assets/app/controllers/ed/edCtrl.js"
                    , "url_template" => "index.php/views_driver/ed_comparativa"
                    , "url_link" => "/ed/comparativa"
                    , "delay" => 250
                    , "main" => false
                )
                , "7" => array(
                    "controller" => "edCtrl"
                    , "url_controller" => "assets/app/controllers/ed/edCtrl.js"
                    , "url_template" => "index.php/views_driver/ed_indicadores"
                    , "url_link" => "/ed/indicadores"
                    , "delay" => 250
                    , "main" => false
                    )
                );
            // Datos de usuarios
            $array_resp['usuario']['nombre'] = "Nombre Apellido1 Apellido2";
            $array_resp['usuario']['matricula'] = "33535776";
            $array_resp['usuario']['del_cve'] = "";
            $array_resp['usuario']['del_nom'] = "Nombre Delegación";
            $array_resp['usuario']['curp'] = "EFTJ348754SHEdfV98";
            $array_resp['usuario']['unidad_cve'] = "";
            $array_resp['usuario']['unidad_nom'] = "Unidad nombre";
            $array_resp['usuario']['categoria_cve'] = "";
            $array_resp['usuario']['categoria_nom'] = "Nombre categría";
            $array_resp['usuario']['nombre_grupo'] = "Nombre Grupo";
            $array_resp['usuario']['nivel'] = 'Nivel ' . "Nivel";
            $array_resp['usuario']['id_region'] = "";
            $array_resp['usuario']['name_region'] = "Nombre Región";
            $array_resp['usuario']['is_umae'] = "";
            
            $data['json']['url_base'] = base_url();
            $data['json']['config'] = $config;
            $data['json']['menu'] = $menu;
            $data['json']['usuario'] = $array_resp['usuario'];
            
            $this->session->set_userdata('usuario', $array_resp['usuario']);
            
            $this->load->view("main/index", $data);
            
        }else{
            if (!is_null($this->session->userdata('usuario'))) {
                $data_user = $this->session->userdata('usuario');
                $this->load->model('Login_model', 'lm');
                $info_user = $this->lm->get_genera_info_usuario($data_user['matricula']); //Obtiene todos los permisos de usuario en ["ui"]["menu"] y ["ui"]["config"]

                $data['json']['url_base'] = base_url();
                $data['json']['config'] = $info_user['ui']['config'];
                $data['json']['menu'] = $info_user['ui']['menu'];
                $data['json']['usuario'] = $data_user; 
                $data['json']['anios_implementacion'] = $info_user['anios_implementacion']; 
//                pr($data);
//                exit();
                $this->load->view("main/index", $data);
            } else {//No existe una session activa actualmente
            }
        }
    }
    
    public function home() {
        $this->load->view("home/home");
    }
    
    public function ecp_comparativa() {
        $this->load->view("ecp/ecpComparativa");
    }
    
    public function ecp_regiones() {
        $this->load->view("ecp/ecpRegiones");
    }

    public function ecp_indicadores() {
        $this->load->view("ecp/ecpIndicadores");
    }
   
    public function ed_comparativa() {
        $this->load->view("ed/edComparativa");
    }
    
    public function ed_regiones() {
        $this->load->view("ed/edRegiones");
    }

    public function ed_indicadores() {
        $this->load->view("ed/edIndicadores");
    }


}
