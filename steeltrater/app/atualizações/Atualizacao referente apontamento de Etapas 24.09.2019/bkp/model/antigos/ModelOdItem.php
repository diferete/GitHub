<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelOdItem {
    private $empcnpj;
    private $odnr;        
    private $odseq;        
    private $procod;        
    private $prodes;        
    private $odqt;       
    private $odvlr;        
    private $odvlrtot;        
    private $odobs;
    
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function getOdnr() {
        return $this->odnr;
    }

    function getOdseq() {
        return $this->odseq;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getOdqt() {
        return $this->odqt;
    }

    function getOdvlr() {
        return $this->odvlr;
    }

    function getOdvlrtot() {
        return $this->odvlrtot;
    }

    function getOdobs() {
        return $this->odobs;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function setOdnr($odnr) {
        $this->odnr = $odnr;
    }

    function setOdseq($odseq) {
        $this->odseq = $odseq;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setOdqt($odqt) {
        $this->odqt = $odqt;
    }

    function setOdvlr($odvlr) {
        $this->odvlr = $odvlr;
    }

    function setOdvlrtot($odvlrtot) {
        $this->odvlrtot = $odvlrtot;
    }

    function setOdobs($odobs) {
        $this->odobs = $odobs;
    }


            
            
}
