<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ModelTabVenda {
    private $Produto;
    private $preco;
    private $revisao;
    private $lotemin;
    
    function getLotemin() {
        return $this->lotemin;
    }

    function setLotemin($lotemin) {
        $this->lotemin = $lotemin;
    }

        
    function getRevisao() {
        return $this->revisao;
    }

    function setRevisao($revisao) {
        $this->revisao = $revisao;
    }

        
    function getProduto() {
        if(!isset($this->Produto)){
            $this->Produto = Fabrica::FabricarModel('Produto');
        }
        return $this->Produto;
    }

    function getPreco() {
        return $this->preco;
    }

    function setProduto($Produto) {
        $this->Produto = $Produto;
    }

    function setPreco($preco) {
        // $this->preco = 'R$ ' . number_format($preco, 2, ',', '.'); 
           $this->preco = $preco;
    }


    
}
