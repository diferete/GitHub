<?php

/*
 * Classe que implementa os models
 * 
 * @author Cleverton Hoffmann
 * @since 28/02/2019
 */

class ModelSTEEL_PCP_PesoCaixas {

    private $nr;
    private $empcodigo;
    private $tipoCaixa;
    private $padrao;
    private $peso;
    
    function getPeso() {
        return $this->peso;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getEmpcodigo() {
        return $this->empcodigo;
    }

    function getTipoCaixa() {
        return $this->tipoCaixa;
    }

    function getPadrao() {
        return $this->padrao;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setEmpcodigo($empcodigo) {
        $this->empcodigo = $empcodigo;
    }

    function setTipoCaixa($tipoCaixa) {
        $this->tipoCaixa = $tipoCaixa;
    }

    function setPadrao($padrao) {
        $this->padrao = $padrao;
    }
    
}