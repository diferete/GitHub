<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelPoliSetor{
    private $codsetor;
    private $setor;
    
    function getCodsetor() {
        return $this->codsetor;
    }

    function getSetor() {
        return $this->setor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }


}