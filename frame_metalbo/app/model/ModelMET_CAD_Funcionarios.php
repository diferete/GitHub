<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_CAD_Funcionarios {

    private $numcad;
    private $nomfun;
    private $cpf;
    private $cargo;
    private $cnpj;
    private $sit;

    function getNumcad() {
        return $this->numcad;
    }

    function getNomfun() {
        return $this->nomfun;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getCargo() {
        return $this->cargo;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getSit() {
        return $this->sit;
    }

    function setNumcad($numcad) {
        $this->numcad = $numcad;
    }

    function setNomfun($nomfun) {
        $this->nomfun = $nomfun;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setCargo($cargo) {
        $this->cargo = $cargo;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

}
