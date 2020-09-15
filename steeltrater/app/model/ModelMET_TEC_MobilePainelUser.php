<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_MobilePainelUser{
    private $usucodigo;
    private $painelcod;
    
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getPainelcod() {
        return $this->painelcod;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setPainelcod($painelcod) {
        $this->painelcod = $painelcod;
    }


    
}