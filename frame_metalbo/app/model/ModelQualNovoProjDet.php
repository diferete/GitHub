<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualNovoProjDet {

    private $EmpRex;
    private $nr;
    private $desenho_prev;
    private $desenho_ter;
    private $desenho_resp;
    private $etapasfab_prev;
    private $etapasfab_ter;
    private $etapas_resp;
    private $relFerr_prev;
    private $relFerr_ter;
    private $relFerr_resp;
    private $relFerrDesen_prev;
    private $relFerrDesen_ter;
    private $relFerrDesen_resp;
    private $relFerrDist_prev;
    private $relFerrDist_ter;
    private $relFerrDist_resp;
    private $relFerrConf_prev;
    private $relFerrConf_ter;
    private $relFerrConf_resp;
    private $ferrElaboradas;
    private $desenAcordo;
    private $respAnaliseCri;
    private $dtanalisecritica;
    private $comenCrit;

    function getDtanalisecritica() {
        return $this->dtanalisecritica;
    }

    function setDtanalisecritica($dtanalisecritica) {
        $this->dtanalisecritica = $dtanalisecritica;
    }

    function getFerrElaboradas() {
        return $this->ferrElaboradas;
    }

    function getDesenAcordo() {
        return $this->desenAcordo;
    }

    function getRespAnaliseCri() {
        return $this->respAnaliseCri;
    }

    function setFerrElaboradas($ferrElaboradas) {
        $this->ferrElaboradas = $ferrElaboradas;
    }

    function setDesenAcordo($desenAcordo) {
        $this->desenAcordo = $desenAcordo;
    }

    function setRespAnaliseCri($respAnaliseCri) {
        $this->respAnaliseCri = $respAnaliseCri;
    }

    function getComenCrit() {
        return $this->comenCrit;
    }

    function setComenCrit($comenCrit) {
        $this->comenCrit = $comenCrit;
    }

    function getRelFerrConf_prev() {
        return $this->relFerrConf_prev;
    }

    function getRelFerrConf_ter() {
        return $this->relFerrConf_ter;
    }

    function getRelFerrConf_resp() {
        return $this->relFerrConf_resp;
    }

    function setRelFerrConf_prev($relFerrConf_prev) {
        $this->relFerrConf_prev = $relFerrConf_prev;
    }

    function setRelFerrConf_ter($relFerrConf_ter) {
        $this->relFerrConf_ter = $relFerrConf_ter;
    }

    function setRelFerrConf_resp($relFerrConf_resp) {
        $this->relFerrConf_resp = $relFerrConf_resp;
    }

    function getRelFerrDist_prev() {
        return $this->relFerrDist_prev;
    }

    function getRelFerrDist_ter() {
        return $this->relFerrDist_ter;
    }

    function getRelFerrDist_resp() {
        return $this->relFerrDist_resp;
    }

    function setRelFerrDist_prev($relFerrDist_prev) {
        $this->relFerrDist_prev = $relFerrDist_prev;
    }

    function setRelFerrDist_ter($relFerrDist_ter) {
        $this->relFerrDist_ter = $relFerrDist_ter;
    }

    function setRelFerrDist_resp($relFerrDist_resp) {
        $this->relFerrDist_resp = $relFerrDist_resp;
    }

    function getRelFerrDesen_prev() {
        return $this->relFerrDesen_prev;
    }

    function getRelFerrDesen_ter() {
        return $this->relFerrDesen_ter;
    }

    function getRelFerrDesen_resp() {
        return $this->relFerrDesen_resp;
    }

    function setRelFerrDesen_prev($relFerrDesen_prev) {
        $this->relFerrDesen_prev = $relFerrDesen_prev;
    }

    function setRelFerrDesen_ter($relFerrDesen_ter) {
        $this->relFerrDesen_ter = $relFerrDesen_ter;
    }

    function setRelFerrDesen_resp($relFerrDesen_resp) {
        $this->relFerrDesen_resp = $relFerrDesen_resp;
    }

    function getRelFerr_ter() {
        return $this->relFerr_ter;
    }

    function setRelFerr_ter($relFerr_ter) {
        $this->relFerr_ter = $relFerr_ter;
    }

    function getRelFerr_prev() {
        return $this->relFerr_prev;
    }

    function getRelFerr_resp() {
        return $this->relFerr_resp;
    }

    function setRelFerr_prev($relFerr_prev) {
        $this->relFerr_prev = $relFerr_prev;
    }

    function setRelFerr_resp($relFerr_resp) {
        $this->relFerr_resp = $relFerr_resp;
    }

    function getEtapasfab_prev() {
        return $this->etapasfab_prev;
    }

    function getEtapasfab_ter() {
        return $this->etapasfab_ter;
    }

    function getEtapas_resp() {
        return $this->etapas_resp;
    }

    function setEtapasfab_prev($etapasfab_prev) {
        $this->etapasfab_prev = $etapasfab_prev;
    }

    function setEtapasfab_ter($etapasfab_ter) {
        $this->etapasfab_ter = $etapasfab_ter;
    }

    function setEtapas_resp($etapas_resp) {
        $this->etapas_resp = $etapas_resp;
    }

    function getEmpRex() {
        if (!isset($this->EmpRex)) {
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }

        return $this->EmpRex;
    }

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

    function getDesenho_prev() {
        return $this->desenho_prev;
    }

    function getDesenho_ter() {
        return $this->desenho_ter;
    }

    function getDesenho_resp() {
        return $this->desenho_resp;
    }

    function setDesenho_prev($desenho_prev) {
        $this->desenho_prev = $desenho_prev;
    }

    function setDesenho_ter($desenho_ter) {
        $this->desenho_ter = $desenho_ter;
    }

    function setDesenho_resp($desenho_resp) {
        $this->desenho_resp = $desenho_resp;
    }

    function getNr() {
        return $this->nr;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

}
