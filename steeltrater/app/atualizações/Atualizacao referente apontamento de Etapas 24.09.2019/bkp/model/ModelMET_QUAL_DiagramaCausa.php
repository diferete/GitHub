<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_QUAL_DiagramaCausa {

    private $filcgc;
    private $nr;
    private $matprimades;
    private $metododes;
    private $maodeobrades;
    private $equipamentodes;
    private $meioambientedes;
    private $medidades;
    
    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

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

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
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

}
