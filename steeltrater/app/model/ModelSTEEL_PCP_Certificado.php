<?php

/*
 * Classe que implementa os models da STEEL_PCP_Certificado
 * 
 * @author Cleverton Hoffmann
 * @since 03/10/2018
 */

class ModelSTEEL_PCP_Certificado {

    private $nrcert;
    private $op;
    private $notasteel;
    private $notacliente;
    private $opcliente;
    private $empcod;
    private $empdes;
    private $procod;
    private $prodes;
    private $dataensaio;
    private $dataemissao;
    private $peso;
    private $quant;
    private $usuario;
    private $hora;
    private $durezaSuperfMin;
    private $durezaSuperfMax;
    private $SuperEscala;
    
    private $durezaNucMin;
    private $durezaNucMax;
    private $NucEscala;
    
    private $expCamadaMin;
    private $expCamadaMax;
    
    private $inspeneg;
    
    private $sitEmail;
    
    private $conclusao;
    
    private $fioDurezaSol;
    private $fioEsferio;
    private $fioDescarbonetaTotal;
    private $fioDescarbonetaParcial;
    private $DiamFinalMin;
    private $DiamFinalMax;
    private $dataNotaRetorno;
    
    private $micrografia;
    
    function getMicrografia() {
        return $this->micrografia;
    }

    function setMicrografia($micrografia) {
        $this->micrografia = $micrografia;
    }

        
    function getDataNotaRetorno() {
        return $this->dataNotaRetorno;
    }

    function setDataNotaRetorno($dataNotaRetorno) {
        $this->dataNotaRetorno = $dataNotaRetorno;
    }

        
    
    function getFioDurezaSol() {
        return $this->fioDurezaSol;
    }

    function getFioEsferio() {
        return $this->fioEsferio;
    }

    function getFioDescarbonetaTotal() {
        return $this->fioDescarbonetaTotal;
    }

    function getFioDescarbonetaParcial() {
        return $this->fioDescarbonetaParcial;
    }

    function getDiamFinalMin() {
        return $this->DiamFinalMin;
    }

    function getDiamFinalMax() {
        return $this->DiamFinalMax;
    }

    function setFioDurezaSol($fioDurezaSol) {
        $this->fioDurezaSol = $fioDurezaSol;
    }

    function setFioEsferio($fioEsferio) {
        $this->fioEsferio = $fioEsferio;
    }

    function setFioDescarbonetaTotal($fioDescarbonetaTotal) {
        $this->fioDescarbonetaTotal = $fioDescarbonetaTotal;
    }

    function setFioDescarbonetaParcial($fioDescarbonetaParcial) {
        $this->fioDescarbonetaParcial = $fioDescarbonetaParcial;
    }

    function setDiamFinalMin($DiamFinalMin) {
        $this->DiamFinalMin = $DiamFinalMin;
    }

    function setDiamFinalMax($DiamFinalMax) {
        $this->DiamFinalMax = $DiamFinalMax;
    }    
    
    function getConclusao() {
        return $this->conclusao;
    }

    function setConclusao($conclusao) {
        $this->conclusao = $conclusao;
    }

    
    
    function getSitEmail() {
        return $this->sitEmail;
    }

    function setSitEmail($sitEmail) {
        $this->sitEmail = $sitEmail;
    }

        
    function getInspeneg() {
        return $this->inspeneg;
    }

    function setInspeneg($inspeneg) {
        $this->inspeneg = $inspeneg;
    }

        
    function getExpCamadaMin() {
        return $this->expCamadaMin;
    }

    function getExpCamadaMax() {
        return $this->expCamadaMax;
    }

    function setExpCamadaMin($expCamadaMin) {
        $this->expCamadaMin = $expCamadaMin;
    }

    function setExpCamadaMax($expCamadaMax) {
        $this->expCamadaMax = $expCamadaMax;
    }

        
    function getDurezaNucMin() {
        return $this->durezaNucMin;
    }

    function getDurezaNucMax() {
        return $this->durezaNucMax;
    }

    function getNucEscala() {
        return $this->NucEscala;
    }

    function setDurezaNucMin($durezaNucMin) {
        $this->durezaNucMin = $durezaNucMin;
    }

    function setDurezaNucMax($durezaNucMax) {
        $this->durezaNucMax = $durezaNucMax;
    }

    function setNucEscala($NucEscala) {
        $this->NucEscala = $NucEscala;
    }

        
    function getSuperEscala() {
        return $this->SuperEscala;
    }

    function setSuperEscala($SuperEscala) {
        $this->SuperEscala = $SuperEscala;
    }

        
    function getDurezaSuperfMin() {
        return $this->durezaSuperfMin;
    }

    function getDurezaSuperfMax() {
        return $this->durezaSuperfMax;
    }

    function setDurezaSuperfMin($durezaSuperfMin) {
        $this->durezaSuperfMin = $durezaSuperfMin;
    }

    function setDurezaSuperfMax($durezaSuperfMax) {
        $this->durezaSuperfMax = $durezaSuperfMax;
    }

        
    function getUsuario(){
        return $this->usuario;
    }
    function setUsuario($usuario){
        $this->usuario = $usuario;
    }
    
    function getHora() {
        return $this->hora;
    }

    function setHora($hora) {
        $this->hora =$hora;
    }
    
    function getDataemissao() {
        return $this->dataemissao;
    }

    function getQuant() {
        return $this->quant;
    }

    function setDataemissao($dataemissao) {
        $this->dataemissao = $dataemissao;
    }

    function setQuant($quant) {
        $this->quant = $quant;
    }

        
    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
    }

        
    function getNrcert() {
        return $this->nrcert;
    }

    function getOp() {
        return $this->op;
    }

    function getNotasteel() {
        return $this->notasteel;
    }

    function getNotacliente() {
        return $this->notacliente;
    }

    function getOpcliente() {
        return $this->opcliente;
    }

    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function getDataensaio() {
        return $this->dataensaio;
    }

    function getPeso() {
        return $this->peso;
    }

    function setNrcert($nrcert) {
        $this->nrcert = $nrcert;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setNotasteel($notasteel) {
        $this->notasteel = $notasteel;
    }

    function setNotacliente($notacliente) {
        $this->notacliente = $notacliente;
    }

    function setOpcliente($opcliente) {
        $this->opcliente = $opcliente;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }


    function setDataensaio($dataensaio) {
        $this->dataensaio = $dataensaio;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }
    
}