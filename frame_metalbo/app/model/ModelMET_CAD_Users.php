<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_CAD_Users {

    private $empcnpj;
    private $coduser;
    private $nome;
    private $sobrenome;
    private $codsetor;
    private $cracha;

    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function getCoduser() {
        return $this->coduser;
    }

    function getNome() {
        return $this->nome;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getCracha() {
        return $this->cracha;
    }

    function setCoduser($coduser) {
        $this->coduser = $coduser;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setCracha($cracha) {
        $this->cracha = $cracha;
    }

}
