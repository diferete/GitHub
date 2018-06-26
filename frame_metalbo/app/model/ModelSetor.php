<?php

class ModelSetor{
    private $codsetor;
    private $descsetor;
    
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


}