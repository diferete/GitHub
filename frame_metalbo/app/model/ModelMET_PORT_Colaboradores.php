<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_PORT_Colaboradores {

    private $filcgc;
    private $nr;
    private $situaca;
    private $datachegou;
    private $horachegou;
    private $dataentrou;
    private $horaentrou;
    private $horasaiu;
    private $datasaiu;
    private $usucod;
    private $usunome;
    private $tipopessoa;
    private $pessoa;
    private $fone;
    private $motivo;
    private $descmotivo;
    private $empdes;
    private $cracha;
    private $placa;
    private $respcracha;
    private $respnome;
    
    function getRespcracha() {
        return $this->respcracha;
    }

    function getRespnome() {
        return $this->respnome;
    }

    function setRespcracha($respcracha) {
        $this->respcracha = $respcracha;
    }

    function setRespnome($respnome) {
        $this->respnome = $respnome;
    }

    function getCracha() {
        return str_pad($this->cracha , 4 , '0' , STR_PAD_LEFT);
    }

    function setCracha($cracha) {
        $this->cracha = str_pad($cracha, 4 , '0' , STR_PAD_LEFT);
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function getDatachegou() {
        return $this->datachegou;
    }

    function getHorachegou() {
        return $this->horachegou;
    }

    function getDataentrou() {
        return $this->dataentrou;
    }

    function getHoraentrou() {
        return $this->horaentrou;
    }

    function getHorasaiu() {
        return $this->horasaiu;
    }

    function getDatasaiu() {
        return $this->datasaiu;
    }

    function getUsucod() {
        return $this->usucod;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getTipopessoa() {
        return $this->tipopessoa;
    }

    function getPessoa() {
        return $this->pessoa;
    }

    function getFone() {
        return $this->fone;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getDescmotivo() {
        return $this->descmotivo;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getPlaca() {
        return $this->placa;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function setDatachegou($datachegou) {
        $this->datachegou = $datachegou;
    }

    function setHorachegou($horachegou) {
        $this->horachegou = $horachegou;
    }

    function setDataentrou($dataentrou) {
        $this->dataentrou = $dataentrou;
    }

    function setHoraentrou($horaentrou) {
        $this->horaentrou = $horaentrou;
    }

    function setHorasaiu($horasaiu) {
        $this->horasaiu = $horasaiu;
    }

    function setDatasaiu($datasaiu) {
        $this->datasaiu = $datasaiu;
    }

    function setUsucod($usucod) {
        $this->usucod = $usucod;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setTipopessoa($tipopessoa) {
        $this->tipopessoa = $tipopessoa;
    }

    function setPessoa($pessoa) {
        $this->pessoa = $pessoa;
    }

    function setFone($fone) {
        $this->fone = $fone;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setDescmotivo($descmotivo) {
        $this->descmotivo = $descmotivo;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setPlaca($placa) {
        $this->placa = $placa;
    }

}
