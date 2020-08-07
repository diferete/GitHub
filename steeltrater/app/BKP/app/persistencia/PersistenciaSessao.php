<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSessao extends Persistencia{
    public function __construct() {
        parent::__construct();
        $this->setTabela('tbsessao');
        
        $this->adicionaRelacionamento('usucodigo','usucodigo',true,true);
        $this->adicionaRelacionamento('usunome','usunome',true,true);
        $this->adicionaRelacionamento('usuidsessao','usuidsessao',true,true);
        $this->adicionaRelacionamento('usustatus','usustatus');
        $this->adicionaRelacionamento('usudata','usudata');
        $this->adicionaRelacionamento('usuhora','usuhora');
        $this->adicionaRelacionamento('usulastacesso','usulastacesso');
    }
}