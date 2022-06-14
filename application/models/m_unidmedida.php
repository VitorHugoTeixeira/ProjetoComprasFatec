<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_unidmedida extends CI_Model{
        public function inserir($sigla, $descricao, $usuario){ 
            
            $this->load->model('m_usuario');

            if($this->m_usuario->consultar($usuario, '', '', true)['codigo'] == 1){
                $sql = "insert into unid_medida (sigla, descricao ,usucria)
                        values ('$sigla', '$descricao', '$usuario')";
    
                $this->db->query($sql);

            if($this->db->affected_rows() > 0) 
            {
                $this->load->model('m_log');

                $retorno_log = $this->m_log->inserir_log($usuario, $sql);

                if($retorno_log['codigo'] == 1){
                    $dados = array('codigo' => 1, 
                                'msg' => 'Unidade de medida cadastrada corretamente');
                }
                else array('codigo' => 7, 'msg' => 'Houve um problema no salvamento do Log, porém, a unidade de medida cadastrada corretamente');
            }
            else $dados = array('codigo' => 6, 
                            'msg' => 'Houve um problema na inserção na tabela de unidade de medida');
            }
            else $dados = array('codigo' => 8, 'msg' => 'Usuário utilizado na inserção não existe!');
            
            return $dados;
        }

        public function consultar($codigo, $sigla, $descricao){
            $sql = "select * from unid_medida where estatus = ''";

            if($codigo != '' && $codigo != 0) $sql = $sql . " and cod_unidade = '$codigo' ";
            if($sigla != '') $sql = $sql . " and sigla = '$sigla' ";
            if($descricao != '') $sql = $sql . " and descricao like '%$descricao%' ";
         
            $retorno = $this->db->query($sql);

            if($retorno->num_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
            else $dados = array('codigo' => 6, 'msg' => 'Dados não encontrados');
            
            return $dados;
        }

        public function alterar($codigo, $sigla, $descricao, $usuario){
            if(trim($sigla) != '' && trim($descricao) != ''){
                $sql = "update unid_medida set sigla = '$sigla', descricao = '$descricao' 
                        where cod_unidade = '$codigo'"; 
            }
            else if(trim($sigla) != ''){
                $sql = "update unid_medida set sigla = '$sigla' where cod_unidade = '$codigo'";
            }
            else{
                $sql = "update unid_medida set descricao = '$descricao' where cod_unidade = '$codigo'";
            }

            $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $this->load->model('m_log');

                $retorno_log = $this->m_log->inserir_log($usuario, $sql);

                if($retorno_log['codigo'] == 1){
                    $dados = array('codigo' => 1,
                                   'msg' => 'Unidade de medida atualizada corretamente');
                }
                else{
                    $dados = array('codigo' => 7,
                                   'msg' => 'Houve algum problema no salvamento do log, porém 
                                            , unidade de medida cadastrada corretamente');
                }
            }
            else{
                $dados = array('codigo' => 6,
                               'msg' => 'Houve algum problema na atualização na tabela de unidade de medida');
            }

            return $dados;
        }

        public function desativar($codigo, $usuario){
            
            $sql = "select * from produtos where unid_medida = '$codigo' and estatus = ''"; 
           
            $retorno = $this->db->query($sql);

            if($retorno->num_rows() > 0){
                $dados = array('codigo' => 3,
                               'msg' => 'Não podemos desativar, existem produtos com essa unidade de medida cadastrado(s)');
            }
            else{
                $sql2 = "update unid_medida set estatus = 'D' where cod_unidade = '$codigo'";
                $this->db->query($sql2);

                if($this->db->affected_rows() > 0){
                    $this->load->model('m_log');
    
                    $retorno_log = $this->m_log->inserir_log($usuario, $sql);
    
                    if($retorno_log['codigo'] == 1){
                        $dados = array('codigo' => 1,
                                       'msg' => 'Unidade de medida DESATIVADA corretamente');
                    }
                    else{
                        $dados = array('codigo' => 8,
                                       'msg' => 'Houve algum problema no salvamento do log, porém 
                                                , unidade de medida desativada corretamente');
                    }
                }
                else{
                    $dados = array('codigo' => 7,
                                   'msg' => 'Houve algum problema na DESATIVAÇÃO da unidade de medida');
                }
    
            }
            
            return $dados;
        }
    }

?>