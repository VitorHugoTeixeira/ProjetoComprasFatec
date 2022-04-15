<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Usuario extends CI_Controller {
        
        public function inserir(){
            
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;
            $senha = $resultado->senha;
            $nome = $resultado->nome;
            $tipo_usuario = strtoupper($resultado->tipo_usuario);

            if(trim($usuario) == '') $retorno = array('codigo' => 2, 'msg' => 'Usuário não informado');
            else if(trim($senha) == '') $retorno = array('codigo' => 3, 'msg' => 'Senha não informada');
            else if(trim($nome) == '') $retorno = array('codigo' => 4, 'msg' => 'Nome não informado');
            else if((trim($tipo_usuario) != 'ADMINISTRADOR' && 
                    trim($tipo_usuario) != 'COMUM') || 
                    trim($tipo_usuario == '')) $retorno = array('codigo' => 5, 'msg' => 'Tipo de usuário inválido');
            else{
                $this->load->model('m_usuario');

                $retorno = $this->m_usuario->inserir($usuario, $senha, $nome, $tipo_usuario);
            }

            echo json_encode($retorno);
        }

        public function consultar(){
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;
            $nome = $resultado->nome;
            $tipo_usuario = strtoupper($resultado->tipo_usuario);

            if(trim($tipo_usuario) != 'ADMINISTRADOR' &&
               trim($tipo_usuario) != 'COMUM' &&
               trim($tipo_usuario) != ''){
                   $retorno = array('codigo' => 5,
                                    'msg' => 'Tipo de usuário inválido');
               }
            else{
                $this->load->model('m_usuario');

                $retorno = $this->m_usuario->consultar($usuario, $nome, $tipo_usuario);
            }

            echo json_encode($retorno);
        }

        public function alterar(){
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;
            $senha = $resultado->senha;
            $nome = $resultado->nome;
            $tipo_usuario = strtoupper($resultado->tipo_usuario);

            if(trim($tipo_usuario) != 'ADMINISTRADOR' &&
               trim($tipo_usuario) != 'COMUM' &&
               trim($tipo_usuario) != ''){
                   $retorno = array('codigo' => 5,
                                    'msg' => 'Tipo de usuário inválido');
               }
            else if(trim($nome) == '') $retorno = array('codigo' => 3, 'msg' => 'Nome não informado');
            elseif(trim($usuario) == '') $retorno = array('codigo' => 2, 'msg' => 'Usuário não informado');
            else if(trim($senha) == '') $retorno = array('codigo' => 4, 'msg' => 'Senha não pode estar vazia');
            else{
                $this->load->model('m_usuario');

                $retorno = $this->m_usuario->alterar($usuario, $nome, $senha, $tipo_usuario);
            }

            echo json_encode($retorno);
        }

        public function desativar(){
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;

            if(trim($usuario) == '') $retorno = array('codigo' => 2, 'msg' => 'Usuário não informado');
            else{
                $this->load->model('m_usuario');

                $retorno = $this->m_usuario->desativar($usuario);
            }

            echo json_encode($retorno);
        }
    }

?>