<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_RH_FuncaoSetor extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_RH_FuncaoSetor');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('codsetor', 'codsetor', true);
        $this->adicionaRelacionamento('codfuncao', 'codfuncao', true);
        $this->adicionaRelacionamento('descfuncao', 'descfuncao');
    }

}
