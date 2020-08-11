<?php

/*
 * Classe que implementa a persistencia
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2018
 */

class PersistenciaMET_TEC_Sequencia extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('TEC_SEQUENCIA');

        $this->adicionaRelacionamento('tec_sequenciatabela', 'tec_sequenciatabela',true,true);
        $this->adicionaRelacionamento('tec_sequenciafilial', 'tec_sequenciafilial', true, true);
        $this->adicionaRelacionamento('tec_sequencianumero', 'tec_sequencianumero');

        $this->setSTop('1000');
        $this->adicionaOrderBy('tec_sequenciafilial', 0);
    }

}
