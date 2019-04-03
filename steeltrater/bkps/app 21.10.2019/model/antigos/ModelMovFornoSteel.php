<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMovFornoSteel {
    
    private $nr;
    private $ofsteel;
    private $procodCod;
    private $prodes;
    private $empcod;
    private $empdes;
    private $ofcliente;
    private $dtent;
    private $horaent; 
    private $forno;
    private $sit;
    private $dtsaida;
    private $horasaida;
    private $lastRefresch;
    
    
    function getLastRefresch() {
        return $this->lastRefresch;
    }
    
    
    function setLastRefresch($lastRefresch) {
        $this->lastRefresch = $lastRefresch;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getOfsteel() {
        return $this->ofsteel;
    }

    function getProcodCod() {
        return $this->procodCod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getOfcliente() {
        return $this->ofcliente;
    }

    function getDtent() {
        return $this->dtent;
    }

    function getHoraent() {
        return $this->horaent;
    }

    function getForno() {
        return $this->forno;
    }

    function getSit() {
        return $this->sit;
    }

    function getDtsaida() {
        return $this->dtsaida;
    }

    function getHorasaida() {
        return $this->horasaida;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setOfsteel($ofsteel) {
        $this->ofsteel = $ofsteel;
    }

    function setProcodCod($procodCod) {
        $this->procodCod = $procodCod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setOfcliente($ofcliente) {
        $this->ofcliente = $ofcliente;
    }

    function setDtent($dtent) {
        $this->dtent = $dtent;
    }

    function setHoraent($horaent) {
        $this->horaent = $horaent;
    }

    function setForno($forno) {
        $this->forno = $forno;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function setDtsaida($dtsaida) {
        $this->dtsaida = $dtsaida;
    }

    function setHorasaida($horasaida) {
        $this->horasaida = $horasaida;
    }





    
    
}