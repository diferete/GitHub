<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModelSTEEL_CCT_CentroCustoFilial
 *
 * @author Alexandre
 */
class ModelSTEEL_CCT_CentroCustoFilial {

    private $cct_codigo;
    private $fil_codigo;

    function getCct_codigo() {
        return $this->cct_codigo;
    }

    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function setCct_codigo($cct_codigo) {
        $this->cct_codigo = $cct_codigo;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

}
