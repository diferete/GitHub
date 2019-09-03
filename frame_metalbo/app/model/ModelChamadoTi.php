<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelChamadoTi {

    private $nr;
    private $filcgc;
    private $usucod;
    private $usunome;
    private $datacad;
    private $horacad;
    private $repoffice;
    private $setor;
    private $tipo;
    private $subtipo;
    private $subtipo_nome;
    private $problema;
    private $situaca;
    private $usunomeinicio;
    private $usunomefim;
    private $datainicio;
    private $horainicio;
    private $datafim;
    private $horafim;
    private $obsfim;
    private $anexo1;
    private $anexo2;
    private $anexo3;

    function getAnexo1() {
        return $this->anexo1;
    }

    function getAnexo2() {
        return $this->anexo2;
    }

    function getAnexo3() {
        return $this->anexo3;
    }

    function setAnexo1($anexo1) {
        $this->anexo1 = $anexo1;
    }

    function setAnexo2($anexo2) {
        $this->anexo2 = $anexo2;
    }

    function setAnexo3($anexo3) {
        $this->anexo3 = $anexo3;
    }

    function getSubtipo_nome() {
        return $this->subtipo_nome;
    }

    function setSubtipo_nome($subtipo_nome) {
        $this->subtipo_nome = $subtipo_nome;
    }

    function getNr() {
        return $this->nr;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getUsucod() {
        return $this->usucod;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getDatacad() {
        return $this->datacad;
    }

    function getHoracad() {
        return $this->horacad;
    }

    function getRepoffice() {
        return $this->repoffice;
    }

    function getSetor() {
        return $this->setor;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getSubtipo() {
        return $this->subtipo;
    }

    function getProblema() {
        return $this->problema;
    }

    function getSituaca() {
        return $this->situaca;
    }

    function getUsunomeinicio() {
        return $this->usunomeinicio;
    }

    function getUsucodigoinicio() {
        return $this->usucodigoinicio;
    }

    function getUsunomefim() {
        return $this->usunomefim;
    }

    function getUsucodigofim() {
        return $this->usucodigofim;
    }

    function getDatainicio() {
        return $this->datainicio;
    }

    function getHorainicio() {
        return $this->horainicio;
    }

    function getDatafim() {
        return $this->datafim;
    }

    function getHorafim() {
        return $this->horafim;
    }

    function getObsfim() {
        return $this->obsfim;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setUsucod($usucod) {
        $this->usucod = $usucod;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setDatacad($datacad) {
        $this->datacad = $datacad;
    }

    function setHoracad($horacad) {
        $this->horacad = $horacad;
    }

    function setRepoffice($repoffice) {
        $this->repoffice = $repoffice;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setSubtipo($subtipo) {
        $this->subtipo = $subtipo;
    }

    function setProblema($problema) {
        $this->problema = $problema;
    }

    function setSituaca($situaca) {
        $this->situaca = $situaca;
    }


    function setUsunomeinicio($usunomeinicio) {
        $this->usunomeinicio = $usunomeinicio;
    }

    function setUsucodigoinicio($usucodigoinicio) {
        $this->usucodigoinicio = $usucodigoinicio;
    }

    function setUsunomefim($usunomefim) {
        $this->usunomefim = $usunomefim;
    }

    function setUsucodigofim($usucodigofim) {
        $this->usucodigofim = $usucodigofim;
    }

    function setDatainicio($datainicio) {
        $this->datainicio = $datainicio;
    }

    function setHorainicio($horainicio) {
        $this->horainicio = $horainicio;
    }

    function setDatafim($datafim) {
        $this->datafim = $datafim;
    }

    function setHorafim($horafim) {
        $this->horafim = $horafim;
    }

    function setObsfim($obsfim) {
        $this->obsfim = $obsfim;
    }

}
