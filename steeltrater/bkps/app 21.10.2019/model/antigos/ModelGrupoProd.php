<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelGrupoProd {
    private $grucod;
    private $grudes;
    private $grutipo;
    
    function getGrucod() {
        return $this->grucod;
    }

    function getGrudes() {
        return $this->grudes;
    }

    function getGrutipo() {
        return $this->grutipo;
    }

    function setGrucod($grucod) {
        $this->grucod = $grucod;
    }

    function setGrudes($grudes) {
        $this->grudes = $grudes;
    }

    function setGrutipo($grutipo) {
        $this->grutipo = $grutipo;
    }


}
