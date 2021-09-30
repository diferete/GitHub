<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaNfRepIten extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela("widl.nfc003");
        
        $this->adicionaRelacionamento('nfsnfnro', 'nfsnfnro',true,true,true);
        $this->adicionaRelacionamento('nfsitcod', 'nfsitcod');
        $this->adicionaRelacionamento('nfsitdes', 'nfsitdes'); 
        $this->adicionaRelacionamento('nfsitqtd', 'nfsitqtd');
        $this->adicionaRelacionamento('nfsitvlrun', 'nfsitvlrun');
        $this->adicionaRelacionamento('nfsitvlrto', 'nfsitvlrto');
        $this->adicionaRelacionamento('nfsitpdvnr', 'nfsitpdvnr');
        $this->adicionaRelacionamento('nfsnfser', 'nfsnfser');
        $this->adicionaRelacionamento('nfsitseq', 'nfsitseq');
      
        $this->adicionaOrderBy('nfsitseq');  
        $this->adicionaFiltro('nfsnfser', '2');
      
    }
}