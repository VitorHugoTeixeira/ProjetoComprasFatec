<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_acesso extends CI_Model{
        public function validalogin($usuario, $senha){
            
            $this->load->model('m_usuario');
            $usuarioConsulta = $this->m_usuario->consultar($usuario, '', '', false);

            if($usuarioConsulta['codigo'] == 1) {

                if($usuarioConsulta['dados'][0]->senha == md5($senha)){

                    if($usuarioConsulta['dados'][0]->estatus == '') $dados = array('codigo' => 1, 'msg' => 'Usuário correto!');
                    else $dados = array('codigo' => 1, 'msg' => 'Usuário desabilitado para acesso!');
                }
                else{
                    $dados = array('codigo' => 3, 'msg' => 'Senha incorreta!');
                } 
                
            }
            else  $dados = array('codigo' => 2, 'msg' => 'Usuário não existe no sistema');
    

            return $dados;
        }
    }

?>