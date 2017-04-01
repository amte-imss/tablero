<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catálogos
 * @version 	: 1.0.0
 * @author      : JZDP
 * */
class Datos_catalogo extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Datos_catalogo_model', 'dcm');
    }

    public function categorias($json = true) {
        $param['select'] = array('clave_categoria clave', 'nombre');
        $categorias = $this->dcm->get_categorias($param);
        if ($json) {
            echo json_encode($categorias, JSON_UNESCAPED_UNICODE);
        } else {
            return $categorias;
        }
    }

}
