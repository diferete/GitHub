<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_MobilePainel extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('MET_TEC_MobilePainel');
        
        $this->adicionaRelacionamento('painelcod', 'painelcod',true,true,true);
        $this->adicionaRelacionamento('paineldesc', 'paineldesc');
        
        $this->setSTop('100');
        $this->adicionaOrderBy('painelcod',1);
        
    }
    
}