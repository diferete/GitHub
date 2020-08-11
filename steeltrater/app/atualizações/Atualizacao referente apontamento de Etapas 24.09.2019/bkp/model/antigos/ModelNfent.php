<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelNfent{
    private $empcnpj;
    private $nfdoc;
    private $nfserie;
    private $pescnpj;
    private $pesnome_razao;
    private $nfdataemi;
    private $nfdatacheg;
    private $nfhoracheg;
    private $nftipo;
    private $nftotprod;
    private $nfbaseicm;
    private $nfvlricm;
    private $nfbasest;
    private $nfvlrst;
    private $nfvlripi;
    private $nfvlrtot;
    private $nfobs;
    private $nf_frete;
    private $nf_finan;
    private $nfusuins;
    private $nfhorains;
    
   
    function getNfhorains() {
        return $this->nfhorains;
    }

    function setNfhorains($nfhorains) {
        $this->nfhorains = $nfhorains;
    }

        
    function getNfusuins() {
        return $this->nfusuins;
    }

    function setNfusuins($nfusuins) {
        $this->nfusuins = $nfusuins;
    }

                
    function getNf_finan() {
        return $this->nf_finan;
    }

    function setNf_finan($nf_finan) {
        $this->nf_finan = $nf_finan;
    }

        
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

        function getNf_frete() {
        return $this->nf_frete;
    }

    function setNf_frete($nf_frete) {
        $this->nf_frete = $nf_frete;
    }

        
    function getNfobs() {
        return $this->nfobs;
    }

    function setNfobs($nfobs) {
        $this->nfobs = $nfobs;
    }

        
    function getNfvlrtot() {
        return $this->nfvlrtot;
    }

    function setNfvlrtot($nfvlrtot) {
        $this->nfvlrtot = $nfvlrtot;
    }

        
    
    function getNfvlripi() {
        return $this->nfvlripi;
    }

    function setNfvlripi($nfvlripi) {
        $this->nfvlripi = $nfvlripi;
    }

                
    function getNfvlrst() {
        return $this->nfvlrst;
    }

    function setNfvlrst($nfvlrst) {
        $this->nfvlrst = $nfvlrst;
    }

        
    function getNfbasest() {
        return $this->nfbasest;
    }

    function setNfbasest($nfbasest) {
        $this->nfbasest = $nfbasest;
    }

        function getNfvlricm() {
        return $this->nfvlricm;
    }

    function setNfvlricm($nfvlricm) {
        $this->nfvlricm = $nfvlricm;
    }

        
    function getNfbaseicm() {
        return $this->nfbaseicm;
    }

    function setNfbaseicm($nfbaseicm) {
        $this->nfbaseicm = $nfbaseicm;
    }

        
    function getNftotprod() {
        return $this->nftotprod;
    }

    function setNftotprod($nftotprod) {
        $this->nftotprod = $nftotprod;
    }

        
    function getNftipo() {
        return $this->nftipo;
    }

    function setNftipo($nftipo) {
        $this->nftipo = $nftipo;
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

    function getPesnome_razao() {
        return $this->pesnome_razao;
    }

    function getNfdataemi() {
        return $this->nfdataemi;
    }

    function getNfdatacheg() {
        return $this->nfdatacheg;
    }

    function getNfhoracheg() {
        return $this->nfhoracheg;
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

    function setPesnome_razao($pesnome_razao) {
        $this->pesnome_razao = $pesnome_razao;
    }

    function setNfdataemi($nfdataemi) {
        $this->nfdataemi = $nfdataemi;
    }

    function setNfdatacheg($nfdatacheg) {
        $this->nfdatacheg = $nfdatacheg;
    }

    function setNfhoracheg($nfhoracheg) {
        $this->nfhoracheg = $nfhoracheg;
    }


}
