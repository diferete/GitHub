<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelGerenContPagar {
    private $empcnpj;
    private $nfdoc;
    private $nfserie;
    private $Pessoa;
    private $contseq;
    private $contvlr;
    private $contvenc;
    private $contsit;
    private $contdatapag;
    private $contpagobs;
    private $origcod;
    private $origdes;
    
    function getOrigdes() {
        return $this->origdes;
    }

    function setOrigdes($origdes) {
        $this->origdes = $origdes;
    }

        
    function getOrigcod() {
        return $this->origcod;
    }

    function setOrigcod($origcod) {
        $this->origcod = $origcod;
    }

        
    function getContpagobs() {
        return $this->contpagobs;
    }

    function setContpagobs($contpagobs) {
        $this->contpagobs = $contpagobs;
    }

        
    
    function getContdatapag() {
        return $this->contdatapag;
    }

    function setContdatapag($contdatapag) {
        $this->contdatapag = $contdatapag;
    }

        
    function getContsit() {
        return $this->contsit;
    }

    function setContsit($contsit) {
        $this->contsit = $contsit;
    }

        
    function getContvenc() {
        return $this->contvenc;
    }

    function setContvenc($contvenc) {
        $this->contvenc = $contvenc;
    }

        
    function getContvlr() {
        return $this->contvlr;
    }

    function setContvlr($contvlr) {
        $this->contvlr = $contvlr;
    }

        
    function getContseq() {
        return $this->contseq;
    }

    function setContseq($contseq) {
        $this->contseq = $contseq;
    }

        
    function getPessoa() {
        if (!isset($this->Pessoa)){
            $this->Pessoa =Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
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

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function setNfdoc($nfdoc) {
        $this->nfdoc = $nfdoc;
    }

    function setNfserie($nfserie) {
        $this->nfserie = $nfserie;
    }


}