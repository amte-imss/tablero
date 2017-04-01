<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Registro_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * @author Ale Quiroz
     * @return type array con las delegaciones existentes
     */
    public function lista_delegaciones()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(array('id_delegacion', 'clave_delegacional', 'nombre'));
        $resultado_delegaciones = $this->db->get('catalogos.delegaciones')->result_array();
        return $resultado_delegaciones;
    }

    public function lista_nivel_atencion()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(array('id_grupo', 'nombre'));
        $resultado_nivel_atencion = $this->db->get('sistema.grupos')->result_array();
        return $resultado_nivel_atencion;
    }

    /**
     * @author Ale Quiroz
     * @return type array con los niveles de atencion
     */
    public function lista_categoria()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(array('clave_categoria', 'nombre'));
        $categoria = $this->db->get('catalogos.categorias')->result_array();
        return $categoria;
    }

    public function lista_unidad()
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->select(array('id_unidad_instituto', 'nombre'));
        $resultado_unidades = $this->db->get('catalogos.unidades_instituto')->result_array();
        return $resultado_unidades;
    }

    public function registro_usuario(&$parametros = null)
    {
        $salida['msg'] = 'Error';
        $salida['result'] = false;
        $data = array(
            "reg_delegacion" => $parametros['delegacion'],
            "asp_matricula" => $parametros['matricula']
        );

        $token = $this->seguridad->folio_random(10, TRUE);
        $pass = $this->seguridad->encrypt_sha512($token . $parametros['password'] . $token);
        $usuario = $this->empleados_siap->buscar_usuario_siap($data)['empleado'];
        //pr($usuario);
        $usuario_db = $this->get_usuario($parametros['matricula']) == null;
        if ($usuario && $usuario_db)
        {
            $unidad_instituto = $this->get_unidad($usuario['adscripcion']);
            $data = array(
                'nombre' => $usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'],
                'password' => $pass,
                'token' => $token,
                'email' => $parametros['email'],
                'matricula' => $parametros['matricula'],
                'curp' => $usuario ['curp'],
                'clave_delegacional' => $usuario ['delegacion'],
                'clave_categoria' => $usuario ['emp_keypue'],
                'id_unidad_instituto' => $unidad_instituto['id_unidad_instituto']
            );
            $salida = $this->insert_guardar($data, $parametros['grupo']);
            $salida['siap'] = $data;
        } else if (!$usuario_db)
        {
            $salida['msg'] = 'Usuario ya registrado';
        } else if (!$usuario)
        {
            $salida['msg'] = 'Usuario no registrado en SIAP';
        }
        return $salida;
    }

    private function insert_guardar(&$datos, $id_grupo)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin(); //Definir inicio de transacción

        $this->db->insert('sistema.usuarios', $datos); //nombre de la tabla en donde se insertaran
        $id_usuario = $this->db->insert_id();
        $data = array(
            'id_grupo' => $id_grupo,
            'id_usuario' => $id_usuario
        );
        $this->db->insert('sistema.grupos_usuarios', $data);
        //pr($this->db->last_query());
        //pr($datos);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $resultado['msg'] = "Ocurrió un error durante el guardado, por favor intentelo de nuevo más tarde.";
        } else
        {
            $this->db->trans_commit();
            $resultado['msg'] = 'Usuario almacenado con éxito';
            $resultado['result'] = TRUE;
        }
        return $resultado;
    }

    private function get_unidad($clave)
    {
        $unidad = null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('clave_departamental', $clave);
        $resultado = $this->db->get('catalogos.departamentos_instituto')->result_array();
        if ($resultado)
        {
            $unidad = $resultado[0];
        }
        return $unidad;
    }

    private function get_usuario($matricula)
    {
        $usuario = null;
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->where('matricula', $matricula);
        $resultado = $this->db->get('sistema.usuarios')->result_array();
        if ($resultado)
        {
            $usuario = $resultado[0];
        }
        return $usuario;
    }

    public function ver($filtros = null)
    {
        $this->db->flush_cache();
        $this->db->reset_query();

        if (isset($filtros['limit']) && $filtros['current_page'])
        {
            $this->db->limit($filtros['limit'], $filtros['current_page'] * $filtros['limit']);
        } else if (isset($filtros['limit']))
        {
            $this->db->limit($filtros['limit']);
        }

        if (isset($filtros['order']) && $filtros['order'] == 2)
        {
            $this->db->order_by('u.matricula', 'DESC');
        } else
        {
            $this->db->order_by('u.matricula', 'ASC');
        }

        $this->db->select(array(
            'u.id_usuario', 'u.nombre nombre', 'u.matricula', 'u.email'
            , 'u.clave_delegacional', 'd.nombre name_delegacion'
            , 'u.clave_categoria', 'c.nombre name_categoria'
            , 'u.id_unidad_instituto', 'ui.nombre name_unidad_ist'
            , 'd.nombre name_region'
            , 'u.email', 'ui.umae', 'u.activo'
        ));
        $this->db->join('catalogos.categorias c', 'c.clave_categoria = u.clave_categoria', 'left');
        $this->db->join('catalogos.delegaciones d', 'd.clave_delegacional = u.clave_delegacional', 'left');
        $this->db->join('catalogos.unidades_instituto ui', 'ui.id_unidad_instituto = u.id_unidad_instituto', 'left');
        $this->db->join('catalogos.regiones r', 'r.id_region = d.id_region', 'left');
        $this->db->order_by('u.id_usuario');
        $tabla = $this->db->get('sistema.usuarios u')->result_array();
        //pr($this->db->last_query());
        $this->db->reset_query();
        $resultado['tabla'] = $tabla;
        $this->db->select('count(*) cantidad');
        $resultado['total'] = $this->db->get('sistema.usuarios')->result_array()[0]['cantidad'];

        return $resultado;
    }

    public function datos_usuario($id = null)
    {


        if (is_null($id))
        {
            return null;
        }

        $select = array(
            'u.id_usuario', 'u.nombre name_user', 'u.matricula', 'u.curp'
            , 'u.clave_delegacional', 'd.nombre name_delegacion'
            , 'u.clave_categoria', 'c.nombre name_categoria'
            , 'u.id_unidad_instituto', 'ui.nombre name_unidad_ist'
            , 'r.id_region', 'd.nombre name_region', 'r.clave_regional', 'u.password'
            , 'u.email', 'ui.umae'
            , 'g.id_grupo', 'g.nombre nombre_grupo', 'g.nivel'
            , 'u.token'
        );

        $this->db->select($select);
        $this->db->from('sistema.usuarios u');
        $this->db->join('sistema.grupos_usuarios gu', 'gu.id_usuario = u.id_usuario', 'left');
        $this->db->join('sistema.grupos g', 'g.id_grupo = gu.id_grupo', 'left');
        $this->db->join('catalogos.categorias c', 'c.clave_categoria = u.clave_categoria', 'left');
        $this->db->join('catalogos.delegaciones d', 'd.clave_delegacional = u.clave_delegacional', 'left');
        $this->db->join('catalogos.unidades_instituto ui', 'ui.id_unidad_instituto = u.id_unidad_instituto', 'left');
        $this->db->join('catalogos.regiones r', 'r.id_region = d.id_region', 'left');

        $this->db->where('u.id_usuario', $id);
        $query = $this->db->get();
        //        $result = $query->row();
        $result = $query->result_array();
        $return = array();
        //        pr($this->db->last_query());
        if (count($result) > 0)
        {
            //            pr($clave);
            //            pr($result[0]['password']);
            //
      //            $return['valido'] = $result[0]['valido_password'];
            $return = $result[0];
        }

        $query->free_result();
        return $return;
    }

    public function actualiza_registro($data)
    {
        $salida = false;
        $token = $data['token'];
        $this->db->where('id_usuario', $data ['id_usuario']);
        $this->db->set('email', $data ['email']);
        $this->db->set('clave_delegacional', $data ['delegacion']);
        $this->db->set('id_unidad_instituto', $data ['unidad']);
        $this->db->set('clave_categoria', $data ['categoria']);
        $obten_registro = $this->db->update('sistema.usuarios');
        //pr($this->db->last_query());
        $salida = true;
        return $salida;
    }

    public function set_status($id_usuario = 0, $status = false)
    {
        $salida = false;
        $this->db->flush_cache();
        $this->db->reset_query();
        try
        {
            $this->db->set('activo', $status);
            $this->db->where('id_usuario', $id_usuario);
            $this->db->update('sistema.usuarios');
            $salida = true;
            //pr($this->db->last_query());
        } catch (Exception $ex)
        {
            
        }
        return $salida;
    }

    public function update_password($datos = null)
    {
        $salida = false;
        try
        {
            $this->db->flush_cache();
            $this->db->reset_query();
            $this->db->select('token');
            $this->db->where('id_usuario', $datos['id_usuario']);
            $resultado = $this->db->get('sistema.usuarios')->result_array();
            //pr($datos);
            //pr($this->db->last_query());
            if ($resultado)
            {
                $this->load->library('seguridad');
                $token = $resultado[0]['token'];
                $this->db->reset_query();
                $password = $this->seguridad->encrypt_sha512($token . $datos['password'] . $token);
                $this->db->set('password', $password);
                $this->db->where('id_usuario', $datos['id_usuario']);
                $this->db->update('sistema.usuarios');
                pr($this->db->last_query());
                $salida = true;
            }else{
               // pr('usuario no localizado');
            }
        } catch (Exception $ex)
        {
          //  pr($ex);
        }
        return $salida;
    }

    private function get_grupo($grupo)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $grupo = null;
        $this->db->where('nombre', $grupo);
        $resultado = $this->db->get('sistema.grupos')->result_array();
        if ($resultado)
        {
            $grupo = $resultado[0];
        }

        return $grupo;
    }

    public function carga_masiva(&$csv_array)
    {
        $this->db->flush_cache();
        $this->db->reset_query();
        $this->db->trans_begin(); //Definir inicio de transacción
        $registros = [];
        foreach ($csv_array as $row)
        {
            if (isset($row['matricula']) && isset($row['clave_delegacional']) && isset($row['grupo']))
            {
                $data = array(
                    "reg_delegacion" => $row['clave_delegacional'],
                    "asp_matricula" => $row['matricula']
                );
                $usuario = $this->empleados_siap->buscar_usuario_siap($data)['empleado'];
                $token = $this->seguridad->folio_random(10, TRUE);
                $pass = $this->seguridad->encrypt_sha512($token . $parametros['password'] . $token);
                $usuario = $this->empleados_siap->buscar_usuario_siap($data)['empleado'];
                $grupo = $this->get_grupo($row['grupo']);
                //pr($usuario);
                if ($usuario && $this->get_usuario($usuario['matricula']) != null && $grupo != null)
                {
                    $unidad_instituto = $this->get_unidad($usuario['adscripcion']);

                    $data = array(
                        'nombre' => $usuario['nombre'] . ' ' . $usuario['paterno'] . ' ' . $usuario['materno'],
                        'password' => $pass,
                        'token' => $token,
                        'email' => $parametros['email'],
                        'matricula' => $parametros['matricula'],
                        'curp' => $usuario ['curp'],
                        'clave_delegacional' => $usuario ['delegacion'],
                        'clave_categoria' => $usuario ['emp_keypue'],
                        'id_unidad_instituto' => $unidad_instituto['id_unidad_instituto']
                    );
                    $this->db->insert('sistema.usuarios', $data); //nombre de la tabla en donde se insertaran
                    $id_usuario = $this->db->insert_id();
                    $data = array(
                        'id_grupo' => $grupo['id_grupo'],
                        'id_usuario' => $id_usuario
                    );
                    $this->db->insert('sistema.grupos_usuarios', $data);
                    //pr($this->db->last_query());
                    //pr($datos);
                    $row[] = array('errores' => '');
                    $row[] = array('nueva password' => $pass);
                } else
                {
                    $row[] = array('errores' => 'Usuario no encontrado o ya registrado en el sistema');
                }
            } else
            {
                $row[] = array('errores' => 'Datos de matricula, grupo y delegacion inválidos');
                $registros[] = $row;
            }
        }
        
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $resultado['result'] = FALSE;
            $registros[] = 'Error en la transaccion';
            $resultado['msg'] = "Ocurrió un error durante el guardado, por favor intentelo de nuevo más tarde.";
            
        } else
        {
            $this->db->trans_commit();
            $resultado['msg'] = 'Usuarios almacenado con éxito';
            $resultado['result'] = TRUE;
        }
        $resultado['data'] = $registros;
        return $resultado;
    }

}
