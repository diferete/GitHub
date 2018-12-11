<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualCausa {

    private $filcgc;
    private $nr;
    private $seq;
    private $causa;
    private $causades;
    private $anexocausa1;
    private $causaprov;
    private $pq1;
    private $pq2;
    private $pq3;
    private $pq4;
    private $pq5;
    private $ocorrencia;
    private $matprimades;
    private $metododes;
    private $maodeobrades;
    private $equipamentodes;
    private $meioambientedes;
    private $medidades;

    function getMatprimades() {
        return $this->matprimades;
    }

    function getMetododes() {
        return $this->metododes;
    }

    function getMaodeobrades() {
        return $this->maodeobrades;
    }

    function getEquipamentodes() {
        return $this->equipamentodes;
    }

    function getMeioambientedes() {
        return $this->meioambientedes;
    }

    function getMedidades() {
        return $this->medidades;
    }

    function setMatprimades($matprimades) {
        $this->matprimades = $matprimades;
    }

    function setMetododes($metododes) {
        $this->metododes = $metododes;
    }

    function setMaodeobrades($maodeobrades) {
        $this->maodeobrades = $maodeobrades;
    }

    function setEquipamentodes($equipamentodes) {
        $this->equipamentodes = $equipamentodes;
    }

    function setMeioambientedes($meioambientedes) {
        $this->meioambientedes = $meioambientedes;
    }

    function setMedidades($medidades) {
        $this->medidades = $medidades;
    }

    function getOcorrencia() {
        return $this->ocorrencia;
    }

    function setOcorrencia($ocorrencia) {
        $this->ocorrencia = $ocorrencia;
    }

    function getCausaprov() {
        return $this->causaprov;
    }

    function getPq1() {
        return $this->pq1;
    }

    function getPq2() {
        return $this->pq2;
    }

    function getPq3() {
        return $this->pq3;
    }

    function getPq4() {
        return $this->pq4;
    }

    function getPq5() {
        return $this->pq5;
    }

    function setCausaprov($causaprov) {
        $this->causaprov = $causaprov;
    }

    function setPq1($pq1) {
        $this->pq1 = $pq1;
    }

    function setPq2($pq2) {
        $this->pq2 = $pq2;
    }

    function setPq3($pq3) {
        $this->pq3 = $pq3;
    }

    function setPq4($pq4) {
        $this->pq4 = $pq4;
    }

    function setPq5($pq5) {
        $this->pq5 = $pq5;
    }

    function getAnexocausa1() {
        return $this->anexocausa1;
    }

    function setAnexocausa1($anexocausa1) {
        $this->anexocausa1 = $anexocausa1;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getSeq() {
        return $this->seq;
    }

    function getCausa() {
        return $this->causa;
    }

    function getCausades() {
        return $this->causades;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setCausa($causa) {
        $this->causa = $causa;
    }

    function setCausades($causades) {
        $this->causades = $causades;
    }

}
