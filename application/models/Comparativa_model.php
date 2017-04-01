<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que contiene la gestion de catalogos
 * @version 	: 1.0.0
 * @author      : LEAS
 * */
class Comparativa_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    /**
     * @author LEAS
     * @param type $param Condiciones para buscar resumen de regiones
     * @return type
     */
    public function get_comparativa_delegaciones($param = null) {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $this->db->where('((NOT ( categorias . id_grupo_categoria  IS NULL)) AND (NOT ( hechos_implementaciones_alumnos . id_sexo  IS NULL)))');
        foreach ($select_adicional['group_by'] as $value) {
            $this->db->group_by($value);
        }
        $select = array(
            'SUM( hechos_implementaciones_alumnos.cantidad_alumnos_inscritos ) AS  cantidad_alumnos_inscritos',
            'SUM( hechos_implementaciones_alumnos . cantidad_alumnos_certificados ) AS  cantidad_alumnos_certificados'
        );

        if (isset($select_adicional['select'])) {
            $select = array_merge($select, $select_adicional['select']);
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_alumnos   hechos_implementaciones_alumnos');
        $this->db->join('catalogos.unidades_instituto unidades_instituto', 'hechos_implementaciones_alumnos.id_unidad_instituto  =  unidades_instituto.id_unidad_instituto');
        $this->db->join('catalogos.categorias categorias', 'hechos_implementaciones_alumnos.id_categoria = categorias.id_categoria');
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
    public function get_comparativa_regiones($param = null) {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $select = array(
            'count(c.id_curso) cantidad_cursos',
        );

        if (isset($param_addicional['select'])) {
            $select = array_merge($select, $param_addicional['select']);
        }
        foreach ($param_addicional['group_by'] as $value) {
            $this->db->group_by($value);
        }
        foreach ($param_addicional['order_by'] as $value) {
            $this->db->order_by($value);
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_alumnos hia');
        $this->db->join('catalogos.implementaciones i', 'i.id_implementacion = hia.id_implementacion');
        $this->db->join('catalogos.cursos c', 'c.id_curso = i.id_curso');
        $this->db->join('catalogos.unidades_instituto unidades_instituto', 'unidades_instituto.id_unidad_instituto = hia.id_unidad_instituto');
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
    public function get_comparativa_umaes($param = null) {
        if (!is_null($param)) {
            foreach ($param as $key => $value) {
                $this->db->where($key, $value);
            }
        }

        $select = array(
            'sum(hid.cantidad_profesores) as cantidad_docentes',
        );

        if (isset($param_addicional['select'])) {
            $select = array_merge($select, $param_addicional['select']);
        }
        foreach ($param_addicional['group_by'] as $value) {
            $this->db->group_by($value);
        }
        foreach ($param_addicional['order_by'] as $value) {
            $this->db->order_by($value);
        }

//        pr($select);
//        exit();
        $this->db->select($select);
        $this->db->from('hechos.hechos_implementaciones_docentes hid');
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

}
