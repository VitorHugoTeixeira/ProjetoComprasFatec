<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Login extends CI_Controller {
        
        public function logar() {
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = isset($resultado->usuario) ? $resultado->usuario : '';
            $senha = isset($resultado->senha) ? $resultado->senha : '';

            if(trim($usuario) == ''){
                $retorno = array('codigo' => 2,
                                'msg' => 'Usuário não informado');
            }else if(trim($senha) == ''){
                $retorno = array('codigo' => 3,
                                'msg' => 'Senha não informada');
            }else {
                 $this->load->model('m_acesso');

                 $retorno = $this->m_acesso->validalogin($usuario, $senha);
            }

            echo json_encode($retorno);
        }
    }

?>