<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config = array(
    'form_user_update_password' => array(
       array(
            'field' => 'pass',
            'label' => 'Contraseña',
            'rules' => 'required|min_length[8]'
        ),
        array(
            'field' => 'pass_confirm',
            'label' => 'Confirmar contraseña',
            'rules' => 'required|min_length[8]' //|callback_valid_pass
        ),
    ),
    'form_actualizar' => array(
        array(
            'field' => 'delegacion',
            'label' => 'Delegación',
            'rules' => 'required' //|callback_valid_pass
        ),
        array(
            'field' => 'email',
            'label' => 'Correo electrónico',
            'rules' => 'trim|required|valida_correo_electronico' //|callback_valid_pass
        ),
        array(
            'field' => 'unidad',
            'label' => 'Unidad',
            'rules' => 'required' //|callback_valid_pass
        )
    ),
    'form_registro' => array(
        array(
            'field' => 'matricula',
            'label' => 'Matrícula',
            'rules' => 'required|max_length[18]|alpha_dash'
        ),
        array(
            'field' => 'delegacion',
            'label' => 'Delegación',
            'rules' => 'required' //|callback_valid_pass
        ),
        array(
            'field' => 'email',
            'label' => 'Correo electrónico',
            'rules' => 'trim|required|valida_correo_electronico' //|callback_valid_pass
        ),
        array(
            'field' => 'pass',
            'label' => 'Contraseña',
            'rules' => 'required' //|callback_valid_pass
        ),
        array(
            'field' => 'repass',
            'label' => 'Confirmación contraseña',
            'rules' => 'required|matches[pass]'
        ),
        array(
            'field' => 'niveles',
            'label' => 'Niveles de Atencion',
            'rules' => 'required'
        )
    ),
    'inicio_sesion' => array(
        array(
            'field' => 'usuario',
            'label' => 'Matrícula',
            'rules' => 'required|max_length[9]|is_numeric'
        ),
        array(
            'field' => 'password',
            'label' => 'Contraseña',
            'rules' => 'required|min_length[1]' //|callback_valid_pass
        ),
        /* array(
          'field'=>'curp',
          'label'=>'CURP',
          'rules'=>'required|exact_length[18]'
          ), */
        array(
            'field' => 'captcha',
            'label' => 'C&oacute;digo de seguridad',
            'rules' => 'required|check_captcha'
        ),
    ),
        //**Fin de validación de actividad docenete********************************
);





// VALIDACIONES
/*
             * isset
             * valid_email
             * valid_url
             * min_length
             * max_length
             * exact_length
             * alpha
             * alpha_numeric
             * alpha_numeric_spaces
             * alpha_dash
             * numeric
             * is_numeric
             * integer
             * regex_match
             * matches
             * differs
             * is_unique
             * is_natural
             * is_natural_no_zero
             * decimal
             * less_than
             * less_than_equal_to
             * greater_than
             * greater_than_equal_to
             * in_list
             * validate_date_dd_mm_yyyy
             * validate_date
             * form_validation_match_date  la fecha debe ser mayor que ()
             *
             *
             *
             */


//custom validation

/*

alpha_accent_space_dot_quot
 *
alpha_numeric_accent_slash
 *
alpha_numeric_accent_space_dot_parent
 *
alpha_numeric_accent_space_dot_double_quot

*/

/*
*password_strong
*
*
*
*
*/
