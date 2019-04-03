<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelFamProd {
    private $grucod;
    private $subcod;
    private $famcod;
    private $famdes;
    
    function getGrucod() {
        return $this->grucod;
    }

    function getSubcod() {
        return $this->subcod;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function setSubcod($subcod) {
        $this->subcod = $subcod;
    }

       
    function getFamcod() {
        return $this->famcod;
    }

    function getFamdes() {
        return $this->famdes;
    }

  


    function setFamcod($famcod) {
        $this->famcod = $famcod;
    }

    function setFamdes($famdes) {
        $this->famdes = $famdes;
    }


    
}
