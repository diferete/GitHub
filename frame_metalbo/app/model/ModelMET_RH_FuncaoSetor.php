<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_RH_FuncaoSetor {

    private $nr;
    private $filcgc;
    private $codsetor;
    private $codfuncao;
    private $descfuncao;
    private $descsetor;

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getCodfuncao() {
        return $this->codfuncao;
    }

    function getDescfuncao() {
        return $this->descfuncao;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setCodfuncao($codfuncao) {
        $this->codfuncao = $codfuncao;
    }

    function setDescfuncao($descfuncao) {
        $this->descfuncao = $descfuncao;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

}
