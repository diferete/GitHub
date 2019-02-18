<?php

/*
 * Classe que implementa os models da STEEL_PCP_TabItemPreco
 * 
 * @author Cleverton Hoffmann
 * @since 04/02/2018
 */

class ModelSTEEL_PCP_TabItemPreco{

    private $nr;
    private $receita;
    private $seq;
    private $prod;
    private $preco;
    private $STEEL_PCP_receitas;
    private $STEEL_PCP_Produtos;
    private $tipo;
    
    
    function getSTEEL_PCP_Produtos() {
        if(!isset($this->STEEL_PCP_Produtos)){
            $this->STEEL_PCP_Produtos = Fabrica::FabricarModel('STEEL_PCP_Produtos');
        }
        return $this->STEEL_PCP_Produtos;
    }

    function setSTEEL_PCP_Produtos($STEEL_PCP_Produtos) {
        $this->STEEL_PCP_Produtos = $STEEL_PCP_Produtos;
    }

        
    
    function getTipo() {
        return $this->tipo;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

     function getSTEEL_PCP_receitas() {
        if(!isset($this->STEEL_PCP_receitas)){
            $this->STEEL_PCP_receitas = Fabrica::FabricarModel('STEEL_PCP_receitas');
        }
        return $this->STEEL_PCP_receitas;
    }

    function setSTEEL_PCP_receitas($STEEL_PCP_receitas) {
        $this->STEEL_PCP_receitas = $STEEL_PCP_receitas;
    }

        
    function getNr() {
        return $this->nr;
    }

    function getReceita() {
        return $this->receita;
    }

    function getSeq() {
        return $this->seq;
    }

    function getProd() {
        return $this->prod;
    }

    function getPreco() {
        return $this->preco;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }

  
    function setReceita($receita) {
        $this->receita = $receita;
    }

    function setSeq($seq) {
        $this->seq = $seq;
    }

    function setProd($prod) {
        $this->prod = $prod;
    }

    function setPreco($preco) {
        $this->preco = $preco;
    }   
    
}