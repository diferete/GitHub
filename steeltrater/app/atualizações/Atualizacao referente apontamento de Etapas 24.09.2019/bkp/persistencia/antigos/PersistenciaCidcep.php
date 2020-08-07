<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaCidcep extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('widl.CID01');
        
        $this->adicionaRelacionamento('cidcep', 'cidcep',true);
        $this->adicionaRelacionamento('cidnome', 'cidnome');
        $this->adicionaRelacionamento('estcod','estcod');
        $this->adicionaRelacionamento('cidIBGE','cidIBGE');
        
        $this->adicionaOrderBy('cidcep',1);
        
        $this->setSTop('35');
    }
}