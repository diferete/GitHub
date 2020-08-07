<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class ModelAdmPed {
    private $data;
    private $nr;
    private $peso;
    private $contpeso;
    private $vlr;
    private $ipi;
    private $vlrcomipi;
    private $contvlr;
    private $mediaSipi;
    private $mediaCipi;
    private $datahora;
    
    function getData() {
        return $this->data;
    }

    function getNr() {
        return $this->nr;
    }

    function getPeso() {
        return $this->peso;
    }

    function getContpeso() {
        return $this->contpeso;
    }

    function getVlr() {
        return $this->vlr;
    }

    function getIpi() {
        return $this->ipi;
    }

    function getVlrcomipi() {
        return $this->vlrcomipi;
    }

    function getContvlr() {
        return $this->contvlr;
    }

    function getMediaSipi() {
        return $this->mediaSipi;
    }

    function getMediaCipi() {
        return $this->mediaCipi;
    }

    function getDatahora() {
        return $this->datahora;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setContpeso($contpeso) {
        $this->contpeso = $contpeso;
    }

    function setVlr($vlr) {
        $this->vlr = $vlr;
    }

    function setIpi($ipi) {
        $this->ipi = $ipi;
    }

    function setVlrcomipi($vlrcomipi) {
        $this->vlrcomipi = $vlrcomipi;
    }

    function setContvlr($contvlr) {
        $this->contvlr = $contvlr;
    }

    function setMediaSipi($mediaSipi) {
        $this->mediaSipi = $mediaSipi;
    }

    function setMediaCipi($mediaCipi) {
        $this->mediaCipi = $mediaCipi;
    }

    function setDatahora($datahora) {
        $this->datahora = $datahora;
    }


}