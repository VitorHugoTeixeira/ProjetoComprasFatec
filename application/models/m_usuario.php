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

        public function alterar($usuario, $nome, $senha, $tipo_usuario){
            $queryUpdate = "update usuarios set";
            $fieldsUpdate = [" nome = '$nome',", " senha = md5('$senha'),", " tipo = '$tipo_usuario',"];
            
            if($nome != '') $queryUpdate = $queryUpdate . $fieldsUpdate[0];
            if($senha != '') $queryUpdate = $queryUpdate . $fieldsUpdate[1];
            if($tipo_usuario != '') $queryUpdate = $queryUpdate . $fieldsUpdate[2];
            if($tipo_usuario == '' && $senha == '' && $nome == '') return array('codigo' => 7, 'msg' => 'Nenhum dado informado para atualizar');

            //Remover a última virgula da string
            $queryUpdate = substr($queryUpdate, 0, -1) . " where usuario = '$usuario'";
            
            $this->db->query($queryUpdate);

            if($this->db->affected_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Usuário atualizado corretamente');
            else $dados = array('codigo' => 6, 'msg' => 'Houve um problema na inserção na tabela de usuários'); 
        
            return $dados;
        }

        public function desativar($usuario){
            $this->db->query("update usuarios set estatus = 'D' where usuario = '$usuario'");

            if($this->db->affected_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Usuário DESATIVADO corretamente');
            else $dados = array('codigo' => 6, 'msg' => 'Houve um problema na DESATIVAÇÃO do usuário'); 
        
            return $dados;
        }

    }

?>