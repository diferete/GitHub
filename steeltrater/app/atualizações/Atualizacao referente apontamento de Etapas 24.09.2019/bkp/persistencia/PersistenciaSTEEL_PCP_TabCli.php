<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_TabCli 
 * 
 * @author Cleverton Hoffmann
 * @since 22/11/2018
 */

class PersistenciaSTEEL_PCP_TabCli extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_TABCLI');

        $this->adicionaRelacionamento('cod', 'cod', true, true,true);
        $this->adicionaRelacionamento('emp_codigo', 'emp_codigo');
        $this->adicionaRelacionamento('tab_preco', 'tab_preco');
        
        $this->setSTop('100');
        
        $this->adicionaOrderBy('cod',1);
    }

}