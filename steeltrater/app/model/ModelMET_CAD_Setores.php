<?php

class ModelMET_CAD_Setores{
    private $codsetor;
    private $descsetor;
    private $tipoconst;
    private $piso;
    private $telhado;
    private $vent;
    private $ilumin;
    private $obsSetor;
    
    function getCodsetor() {
        return $this->codsetor;
    }

    function getDescsetor() {
        return $this->descsetor;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }

    function getTipoconst() {
        return $this->tipoconst;
    }

    function getPiso() {
        return $this->piso;
    }

    function getTelhado() {
        return $this->telhado;
    }

    function getVent() {
        return $this->vent;
    }

    function getIlumin() {
        return $this->ilumin;
    }

    function getObsSetor() {
        return $this->obsSetor;
    }

    function setTipoconst($tipoconst) {
        $this->tipoconst = $tipoconst;
    }

    function setPiso($piso) {
        $this->piso = $piso;
    }

    function setTelhado($telhado) {
        $this->telhado = $telhado;
    }

    function setVent($vent) {
        $this->vent = $vent;
    }

    function setIlumin($ilumin) {
        $this->ilumin = $ilumin;
    }

    function setObsSetor($obsSetor) {
        $this->obsSetor = $obsSetor;
    }    
    
}