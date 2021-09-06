<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelProduto {

    private $procod;
    private $prodes;
    private $probloqpro;
    private $pround;

    function getPround() {
        return $this->pround;
    }

    function setPround($pround) {
        $this->pround = $pround;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function getProbloqpro() {
        return $this->probloqpro;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

    function setProbloqpro($probloqpro) {
        $this->probloqpro = $probloqpro;
    }

}
