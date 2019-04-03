<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelPedRep{
    private $pdvnro;
    private $pdvordcomp;
    private $Pessoa;
    private $empdes;
    private $pdvemissao;
    private $pdvdtentre;
    private $situaca;
    private $pdvobs;
    private $filcgc;
    private $pdvrepcod;
    
    function getPessoa() {
        if(!isset($this->Pessoa)){
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

        
    function getPdvrepcod() {
        return $this->pdvrepcod;
    }

    function setPdvrepcod($pdvrepcod) {
        $this->pdvrepcod = $pdvrepcod;
    }

        
    function getPdvnro() {
        return $this->pdvnro;
    }

    function getPdvordcomp() {
        return $this->pdvordcomp;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getPdvemissao() {
        return $this->pdvemissao;
    }

    function getPdvdtentre() {
        return $this->pdvdtentre;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function getPdvobs() {
        return $this->pdvobs;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function setPdvnro($pdvnro) {
        $this->pdvnro = $pdvnro;
    }

    function setPdvordcomp($pdvordcomp) {
        $this->pdvordcomp = $pdvordcomp;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setPdvemissao($pdvemissao) {
        $this->pdvemissao = $pdvemissao;
    }

    function setPdvdtentre($pdvdtentre) {
        $this->pdvdtentre = $pdvdtentre;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function setPdvobs($pdvobs) {
        $this->pdvobs = $pdvobs;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }


}








/*  $this->adicionaRelacionamento('pdvnro','pdvnro');
        $this->adicionaRelacionamento('pdvordcomp', 'pdvordcomp');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('pdvemissao', 'pdvemissao');
        $this->adicionaRelacionamento('pdvdtentre', 'pdvdtentre');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('pdvobs', 'pdvobs');
        $this->adicionaRelacionamento('filcgc','filcgc');*/