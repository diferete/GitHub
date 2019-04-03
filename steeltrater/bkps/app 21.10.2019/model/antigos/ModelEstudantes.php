<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelEstudantes {
    private $cod;
    private $nome;
    private $ultparte;
    private $proxparte;
    private $obs;
    
    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getUltparte() {
        return $this->ultparte;
    }

    function getProxparte() {
        return $this->proxparte;
    }

    function getObs() {
        return $this->obs;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setUltparte($ultparte) {
        $this->ultparte = $ultparte;
    }

    function setProxparte($proxparte) {
        $this->proxparte = $proxparte;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }


}