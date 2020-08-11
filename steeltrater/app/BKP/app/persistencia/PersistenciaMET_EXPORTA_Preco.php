<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_EXPORTA_Preco extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_EXPORTA_Preco');
        $this->adicionaRelacionamento('codigo', 'Produto.procod', true);
        $this->adicionaRelacionamento('preco', 'preco');
        $this->adicionaRelacionamento('revisao', 'revisao');
        $this->adicionaRelacionamento('lotemin', 'lotemin');

        $this->adicionaJoin('Produto', NULL, 1, 'codigo', 'procod');
        $this->setSTop('50');
        $this->adicionaOrderBy('codigo', 1);
    }

}
