<?php

/**
 * Classe que implementa o Model do objeto Sistema 
 */
class ModelSolCadUser {

    private $usucodigo;
    private $usunome;
    private $ususobrenome;
    private $usulogin;
    private $usuemail;
    private $ususit;
    private $obs;
    private $dataSolUser;

    function getDataSolUser() {
        return $this->dataSolUser;
    }

    function setDataSolUser($dataSolUser) {
        $this->dataSolUser = $dataSolUser;
    }

    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getUsusobrenome() {
        return $this->ususobrenome;
    }

    function getUsulogin() {
        return $this->usulogin;
    }

    function getUsuemail() {
        return $this->usuemail;
    }

    function getUsusit() {
        return $this->ususit;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setUsusobrenome($ususobrenome) {
        $this->ususobrenome = $ususobrenome;
    }

    function setUsulogin($usulogin) {
        $this->usulogin = $usulogin;
    }

    function setUsuemail($usuemail) {
        $this->usuemail = $usuemail;
    }

    function setUsusit($ususit) {
        $this->ususit = $ususit;
    }

}
