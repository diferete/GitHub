<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSTEEL_PCP_HorasParadas {

    private $fornocod;
    private $seq;
    private $fornodes;
    private $usunome;
    private $dataini;
    private $horaini;
    private $datafim;
    private $horafim;
    private $motivo;
    private $tempoparada;
    private $horasparadas;
    private $codmotivo;
    
    function getHorasparadas() {
        return $this->horasparadas;
    }

    function getCodmotivo() {
        return $this->codmotivo;
    }

    function setHorasparadas($horasparadas) {
        $this->horasparadas = $horasparadas;
    }

    function setCodmotivo($codmotivo) {
        $this->codmotivo = $codmotivo;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function getSeq() {
        return $this->seq;
    }

    function getFornodes() {
        return $this->fornodes;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getDataini() {
        return $this->dataini;
    }

    function getHoraini() {
        return $this->horaini;
    }

    function getDatafim() {
        return $this->datafim;
    }

    function getHorafim() {
        return $this->horafim;
    }

    function getMotivo() {
        return $this->motivo;
    }

    function getTempoparada() {
        return $this->tempoparada;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setDataini($dataini) {
        $this->dataini = $dataini;
    }

    function setHoraini($horaini) {
        $this->horaini = $horaini;
    }

    function setDatafim($datafim) {
        $this->datafim = $datafim;
    }

    function setHorafim($horafim) {
        $this->horafim = $horafim;
    }

    function setMotivo($motivo) {
        $this->motivo = $motivo;
    }

    function setTempoparada($tempoparada) {
        $this->tempoparada = $tempoparada;
    }

}
