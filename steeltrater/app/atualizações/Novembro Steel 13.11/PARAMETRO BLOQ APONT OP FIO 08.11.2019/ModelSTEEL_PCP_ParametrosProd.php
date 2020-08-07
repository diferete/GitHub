<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_PCP_ParametrosProd{
    private $cod;
    private $parametro;
    private $valor;
    private $obs;
    
    function getCod() {
        return $this->cod;
    }

    function getParametro() {
        return $this->parametro;
    }

    function getValor() {
        return $this->valor;
    }

    function getObs() {
        return $this->obs;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setParametro($parametro) {
        $this->parametro = $parametro;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }


}