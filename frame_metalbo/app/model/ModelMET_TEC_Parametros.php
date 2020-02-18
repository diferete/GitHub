<?php

/* 
 * Classe que controla o model 
 * 
 * @author Avanei Martendal
 * @since 25/08/2017
 */

class ModelMET_TEC_Parametros {
    private $codigo;
    private $parametro;
    private $valor;
    private $aplicacao;
    private $filcgc;
    private $officecod;


    function getFilcgc() {
        return $this->filcgc;
    }

    function getOfficecod() {
        return $this->officecod;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setOfficecod($officecod) {
        $this->officecod = $officecod;
    }

        
    function getAplicacao() {
        return $this->aplicacao;
    }

    function setAplicacao($aplicacao) {
        $this->aplicacao = $aplicacao;
    }

        
    function getCodigo() {
        return $this->codigo;
    }

    function getParametro() {
        return $this->parametro;
    }

    function getValor() {
        return $this->valor;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setParametro($parametro) {
        $this->parametro = $parametro;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }


}

