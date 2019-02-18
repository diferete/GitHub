<?php

/*
 * To change this license header choose License Headers in Project Properties.
 * To change this template file choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_PORT_Transito {

    private $filcgc;
    private $nr;
    private $situaca;
    private $placa;
    private $empcod;
    private $empdes;
    private $datachegou;
    private $horachegou;
    private $dataentrou;
    private $horaentrou;
    private $horasaiu;
    private $datasaiu;
    private $usucod;
    private $usunome;
    private $motorista;
    private $cpf;
    private $fone;
    private $motivo;
    private $descmotivo;
    private $tipo;
    private $placacarr1;
    private $placacarr2;

    function getPlacacarr1() {
        return $this->placacarr1;
    }

    function getPlacacarr2() {
        return $this->placacarr2;
    }

    function setPlacacarr1($placacarr1) {
        $this->placacarr1 = $placacarr1;
    }

    function setPlacacarr2($placacarr2) {
        $this->placacarr2 = $placacarr2;
    }

    function getCpf() {
        return $this->cpf;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
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

    function getSituaca() {
        return $this->situaca;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }

    function getDescmotivo() {
        return $this->descmotivo;
    }

    function setDescmotivo($descmotivo) {
        $this->descmotivo = $descmotivo;
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

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getUsucod() {
        return $this->usucod;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getMotorista() {
        return $this->motorista;
    }

    function getFone() {
        return $this->fone;
    }

    function getMotivo() {
        return $this->motivo;
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

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }

    function setUsucod($usucod) {
        $this->usucod = $usucod;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setMotorista($motorista) {
        $this->motorista = $motorista;
    }

    function setFone($fone) {
        $this->fone = $fone;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

}
