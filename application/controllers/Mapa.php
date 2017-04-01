<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Jesús Díaz P. & Pablo José
 */
class Mapa extends CI_Controller {

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('grocery_CRUD');
        $this->load->model('Mapa_model', 'mapa');
    }

    public function new_crud() {
        $db_driver = $this->db->platform();
//        pr($db_driver);
        $model_name = 'Grocery_crud_model_' . $db_driver;
        $model_alias = 'm' . substr(md5(rand()), 0, rand(4, 15));
        unset($this->{$model_name});
        $this->load->library('grocery_CRUD');
        $crud = new Grocery_CRUD();
        if (file_exists(APPPATH . '/models/' . $model_name . '.php')) {
            $this->load->model('Grocery_crud_model');
            $this->load->model('Grocery_crud_generic_model');
            $this->load->model($model_name, $model_alias);
            $crud->basic_model = $this->{$model_alias};
        }
        $crud->set_theme('datatables');
        $crud->unset_print();
        return $crud;
    }

    public function index() {
        
    }

    function get_datos_mapa() {
        $data_post = $this->input->post();

        $array_resp = array();
        if (isset($data_post['usuario']) and isset($data_post['password'])) {
            $array_resp['acceso'] = TRUE;
            $array_resp['token'] = 'ASL34ADRT%DCFFGRFDSFFFSJKJHDU%8etyueyuewiueuwyt2yi2n';
        } else {
            $array_resp['acceso'] = FALSE;
        }

        echo json_encode($array_resp);
    }

    function get_tabla() {
        try {
            $crud = $this->new_crud();
            $crud->set_table('mytable')
                    ->set_subject('Datos_Tabla')
                    ->columns('id', 'nom', 'pais', 'tel')
                    ->display_as('id', 'Identificador')
                    ->display_as('nom', 'Nombre')
                    ->display_as('pais', 'Pais')
                    ->display_as('tel', 'Teléfono')
            ;

//            $crud->unset_read();

            $output = $crud->render();
//            pr($output);
//            exit();


            echo $this->load->view('modulos_acceso', $output, true);
//            $this->template->setMainContent($this->load->view('modulos_acceso', $output, TRUE));
//            $this->template->getTemplate();
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }

//        $array_permisos_menu = array(
//        "home" => array( "label" => "Mi unidad", "acceso" => true ),//9
//        "ecp" => array( "label" => "EC presencial", "acceso" => true ),//8
//        "ecp_comparativa" => array( "label" => "Comparativa", "acceso" => true ),
//        "ecp_regiones" => array( "label" => "Regiones", "acceso" => true),
//        "ecp_indicadores" => array( "label" => "Indicadores", "acceso" => true ),
//        "ed" => array( "label" => "ED", "acceso" => true), //7
//        "ed_comparativa" => array( "label" => "Comparativa", "acceso" => true ),
//        "ed_regiones" => array( "label" => "Regiones", "acceso" => true ),
//        "ed_indicadores" => array( "label" => "Indicadores", "acceso" => true),
//        "admin" => array( "label" => "Admin", "acceso" => true ), //6
//        "admin_buscar" => array( "label" => "Buscar", "acceso" => true),
//        "admin_registrar" => array( "label" => "Registrar", "acceso" => true),
//        "admin_catalogos" => array( "label" => "Catálogos", "acceso" => true, ""=>array()) 
//        );
    }

}
