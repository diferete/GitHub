<?php

/* 
 * Model destinado para a tabela de empresas que nao participam dos indicadores da expedição
 */

class ModelNotEmpQual {
    private $empcod;
    private $empdes;
    
    function getEmpcod() {
        return $this->empcod;
    }

    function getEmpdes() {
        return $this->empdes;
    }

    function setEmpcod($empcod) {
        $this->empcod = $empcod;
    }

    function setEmpdes($empdes) {
        $this->empdes = $empdes;
    }


}