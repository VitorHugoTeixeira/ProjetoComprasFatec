<?php

use LDAP\Result;

defined('BASEPATH') or exit('No direct script access allowed');

class UnidMedida extends CI_Controller
{
    public function inserir()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $resultado->usuario;

        if (trim($sigla) == '') $retorno = array(
            'codigo' => 2,
            'msg' => 'Sigla não informada');
        elseif (strlen(trim($sigla)) > 3) $retorno = array(
            'codigo' => 3,
            'msg' => 'Sigla pode conter no máximo 3 caracteres');
        elseif (trim($descricao) == '') $retorno = array(
            'codigo' => 4,
            'msg' => 'Descrição não informada');
        elseif (trim($usuario) == '') $retorno = array(
            'codigo' => 5,
            'msg' => 'Usuário não informada');
        else {
            $this->load->model('m_unidmedida');

            $retorno = $this->m_unidmedida->inserir($sigla, $descricao, $usuario);
        }

        echo json_encode($retorno);
    }

    public function consultar()
    {
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;

        if (strlen(trim($sigla)) > 3) $retorno = array(
            'codigo' => 3,
            'msg' => 'Sigla pode conter no máximo 3 caracteres'
        );
        else {
            $this->load->model('m_unidmedida');

            $retorno = $this->m_unidmedida->consultar($codigo, $sigla, $descricao);
        }

        echo json_encode($retorno);
    }

    public function alterar(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;
        $sigla = $resultado->sigla;
        $descricao = $resultado->descricao;
        $usuario = $resultado->usuario;

        if (trim($codigo) == '') $retorno = array(
            'codigo' => 2,
            'msg' => 'Código não informado');
        elseif (strlen(trim($sigla)) > 3) $retorno = array(
            'codigo' => 3,
            'msg' => 'Sigla pode conter no máximo 3 caracteres');
        elseif (trim($descricao) == '' && trim($sigla) == '') $retorno = array(
            'codigo' => 4,
            'msg' => 'Descrição e Siglas não informadas');
        elseif (trim($usuario) == '') $retorno = array(
            'codigo' => 5,
            'msg' => 'Usuário não informado');
        else {
            $this->load->model('m_unidmedida');

            $retorno = $this->m_unidmedida->alterar($codigo, $sigla, $descricao, $usuario);
        }

        echo json_encode($retorno);


    }

    public function desativar(){
        $json = file_get_contents('php://input');
        $resultado = json_decode($json);

        $codigo = $resultado->codigo;

        $usuario = $resultado->usuario;

        if (trim($codigo) == '') $retorno = array(
            'codigo' => 2,
            'msg' => 'Código não informado');
        elseif (trim($usuario) == '') $retorno = array(
            'codigo' => 5,
            'msg' => 'Usuário não informado');
        else {
            $this->load->model('m_unidmedida');

            $retorno = $this->m_unidmedida->desativar($codigo, $usuario);
        }

        echo json_encode($retorno);
    }

}
