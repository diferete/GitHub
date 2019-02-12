<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_CAD_Placas {

    private $filcgc;
    private $empcod;
    private $empdes;
    private $placa;
    private $cracha;
    private $nome;

    function getNome() {
        return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getCracha() {
        return $this->cracha;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setCracha($cracha) {
        $this->cracha = $cracha;
    }

}
