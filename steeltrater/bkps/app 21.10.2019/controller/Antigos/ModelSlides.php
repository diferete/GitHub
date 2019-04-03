<?php

/**
 * Model da classe slides, que é responsável por controlar slides no MetalboApp e no Site
 * Atualmente é utilizada na classe
 * @author Carlos
 */
class ModelSlides {
    private $slidid;
    private $sliddesc;
    private $slidimg;
    private $slidativo;
    private $slidusuario;
    private $sliddata;
            
    function getSlidid() {
        return $this->slidid;
    }

    function getSliddesc() {
        return $this->sliddesc;
    }

    function getSlidimg() {
        return $this->slidimg;
    }

    function getSlidativo() {
        return $this->slidativo;
    }

    function setSlidid($slidid) {
        $this->slidid = $slidid;
    }

    function setSliddesc($sliddesc) {
        $this->sliddesc = $sliddesc;
    }

    function setSlidimg($slidimg) {
        $this->slidimg = $slidimg;
    }

    function setSlidativo($slidativo) {
        $this->slidativo = $slidativo;
    }
    
    function getSlidusuario() {
        return $this->slidusuario;
    }

    function getSliddata() {
        return date('d/m/Y', strtotime($this->sliddata));
    }

    function setSlidusuario($slidusuario) {
        $this->slidusuario = $slidusuario;
    }

    function setSliddata($sliddata) {
        $this->sliddata = $sliddata;
    }

}
