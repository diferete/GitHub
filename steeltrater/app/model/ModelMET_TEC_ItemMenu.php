<?php

/**
 * Classe que implementa o Model do objeto ItemMenu 
 */
class ModelMET_TEC_ItemMenu {

    private $MET_TEC_Modulo;
    private $MET_TEC_Menu;
    private $itecodigo;
    private $itedescricao;
    private $iteordem;
    private $iteclasse;
    private $itemetodo;
    private $url;
    private $iconApp;
    private $rotina;

    function getRotina() {
        return $this->rotina;
    }

    function setRotina($rotina) {
        $this->rotina = $rotina;
    }

    function getUrl() {
        return $this->url;
    }

    function getIconApp() {
        return $this->iconApp;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setIconApp($iconApp) {
        $this->iconApp = $iconApp;
    }

    function getMET_TEC_Menu() {
        if (!isset($this->MET_TEC_Menu)) {
            $this->MET_TEC_Menu = Fabrica::FabricarModel('MET_TEC_Menu');
        }
        return $this->MET_TEC_Menu;
    }

    function setMET_TEC_Menu($MET_TEC_Menu) {
        $this->MET_TEC_Menu = $MET_TEC_Menu;
    }

    function getMET_TEC_Modulo() {
        if (!isset($this->MET_TEC_Modulo)) {
            $this->MET_TEC_Modulo = Fabrica::FabricarModel('MET_TEC_Modulo');
        }
        return $this->MET_TEC_Modulo;
    }

    function setMET_TEC_Modulo($MET_TEC_Modulo) {
        $this->MET_TEC_Modulo = $MET_TEC_Modulo;
    }

    function getItecodigo() {
        return $this->itecodigo;
    }

    function getItedescricao() {
        return $this->itedescricao;
    }

    function getIteordem() {
        return $this->iteordem;
    }

    function getIteclasse() {
        return $this->iteclasse;
    }

    function getItemetodo() {
        return $this->itemetodo;
    }

    function setItecodigo($itecodigo) {
        $this->itecodigo = $itecodigo;
    }

    function setItedescricao($itedescricao) {
        $this->itedescricao = $itedescricao;
    }

    function setIteordem($iteordem) {
        $this->iteordem = $iteordem;
    }

    function setIteclasse($iteclasse) {
        $this->iteclasse = $iteclasse;
    }

    function setItemetodo($itemetodo) {
        $this->itemetodo = $itemetodo;
    }

}

?>