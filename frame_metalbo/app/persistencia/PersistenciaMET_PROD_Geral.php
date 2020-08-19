<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_PROD_Geral extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.PROD01');

        $this->adicionaRelacionamento('procod', 'procod',true);
        $this->adicionaRelacionamento('prodes', 'prodes');
        
        $this->setSTop(75);
    }

}
