<?php

/*
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ModelMET_MP_ItensManPrev {
    
    private $MET_MP_ServicoMaquina;
    private $filcgc;
    private $nr;
    private $seq;
    private $codmaq;
    private $maquina;
    private $codsit;
    private $servico;
    private $sitmp;
    private $dias;
    private $databert;
    private $userinicial;
    private $datafech;
    private $userfinal;
    private $obs;
    private $oqfazer;
    private $fezmanut;
    
    function getFezmanut() {
        return $this->fezmanut;
    }

    function setFezmanut($fezmanut) {
        $this->fezmanut = $fezmanut;
    }
<<<<<<< HEAD:steeltrater/app/BKP/app/model/ModelMET_ItensManPrev.php
    
=======
  
>>>>>>> a54785e83fce56537b06fb4e15ca79b1f590fce7:frame_metalbo/app/model/ModelMET_MP_ItensManPrev.php
    function getServico() {
        return $this->servico;
    }

    function setServico($servico) {
        $this->servico = $servico;
    }
<<<<<<< HEAD:steeltrater/app/BKP/app/model/ModelMET_ItensManPrev.php
    
    function getOqfazer() {
        return $this->oqfazer;
    }

    function setOqfazer($oqfazer) {
        $this->oqfazer = $oqfazer;
    }
  
    function getMET_ServicoMaquina() {
        if (!isset($this->MET_ServicoMaquina)) {
            $this->MET_ServicoMaquina = Fabrica::FabricarModel('MET_ServicoMaquina');
=======
      
    function getMET_MP_ServicoMaquina() {
        if (!isset($this->MET_MP_ServicoMaquina)) {
            $this->MET_MP_ServicoMaquina = Fabrica::FabricarModel('MET_MP_ServicoMaquina');
>>>>>>> a54785e83fce56537b06fb4e15ca79b1f590fce7:frame_metalbo/app/model/ModelMET_MP_ItensManPrev.php
        }
        return $this->MET_MP_ServicoMaquina;
    }

    function setMET_MP_ServicoMaquina($MET_MP_ServicoMaquina) {
        $this->MET_MP_ServicoMaquina = $MET_MP_ServicoMaquina;
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

    function getCodmaq() {
        return $this->codmaq;
    }

    function getMaquina() {
        return $this->maquina;
    }

    function getCodsit() {
        return $this->codsit;
    }

    function getSitmp() {
        return $this->sitmp;
    }

    function getDias() {
        return $this->dias;
    }

    function getDatabert() {
        return $this->databert;
    }

    function getUserinicial() {
        return $this->userinicial;
    }

    function getDatafech() {
        return $this->datafech;
    }

    function getUserfinal() {
        return $this->userfinal;
    }

    function getObs() {
        return $this->obs;
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

    function setCodmaq($codmaq) {
        $this->codmaq = $codmaq;
    }

    function setMaquina($maquina) {
        $this->maquina = $maquina;
    }

    function setCodsit($codsit) {
        $this->codsit = $codsit;
    }

    function setSitmp($sitmp) {
        $this->sitmp = $sitmp;
    }

    function setDias($dias) {
        $this->dias = $dias;
    }

    function setDatabert($databert) {
        $this->databert = $databert;
    }

    function setUserinicial($userinicial) {
        $this->userinicial = $userinicial;
    }

    function setDatafech($datafech) {
        $this->datafech = $datafech;
    }

    function setUserfinal($userfinal) {
        $this->userfinal = $userfinal;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }
    
}

