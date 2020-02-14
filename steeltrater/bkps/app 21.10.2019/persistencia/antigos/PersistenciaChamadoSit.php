<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaChamadoSit extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metsitcham');
        
        $this->adicionaRelacionamento('codsit', 'codsit',true,true,true);
        $this->adicionaRelacionamento('sit', 'sit');
        
        
    }
    
    
    
    
}