<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualAqApont {

    private $filcgc;
    private $nr;
    private $seq;
    private $plano;
    private $dataprev;
    private $datafim;
    private $obsfim;
    private $sitfim;
    private $anexofim;
    private $nrEfi;
    private $anexoplan1;

    function getAnexoplan1() {
        return $this->anexoplan1;
    }

    function setAnexoplan1($anexoplan1) {
        $this->anexoplan1 = $anexoplan1;
    }

    function getNrEfi() {
        return $this->nrEfi;
    }

    function setNrEfi($nrEfi) {
        $this->nrEfi = $nrEfi;
    }

    function getAnexofim() {
        return $this->anexofim;
    }

    function setAnexofim($anexofim) {
        $this->anexofim = $anexofim;
    }

    function getSitfim() {
        return $this->sitfim;
    }

    function setSitfim($sitfim) {
        $this->sitfim = $sitfim;
    }

    function getObsfim() {
        return $this->obsfim;
    }

    function setObsfim($obsfim) {
        $this->obsfim = $obsfim;
    }

    function getDatafim() {
        return $this->datafim;
    }

    function setDatafim($datafim) {
        $this->datafim = $datafim;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getPlano() {
        return $this->plano;
    }

    function getDataprev() {
        return $this->dataprev;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setPlano($plano) {
        $this->plano = $plano;
    }

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }

}
