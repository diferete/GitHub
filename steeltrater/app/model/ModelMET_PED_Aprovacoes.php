<?php

/*
 * Implementa a classe model MET_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ModelMET_PED_Aprovacoes {

    private $filcgc;
    private $pdcnro;
    private $empcod;
    private $pdcsituaca;
    private $pdcimplant;
    private $pdcusu;
    private $pdcfutaut;
    private $pdcfrevalo;
    private $totalipi;
    private $desconto;
    private $valortotal;
    private $empdes;

    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function getPdcfutaut() {
        return $this->pdcfutaut;
    }

    function setPdcfutaut($pdcfutaut) {
        $this->pdcfutaut = $pdcfutaut;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getPdcnro() {
        return $this->pdcnro;
    }

    function getPdcsituaca() {
        return $this->pdcsituaca;
    }

    function getPdcimplant() {
        return $this->pdcimplant;
    }

    function getPdcusu() {
        return $this->pdcusu;
    }

    function getPdcfrevalo() {
        return $this->pdcfrevalo;
    }

    function getTotalipi() {
        return $this->totalipi;
    }

    function getDesconto() {
        return $this->desconto;
    }

    function getValortotal() {
        return $this->valortotal;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setPdcnro($pdcnro) {
        $this->pdcnro = $pdcnro;
    }

    function setPdcsituaca($pdcsituaca) {
        $this->pdcsituaca = $pdcsituaca;
    }

    function setPdcimplant($pdcimplant) {
        $this->pdcimplant = $pdcimplant;
    }

    function setPdcusu($pdcusu) {
        $this->pdcusu = $pdcusu;
    }

    function setPdcfrevalo($pdcfrevalo) {
        $this->pdcfrevalo = $pdcfrevalo;
    }

    function setTotalipi($totalipi) {
        $this->totalipi = $totalipi;
    }

    function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    function setValortotal($valortotal) {
        $this->valortotal = $valortotal;
    }

}
