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

        public function consultar($usuario, $nome, $tipo_usuario){
            $sql = "select * from usuarios where estatus = ''";

            if($usuario != '') $sql = $sql . " and usuario = '$usuario' ";
            elseif($tipo_usuario != '') $sql = $sql . " and tipo = '$tipo_usuario' ";
            elseif($nome != '') $sql = $sql . " and nome like '%$nome%' ";
         
            $retorno = $this->db->query($sql);

            if($retorno->num_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
            else $dados = array('codigo' => 6, 'msg' => 'Dados não encontrados');
            
            return $dados;
        }
    }

?>