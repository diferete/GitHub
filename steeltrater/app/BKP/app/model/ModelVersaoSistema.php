<?php

/*
 * Classe que gerencia o Model da VersaoSistema
 * @author: Alexandre W. de Souza
 * @since: 15/09/2017
 * 
 */

class ModelVersaoSistema {

    private $seq;
    private $tec;
    private $usucodigo;
    private $usunome;
    private $versao;
    private $data;
    private $hora;
    private $descricao;
    private $equipe;

    function getSeq() {
        return $this->seq;
    }

    function getTec() {
        return $this->tec;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getVersao() {
        return $this->versao;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getEquipe() {
        return $this->equipe;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setTec($tec) {
        $this->tec = $tec;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setVersao($versao) {
        $this->versao = $versao;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setEquipe($equipe) {
        $this->equipe = $equipe;
    }


}



