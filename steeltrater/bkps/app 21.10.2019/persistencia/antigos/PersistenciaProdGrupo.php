<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaProdGrupo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbprodgrupo');
        
        $this->adicionaRelacionamento('grucod', 'grucod',true,true,true);
        $this->adicionaRelacionamento('grudes', 'grudes');
    }
}