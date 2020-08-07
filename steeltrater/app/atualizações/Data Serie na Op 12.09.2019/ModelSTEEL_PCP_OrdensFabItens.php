<?php

/* 
 * Classe que implementa o model da produção steeltrater
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ModelSTEEL_PCP_OrdensFabItens{
    
    private $op;
    private $opseq;
    private $receita;
    private $receita_seq;
    private $tratamento;
    private $camada_min;
    private $camada_max;
    private $temperatura;
    private $tempo;
    private $resfriamento;
    private $STEEL_PCP_Tratamentos;
    
    function getSTEEL_PCP_Tratamentos() {
        if(!isset($this->STEEL_PCP_Tratamentos)){
            $this->STEEL_PCP_Tratamentos = Fabrica::FabricarModel('STEEL_PCP_Tratamentos');
        }
        
        return $this->STEEL_PCP_Tratamentos;
    }

    function setSTEEL_PCP_Tratamentos($STEEL_PCP_Tratamentos) {
        $this->STEEL_PCP_Tratamentos = $STEEL_PCP_Tratamentos;
    }

        
    function getReceita_seq() {
        return $this->receita_seq;
    }

    function setReceita_seq($receita_seq) {
        $this->receita_seq = $receita_seq;
    }

        
    function getOp() {
        return $this->op;
    }

    function getOpseq() {
        return $this->opseq;
    }

    function getReceita() {
        return $this->receita;
    }

    function getTratamento() {
        return $this->tratamento;
    }

    function getCamada_min() {
        return $this->camada_min;
    }

    function getCamada_max() {
        return $this->camada_max;
    }

    function getTemperatura() {
        return $this->temperatura;
    }

    function getTempo() {
        return $this->tempo;
    }

    function getResfriamento() {
        return $this->resfriamento;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setOpseq($opseq) {
        $this->opseq = $opseq;
    }

    function setReceita($receita) {
        $this->receita = $receita;
    }

    function setTratamento($tratamento) {
        $this->tratamento = $tratamento;
    }

    function setCamada_min($camada_min) {
        $this->camada_min = $camada_min;
    }

    function setCamada_max($camada_max) {
        $this->camada_max = $camada_max;
    }

    function setTemperatura($temperatura) {
        $this->temperatura = $temperatura;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
    }

    function setResfriamento($resfriamento) {
        $this->resfriamento = $resfriamento;
    }

        
   
}
