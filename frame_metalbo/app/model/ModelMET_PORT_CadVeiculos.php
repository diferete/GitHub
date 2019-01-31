<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_PORT_CadVeiculos {

    private $filcgc;
    private $nr;
    private $placa;
    private $datacad;
    private $usucod;
    private $usunome;
    private $contato;
    private $modelo;
    private $cor;
    private $emptranscod;
    private $emptransdes;
    private $codsetor;
    private $descsetor;

    function getEmptranscod() {
        return $this->emptranscod;
    }

    function getEmptransdes() {
        return $this->emptransdes;
    }

    function setEmptranscod($emptranscod) {
        $this->emptranscod = $emptranscod;
    }

    function setEmptransdes($emptransdes) {
        $this->emptransdes = $emptransdes;
    }

    function getUsucod() {
        return $this->usucod;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function setUsucod($usucod) {
        $this->usucod = $usucod;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getPlaca() {
        return $this->placa;
    }

    function getDatacad() {
        return $this->datacad;
    }

    function getContato() {
        return $this->contato;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getCor() {
        return $this->cor;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

    function setDatacad($datacad) {
        $this->datacad = $datacad;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setCor($cor) {
        $this->cor = $cor;
    }

}
