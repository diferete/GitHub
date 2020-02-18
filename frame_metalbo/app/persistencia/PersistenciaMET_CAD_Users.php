<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_CAD_Users extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MetCad_User');
        
        $this->adicionaRelacionamento('empcnpj', 'empcnpj');
        $this->adicionaRelacionamento('coduser', 'coduser');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('sobrenome', 'sobrenome');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('cracha', 'cracha');
       
        
        $this->adicionaOrderBy('coduser', 1);
        $this->setSTop(50);
    }

}
