<?php

/*
 * Classe que implementa os models da STEEL_PCP_ordensFabLista
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class ModelSTEEL_PCP_ordensFabLista {

    private $nr;
    private $op;
    private $situacao;
    private $data;
    private $hora;
    private $usucodigo;
    private $usunome;
    private $fornocod;
    private $fornodes;
    private $dataEntForno;
    private $horaEntForno;
    private $seqApont;
    private $tempForno;
    private $prioridade;
    private $STEEL_PCP_ordensFab;
    
    function getSTEEL_PCP_ordensFab() {
        if(!$this->STEEL_PCP_ordensFab){
            $this->STEEL_PCP_ordensFab = Fabrica::FabricarModel('STEEL_PCP_ordensFab');
        }
        return $this->STEEL_PCP_ordensFab;
    }

    function setSTEEL_PCP_ordensFab($STEEL_PCP_ordensFab) {
        $this->STEEL_PCP_ordensFab = $STEEL_PCP_ordensFab;
    }

        
    function getPrioridade() {
        return $this->prioridade;
    }

    function setPrioridade($prioridade) {
        $this->prioridade = $prioridade;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getOp() {
        return $this->op;
    }

    function getSituacao() {
        return $this->situacao;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function getUsucodigo() {
        return $this->usucodigo;
    }

    function getUsunome() {
        return $this->usunome;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function getFornodes() {
        return $this->fornodes;
    }

    function getDataEntForno() {
        return $this->dataEntForno;
    }

    function getHoraEntForno() {
        return $this->horaEntForno;
    }

    function getSeqApont() {
        return $this->seqApont;
    }

    function getTempForno() {
        return $this->tempForno;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setOp($op) {
        $this->op = $op;
    }

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }

    function setUsucodigo($usucodigo) {
        $this->usucodigo = $usucodigo;
    }

    function setUsunome($usunome) {
        $this->usunome = $usunome;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
    }

    function setDataEntForno($dataEntForno) {
        $this->dataEntForno = $dataEntForno;
    }

    function setHoraEntForno($horaEntForno) {
        $this->horaEntForno = $horaEntForno;
    }

    function setSeqApont($seqApont) {
        $this->seqApont = $seqApont;
    }

    function setTempForno($tempForno) {
        $this->tempForno = $tempForno;
    }

}
