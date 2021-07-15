<?php

/**
 * Implementa model da classe MET_TEC_Historico
 * @author Alexandre W de Souza
 * @since 09/10/2018
 * ** */
class ModelMET_TEC_Historico {

    private $seq;
    private $usuario;
    private $data;
    private $hora;
    private $classe;
    private $historico;

    function getHistorico() {
        return $this->historico;
    }

    function setHistorico($historico) {
        $this->historico = $historico;
    }

    function getSeq() {
        return $this->seq;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getClasse() {
        return $this->classe;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setClasse($classe) {
        $this->classe = $classe;
    }

}
