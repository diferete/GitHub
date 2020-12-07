<?php

/*
 * Classe que implementa os models da STEEL_PCP_ParFornoMaster
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2020
 */

class ModelSTEEL_PCP_ParFornoMaster{

    private $fornocod;
    private $fornodes;
    private $fornosigla;
    private $tipoOrdem;
    private $cookfornocod;
    private $cookfornodes;
    private $eficienciaHora;
    
    function getEficienciaHora() {
        return $this->eficienciaHora;
    }

    function setEficienciaHora($eficienciaHora) {
        $this->eficienciaHora = $eficienciaHora;
    }
    
    function getCookfornodes() {
        return $this->cookfornodes;
    }

    function setCookfornodes($cookfornodes) {
        $this->cookfornodes = $cookfornodes;
    }

        
    function getCookfornocod() {
        return $this->cookfornocod;
    }

    function setCookfornocod($cookfornocod) {
        $this->cookfornocod = $cookfornocod;
    }

            
    function getFornocod() {
        return $this->fornocod;
    }

    function getFornodes() {
        return $this->fornodes;
    }

    function getFornosigla() {
        return $this->fornosigla;
    }

    function setFornocod($fornocod) {
        $this->fornocod = $fornocod;
    }

    function setFornodes($fornodes) {
        $this->fornodes = $fornodes;
    }

    function setFornosigla($fornosigla) {
        $this->fornosigla = $fornosigla;
    }

    function getTipoOrdem() {
        return $this->tipoOrdem;
    }

    function setTipoOrdem($tipoOrdem) {
        $this->tipoOrdem = $tipoOrdem;
    }
    
}
