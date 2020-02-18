<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelMET_QUAL_MovOi{
    private $nroi;
    private $corrida;
    
    function getNroi() {
        return $this->nroi;
    }

    function getCorrida() {
        return $this->corrida;
    }

    function setNroi($nroi) {
        $this->nroi = $nroi;
    }

    function setCorrida($corrida) {
        $this->corrida = $corrida;
    }


}