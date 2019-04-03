<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelProduto{
    private $procod;
    private $prodes;
    private $probloqpro;
    private $GrupoProd;
    private $SubGrupoProd;
    private $FamProd;
    private $FamSub;
    private $pround;
    private $propesprat;
    private $proclasfis;
    private $procest;
    
    function getProcest() {
        return $this->procest;
    }

    function setProcest($procest) {
        $this->procest = $procest;
    }

        
    function getProclasfis() {
        return $this->proclasfis;
    }

    function setProclasfis($proclasfis) {
        $this->proclasfis = $proclasfis;
    }

        
    function getPropesprat() {
        return $this->propesprat;
    }

    function setPropesprat($propesprat) {
        $this->propesprat = $propesprat;
    }

        
   
    function getPround() {
        return $this->pround;
    }

    function setPround($pround) {
        $this->pround = $pround;
    }

    
    function getFamSub() {
        if(!isset($this->FamSub)){
            $this->FamSub = Fabrica::FabricarModel('Famsub');
        }
        return $this->FamSub;
    }

    function setFamSub($FamSub) {
        $this->FamSub = $FamSub;
    }

        
    function getFamProd() {
        if(!isset($this->FamProd)){
            $this->FamProd = Fabrica::FabricarModel('FamProd');
        }
        return $this->FamProd;
    }

    function setFamProd($FamProd) {
        $this->FamProd = $FamProd;
    }

        
    function getSubGrupoProd() {
        if(!isset($this->SubGrupoProd)){
            $this->SubGrupoProd = Fabrica::FabricarModel('SubGrupoProd');
        }
        return $this->SubGrupoProd;
    }

    function setSubGrupoProd($SubGrupoProd) {
        $this->SubGrupoProd = $SubGrupoProd;
    }

        
    function getGrupoProd() {
        if(!isset($this->GrupoProd)){
            $this->GrupoProd = Fabrica::FabricarModel('GrupoProd');
        }
        return $this->GrupoProd;
    }

    function setGrupoProd($GrupoProd) {
        $this->GrupoProd = $GrupoProd;
    }

        
    function getProbloqpro() {
        return $this->probloqpro;
    }

    function setProbloqpro($probloqpro) {
        $this->probloqpro = $probloqpro;
    }

        
    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return  trim($this->prodes);
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $s=  trim($prodes);
        $this->prodes = trim($prodes);
    }


    
    
}