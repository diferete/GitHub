<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelTransp {
    private $empcod;
    private $empdes;
    private $Cidcep;
    private $empcnpj;
    private $empfant;
    private $empfone;
    private $empinterne;
    private $empend;
    private $empendbair;
    private $empins;
    private $empativo;
    private $empobs;
    private $empausucad;
    private $empadtcad;
    private $repcod;
    private $emptr;
    private $empsit;
    
    function getEmpsit() {
        return $this->empsit;
    }

    function setEmpsit($empsit) {
        $this->empsit = $empsit;
    }

        
    function getEmptr() {
        return $this->emptr;
    }

    function setEmptr($emptr) {
        $this->emptr = $emptr;
    }

        
    function getRepcod() {
        return $this->repcod;
    }

    function setRepcod($repcod) {
        $this->repcod = $repcod;
    }

        
    function getEmpadtcad() {
        return $this->empadtcad;
    }

    function setEmpadtcad($empadtcad) {
        $this->empadtcad = $empadtcad;
    }

        
    function getEmpausucad() {
        return $this->empausucad;
    }

    function setEmpausucad($empausucad) {
        $this->empausucad = $empausucad;
    }

        
    function getEmpobs() {
        return $this->empobs;
    }

    function setEmpobs($empobs) {
        $this->empobs = $empobs;
    }

        
    function getEmpativo() {
        return $this->empativo;
    }

    function setEmpativo($empativo) {
        $this->empativo = $empativo;
    }

        
    function getEmpins() {
        return $this->empins;
    }

    function setEmpins($empins) {
        $this->empins = $empins;
    }

        
    function getEmpendbair() {
        return $this->empendbair;
    }

    function setEmpendbair($empendbair) {
        $this->empendbair = $empendbair;
    }

        
    function getEmpend() {
        return $this->empend;
    }

    function setEmpend($empend) {
        $this->empend = $empend;
    }

        
    function getEmpinterne() {
        return $this->empinterne;
    }

    function setEmpinterne($empinterne) {
        $this->empinterne = $empinterne;
    }

        
    function getEmpfone() {
        return $this->empfone;
    }

    function setEmpfone($empfone) {
        $this->empfone = $empfone;
    }

        
    function getEmpfant() {
        return $this->empfant;
    }

    function setEmpfant($empfant) {
        $this->empfant = $empfant;
    }

        
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

        
    function getCidcep() {
        if(!isset($this->Cidcep)){
            $this->Cidcep = Fabrica::FabricarModel('Cidcep');
        }
        return $this->Cidcep;
    }

    function setCidcep($Cidcep) {
        $this->Cidcep = $Cidcep;
    }

       
 
        
    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }


}