<?php

/**
 * Classe que implementa o ModelPessoa
 */
class ModelPessoa {

    private $empcod;
    private $empdes;
    private $empsit;

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getEmpsit() {
        return $this->empsit;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setEmpsit($empsit) {
        $this->empsit = $empsit;
    }

}
