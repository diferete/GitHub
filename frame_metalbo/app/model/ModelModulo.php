<?php

class ModelModulo {

    private $modcod;
    private $modescricao;
    private $dragodrop;
    private $upload;

    function getDragodrop() {
        return $this->dragodrop;
    }

    function getUpload() {
        return $this->upload;
    }

    function setDragodrop($dragodrop) {
        $this->dragodrop = $dragodrop;
    }

    function setUpload($upload) {
        $this->upload = $upload;
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

