<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPoliFab extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('tbpolifab');
        
        $this->adicionaRelacionamento('fabcod', 'fabcod',true,true,true);
        $this->adicionaRelacionamento('cnpj', 'cnpj');
        $this->adicionaRelacionamento('fabdes', 'fabdes');
        
        $this->adicionaOrderBy('fabcod',1);
    }
}