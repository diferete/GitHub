<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelPoliCadMaq {
    private $codmaq;
    private $maquina;
    private $PoliFab;
    private $nomeclatura;
    private $modelo;
    private $fabricacao;
    private $horasop;
    private $nroperador;
    private $PoliSetor;
    private $serie;
    private $patrimonio;
    private $obs;
    private $ativa;
    private $seguranca;
    private $responsavel;
    private $usercad;
    private $datacad;
    private $horacad;
    
    function getUsercad() {
        return $this->usercad;
    }

    function getDatacad() {
        return $this->datacad;
    }

    function getHoracad() {
        return $this->horacad;
    }

    function setUsercad($usercad) {
        $this->usercad = $usercad;
    }

    function setDatacad($datacad) {
        $this->datacad = $datacad;
    }

    function setHoracad($horacad) {
        $this->horacad = $horacad;
    }

        
    function getResponsavel() {
        return $this->responsavel;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

        
    function getSeguranca() {
        return $this->seguranca;
    }

    function setSeguranca($seguranca) {
        $this->seguranca = $seguranca;
    }

        
    function getAtiva() {
        return $this->ativa;
    }

    function setAtiva($ativa) {
        $this->ativa = $ativa;
    }

        
    function getObs() {
        return $this->obs;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

        
    function getPatrimonio() {
        return $this->patrimonio;
    }

    function setPatrimonio($patrimonio) {
        $this->patrimonio = $patrimonio;
    }

        
    function getSerie() {
        return $this->serie;
    }

    function setSerie($serie) {
        $this->serie = $serie;
    }

        
    function getPoliSetor() {
        if(!isset($this->PoliSetor)){
            $this->PoliSetor = Fabrica::FabricarModel('PoliSetor');
        }
        return $this->PoliSetor;
    }

    function setPoliSetor($PoliSetor) {
        $this->PoliSetor = $PoliSetor;
    }

        
    function getNroperador() {
        return $this->nroperador;
    }

    function setNroperador($nroperador) {
        $this->nroperador = $nroperador;
    }

        
    function getHorasop() {
        return $this->horasop;
    }

    function setHorasop($horasop) {
        $this->horasop = $horasop;
    }

        
    function getNomeclatura() {
        return $this->nomeclatura;
    }

    function getModelo() {
        return $this->modelo;
    }

    function getFabricacao() {
        return $this->fabricacao;
    }

    function setNomeclatura($nomeclatura) {
        $this->nomeclatura = $nomeclatura;
    }

    function setModelo($modelo) {
        $this->modelo = $modelo;
    }

    function setFabricacao($fabricacao) {
        $this->fabricacao = $fabricacao;
    }

        
    function getPoliFab() {
        if(!isset($this->PoliFab)){
            $this->PoliFab = Fabrica::FabricarModel('PoliFab');
        }
        return $this->PoliFab;
    }

    function setPoliFab($PoliFab) {
        $this->PoliFab = $PoliFab;
    }
    
    function getCodmaq() {
        return $this->codmaq;
    }

    function getMaquina() {
        return $this->maquina;
    }

    function setCodmaq($codmaq) {
        $this->codmaq = $codmaq;
    }

    function setMaquina($maquina) {
        $this->maquina = $maquina;
    }


}