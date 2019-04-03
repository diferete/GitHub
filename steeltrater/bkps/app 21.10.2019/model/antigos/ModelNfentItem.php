<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelNfentItem {
    private $empcnpj;
    private $nfdoc;
    private $nfserie;
    private $pescnpj;
    private $nfseq;
    private $procod;
    private $prodes;
    private $nfqt;
    private $nfvlrunit;
    private $nfvlrtot;
    
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

        
    function getNfvlrtot() {
        return $this->nfvlrtot;
    }

    function setNfvlrtot($nfvlrtot) {
        $this->nfvlrtot = $nfvlrtot;
    }

                
    function getNfvlrunit() {
        return $this->nfvlrunit;
    }

    function setNfvlrunit($nfvlrunit) {
        $this->nfvlrunit = $nfvlrunit;
    }

        
    function getNfqt() {
        return $this->nfqt;
    }

    function setNfqt($nfqt) {
        $this->nfqt = $nfqt;
    }

                
    function getProdes() {
        return $this->prodes;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

        
    function getProcod() {
        return $this->procod;
    }

    function setProcod($procod) {
        $this->procod = $procod;
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

    function getNfseq() {
        return $this->nfseq;
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

    function setNfseq($nfseq) {
        $this->nfseq = $nfseq;
    }


    
}