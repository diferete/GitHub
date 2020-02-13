<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelDELX_COM_Repcod {
    private $rep_codigo;
    private $rep_comissao;
    
    function getRep_codigo() {
        return $this->rep_codigo;
    }

    function getRep_comissao() {
        return $this->rep_comissao;
    }

    function setRep_codigo($rep_codigo) {
        $this->rep_codigo = $rep_codigo;
    }

    function setRep_comissao($rep_comissao) {
        $this->rep_comissao = $rep_comissao;
    }


}