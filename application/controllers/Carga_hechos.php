<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controlador para actualizar los hechos del tablero
 * @version 	: 1.0.0
 * @autor 		: Christian García
 */
class Carga_hechos extends CI_Controller
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
        $this->load->model('Carga_hechos_model', 'carga_model');
        $this->load->model('Login_model', 'lm');
        $data_user = $this->session->userdata('usuario');
        $info_user = $this->lm->get_genera_info_usuario($data_user['matricula']);
        $datos_perfil['usuario'] = $data_user;
        $datos_perfil['menu'] = $info_user['ui']['menu'];
        $this->ficha_usuario = $this->load->view('ci_template/ficha_usuario', $datos_perfil, true);
        $this->menu = $this->load->view('ci_template/menu', $datos_perfil, true);
    }

    /**
     * Acceso principal del controlador.
     * @autor 		: Christian García
     * @modified 	:
     * @access 		: public
     */
    public function index()
    {
        redirect(site_url());
    }

    public function upload()
    {
        if ($this->input->post())
        {     // SI EXISTE UN ARCHIVO EN POST
            $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
            $config['allowed_types'] = 'gz';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
            $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO
            $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
            if ($this->upload->do_upload())
            {
                $json = $this->carga_model->get_content_file();
                if ($this->carga_model->valid_json($json)['status'])
                {
                    $json = json_decode($json, true);
                    $resultado = $this->carga_model->insert_data($json);
                    if($resultado['result']){
                        redirect(site_url().'/carga_hechos/get_lista/1');
                    }else{
                        redirect(site_url().'/carga_hechos/draw_form/3');
                    }
                } else
                {
                    redirect(site_url().'/carga_hechos/draw_form/3');
                }
            } else
            {
                redirect(site_url().'/carga_hechos/draw_form/2');
            }
        } else
        {
            redirect(site_url().'/carga_hechos/draw_form');
        }
    }

    public function update_carga($id = 0, $activo = 0)
    {
        pr($activo);
        if ($id > 0)
        {
            $this->carga_model->update($id, $activo);
        }
    }

    public function get_lista($status = null)
    {
        $datos['ficha_usuario'] = $this->ficha_usuario;
        $datos['menu'] = $this->menu;
        $data['status'] = $status;
        $data['lista'] = $this->carga_model->get_lista();
        $datos['contenido'] = $this->load->view('carga_hechos/lista', $data, true);
        $main_content = $this->load->view('admin/admin', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    public function draw_form($status = null)
    {
        $datos['ficha_usuario'] = $this->ficha_usuario;
        $datos['menu'] = $this->menu;
        $output['status'] = $status;
        $datos['contenido'] = $this->load->view('carga_hechos/formulario', $output, true);
        $main_content = $this->load->view('admin/admin', $datos, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

}
