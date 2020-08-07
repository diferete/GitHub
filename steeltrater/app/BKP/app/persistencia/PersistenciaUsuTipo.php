<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class PersistenciaUsuTipo extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbusutipo');
        
        $this->adicionaRelacionamento('usutipo','usutipo',true,true,true);
        $this->adicionaRelacionamento('usutipdescricao', 'usutipdescricao');
        
        
    }
}
