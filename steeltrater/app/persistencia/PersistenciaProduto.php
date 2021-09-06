<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaProduto extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.prod01');

        $this->adicionaRelacionamento('procod', 'procod', true);
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('probloqpro', 'probloqpro');
        $this->adicionaRelacionamento('pround', 'pround');

        $this->setSTop('35');
        $this->adicionaOrderBy('procod');
        $this->adicionaFiltro('probloqpro', 'S', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);
    }

}
