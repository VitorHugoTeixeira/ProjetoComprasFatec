<?php

use LDAP\Result;

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Usuario extends CI_Controller {
        
        public function inserir(){
            
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;
            $senha = $resultado->senha;
            $nome = $resultado->nome;
            $tipo_usuario = strtoupper($resultado->tipo_usuario);

            $usu_sistema = strtoupper($resultado->usu_sistema);

            if(trim($usu_sistema) == '') $retorno = array('codigo' => 7, 'msg' => 'Usuário do sistema não informado');
            elseif(trim($usuario) == '') $retorno = array('codigo' => 2, 'msg' => 'Usuário não informado');
            else if(trim($senha) == '') $retorno = array('codigo' => 3, 'msg' => 'Senha não informada');
            else if(trim($nome) == '') $retorno = array('codigo' => 4, 'msg' => 'Nome não informado');
            else if((trim($tipo_usuario) != 'ADMINISTRADOR' && 
                    trim($tipo_usuario) != 'COMUM') || 
                    trim($tipo_usuario == '')) $retorno = array('codigo' => 5, 'msg' => 'Tipo de usuário inválido');
            else{
                $this->load->model('m_usuario');

                $retorno = $this->m_usuario->inserir($usuario, $senha, $nome, $tipo_usuario, $usu_sistema);
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

                $retorno = $this->m_usuario->consultar($usuario, $nome, $tipo_usuario, true);
            }

            echo json_encode($retorno);
        }

        public function alterar(){
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = isset($resultado->usuario) ? $resultado->usuario : '';
            $senha = isset($resultado->senha) ? $resultado->senha : ''; //isset para verificar se a variável existe
            $nome = isset($resultado->nome) ? $resultado->nome : ''; //isset para verificar se a variável existe
            $tipo_usuario = isset($resultado->tipo_usuario) ? strtoupper($resultado->tipo_usuario) : ''; 
            $usu_sistema = isset($resultado->usu_sistema) ? strtoupper($resultado->usu_sistema) : '';

            if(trim($usu_sistema) == '') $retorno = array('codigo' => 7, 'msg' => 'Usuário do sistema não informado');
            elseif(trim($tipo_usuario) != 'ADMINISTRADOR' && trim($tipo_usuario) != 'COMUM' && $tipo_usuario != '') $retorno = array('codigo' => 5, 
                                'msg' => 'Tipo de usuário inválido');
            elseif(trim($usuario) == '') $retorno = array('codigo' => 2, 
                                'msg' => 'Usuário não informado');
            else{
                $this->load->model('m_usuario');
                $retorno = $this->m_usuario->alterar($usuario, $nome, $senha, $tipo_usuario, $usu_sistema);
            }

            echo json_encode($retorno);
        }

        public function desativar(){
            $json = file_get_contents('php://input');
            $resultado = json_decode($json);

            $usuario = $resultado->usuario;

            $usu_sistema = strtoupper($resultado->usu_sistema);

            if(trim($usu_sistema) == '') $retorno = array('codigo' => 7, 'msg' => 'Usuário do sistema não informado');
            elseif(trim($usuario) == '') $retorno = array('codigo' => 2, 'msg' => 'Usuário não informado');
            else{
                $this->load->model('m_usuario');
                $retorno = $this->m_usuario->desativar($usuario, $usu_sistema);
            }


            echo json_encode($retorno);
        }
    }

?>