<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona la entrega de las vistas
 * @version 	: 1.0.0
 * @autor 	: D.P.G
 */
class Exportar extends MY_Controller {

    /**
     * * @access 	: public
     * * @modified 	: 
     */
    public function __construct() {
        parent::__construct();
    }

    
    // Método para imprimir reportes comparativas en pdf
    public function print_pdf(){
        $data_post = $this->input->post();
        if(isset($data_post['imagen'])){
            $this->load->helper(array('dompdf', 'file'));
            $fecha = date("Y-m-d");
            $nombre_pdf = "";
            
            // La grafica de tipo radar se imprimer en veertical
//            $options["orientacion"] = $data_post["tipo_grafica"] === "radar" ? "portrait" : "landscape" ; 
//            $data_post["options"] = $options["orientacion"];
            $options["orientacion"] = "landscape";
            $html = $this->load->view("exportar/comparativas_pdf", $data_post, true);
            generarPdf($html, 'reporte_'.$fecha, $options);
        }
    }

    // Mpetodod para imprimir reportes de comparativas en excel
//    public function print_excel(){
//        $datos = $this->input->post();
//        $tabla = $this->load->view("exportar/comparativas_excel", $datos, true);
//        echo $tabla;
//    }
    
}
