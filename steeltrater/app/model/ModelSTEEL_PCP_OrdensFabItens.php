<?php

/*
 * Classe que implementa o model da produção steeltrater
 * 
 * @author Avanei Martendal
 * @since 25/06/2018
 */

class ModelSTEEL_PCP_OrdensFabItens {

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
    private $fornocod;
    private $fornodes;
    private $dataent_forno;
    private $horaent_forno;
    private $datasaida_forno;
    private $horasaida_forno;
    private $situacao;
    private $coduser;
    private $usernome;
    private $codusersaida;
    private $usernomesaida;
    private $turnoSteel;
    private $turnoSteelSaida;
    private $diamMin;
    private $diamMax;
    private $CamadaEspessura;
    private $TempoZinc;
    private $PesoDoCesto;

    function getCamadaEspessura() {
        return $this->CamadaEspessura;
    }

    function getTempoZinc() {
        return $this->TempoZinc;
    }

    function getPesoDoCesto() {
        return $this->PesoDoCesto;
    }

    function setCamadaEspessura($CamadaEspessura) {
        $this->CamadaEspessura = $CamadaEspessura;
    }

    function setTempoZinc($TempoZinc) {
        $this->TempoZinc = $TempoZinc;
    }

    function setPesoDoCesto($PesoDoCesto) {
        $this->PesoDoCesto = $PesoDoCesto;
    }

    function getDiamMin() {
        return $this->diamMin;
    }

    function getDiamMax() {
        return $this->diamMax;
    }

    function setDiamMin($diamMin) {
        $this->diamMin = $diamMin;
    }

    function setDiamMax($diamMax) {
        $this->diamMax = $diamMax;
    }

    function getTurnoSteelSaida() {
        return $this->turnoSteelSaida;
    }

    function setTurnoSteelSaida($turnoSteelSaida) {
        $this->turnoSteelSaida = $turnoSteelSaida;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function getFornodes() {
        return $this->fornodes;
    }

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

    function getSituacao() {
        return $this->situacao;
    }

    function getCoduser() {
        return $this->coduser;
    }

    function getUsernome() {
        return $this->usernome;
    }

    function getCodusersaida() {
        return $this->codusersaida;
    }

    function getUsernomesaida() {
        return $this->usernomesaida;
    }

    function getTurnoSteel() {
        return $this->turnoSteel;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
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

    function setSituacao($situacao) {
        $this->situacao = $situacao;
    }

    function setCoduser($coduser) {
        $this->coduser = $coduser;
    }

    function setUsernome($usernome) {
        $this->usernome = $usernome;
    }

    function setCodusersaida($codusersaida) {
        $this->codusersaida = $codusersaida;
    }

    function setUsernomesaida($usernomesaida) {
        $this->usernomesaida = $usernomesaida;
    }

    function setTurnoSteel($turnoSteel) {
        $this->turnoSteel = $turnoSteel;
    }

    function getSTEEL_PCP_Tratamentos() {
        if (!isset($this->STEEL_PCP_Tratamentos)) {
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
