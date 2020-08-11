<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelSessao {
    private $usucodigo;
    private $usunome;
    private $usuidsessao;
    private $usustatus;
    private $usudata;
    private $usuhora;
    private $usulastacesso;
    
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getUsuidsessao() {
        return $this->usuidsessao;
    }

    function getUsustatus() {
        return $this->usustatus;
    }

    function getUsudata() {
        return $this->usudata;
    }

    function getUsuhora() {
        return $this->usuhora;
    }

    function getUsulastacesso() {
        return $this->usulastacesso;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setUsuidsessao($usuidsessao) {
        $this->usuidsessao = $usuidsessao;
    }

    function setUsustatus($usustatus) {
        $this->usustatus = $usustatus;
    }

    function setUsudata($usudata) {
        $this->usudata = $usudata;
    }

    function setUsuhora($usuhora) {
        $this->usuhora = $usuhora;
    }

    function setUsulastacesso($usulastacesso) {
        $this->usulastacesso = $usulastacesso;
    }


}
