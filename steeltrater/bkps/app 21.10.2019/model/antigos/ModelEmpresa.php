<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelEmpresa{
    private $empcnpj;
    private $emprazao;
    
    function getEmpcnpj() {
        return $this->empcnpj;
    }

    function getEmprazao() {
        return $this->emprazao;
    }

    function setEmpcnpj($empcnpj) {
        $this->empcnpj = $empcnpj;
    }

    function setEmprazao($emprazao) {
        $this->emprazao = $emprazao;
    }


}