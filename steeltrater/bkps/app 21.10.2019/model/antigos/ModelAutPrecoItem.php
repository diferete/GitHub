<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelAutPrecoItem {
    private $id;
    private $tipo;
    private $nr;
    private $codigo;
    private $descricao;
    private $precotab;
    private $unitario;
    private $totaldesconto;
    private $precoKg;
    private $nome;
    private $coduser;
    private $data;
    private $hora;
    private $sit;
    private $dataaut;
    private $horaaut;
    private $obs;
    private $useraprov;
    private $codrep;
    private $empcod;
    private $empdes;
    private $qt;
    private $datarep;
    private $horarep;
    
    
    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

        
    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getNr() {
        return $this->nr;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getPrecotab() {
        return $this->precotab;
    }

    function getUnitario() {
        return $this->unitario;
    }

    function getTotaldesconto() {
        return $this->totaldesconto;
    }

    function getPrecoKg() {
        return $this->precoKg;
    }

    function getNome() {
        return $this->nome;
    }

    function getCoduser() {
        return $this->coduser;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getSit() {
        return $this->sit;
    }

    function getDataaut() {
        return $this->dataaut;
    }

    function getHoraaut() {
        return $this->horaaut;
    }

    function getObs() {
        return $this->obs;
    }

    function getUseraprov() {
        return $this->useraprov;
    }

    function getCodrep() {
        return $this->codrep;
    }

    function getEmpcod() {
        return $this->empcod;
    }

   

    function getQt() {
        return $this->qt;
    }

    function getDatarep() {
        return $this->datarep;
    }

    function getHorarep() {
        return $this->horarep;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setPrecotab($precotab) {
        $this->precotab = $precotab;
    }

    function setUnitario($unitario) {
        $this->unitario = $unitario;
    }

    function setTotaldesconto($totaldesconto) {
        $this->totaldesconto = $totaldesconto;
    }

    function setPrecoKg($precoKg) {
        $this->precoKg = $precoKg;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCoduser($coduser) {
        $this->coduser = $coduser;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function setDataaut($dataaut) {
        $this->dataaut = $dataaut;
    }

    function setHoraaut($horaaut) {
        $this->horaaut = $horaaut;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setUseraprov($useraprov) {
        $this->useraprov = $useraprov;
    }

    function setCodrep($codrep) {
        $this->codrep = $codrep;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

   

    function setQt($qt) {
        $this->qt = $qt;
    }

    function setDatarep($datarep) {
        $this->datarep = $datarep;
    }

    function setHorarep($horarep) {
        $this->horarep = $horarep;
    }


}
