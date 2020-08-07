<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelDELX_FIL_Empresa{
    private $fil_codigo;
    private $fil_fantasia;
    
    function getFil_codigo() {
        return $this->fil_codigo;
    }

    function getFil_fantasia() {
        return $this->fil_fantasia;
    }

    function setFil_codigo($fil_codigo) {
        $this->fil_codigo = $fil_codigo;
    }

    function setFil_fantasia($fil_fantasia) {
        $this->fil_fantasia = $fil_fantasia;
    }


    
}