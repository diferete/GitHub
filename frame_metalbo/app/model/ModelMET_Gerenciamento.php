<?php

/*
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ModelMET_Gerenciamento {

    private $MET_Maquinas;
    private $MET_Setores;
    private $filcgc;
    private $nr;
    private $codmaq;
    private $codsetor;
    private $descsetor;
    private $sitmp;
    private $databert;
    private $userabert;
    private $userfecho;
    private $datafech;
    
    function getDescsetor() {
        return $this->descsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }
    
    ////////////////////
    function getMET_Maquinas() {
        if (!isset($this->MET_Maquinas)) {
            $this->MET_Maquinas = Fabrica::FabricarModel('MET_Maquinas');
        }
        return $this->MET_Maquinas;
    }

    function setMET_Maquinas($MET_Maquinas) {
        $this->MET_Maquinas = $MET_Maquinas;
    }
    
    function getMET_Setores() {
        if(!isset($this->MET_Setores)){
            $this->MET_Setores = Fabrica::FabricarModel('MET_Setores');
        }
        return $this->MET_Setores;
    }

    function setMET_Setores($MET_Setores) {
        $this->MET_Setores = $MET_Setores;
    }

    function getFilcgc() {
        return $this->filcgc;
    }

    function getNr() {
        return $this->nr;
    }

    function getCodmaq() {
        return $this->codmaq;
    }

    function getCodsetor() {
        return $this->codsetor;
    }

    function getSitmp() {
        return $this->sitmp;
    }

    function getDatabert() {
        return $this->databert;
    }

    function getUserabert() {
        return $this->userabert;
    }

    function getUserfecho() {
        return $this->userfecho;
    }

    function getDatafech() {
        return $this->datafech;
    }

    function setFilcgc($filcgc) {
        $this->filcgc = $filcgc;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setCodmaq($codmaq) {
        $this->codmaq = $codmaq;
    }

    function setCodsetor($codsetor) {
        $this->codsetor = $codsetor;
    }

    function setSitmp($sitmp) {
        $this->sitmp = $sitmp;
    }

    function setDatabert($databert) {
        $this->databert = $databert;
    }

    function setUserabert($userabert) {
        $this->userabert = $userabert;
    }

    function setUserfecho($userfecho) {
        $this->userfecho = $userfecho;
    }

    function setDatafech($datafech) {
        $this->datafech = $datafech;
    }

}
