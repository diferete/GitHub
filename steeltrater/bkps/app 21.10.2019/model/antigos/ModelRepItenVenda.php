<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ModelRepItenVenda {
    private $nr;
    private $cnpj;
    private $cliente;
    private $data2;
    private $data;
    private $odcompra;
    private $codigo;
    private $descricao;
    private $quant;
    private $vlrunit;
    private $vlrtot;
    
    
     function getOdcompra() {
         return $this->odcompra;
     }

     function getCodigo() {
         return $this->codigo;
     }

     function getDescricao() {
         return $this->descricao;
     }

     function getQuant() {
         return $this->quant;
     }

     function getVlrunit() {
         return $this->vlrunit;
     }

     function getVlrtot() {
         return $this->vlrtot;
     }

     function setOdcompra($odcompra) {
         $this->odcompra = $odcompra;
     }

     function setCodigo($codigo) {
         $this->codigo = $codigo;
     }

     function setDescricao($descricao) {
         $this->descricao = $descricao;
     }

     function setQuant($quant) {
         $this->quant = $quant;
     }

     function setVlrunit($vlrunit) {
         $this->vlrunit = $vlrunit;
     }

     function setVlrtot($vlrtot) {
         $this->vlrtot = $vlrtot;
     }

         
    function getData2() {
        return $this->data2;
    }

    function getData() {
        return $this->data;
    }

    function setData2($data2) {
        $this->data2 = $data2;
    }

    function setData($data) {
        $this->data = $data;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getCliente() {
        return $this->cliente;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }


}