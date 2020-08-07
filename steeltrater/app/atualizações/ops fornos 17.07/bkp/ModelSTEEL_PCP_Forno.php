<?php

/*
 * Classe que implementa os models da STEEL_PCP_Forno
 * 
 * @author Cleverton Hoffmann
 * @since 05/07/2018
 */

class ModelSTEEL_PCP_Forno {

    private $fornocod;
    private $fornodes;
    private $fornosigla;
    private $cookfornocod;
    private $cookfornodes;
    
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

}
