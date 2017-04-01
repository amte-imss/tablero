<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT !== "development")
        {
            $this->load->database();
        }
        $this->load->library("session");
        $this->load->helper('url');
        $this->load->model('Login_model', 'lm');
        $data_user = $this->session->userdata('usuario');
        $info_user = $this->lm->get_genera_info_usuario($data_user['matricula']);
        $datos_perfil['usuario'] = $data_user;
        $datos_perfil['menu'] = $info_user['ui']['menu'];
        $this->ficha_usuario = $this->load->view('ci_template/ficha_usuario', $datos_perfil, true);
        $this->menu = $this->load->view('ci_template/menu', $datos_perfil, true);       
        $this->modal = $this->load->view("ci_template/modal_info_usuario");
    }

    public function index()
    {
        echo "Error 404";
    }

    public function registrar()
    {

        $componenetes['ficha_usuario'] = $this->ficha_usuario;
        $componenetes['menu'] = $this->menu;
        $componenetes['modal'] = $this->modal; 
        $main_content = $this->load->view('admin/admin', $componenetes, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
    }

    /**
     * Grocery crud de usuarios registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function usuarios()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('usuarios');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function grupos()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('grupos');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de servicios registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function servicios()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('servicios_rest');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de tipos de servicios registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function tipos_servicios()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('tipos_servicios');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de servicios por grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function servicios_grupos()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('servicios_grupos');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de usaurios en grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function grupos_usuarios()
    {
        try
        {
            $this->db->schema = 'sistema';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('grupos_usuarios');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de usaurios en grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function routes()
    {
        try
        {
            $this->db->schema = 'ui';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('angular_routes');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de usaurios en grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function menus()
    {
        try
        {
            $this->db->schema = 'ui';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('menus');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    /**
     * Grocery crud de usaurios en grupos registrados
     * @author Christian Garcia
     * @version 8 marzo 2017
     */
    public function permisos_menus()
    {
        try
        {
            $this->db->schema = 'ui';
            //pr($this->db->list_tables()); //Muestra el listado de tablas pertenecientes al esquema seleccionado

            $crud = $this->new_crud();
            $crud->set_table('servicios_routes_menus');

            $output = $crud->render();
            $view['ficha_usuario'] = $this->ficha_usuario;
            $view['menu'] = $this->menu;
            $view['contenido'] = $this->load->view('catalogo/gc_output', $output, true);
            $main_content = $this->load->view('admin/admin', $view, true);
            $this->template->setMainContent($main_content);
            $this->template->getTemplate();
        } catch (Exception $e)
        {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

}
