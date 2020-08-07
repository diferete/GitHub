<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_CAD_Cpf {

    private $cpf;
    private $filcgc;
    private $nome;
    private $empfant;
    private $fone;

    function getCpf() {
        return $this->cpf;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmpfant() {
        return $this->empfant;
    }

    function getFone() {
        return $this->fone;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmpfant($empfant) {
        $this->empfant = $empfant;
    }

    function setFone($fone) {
        $this->fone = $fone;
    }

}
