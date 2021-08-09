<?php

class ModelMET_TEC_Modulo {

    private $modcod;
    private $modescricao;
    private $modApp;

    function getModApp() {
        return $this->modApp;
    }

    function setModApp($modApp) {
        $this->modApp = $modApp;
    }

    function getModcod() {
        return $this->modcod;
    }

    function getModescricao() {
        return $this->modescricao;
    }

    function setModcod($modcod) {
        $this->modcod = $modcod;
    }

    function setModescricao($modescricao) {
        $this->modescricao = $modescricao;
    }

}

/*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

