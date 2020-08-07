<?php

/*
 * Classe que implementa os models da DELX_CID_Cidade
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ModelSTEEL_PCP_prodMatReceita {
    
    private $DELX_PRO_Produtos;
    private $STEEL_PCP_material;
    private $STEEL_PCP_receitas;
    private $prod;
    private $matcod;
    private $cod;
    private $durezaNucMin;
    private $durezaNucMax;
    private $NucEscala;
    private $durezaSuperfMin;
    private $durezaSuperfMax;
    private $SuperEscala;
    private $expCamadaMin;
    private $expCamadaMax;
    private $seqmat;
    private $tratrevencomp;
    
    private $fioDurezaSol;
    private $fioEsferio;
    private $fioDescarbonetaTotal;
    private $fioDescarbonetaParcial;
    private $DiamFinalMin;
    private $DiamFinalMax;
    
    private $ppap;
    private $nrppap;
    
    function getNrppap() {
        return $this->nrppap;
    }

    function setNrppap($nrppap) {
        $this->nrppap = $nrppap;
    }
    
    function getPpap() {
        return $this->ppap;
    }

    function setPpap($ppap) {
        $this->ppap = $ppap;
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

         
    function getSuperEscala() {
        return $this->SuperEscala;
    }

    function setSuperEscala($SuperEscala) {
        $this->SuperEscala = $SuperEscala;
    }

        
    
    function getNucEscala() {
        return $this->NucEscala;
    }

    function setNucEscala($NucEscala) {
        $this->NucEscala = $NucEscala;
    }

        
    function getExpCamadaMax() {
        return $this->expCamadaMax;
    }

    function setExpCamadaMax($expCamadaMax) {
        $this->expCamadaMax = $expCamadaMax;
    }

        
    
    function getExpCamadaMin() {
        return $this->expCamadaMin;
    }

    function setExpCamadaMin($expCamadaMin) {
        $this->expCamadaMin = $expCamadaMin;
    }

        
    function getDurezaSuperfMax() {
        return $this->durezaSuperfMax;
    }

    function setDurezaSuperfMax($durezaSuperfMax) {
        $this->durezaSuperfMax = $durezaSuperfMax;
    }

        
    function getDurezaSuperfMin() {
        return $this->durezaSuperfMin;
    }

    function setDurezaSuperfMin($durezaSuperfMin) {
        $this->durezaSuperfMin = $durezaSuperfMin;
    }

        
    function getDurezaNucMax() {
        return $this->durezaNucMax;
    }

    function setDurezaNucMax($durezaNucMax) {
        $this->durezaNucMax = $durezaNucMax;
    }

        
    function getDurezaNucMin() {
        return $this->durezaNucMin;
    }

    function setDurezaNucMin($durezaNucMin) {
        $this->durezaNucMin = $durezaNucMin;
    }

        
    function getTratrevencomp() {
        return $this->tratrevencomp;
    }

    function setTratrevencomp($tratrevencomp) {
        $this->tratrevencomp = $tratrevencomp;
    }

   
    function getSeqmat() {
        return $this->seqmat;
    }

    function setSeqmat($seqmat) {
        $this->seqmat = $seqmat;
    }
    
   

    function getProd() {
        return $this->prod;
    }

    function setProd($prod) {
        $this->prod = $prod;
    }
    
        
    function getDELX_PRO_Produtos() {
        if(!isset($this->DELX_PRO_Produtos)){
            $this->DELX_PRO_Produtos = Fabrica::FabricarModel('DELX_PRO_Produtos');
        }
        return $this->DELX_PRO_Produtos;
    }

    function setDELX_PRO_Produtos($DELX_PRO_Produtos) {
        $this->DELX_PRO_Produtos = $DELX_PRO_Produtos;
    }

    function getSTEEL_PCP_material() {
        if(!isset($this->STEEL_PCP_material)){
            $this->STEEL_PCP_material = Fabrica::FabricarModel('STEEL_PCP_material');
        }
        return $this->STEEL_PCP_material;
    }

    function setSTEEL_PCP_material($STEEL_PCP_material) {
        $this->STEEL_PCP_material = $STEEL_PCP_material;
    }
    
     function getSTEEL_PCP_receitas() {
        if(!isset($this->STEEL_PCP_receitas)){
            $this->STEEL_PCP_receitas = Fabrica::FabricarModel('STEEL_PCP_receitas');
        }
        return $this->STEEL_PCP_receitas;
    }

    function setSTEEL_PCP_receitas($STEEL_PCP_receitas) {
        $this->STEEL_PCP_receitas = $STEEL_PCP_receitas;
    }
    
    function getMatcod() {
        return $this->matcod;
    }

    function getCod() {
        return $this->cod;
    }

    

    function setMatcod($matcod) {
        $this->matcod = $matcod;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }
    
}
    