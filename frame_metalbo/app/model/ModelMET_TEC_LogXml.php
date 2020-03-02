<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_LogXml {

    private $filcgc;
    private $nf;
    private $datalog;
    private $horalog;
    private $logxml;
    private $tipolog;

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNf() {
        return $this->nf;
    }

    function getDatalog() {
        return $this->datalog;
    }

    function getHoralog() {
        return $this->horalog;
    }

    function getLogxml() {
        return $this->logxml;
    }

    function getTipolog() {
        return $this->tipolog;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNf($nf) {
        $this->nf = $nf;
    }

    function setDatalog($datalog) {
        $this->datalog = $datalog;
    }

    function setHoralog($horalog) {
        $this->horalog = $horalog;
    }

    function setLogxml($logxml) {
        $this->logxml = $logxml;
    }

    function setTipolog($tipolog) {
        $this->tipolog = $tipolog;
    }

}
