<?php

/*
 * Classe que implementa a persistencia de receita
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class PersistenciaSTEEL_PCP_ProdReceita extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_PRODRECEITA');

        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo', true, true);
        $this->adicionaRelacionamento('cod_receita', 'cod_receita', true, true);

        $this->setSTop('40');
        $this->adicionaOrderBy('pro_codigo', 1);
    }

}
