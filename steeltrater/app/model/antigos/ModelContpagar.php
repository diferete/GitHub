<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelContpagar {
    private $empcnpj;
    private $nfdoc;
    private $nfserie;
    private $pescnpj;
    private $contdataemi;
    private $contuseremi;
    private $contdatahora;
    
    function getContdatahora() {
        return $this->contdatahora;
    }

    function setContdatahora($contdatahora) {
        $this->contdatahora = $contdatahora;
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

    function getContdataemi() {
        return $this->contdataemi;
    }

    function getContuseremi() {
        return $this->contuseremi;
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

    function setContdataemi($contdataemi) {
        $this->contdataemi = $contdataemi;
    }

    function setContuseremi($contuseremi) {
        $this->contuseremi = $contuseremi;
    }


    
    
    
    
}