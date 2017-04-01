<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modelo para agregar, modificar, eliminar hechos estaticos del tablero
 * @version 	: 1.0.0
 * @autor 		: Christian García
 */
class Reportes_estaticos_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * Carga de un reporte estatico
     * @param type $nombre - nombre del reporte
     * @param type $descripcion - descripcion del reporte
     */
    public function upload($nombre = null, $descripcion = null)
    {
        $salida = false;
        if ($nombre != null)
        {
            $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
            //reiniciamos el query y borramos cache por si las moscas
            $this->db->flush_cache();
            $this->db->reset_query();
            $data = array(
                'nombre' => $nombre,
                'filename' => $file_data['file_name'],
                'tipo' => $file_data['file_type'],
                'descripcion' => $descripcion
            );
            $this->db->insert('hechos.reportes_estaticos', $data);
            $salida = true;
        }
        return $salida;
    }

    public function get_table($filtros = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $resultado = $this->db->get('hechos.reportes_estaticos')->result_array();
        return $resultado;
    }

    public function get_reporte($id = 0)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('id_reporte_estatico', $id);
        $resultado = $this->db->get('hechos.reportes_estaticos')->result_array();
        if (count($resultado) > 0)
        {
            return $resultado[0];
        }
        return null;
    }

    /**
     * Metodo para marcar como activo/inactivo un reporte
     * @author Christian Garcia
     * @version 8 marzo 2017
     * @param type $id
     * @param type $status 
     */
    function delete_reporte($id = 0, $status = false)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('id_reporte_estatico', $id);
        $this->db->set('activo', $status);
        $this->db->update('hechos.reportes_estaticos');
    }

}
