<?php

/* 
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class ModelMET_ServicoMaquina {
    
    private $codsit;
    private $tipcod;
    private $servico;
    private $ciclo;
    private $resp;
    private $usercad;
    private $data;
    private $hora;
    
    function getCodsit() {
        return $this->codsit;
    }

    function getTipcod() {
        return $this->tipcod;
    }

    function getServico() {
        return $this->servico;
    }

    function getCiclo() {
        return $this->ciclo;
    }

    function getResp() {
        return $this->resp;
    }

    function getUsercad() {
        return $this->usercad;
    }

    function getData() {
        return $this->data;
    }

    function getHora() {
        return $this->hora;
    }

    function setCodsit($codsit) {
        $this->codsit = $codsit;
    }

    function setTipcod($tipcod) {
        $this->tipcod = $tipcod;
    }

    function setServico($servico) {
        $this->servico = $servico;
    }

    function setCiclo($ciclo) {
        $this->ciclo = $ciclo;
    }

    function setResp($resp) {
        $this->resp = $resp;
    }

    function setUsercad($usercad) {
        $this->usercad = $usercad;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setHora($hora) {
        $this->hora = $hora;
    }    
}