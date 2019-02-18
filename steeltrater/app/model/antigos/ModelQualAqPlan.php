<?php

/* 
 * Class Model 
 * 
 * @autor Avanei Martendal
 * 
 * @since 01/06/2017
 */

class ModelQualAqPlan {
    private $filcgc;
    private $nr;
    private $seq;
    private $plano;
    private $dataprev;
    private $anexoplan1;
    private $usucodigo;
    private $usunome;
    private $tipo;
    
    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

        
    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

        
    function getAnexoplan1() {
        return $this->anexoplan1;
    }

    function setAnexoplan1($anexoplan1) {
        $this->anexoplan1 = $anexoplan1;
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

    function getPlano() {
        return $this->plano;
    }

   

    function getDataprev() {
        return $this->dataprev;
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

    function setPlano($plano) {
        $this->plano = $plano;
    }

   

    function setDataprev($dataprev) {
        $this->dataprev = $dataprev;
    }


    
    
    
}