<?php

/* 
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class ModelMET_MP_CadastroMaquinas {
    
    private $tipcod;
    private $tipdes;

    function getTipcod() {
        return $this->tipcod;
    }

    function getTipdes() {
        return $this->tipdes;
    }

    function setTipcod($tipcod) {
        $this->tipcod = $tipcod;
    }

    function setTipdes($tipdes) {
        $this->tipdes = $tipdes;
    }    
}