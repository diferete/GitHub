<?php

/*
 * Classe que implementa os models da STEEL_PCP_GerenciaApont
 * 
 * @author Cleverton Hoffmann
 * @since 06/08/2018
 */

class ModelSTEEL_PCP_GerenciaApont {

    private $op;
    private $seq;
    private $fornocod;
    private $fornodes;
    private $procod;
    private $prodes;
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

    function getOp() {
        return $this->op;
    }

    function getSeq() {
        return $this->seq;
    }

    function getFornocod() {
        return $this->fornocod;
    }

    function getFornodes() {
        return $this->fornodes;
    }

    function getProcod() {
        return $this->procod;
    }

    function getProdes() {
        return $this->prodes;
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

    function setOp($op) {
        $this->op = $op;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
    }

    function setProcod($procod) {
        $this->procod = $procod;
    }

    function setProdes($prodes) {
        $this->prodes = $prodes;
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
    
}
