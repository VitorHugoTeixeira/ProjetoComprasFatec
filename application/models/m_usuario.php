<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_usuario extends CI_Model{
        public function inserir($usuario, $senha, $nome, $tipo_usuario){
            $this->db->query("insert into usuarios (usuario, senha, nome, tipo)
                             values ('$usuario', md5('$senha'), '$nome', '$tipo_usuario')");

            if($this->db->affected_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Usuário cadastrado corretamente');
            else $dados = array('codigo' => 6, 'msg' => 'Houve um problema na inserção na tabela de usuários'); 
        
            return $dados;
        }
    }

?>