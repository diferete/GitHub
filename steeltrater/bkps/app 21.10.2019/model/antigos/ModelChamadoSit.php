<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelChamadoSit {
    private $codsit;
    private $sit;
    
    function getCodsit() {
        return $this->codsit;
    }

    function getSit() {
        return $this->sit;
    }

    function setCodsit($codsit) {
        $this->codsit = $codsit;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }


}
