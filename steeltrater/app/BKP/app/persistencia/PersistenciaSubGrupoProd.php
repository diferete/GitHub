<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSubGrupoProd extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.prod05');
        
        $this->adicionaRelacionamento('grucod','grucod',true);
        $this->adicionaRelacionamento('subcod','subcod',true);
        $this->adicionaRelacionamento('subdes', 'subdes');
        
        $this->adicionaOrderBy('subcod',1);
        
        $this->setSTop(50);
        
        
    }
}