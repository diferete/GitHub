<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelPoliFab{
    private $fabcod;
    private $cnpj;
    private $fabdes;
    

        
    function getFabcod() {
        return $this->fabcod;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getFabdes() {
        return $this->fabdes;
    }

    function setFabcod($fabcod) {
        $this->fabcod = $fabcod;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setFabdes($fabdes) {
        $this->fabdes = $fabdes;
    }


}