<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaRepcod extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.rep01');
        
        $this->adicionaRelacionamento('repcod', 'repcod',true);
        $this->adicionaRelacionamento('repdes', 'repdes');
        $this->adicionaOrderBy('repcod',1);
    }
    
    
    
}