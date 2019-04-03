<?php

class ModelMetSisMetalbo {
    private $coduser;
    private $nome;
    private $sobrenome;

    function getCoduser() {
        return $this->coduser;
    }

    function setCoduser($coduser) {
        $this->coduser = $coduser;
    }

        
    
    function getNome() {
        return $this->nome;
    }

    function getSobrenome() {
        return $this->sobrenome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSobrenome($sobrenome) {
        $this->sobrenome = $sobrenome;
    }

}
