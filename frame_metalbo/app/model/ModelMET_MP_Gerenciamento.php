<?php

/*
 * Implementa a classe model
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class ModelMET_MP_Gerenciamento {

    private $MET_MP_Maquinas;
    private $MET_CAD_Setores;
    private $filcgc;
    private $nr;
    private $codmaq;
    private $maqmp;
    private $codsetor;
    private $descsetor;
    private $sitmp;
    private $databert;
    private $userabert;
    private $userfecho;
    private $datafech;
    
    function getMaqmp() {
        return $this->maqmp;
    }

    function setMaqmp($maqmp) {
        $this->maqmp = $maqmp;
    }
    
    function getDescsetor() {
        return $this->descsetor;
    }

    function setDescsetor($descsetor) {
        $this->descsetor = $descsetor;
    }
    
    function getMET_MP_Maquinas() {
        if (!isset($this->MET_MP_Maquinas)) {
            $this->MET_MP_Maquinas = Fabrica::FabricarModel('MET_MP_Maquinas');
        }
        return $this->MET_MP_Maquinas;
    }

    function setMET_MP_Maquinas($MET_MP_Maquinas) {
        $this->MET_MP_Maquinas = $MET_MP_Maquinas;
    }
    
    function getMET_CAD_Setores() {
        if(!isset($this->MET_CAD_Setores)){
            $this->MET_CAD_Setores = Fabrica::FabricarModel('MET_CAD_Setores');
        }
        return $this->MET_CAD_Setores;
    }

    function setMET_CAD_Setores($MET_CAD_Setores) {
        $this->MET_CAD_Setores = $MET_CAD_Setores;
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
