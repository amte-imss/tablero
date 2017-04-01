<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Datos_catalogo_model extends CI_Model {

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
    public function get_categorias($param = null) {
        if (!is_null($param) and isset($param['select'])) {
            $query = $this->db->select($param['select']);
        }

        $query = $this->db->get('catalogos.categorias');
        return $query->result_array();
    }

}
