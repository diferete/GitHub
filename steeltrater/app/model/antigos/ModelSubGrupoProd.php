<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSubGrupoProd{
    private $grucod;
    private $subcod;
    private $subdes;
    
    function getGrucod() {
        return $this->grucod;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

       

    function getSubcod() {
        return $this->subcod;
    }

    function getSubdes() {
        return $this->subdes;
    }

   

    function setSubcod($subcod) {
        $this->subcod = $subcod;
    }

    function setSubdes($subdes) {
        $this->subdes = $subdes;
    }


}