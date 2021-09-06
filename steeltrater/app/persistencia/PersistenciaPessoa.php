<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaPessoa extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.EMP01');

        $this->adicionaRelacionamento('empcod', 'empcod', true, true);
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('empsit', 'empsit');

        $this->setSTop('25');
        $this->adicionaOrderBy('empcod', 1);
        $this->adicionaFiltro('empsit', 'B', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);
    }

}
