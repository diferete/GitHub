<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelFamSub{
    private $grucod;
    private $subcod;
    private $famcod;
    private $famsub;
    private $famsdes;
    
    function getSubcod() {
        return $this->subcod;
    }

    function setSubcod($subcod) {
        $this->subcod = $subcod;
    }

        
    
    function getGrucod() {
        return $this->grucod;
    }

    
    function getFamcod() {
        return $this->famcod;
    }

    function getFamsub() {
        return $this->famsub;
    }

    function getFamsdes() {
        return $this->famsdes;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    

    function setFamcod($famcod) {
        $this->famcod = $famcod;
    }

    function setFamsub($famsub) {
        $this->famsub = $famsub;
    }

    function setFamsdes($famsdes) {
        $this->famsdes = $famsdes;
    }


    
}