<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_TEC_MobilePainel {
    private $painelcod;
    private $paineldesc;
    
    function getPainelcod() {
        return $this->painelcod;
    }

    function getPaineldesc() {
        return $this->paineldesc;
    }

    function setPainelcod($painelcod) {
        $this->painelcod = $painelcod;
    }

    function setPaineldesc($paineldesc) {
        $this->paineldesc = $paineldesc;
    }


}