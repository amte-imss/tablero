<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author: Mr. Guag
 * @version: 1.0
 * @desc: Clase padre de los controladores del sistema
 * */
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        //definir un estandar para los archivos de lenguaje
        $this->lang->load('interface', 'spanish');
        //$string_values = $this->lang->line('interface');
    }

    public function check_captcha_form($str) {
        $datos['capt_sess'] = 'txt_captcha';
        return $this->captcha_becas->check_captcha($str, $datos);
    }

    /*
      Explicación $\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$
      $ = Inicio de cadena
      \S* = Cualquier set de caracteres
      (?=\S{8,}) = longitud de al menos 8 caracteres
      (?=\S*[a-z]) = asegurar que al menos existe una letra minúscula
      (?=\S*[A-Z]) = asegurar que al menos existe una letra mayúscula
      (?=\S*[\d]) = asegurar que al menos exista un número
      (?=\S*[\W]) = y asegurar que al menos tenga un caracter especial (+%#.,);
      $ = fin de la cadena */

    function valid_pass($candidate) {
        if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[-+%#.,;:\d])\S*$', $candidate, $condiciones)) {
            return FALSE;
        }
        return TRUE;
    }

    /** Explicación
     * ^                               - A partir de la linea/cadena
      (?=.{8})                       - busqueda incremental para asegurar que se tienen 8 caracteres
      (?=.*[A-Z])                    - ...para asegurar que tenemos al menos un caracter en mayuscula
      (?=.*[a-z])                    - ...para asegurar que tenemos al menos un caracter en minuscula
      (?=.*\d.*\d.*\d                - ...para asegurar que tenemos al menos tres digitos
      (?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])
      - ...para asegurar que tiene al menos 3 caracteres especiales (caracteres diferentes a letras y numeros)
      [-+%#a-zA-Z\d]+                - combinacion de caracteres permitidos
      $                              - fin de la linea/cadena
     */
    public function password_strong($str) {
        //$exp = '/^(?=.{8})(?=.*[A-Z])(?=.*[a-z])(?=.*\d.*\d.*\d)(?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])[-+%#a-zA-Z\d]+$/u';
        $exp = '/^(?=.{8})(?=.*[A-Z])(?=.*[a-z])(?=.*\d.*\d.*\d)(?=.*[^a-zA-Z\d].*[^a-zA-Z\d].*[^a-zA-Z\d])[-+%#a-zA-Z.,;:\d]+$/u';
        return (!preg_match($exp, $str)) ? FALSE : TRUE;
    }

    public function new_crud() {
        $db_driver = $this->db->platform();
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
    
    public function print_excel($metodo = null){
        if(method_exists ($this, $metodo)){
            $series_nombres_string = $this->input->post("series_nombres");
            $datos = array();
            $datos["nombres_series"] = explode(',', $series_nombres_string);
            $datos_json = $this->{$metodo}(false);
            $datos["resultset"] = json_decode($datos_json);
            if(json_last_error() == JSON_ERROR_NONE){
                header("Content-type: application/vnd.ms-excel");
                header("Content-Disposition: attachment; filename=archivo.xls");
                header("Pragma: no-cache");
                header("Expires: 0");
                $html = $this->load->view("exportar/comparativas_excel", $datos , true);
                echo $html;
            }
        }
    }

}
