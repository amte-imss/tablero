<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para actualizar los hechos del tablero
 * @version 	: 1.0.0
 * @autor 		: Christian García
 */
class Reportes_estaticos extends MY_Controller
{

    /**
     * Carga de clases para el acceso a base de datos y obtencion de las variables de session
     * @access 		: public
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'general'));
        $this->load->library('form_complete');
        $this->load->library('form_validation');
        $this->load->model('Reportes_estaticos_model', 'reporte_model');
        $this->load->model('Login_model', 'lm');
        $data_user = $this->session->userdata('usuario');
        $info_user = $this->lm->get_genera_info_usuario($data_user['matricula']);
        $datos_perfil['usuario'] = $data_user;
        $datos_perfil['menu'] = $info_user['ui']['menu'];
        $this->ficha_usuario = $this->load->view('ci_template/ficha_usuario', $datos_perfil, true);
        $this->menu = $this->load->view('ci_template/menu', $datos_perfil, true);
    }

    public function index($status = null)
    {
        $reportes['data'] = $this->reporte_model->get_table();
        $reportes['status'] = $status;
        $datos['ficha_usuario'] = $this->ficha_usuario;
        $datos['menu'] = $this->menu;
        $datos['contenido'] = $this->load->view('reportes_estaticos/tabla', $reportes, true);
        
        $main_content = $this->load->view('admin/admin', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function upload()
    {
        if ($this->input->post())
        {     // SI EXISTE UN ARCHIVO EN POST
            $config['allowed_types'] = 'pdf';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
            $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
            $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO
            $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
            if ($this->upload->do_upload())
            {
                $this->form_validation->set_rules('nombre', 'Nombre', 'required');
                if ($this->form_validation->run())
                { //Se ejecuta la validación de datos
                    $nombre = $this->input->post("nombre");
                    $descripcion = $this->input->post("descripcion");
                    $status = $this->reporte_model->upload($nombre, $descripcion);
                    if($status){
                        redirect(site_url().'/reportes_estaticos/index/1');
                    }else{
                        redirect(site_url().'/reportes_estaticos/index/2');
                    }
                } else
                {
                    redirect(site_url().'/reportes_estaticos/draw_form/2');
                    //pr('datos no validos');
                }
            } else
            {
                //pr('fail upload');
                redirect(site_url().'/reportes_estaticos/draw_form/3');
            }
        } else
        {
            redirect(site_url().'/reportes_estaticos/draw_form/4');
        }
    }

    public function descarga($id = 0)
    {
        $reporte = $this->reporte_model->get_reporte($id);
        if ($reporte != null)
        {
//            pr($reporte);
            $size = filesize("./uploads/" . $reporte['filename']);
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $reporte['tipo']);
            header('Content-Disposition: attachment; filename="' . $reporte['filename'] . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile("./uploads/" . $reporte['filename']);
        }
    }

    public function draw_form($status = null)
    {
        $datos['ficha_usuario'] = $this->ficha_usuario;
        $datos['menu'] = $this->menu;
        $output['status'] = $status;
        $datos['contenido'] = $this->load->view('reportes_estaticos/formulario', $output, true);
        $main_content = $this->load->view('admin/admin', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

}
