<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelQualNovoProjVerif {

    private $EmpRex;
    private $nr;
    private $verifDesenhoPrev;
    private $verifDesenhoTer;
    private $verifDesenhoResp;
    private $verifDesenhoAnex;
    private $verifRelFerrPrev;
    private $verifRelFerrter;
    private $verifRelFerrResp;
    private $verifRelFerrAnex;
    private $verifDesenhoFerrPrev;
    private $verifDesenhoFerrTer;
    private $verifDesenhoFerrResp;
    private $verifDesenhoFerrAnex;
    private $dimenFerrPrev;
    private $dimenFerrTer;
    private $dimenFerrResp;
    private $dimenFerrAnex;
    private $dimenProdPrev;
    private $dimenProdTer;
    private $dimenProdResp;
    private $dimenProdAnex;
    private $camadaZincoPrev;
    private $camadaZincoTer;
    private $camadaZincoResp;
    private $camadaZincoAnex;
    private $ensaioDurezaPrev;
    private $ensaioDurezaTer;
    private $ensaioDurezaResp;
    private $ensaioDurezaAnex;
    private $cargaprovaPrev;
    private $cargaprovaTer;
    private $cargaprovaResp;
    private $cargaprovaAnex;
    private $terceiroPrev;
    private $terceiroTer;
    private $terceiroResp;
    private $terceiroAnex;
    private $ensReq;
    private $ensReqDef;
    private $ensReqLegal;
    private $ensPlan;
    private $ensComem;
    private $respEns;
    private $valNf;
    private $valNfPrev;
    private $valNfTer;
    private $valNfResp;
    private $valOd;
    private $valOdPrev;
    private $valOdTer;
    private $valODResp;
    private $valPed;
    private $valPedPrev;
    private $valPedTer;
    private $valPedResp;
    private $valPapp;
    private $valPappPrev;
    private $valPappTer;
    private $valPappResp;
    private $etapProj;
    private $result;
    private $cliprov;
    private $valproj;
    private $comenvalproj;
    private $respvalproj;
    private $dtanaliseens;
    private $dtanalisevalproj;

    function getDtanalisevalproj() {
        return $this->dtanalisevalproj;
    }

    function setDtanalisevalproj($dtanalisevalproj) {
        $this->dtanalisevalproj = $dtanalisevalproj;
    }

    function getDtanaliseens() {
        return $this->dtanaliseens;
    }

    function setDtanaliseens($dtanaliseens) {
        $this->dtanaliseens = $dtanaliseens;
    }

    /* etapProj varchar(10),
      result varchar(10),
      cliprov varchar(10),
      valproj varchar(10),
      comenvalproj varchar(1000),
      respvalproj varchar(80) */

    function getEtapProj() {
        return $this->etapProj;
    }

    function getResult() {
        return $this->result;
    }

    function getCliprov() {
        return $this->cliprov;
    }

    function getValproj() {
        return $this->valproj;
    }

    function getComenvalproj() {
        return $this->comenvalproj;
    }

    function getRespvalproj() {
        return $this->respvalproj;
    }

    function setEtapProj($etapProj) {
        $this->etapProj = $etapProj;
    }

    function setResult($result) {
        $this->result = $result;
    }

    function setCliprov($cliprov) {
        $this->cliprov = $cliprov;
    }

    function setValproj($valproj) {
        $this->valproj = $valproj;
    }

    function setComenvalproj($comenvalproj) {
        $this->comenvalproj = $comenvalproj;
    }

    function setRespvalproj($respvalproj) {
        $this->respvalproj = $respvalproj;
    }

    function getValPapp() {
        return $this->valPapp;
    }

    function getValPappPrev() {
        return $this->valPappPrev;
    }

    function getValPappTer() {
        return $this->valPappTer;
    }

    function getValPappResp() {
        return $this->valPappResp;
    }

    function setValPapp($valPapp) {
        $this->valPapp = $valPapp;
    }

    function setValPappPrev($valPappPrev) {
        $this->valPappPrev = $valPappPrev;
    }

    function setValPappTer($valPappTer) {
        $this->valPappTer = $valPappTer;
    }

    function setValPappResp($valPappResp) {
        $this->valPappResp = $valPappResp;
    }

    function getValPed() {
        return $this->valPed;
    }

    function getValPedPrev() {
        return $this->valPedPrev;
    }

    function getValPedTer() {
        return $this->valPedTer;
    }

    function getValPedResp() {
        return $this->valPedResp;
    }

    function setValPed($valPed) {
        $this->valPed = $valPed;
    }

    function setValPedPrev($valPedPrev) {
        $this->valPedPrev = $valPedPrev;
    }

    function setValPedTer($valPedTer) {
        $this->valPedTer = $valPedTer;
    }

    function setValPedResp($valPedResp) {
        $this->valPedResp = $valPedResp;
    }

    function getValOd() {
        return $this->valOd;
    }

    function getValOdPrev() {
        return $this->valOdPrev;
    }

    function getValOdTer() {
        return $this->valOdTer;
    }

    function getValODResp() {
        return $this->valODResp;
    }

    function setValOd($valOd) {
        $this->valOd = $valOd;
    }

    function setValOdPrev($valOdPrev) {
        $this->valOdPrev = $valOdPrev;
    }

    function setValOdTer($valOdTer) {
        $this->valOdTer = $valOdTer;
    }

    function setValODResp($valODResp) {
        $this->valODResp = $valODResp;
    }

    function getValNf() {
        return $this->valNf;
    }

    function getValNfPrev() {
        return $this->valNfPrev;
    }

    function getValNfTer() {
        return $this->valNfTer;
    }

    function getValNfResp() {
        return $this->valNfResp;
    }

    function setValNf($valNf) {
        $this->valNf = $valNf;
    }

    function setValNfPrev($valNfPrev) {
        $this->valNfPrev = $valNfPrev;
    }

    function setValNfTer($valNfTer) {
        $this->valNfTer = $valNfTer;
    }

    function setValNfResp($valNfResp) {
        $this->valNfResp = $valNfResp;
    }

    function getEnsReq() {
        return $this->ensReq;
    }

    function getEnsReqDef() {
        return $this->ensReqDef;
    }

    function getEnsReqLegal() {
        return $this->ensReqLegal;
    }

    function getEnsPlan() {
        return $this->ensPlan;
    }

    function getEnsComem() {
        return $this->ensComem;
    }

    function getRespEns() {
        return $this->respEns;
    }

    function setEnsReq($ensReq) {
        $this->ensReq = $ensReq;
    }

    function setEnsReqDef($ensReqDef) {
        $this->ensReqDef = $ensReqDef;
    }

    function setEnsReqLegal($ensReqLegal) {
        $this->ensReqLegal = $ensReqLegal;
    }

    function setEnsPlan($ensPlan) {
        $this->ensPlan = $ensPlan;
    }

    function setEnsComem($ensComem) {
        $this->ensComem = $ensComem;
    }

    function setRespEns($respEns) {
        $this->respEns = $respEns;
    }

    function getTerceiroPrev() {
        return $this->terceiroPrev;
    }

    function getTerceiroTer() {
        return $this->terceiroTer;
    }

    function getTerceiroResp() {
        return $this->terceiroResp;
    }

    function getTerceiroAnex() {
        return $this->terceiroAnex;
    }

    function setTerceiroPrev($terceiroPrev) {
        $this->terceiroPrev = $terceiroPrev;
    }

    function setTerceiroTer($terceiroTer) {
        $this->terceiroTer = $terceiroTer;
    }

    function setTerceiroResp($terceiroResp) {
        $this->terceiroResp = $terceiroResp;
    }

    function setTerceiroAnex($terceiroAnex) {
        $this->terceiroAnex = $terceiroAnex;
    }

    function getCargaprovaPrev() {
        return $this->cargaprovaPrev;
    }

    function getCargaprovaTer() {
        return $this->cargaprovaTer;
    }

    function getCargaprovaResp() {
        return $this->cargaprovaResp;
    }

    function getCargaprovaAnex() {
        return $this->cargaprovaAnex;
    }

    function setCargaprovaPrev($cargaprovaPrev) {
        $this->cargaprovaPrev = $cargaprovaPrev;
    }

    function setCargaprovaTer($cargaprovaTer) {
        $this->cargaprovaTer = $cargaprovaTer;
    }

    function setCargaprovaResp($cargaprovaResp) {
        $this->cargaprovaResp = $cargaprovaResp;
    }

    function setCargaprovaAnex($cargaprovaAnex) {
        $this->cargaprovaAnex = $cargaprovaAnex;
    }

    function getEnsaioDurezaPrev() {
        return $this->ensaioDurezaPrev;
    }

    function getEnsaioDurezaTer() {
        return $this->ensaioDurezaTer;
    }

    function getEnsaioDurezaResp() {
        return $this->ensaioDurezaResp;
    }

    function getEnsaioDurezaAnex() {
        return $this->ensaioDurezaAnex;
    }

    function setEnsaioDurezaPrev($ensaioDurezaPrev) {
        $this->ensaioDurezaPrev = $ensaioDurezaPrev;
    }

    function setEnsaioDurezaTer($ensaioDurezaTer) {
        $this->ensaioDurezaTer = $ensaioDurezaTer;
    }

    function setEnsaioDurezaResp($ensaioDurezaResp) {
        $this->ensaioDurezaResp = $ensaioDurezaResp;
    }

    function setEnsaioDurezaAnex($ensaioDurezaAnex) {
        $this->ensaioDurezaAnex = $ensaioDurezaAnex;
    }

    function getCamadaZincoPrev() {
        return $this->camadaZincoPrev;
    }

    function getCamadaZincoTer() {
        return $this->camadaZincoTer;
    }

    function getCamadaZincoResp() {
        return $this->camadaZincoResp;
    }

    function getCamadaZincoAnex() {
        return $this->camadaZincoAnex;
    }

    function setCamadaZincoPrev($camadaZincoPrev) {
        $this->camadaZincoPrev = $camadaZincoPrev;
    }

    function setCamadaZincoTer($camadaZincoTer) {
        $this->camadaZincoTer = $camadaZincoTer;
    }

    function setCamadaZincoResp($camadaZincoResp) {
        $this->camadaZincoResp = $camadaZincoResp;
    }

    function setCamadaZincoAnex($camadaZincoAnex) {
        $this->camadaZincoAnex = $camadaZincoAnex;
    }

    function getDimenProdPrev() {
        return $this->dimenProdPrev;
    }

    function getDimenProdTer() {
        return $this->dimenProdTer;
    }

    function getDimenProdResp() {
        return $this->dimenProdResp;
    }

    function getDimenProdAnex() {
        return $this->dimenProdAnex;
    }

    function setDimenProdPrev($dimenProdPrev) {
        $this->dimenProdPrev = $dimenProdPrev;
    }

    function setDimenProdTer($dimenProdTer) {
        $this->dimenProdTer = $dimenProdTer;
    }

    function setDimenProdResp($dimenProdResp) {
        $this->dimenProdResp = $dimenProdResp;
    }

    function setDimenProdAnex($dimenProdAnex) {
        $this->dimenProdAnex = $dimenProdAnex;
    }

    function getDimenFerrPrev() {
        return $this->dimenFerrPrev;
    }

    function getDimenFerrTer() {
        return $this->dimenFerrTer;
    }

    function getDimenFerrResp() {
        return $this->dimenFerrResp;
    }

    function getDimenFerrAnex() {
        return $this->dimenFerrAnex;
    }

    function setDimenFerrPrev($dimenFerrPrev) {
        $this->dimenFerrPrev = $dimenFerrPrev;
    }

    function setDimenFerrTer($dimenFerrTer) {
        $this->dimenFerrTer = $dimenFerrTer;
    }

    function setDimenFerrResp($dimenFerrResp) {
        $this->dimenFerrResp = $dimenFerrResp;
    }

    function setDimenFerrAnex($dimenFerrAnex) {
        $this->dimenFerrAnex = $dimenFerrAnex;
    }

    function getVerifDesenhoFerrPrev() {
        return $this->verifDesenhoFerrPrev;
    }

    function getVerifDesenhoFerrTer() {
        return $this->verifDesenhoFerrTer;
    }

    function getVerifDesenhoFerrResp() {
        return $this->verifDesenhoFerrResp;
    }

    function getVerifDesenhoFerrAnex() {
        return $this->verifDesenhoFerrAnex;
    }

    function setVerifDesenhoFerrPrev($verifDesenhoFerrPrev) {
        $this->verifDesenhoFerrPrev = $verifDesenhoFerrPrev;
    }

    function setVerifDesenhoFerrTer($verifDesenhoFerrTer) {
        $this->verifDesenhoFerrTer = $verifDesenhoFerrTer;
    }

    function setVerifDesenhoFerrResp($verifDesenhoFerrResp) {
        $this->verifDesenhoFerrResp = $verifDesenhoFerrResp;
    }

    function setVerifDesenhoFerrAnex($verifDesenhoFerrAnex) {
        $this->verifDesenhoFerrAnex = $verifDesenhoFerrAnex;
    }

    function getVerifRelFerrPrev() {
        return $this->verifRelFerrPrev;
    }

    function getVerifRelFerrter() {
        return $this->verifRelFerrter;
    }

    function getVerifRelFerrResp() {
        return $this->verifRelFerrResp;
    }

    function getVerifRelFerrAnex() {
        return $this->verifRelFerrAnex;
    }

    function setVerifRelFerrPrev($verifRelFerrPrev) {
        $this->verifRelFerrPrev = $verifRelFerrPrev;
    }

    function setVerifRelFerrter($verifRelFerrter) {
        $this->verifRelFerrter = $verifRelFerrter;
    }

    function setVerifRelFerrResp($verifRelFerrResp) {
        $this->verifRelFerrResp = $verifRelFerrResp;
    }

    function setVerifRelFerrAnex($verifRelFerrAnex) {
        $this->verifRelFerrAnex = $verifRelFerrAnex;
    }

    function getVerifDesenhoPrev() {
        return $this->verifDesenhoPrev;
    }

    function getVerifDesenhoTer() {
        return $this->verifDesenhoTer;
    }

    function getVerifDesenhoResp() {
        return $this->verifDesenhoResp;
    }

    function getVerifDesenhoAnex() {
        return $this->verifDesenhoAnex;
    }

    function setVerifDesenhoPrev($verifDesenhoPrev) {
        $this->verifDesenhoPrev = $verifDesenhoPrev;
    }

    function setVerifDesenhoTer($verifDesenhoTer) {
        $this->verifDesenhoTer = $verifDesenhoTer;
    }

    function setVerifDesenhoResp($verifDesenhoResp) {
        $this->verifDesenhoResp = $verifDesenhoResp;
    }

    function setVerifDesenhoAnex($verifDesenhoAnex) {
        $this->verifDesenhoAnex = $verifDesenhoAnex;
    }

    function getEmpRex() {
        if (!isset($this->EmpRex)) {
            $this->EmpRex = Fabrica::FabricarModel('EmpRex');
        }
        return $this->EmpRex;
    }

    function getNr() {
        return $this->nr;
    }

    function setEmpRex($EmpRex) {
        $this->EmpRex = $EmpRex;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

}
