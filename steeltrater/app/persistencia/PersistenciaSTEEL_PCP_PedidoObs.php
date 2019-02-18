<?php

/*
 * Classe que implementa a persistencia 
 * 
 * @author Cleverton Hoffmann
 * @since 29/11/2018
 */

class PersistenciaSTEEL_PCP_PedidoObs extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PDV_PEDIDOOBS');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo', true, true);
        $this->adicionaRelacionamento('pdv_pedidoobscodigo', 'pdv_pedidoobscodigo', true, true,true);
        $this->adicionaRelacionamento('pdv_pedidoobsdescricao', 'pdv_pedidoobsdescricao');
        
        $this->setSTop('100');
        
        $this->adicionaOrderBy('pdv_pedidocodigo',1);
    }

}