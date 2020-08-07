<?php

/* 
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ModelMET_Maquinas {
    
    private $cod;
    private $maquina;
    private $maqtip;
    private $nomeclatura;
    private $seq;
    private $tipmanut;
    private $sitmaq;
    private $codsetor;
    
    function getCodsetor() {
        return $this->codsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }
    
    function getSitmaq() {
        return $this->sitmaq;
    }

    function setSitmaq($sitmaq) {
        $this->sitmaq = $sitmaq;
    }
    
    function getTipmanut() {
        return $this->tipmanut;
    }

    function setTipmanut($tipmanut) {
        $this->tipmanut = $tipmanut;
    }
    
    function getSeq() {
        return $this->seq;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }
    
    function getNomeclatura() {
        return $this->nomeclatura;
    }

    function setNomeclatura($nomeclatura) {
        $this->nomeclatura = $nomeclatura;
    }
   
    function getMaqtip() {
        return $this->maqtip;
    }

    function setMaqtip($maqtip) {
        $this->maqtip = $maqtip;
    }
   
    function getCod() {
        return $this->cod;
    }

    function getMaquina() {
        return $this->maquina;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setMaquina($maquina) {
        $this->maquina = $maquina;
    }
    
}