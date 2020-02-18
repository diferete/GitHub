<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_QUAL_MovOi extends Persistencia{
    public function __construct() {
        parent::__construct();
    
        $this->setTabela('MetQual_MovOi');
        
        $this->adicionaRelacionamento('nroi', 'nroi',true,true);
        $this->adicionaRelacionamento('corrida', 'corrida');
        
        $this->setSTop(20);
    }
}