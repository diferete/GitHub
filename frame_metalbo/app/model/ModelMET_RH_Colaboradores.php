<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_RH_Colaboradores {

    private $numcad;
    private $nomfun;
    private $dessit;
    private $nomccu;
    private $grains;
    private $desgra;
    private $titcar;

    function getNumcad() {
        return $this->numcad;
    }

    function getNomfun() {
        return $this->nomfun;
    }

    function getDessit() {
        return $this->dessit;
    }

    function getNomccu() {
        return $this->nomccu;
    }

    function getGrains() {
        return $this->grains;
    }

    function getDesgra() {
        return $this->desgra;
    }

    function getTitcar() {
        return $this->titcar;
    }

    function setNumcad($numcad) {
        $this->numcad = $numcad;
    }

    function setNomfun($nomfun) {
        $this->nomfun = $nomfun;
    }

    function setDessit($dessit) {
        $this->dessit = $dessit;
    }

    function setNomccu($nomccu) {
        $this->nomccu = $nomccu;
    }

    function setGrains($grains) {
        $this->grains = $grains;
    }

    function setDesgra($desgra) {
        $this->desgra = $desgra;
    }

    function setTitcar($titcar) {
        $this->titcar = $titcar;
    }

}
