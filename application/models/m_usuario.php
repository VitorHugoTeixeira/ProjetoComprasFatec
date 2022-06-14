<?php
    defined('BASEPATH') or exit ('No direct script access allowed');

    class M_usuario extends CI_Model{
        public function inserir($usuario, $senha, $nome, $tipo_usuario, $usu_sistema){
            
            $sql = "insert into usuarios (usuario, senha, nome, tipo)
                    values ('$usuario', md5('$senha'), '$nome', '$tipo_usuario')";

            $this->db->query($sql);

            if($this->db->affected_rows() > 0) 
            {
                $this->load->model('m_log');

                $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);

                if($retorno_log['codigo'] == 1){
                    $dados = array('codigo' => 1, 
                                'msg' => 'Usuário cadastrado corretamente');
                }
                else array('codigo' => 8, 'msg' => 'Houve um problema no salvamento do Log, porém, o usuário foi cadastrado corretamente');
            }
            else $dados = array('codigo' => 6, 
                            'msg' => 'Houve um problema na inserção na tabela de usuários'); 
        
            return $dados;
        }

        public function consultar($usuario, $nome, $tipo_usuario, $tipoSelect){
            if($tipoSelect){

                $sql = "select * from usuarios where estatus = ''";
    
                if($usuario != '') $sql = $sql . " and usuario = '$usuario' ";
                elseif($tipo_usuario != '') $sql = $sql . " and tipo = '$tipo_usuario' ";
                elseif($nome != '') $sql = $sql . " and nome like '%$nome%' ";
            }
            else $sql = "select * from usuarios where usuario = '$usuario'";
         
            $retorno = $this->db->query($sql);

            if($retorno->num_rows() > 0) $dados = array('codigo' => 1, 'msg' => 'Consulta efetuada com sucesso', 'dados' => $retorno->result());
            else $dados = array('codigo' => 6, 'msg' => 'Dados não encontrados');
            
            return $dados;
        }

        public function alterar($usuario, $nome, $senha, $tipo_usuario, $usu_sistema){
            $queryUpdate = "update usuarios set";
            $fieldsUpdate = [" nome = '$nome',", " senha = md5('$senha'),", " tipo = '$tipo_usuario',"];
            
            if($nome != '') $queryUpdate = $queryUpdate . $fieldsUpdate[0];
            if($senha != '') $queryUpdate = $queryUpdate . $fieldsUpdate[1];
            if($tipo_usuario != '') $queryUpdate = $queryUpdate . $fieldsUpdate[2];
            if($tipo_usuario == '' && $senha == '' && $nome == '') return array('codigo' => 7, 'msg' => 'Nenhum dado informado para atualizar');

            //Remover a última virgula da string
            $queryUpdate = substr($queryUpdate, 0, -1) . " where usuario = '$usuario'";
            
            $this->db->query($queryUpdate);



            if($this->db->affected_rows() > 0)
            {
                $this->load->model('m_log');
                $retorno_log = $this->m_log->inserir_log($usu_sistema, $queryUpdate);

                if($retorno_log['codigo'] == 1){
                    $dados = array('codigo' => 1, 'msg' => 'Usuário atualizado corretamente');
                }
                else array('codigo' => 8, 'msg' => 'Houve um problema no salvamento do Log, porém, o usuário foi atualizado corretamente');
                
            } 
            else $dados = array('codigo' => 6, 'msg' => 'Houve um problema na atualização da tabela de usuários'); 
        
            return $dados;
        }

        public function desativar($usuario, $usu_sistema){
            $usuarioConsulta = $this->m_usuario->consultar($usuario, '', '', false);

            if($usuarioConsulta['codigo'] == 1 && $usuarioConsulta['dados'][0]->estatus == ''){
                $sql = "update usuarios set estatus = 'D' where usuario = '$usuario'";
            
                $this->db->query($sql);

            if($this->db->affected_rows() > 0){
                $this->load->model('m_log');
                $retorno_log = $this->m_log->inserir_log($usu_sistema, $sql);
                
                if($retorno_log['codigo'] == 1){
                    $dados = array('codigo' => 1, 'msg' => 'Usuário DESATIVADO corretamente');

                }else array('codigo' => 8, 'msg' => 'Houve um problema no salvamento do Log, porém, o usuário foi cadastrado corretamente');
                
            } 
            else $dados = array('codigo' => 6, 'msg' => 'Houve um problema na DESATIVAÇÃO do usuário');
            }
            else $dados = array('codigo' => 6, 'msg' => 'Usuário já está desabilitado para acesso');
        
            return $dados;
        }

    }

?>