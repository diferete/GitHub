<?php

class ModelModulo {

    private $modcod;
    private $modescricao;

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
