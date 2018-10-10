<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class PersistenciaSTEEL_PCP_prodMatReceita extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_prodMatReceita');

        $this->adicionaRelacionamento('seqmat', 'seqmat', true, true, true);
        $this->adicionaRelacionamento('prod', 'DELX_PRO_Produtos.pro_codigo', false,false);
        $this->adicionaRelacionamento('prod', 'prod');
        $this->adicionaRelacionamento('matcod', 'matcod');
        $this->adicionaRelacionamento('matcod', 'STEEL_PCP_material.matcod', false,false);
        $this->adicionaRelacionamento('cod', 'cod');
        $this->adicionaRelacionamento('matcod', 'STEEL_PCP_receitas.cod', false,false);
        $this->adicionaRelacionamento('durezaNuc', 'durezaNuc');
        $this->adicionaRelacionamento('durezaSuperf', 'durezaSuperf');
        $this->adicionaRelacionamento('expeCamada', 'expeCamada');

        $this->setSTop('30');
        $this->adicionaOrderBy('seqmat', 1);
        $this->adicionaJoin('DELX_PRO_Produtos', null,1, 'prod','pro_codigo');
        $this->adicionaJoin('STEEL_PCP_material');
        $this->adicionaJoin('STEEL_PCP_receitas');
        
    }

}