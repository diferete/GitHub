<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelOfRep{
    private $op;
    private $cod;
    private $prodes;
    private $quant;
    private $data;
    private $situaca;
    
    function getSituaca() {
        return $this->situaca;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

        
    function getOp() {
        return $this->op;
    }

    function getCod() {
        return $this->cod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getQuant() {
        return $this->quant;
    }

    function getData() {
        return $this->data;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setQuant($quant) {
        $this->quant = $quant;
    }

    function setData($data) {
        $this->data = $data;
    }


}