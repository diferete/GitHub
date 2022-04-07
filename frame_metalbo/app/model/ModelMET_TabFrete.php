<?php

/*
 * Classe que gerencia a Model da MET_TabFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ModelMET_TabFrete {
    
    private $Pessoa;
    private $cnpj;
    private $seq;
    private $codtipo;
    private $ref;
    private $taxamin;
    private $fretevalor;
    private $fretepeso;
    private $pedagio;
    private $taxa2;
    private $tas;
    private $gris;
    private $taxa;
    private $imposto;
    private $formula1;
    private $formula2;
    private $formula3;
    private $formula4;
    private $empdes;
    private $taxaEmergencial;
    
    
    function getTaxaEmergencial() {
        return $this->taxaEmergencial;
    }

    function setTaxaEmergencial($taxaEmergencial) {
        $this->taxaEmergencial = $taxaEmergencial;
    }

        
    function getPessoa() {
        if (!isset($this->Pessoa)) {
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }
    
    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }
    
    function getCnpj() {
        return $this->cnpj;
    }

    function getSeq() {
        return $this->seq;
    }

    function getCodtipo() {
        return $this->codtipo;
    }

    function getRef() {
        return $this->ref;
    }

    function getTaxamin() {
        return $this->taxamin;
    }

    function getFretevalor() {
        return $this->fretevalor;
    }

    function getFretepeso() {
        return $this->fretepeso;
    }

    function getPedagio() {
        return $this->pedagio;
    }

    function getTaxa2() {
        return $this->taxa2;
    }

    function getTas() {
        return $this->tas;
    }

    function getGris() {
        return $this->gris;
    }

    function getTaxa() {
        return $this->taxa;
    }

    function getImposto() {
        return $this->imposto;
    }

    function getFormula1() {
        return $this->formula1;
    }

    function getFormula2() {
        return $this->formula2;
    }

    function getFormula3() {
        return $this->formula3;
    }

    function getFormula4() {
        return $this->formula4;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setCodtipo($codtipo) {
        $this->codtipo = $codtipo;
    }

    function setRef($ref) {
        $this->ref = $ref;
    }

    function setTaxamin($taxamin) {
        $this->taxamin = $taxamin;
    }

    function setFretevalor($fretevalor) {
        $this->fretevalor = $fretevalor;
    }

    function setFretepeso($fretepeso) {
        $this->fretepeso = $fretepeso;
    }

    function setPedagio($pedagio) {
        $this->pedagio = $pedagio;
    }

    function setTaxa2($taxa2) {
        $this->taxa2 = $taxa2;
    }

    function setTas($tas) {
        $this->tas = $tas;
    }

    function setGris($gris) {
        $this->gris = $gris;
    }

    function setTaxa($taxa) {
        $this->taxa = $taxa;
    }

    function setImposto($imposto) {
        $this->imposto = $imposto;
    }

    function setFormula1($formula1) {
        $this->formula1 = $formula1;
    }

    function setFormula2($formula2) {
        $this->formula2 = $formula2;
    }

    function setFormula3($formula3) {
        $this->formula3 = $formula3;
    }

    function setFormula4($formula4) {
        $this->formula4 = $formula4;
    }   
    
}