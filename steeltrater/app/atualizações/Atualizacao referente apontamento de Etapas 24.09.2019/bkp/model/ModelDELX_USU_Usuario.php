<?php

/*
 * Implementa model da classe DELX_USU_Usuario
 * @author Alexandre W. de Souza
 * @since 18-10-2018
 * *** */

class ModelDELX_USU_Usuario {

    private $usu_codigo;
    private $usu_nome;
    private $usu_senha;
    private $usu_status;
    private $usu_logasistema;
    private $usu_empcodigo;

    function getUsu_codigo() {
        return $this->usu_codigo;
    }

    function getUsu_nome() {
        return $this->usu_nome;
    }

    function getUsu_senha() {
        return $this->usu_senha;
    }

    function getUsu_status() {
        return $this->usu_status;
    }

    function getUsu_logasistema() {
        return $this->usu_logasistema;
    }

    function getUsu_empcodigo() {
        return $this->usu_empcodigo;
    }

    function setUsu_codigo($usu_codigo) {
        $this->usu_codigo = $usu_codigo;
    }

    function setUsu_nome($usu_nome) {
        $this->usu_nome = $usu_nome;
    }

    function setUsu_senha($usu_senha) {
        $this->usu_senha = $usu_senha;
    }

    function setUsu_status($usu_status) {
        $this->usu_status = $usu_status;
    }

    function setUsu_logasistema($usu_logasistema) {
        $this->usu_logasistema = $usu_logasistema;
    }

    function setUsu_empcodigo($usu_empcodigo) {
        $this->usu_empcodigo = $usu_empcodigo;
    }

}
