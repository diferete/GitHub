<?php

/*
 * Classe para gerenciar Agendamentos de rotinas no sistema
 * 
 * @author Alexandre W. de Souza
 * @since 05-02-2018
 */

class ModelAgendamentos {
    
    private $dtaprovendas;
    private $sitvendas;
    private $sitgeralproj;
    private $sitcliente;
    private $userreprovcli;
    private $dtareprovcli;
    private $horareprovcli;
    private $filcgc;
    private $nr;
    
    
    
    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function getDtaprovendas() {
        return $this->dtaprovendas;
    }

    function getSitvendas() {
        return $this->sitvendas;
    }

    function getSitgeralproj() {
        return $this->sitgeralproj;
    }

    function getSitcliente() {
        return $this->sitcliente;
    }

    function getUserreprovcli() {
        return $this->userreprovcli;
    }

    function getDtareprovcli() {
        return $this->dtareprovcli;
    }

    function getHorareprovcli() {
        return $this->horareprovcli;
    }

    function setDtaprovendas($dtaprovendas) {
        $this->dtaprovendas = $dtaprovendas;
    }

    function setSitvendas($sitvendas) {
        $this->sitvendas = $sitvendas;
    }

    function setSitgeralproj($sitgeralproj) {
        $this->sitgeralproj = $sitgeralproj;
    }

    function setSitcliente($sitcliente) {
        $this->sitcliente = $sitcliente;
    }

    function setUserreprovcli($userreprovcli) {
        $this->userreprovcli = $userreprovcli;
    }

    function setDtareprovcli($dtareprovcli) {
        $this->dtareprovcli = $dtareprovcli;
    }

    function setHorareprovcli($horareprovcli) {
        $this->horareprovcli = $horareprovcli;
    }


    
    
}
