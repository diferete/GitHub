<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaRepItenVenda extends Persistencia{
    public function __construct() {
        parent::__construct();
        
         if(isset($_SESSION['officecabsol'])){
            $this->setTabela($_SESSION['officecabsol']);
        }else{
          $this->setTabela('pdfvenda');
        }
        
        $this->adicionaRelacionamento('nr', 'nr',true,true,true);
        $this->adicionaRelacionamento('cnpj', 'cnpj');
        $this->adicionaRelacionamento('cliente','cliente');
        $this->adicionaRelacionamento('data2','data2');
        $this->adicionaRelacionamento('data','data');
        $this->adicionaRelacionamento('odcompra', 'odcompra');
        $this->adicionaRelacionamento('codigo', 'codigo');
        $this->adicionaRelacionamento('descricao', 'descricao');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('vlrunit', 'vlrunit');
        $this->adicionaRelacionamento('vlrtot', 'vlrtot');
        
        $this->setBConsultaManual(true);
        
       
        
    }
    
    public function consultaManual() {
        parent::consultaManual();
        $sTabelaIten = $_SESSION['officecabsoliten'];
        
        $sSql = "select distinct ".$this->getTabela().".NR as '".$this->getTabela().".nr',
				  ".$this->getTabela().".CNPJ as '".$this->getTabela().".cnpj',
				  ".$this->getTabela().".CLIENTE AS '".$this->getTabela().".cliente',
                  ".$this->getTabela().".DATA as '".$this->getTabela().".data',
                  ".$this->getTabela().".ODCOMPRA as '".$this->getTabela().".ODCOMPRA',
                  ".$sTabelaIten.".CODIGO AS '".$this->getTabela().".codigo',
                  ".$sTabelaIten.".DESCRICAO AS '".$this->getTabela().".descricao',
                  ".$sTabelaIten.".QUANT AS '".$this->getTabela().".quant' ,
                  ".$sTabelaIten.".VLRUNIT AS '".$this->getTabela().".vlrunit',
                  ".$sTabelaIten.".VLRTOT AS '".$this->getTabela().".vlrtot' 
                  from ".$this->getTabela().",".$sTabelaIten."
                  ";
        return $sSql;
    }
}