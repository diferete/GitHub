<?php

/* 
 * @author Avanei Martendal
 * @since 06/09/2019
 */

class ModelSTEEL_PCP_ordensFabApontEtapas {
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
    private $dataent_forno;
    private $horaent_forno;
    private $datasaida_forno;
    private $horasaida_forno;
    
    function getDataent_forno() {
        return $this->dataent_forno;
    }

    function getHoraent_forno() {
        return $this->horaent_forno;
    }

    function getDatasaida_forno() {
        return $this->datasaida_forno;
    }

    function getHorasaida_forno() {
        return $this->horasaida_forno;
    }

    function setDataent_forno($dataent_forno) {
        $this->dataent_forno = $dataent_forno;
    }

    function setHoraent_forno($horaent_forno) {
        $this->horaent_forno = $horaent_forno;
    }

    function setDatasaida_forno($datasaida_forno) {
        $this->datasaida_forno = $datasaida_forno;
    }

    function setHorasaida_forno($horasaida_forno) {
        $this->horasaida_forno = $horasaida_forno;
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

