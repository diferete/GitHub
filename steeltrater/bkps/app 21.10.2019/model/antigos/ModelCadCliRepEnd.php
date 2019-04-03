<?php

/**
 * Class que implementa a model CadCliRepEnd para inserçao de cobrancás 
 * @author Avanei Martendal
 * @since 27/09/2017
 */

class ModelCadCliRepEnd {
    private $nr;
    private $empcod;
    private $tipo;
    private $ender;
    private $endbairr;
    private $endcep;
    private $endcid;
    private $enduf;
    private $endcnpj;
    private $endInsc;
    private $empendfone;
    private $empendemail;
    private $empendobs;
    private $endnr;
    
    
    function getEndnr() {
        return $this->endnr;
    }

    function setEndnr($endnr) {
        $this->endnr = $endnr;
    }

                
    function getNr() {
        return $this->nr;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getEnder() {
        return $this->ender;
    }

    function getEndbairr() {
        return $this->endbairr;
    }

    function getEndcep() {
        return $this->endcep;
    }

    function getEndcid() {
        return $this->endcid;
    }

    function getEnduf() {
        return $this->enduf;
    }

    function getEndcnpj() {
        return $this->endcnpj;
    }

    function getEndInsc() {
        return $this->endInsc;
    }

    function getEmpendfone() {
        return $this->empendfone;
    }

    function getEmpendemail() {
        return $this->empendemail;
    }

    function getEmpendobs() {
        return $this->empendobs;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setEnder($ender) {
        $this->ender = $ender;
    }

    function setEndbairr($endbairr) {
        $this->endbairr = $endbairr;
    }

    function setEndcep($endcep) {
        $this->endcep = $endcep;
    }

    function setEndcid($endcid) {
        $this->endcid = $endcid;
    }

    function setEnduf($enduf) {
        $this->enduf = $enduf;
    }

    function setEndcnpj($endcnpj) {
        $this->endcnpj = $endcnpj;
    }

    function setEndInsc($endInsc) {
        $this->endInsc = $endInsc;
    }

    function setEmpendfone($empendfone) {
        $this->empendfone = $empendfone;
    }

    function setEmpendemail($empendemail) {
        $this->empendemail = $empendemail;
    }

    function setEmpendobs($empendobs) {
        $this->empendobs = $empendobs;
    }


}

