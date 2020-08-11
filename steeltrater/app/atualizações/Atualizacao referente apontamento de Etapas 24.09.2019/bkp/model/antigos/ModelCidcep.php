<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelCidcep {
    private $cidcep;
    private $cidnome;
    private $estcod;
    private $cidIBGE;
   
    function getCidIBGE() {
        return $this->cidIBGE;
    }

    function setCidIBGE($cidIBGE) {
        $this->cidIBGE = $cidIBGE;
    }

        
    
    function getCidcep() {
        return $this->cidcep;
    }

    function getCidnome() {
        return $this->cidnome;
    }

    function getEstcod() {
        return $this->estcod;
    }

    function setCidcep($cidcep) {
        $this->cidcep = $cidcep;
    }

    function setCidnome($cidnome) {
        $this->cidnome = $cidnome;
    }

    function setEstcod($estcod) {
        $this->estcod = $estcod;
    }


}