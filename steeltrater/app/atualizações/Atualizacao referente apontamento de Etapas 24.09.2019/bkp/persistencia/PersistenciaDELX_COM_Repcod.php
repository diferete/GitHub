<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaDELX_COM_Repcod extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('REP_REPRESENTANTE');
        
        $this->adicionaRelacionamento('rep_codigo', 'rep_codigo',true,true,true);
        $this->adicionaRelacionamento('rep_comissao', 'rep_comissao');
        
        $this->adicionaOrderBy('rep_codigo',1);
    }
    
    
    
}