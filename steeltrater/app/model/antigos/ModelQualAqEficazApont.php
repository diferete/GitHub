<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualAqEficazApont {
    private $filcgc;
    private $nr;
    private $seq;
    private $acao;
    private $dataprev;
    private $datareal;
    private $eficaz;
    private $obs;
    private $sit;
    private $usucodigo;
    private $usunome;
    
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

        
    function getSit() {
        return $this->sit;
    }

    function setSit($sit) {
        $this->sit = $sit;
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

    function getAcao() {
        return $this->acao;
    }


    function getDataprev() {
        return $this->dataprev;
    }

    function getDatareal() {
        return $this->datareal;
    }

    function getEficaz() {
        return $this->eficaz;
    }

    function getObs() {
        return $this->obs;
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

    function setAcao($acao) {
        $this->acao = $acao;
    }

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }

    function setDatareal($datareal) {
        $this->datareal = $datareal;
    }

    function setEficaz($eficaz) {
        $this->eficaz = $eficaz;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }


    
    
}