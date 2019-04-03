<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelSolFat {
    private $empcnpj;
    private $fatsol;
    
    
    private $Pessoa;
    private $pesnome_razao;
    private $contato;
    private $fatsit;
    private $fatdtlibdata;
    private $fatod;
    private $fatvlrtot;
    private $fatfinan;
    
    function getFatfinan() {
        return $this->fatfinan;
    }

    function setFatfinan($fatfinan) {
        $this->fatfinan = $fatfinan;
    }

        
    function getFatvlrtot() {
        return $this->fatvlrtot;
    }

    function setFatvlrtot($fatvlrtot) {
        $this->fatvlrtot = $fatvlrtot;
    }

        
    function getFatsol() {
        return $this->fatsol;
    }

    function setFatsol($fatsol) {
        $this->fatsol = $fatsol;
    }

        
    function getFatod() {
        return $this->fatod;
    }

    function setFatod($fatod) {
        $this->fatod = $fatod;
    }

        
    function getFatdtlibdata() {
        return $this->fatdtlibdata;
    }

    function setFatdtlibdata($fatdtlibdata) {
        $this->fatdtlibdata = $fatdtlibdata;
    }

    
        
    function getFatsit() {
        return $this->fatsit;
    }

    function setFatsit($fatsit) {
        $this->fatsit = $fatsit;
    }

        
    function getContato() {
        return $this->contato;
    }

    function setContato($contato) {
        $this->contato = $contato;
    }

        
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function getFatnro() {
        return $this->fatnro;
    }



    function getPessoa() {
        if(!isset($this->Pessoa)){
            $this->Pessoa = Fabrica::FabricarModel('Pessoa');
        }
        return $this->Pessoa;
    }

    function getPesnome_razao() {
        return $this->pesnome_razao;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function setFatnro($fatnro) {
        $this->fatnro = $fatnro;
    }

    function setPessoa($Pessoa) {
        $this->Pessoa = $Pessoa;
    }

    function setPesnome_razao($pesnome_razao) {
        $this->pesnome_razao = $pesnome_razao;
    }


}