<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_CAD_Cpf extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_CAD_Cpf');
        $this->adicionaRelacionamento('cpf', 'cpf',true,true);
        $this->adicionaRelacionamento('filcgc', 'filcgc',true,true);
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('empfant', 'empfant');
        $this->adicionaRelacionamento('fone', 'fone');

    }

}
