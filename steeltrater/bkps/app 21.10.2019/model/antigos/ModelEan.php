<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelEan {
    private $ean;
    private $Produto;
    private $nrcaixa;
    private $pcs;
    
    function getEan() {
        return $this->ean;
    }

    function getProduto() {
        if(!isset($this->Produto)){
            $this->Produto = Fabrica::FabricarModel('Produto');
        }
        return $this->Produto;
    }
    

    function getNrcaixa() {
        return $this->nrcaixa;
    }

   

    function setEan($ean) {
        $this->ean = $ean;
    }

    function setProduto($Produto) {
        $this->Produto = $Produto;
    }

    function setNrcaixa($nrcaixa) {
        $this->nrcaixa = $nrcaixa;
    }

    function getPcs() {
        return $this->pcs;
    }

    function setPcs($pcs) {
        //tira as dizimas quando o campo é money
       $this->pcs = floatval ($pcs);
    }



    
}