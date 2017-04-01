<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['alert_msg'] = array(
    'SUCCESS' => array('id_msg' => 1, 'class' => 'success'),
    'DANGER' => array('id_msg' => 2, 'class' => 'danger'),
    'WARNING' => array('id_msg' => 3, 'class' => 'warning'),
    'INFO' => array('id_msg' => 4, 'class' => 'info')
);

//$config['modulos_no_sesion'] = array(
//    'sesion' => array('index', 'cerrar_sesion', ''),
//    'registro' => array('*'),
//    'account' => array('*'),
//    'pagina_no_encontrada' => array('index'),
//    'recuperar_contrasenia' => '*',
//    'captcha' => '*'
//);
//$config['modulos_sesion_generales'] = array(
//    'login' => array('cerrar_session', 'cerrar_session_ajax'),
//    'rol' => '*',
//    'pagina_no_encontrada' => array('index'),
//    'pruebas' => '*'
//);


