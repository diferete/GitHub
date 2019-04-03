<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelConsultaEstoque{
    private $grucod;
    private $subcod;
    private $famcod;
    private $famsub;
    private $procod;
    private $prodes;
    private $pround;
    private $propesprat;
    private $probloqpro;
    private $tabvenda;
    
    function getTabvenda() {
        if(!isset($this->tabvenda)){
            $this->tabvenda = Fabrica::FabricarModel('TabVenda');
        }
        return $this->tabvenda;
    }

    function setTabvenda($tabvenda) {
        $this->tabvenda = $tabvenda;
    }

            
    function getProbloqpro() {
        return $this->probloqpro;
    }

    function setProbloqpro($probloqpro) {
        $this->probloqpro = $probloqpro;
    }

        
    function getGrucod() {
        return $this->grucod;
    }

    function getSubcod() {
        return $this->subcod;
    }

    function getFamcod() {
        return $this->famcod;
    }

    function getFamsub() {
        return $this->famsub;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function setSubcod($subcod) {
        $this->subcod = $subcod;
    }

    function setFamcod($famcod) {
        $this->famcod = $famcod;
    }

    function setFamsub($famsub) {
        $this->famsub = $famsub;
    }

        
    function getProdes() {
        return $this->prodes;
    }

    function getPround() {
        return $this->pround;
    }

    function getPropesprat() {
        return $this->propesprat;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setPround($pround) {
        $this->pround = $pround;
    }

    function setPropesprat($propesprat) {
        $this->propesprat = $propesprat;
    }

        
    
    function getProcod() {
        return $this->procod;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    


}