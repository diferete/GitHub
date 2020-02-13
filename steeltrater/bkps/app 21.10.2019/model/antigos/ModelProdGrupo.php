<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelProdGrupo {
    private $grucod;
    private $grudes;
    
    function getGrucod() {
        return $this->grucod;
    }

    function getGrudes() {
        return $this->grudes;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function setGrudes($grudes) {
        $this->grudes = $grudes;
    }


}