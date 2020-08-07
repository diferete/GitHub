<?php

class ModelModulo {

    private $modcod;
    private $modescricao;
    private $uploads;
    private $uploadmulti;

    function getUploads() {
        return $this->uploads;
    }

    function getUploadmulti() {
        return $this->uploadmulti;
    }

    function setUploads($uploads) {
        $this->uploads = $uploads;
    }

    function setUploadmulti($uploadmulti) {
        $this->uploadmulti = $uploadmulti;
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

