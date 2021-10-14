<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaSTEEL_CCT_CentroCustoFilial
 *
 * @author Alexandre
 */
class PersistenciaSTEEL_CCT_CentroCustoFilial extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CCT_CENTROCUSTOFILIAL');

        $this->adicionaRelacionamento('cct_codigo', 'cct_codigo', true, true);
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo');

        //$this->adicionaFiltro('fil_codigo', '8993358000174');

        $this->adicionaOrderBy('cct_codigo', 1);
    }

}
