<?php

/**
 * Implementa model da classe MET_TEC_Historico
 * @author Alexandre W de Souza
 * @since 09/10/2018
 * ** */
class ModelMET_TEC_Historico {

    private $seq;
    private $filcgc;
    private $usucodigo;
    private $usunome;
    private $data;
    private $hora;
    private $classe;
    private $historico;
    private $acao;

    function getSeq() {
        return $this->seq;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
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

    function getHistorico() {
        return $this->historico;
    }

    function getAcao() {
        return $this->acao;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
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

    function setHistorico($historico) {
        $this->historico = $historico;
    }

    function setAcao($acao) {
        $this->acao = $acao;
    }

}
