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
    private $codsetor;
    private $servico;
    private $ciclo;
    private $resp;
    private $usercad;
    private $data;
    private $hora;
    private $MET_CadastroMaquinas;
    private $Setor;
    private $sit;
    
    function getSit() {
        return $this->sit;
    }

    function setSit($sit) {
        $this->sit = $sit;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }
    
    function getMET_CadastroMaquinas() {
        if(!isset($this->MET_CadastroMaquinas)){
            $this->MET_CadastroMaquinas = Fabrica::FabricarModel('MET_CadastroMaquinas');
        }
        return $this->MET_CadastroMaquinas;
    }

    function setMET_CadastroMaquinas($MET_CadastroMaquinas) {
        $this->MET_CadastroMaquinas = $MET_CadastroMaquinas;
    }
    
    function getSetor() {
        if(!isset($this->Setor)){
            $this->Setor = Fabrica::FabricarModel('Setor');
        }
        return $this->Setor;
    }

    function setSetor($Setor) {
        $this->Setor = $Setor;
    }

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