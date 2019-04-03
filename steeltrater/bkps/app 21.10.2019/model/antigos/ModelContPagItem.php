<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelContPagItem {
    private $empcnpj;
    private $nfdoc;
    private $nfserie;
    private $pescnpj;
    private $contseq;
    private $contvlr;
    private $contvenc;
    private $contsit;
    
    function getContsit() {
        return $this->contsit;
    }

    function setContsit($contsit) {
        $this->contsit = $contsit;
    }

        
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function getNfdoc() {
        return $this->nfdoc;
    }

    function getNfserie() {
        return $this->nfserie;
    }

    function getPescnpj() {
        return $this->pescnpj;
    }

    function getContseq() {
        return $this->contseq;
    }

    function getContvlr() {
        return $this->contvlr;
    }

    function getContvenc() {
        return $this->contvenc;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function setNfdoc($nfdoc) {
        $this->nfdoc = $nfdoc;
    }

    function setNfserie($nfserie) {
        $this->nfserie = $nfserie;
    }

    function setPescnpj($pescnpj) {
        $this->pescnpj = $pescnpj;
    }

    function setContseq($contseq) {
        $this->contseq = $contseq;
    }

    function setContvlr($contvlr) {
        $this->contvlr = $contvlr;
    }

    function setContvenc($contvenc) {
        $this->contvenc = $contvenc;
    }


}