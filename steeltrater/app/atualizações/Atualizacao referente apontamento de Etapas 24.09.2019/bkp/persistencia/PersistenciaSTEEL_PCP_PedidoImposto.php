<?php

/*
 * Classe que implementa a persistencia STEEL_PCP_PedidoImposto
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class PersistenciaSTEEL_PCP_PedidoImposto extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PDV_PEDIDOIMPOSTO');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo',true, true);
        $this->adicionaRelacionamento('pdv_pedidoimpostocodigo', 'pdv_pedidoimpostocodigo', true, true);
        $this->adicionaRelacionamento('PDV_PedidoImpostoBCalculo', 'PDV_PedidoImpostoBCalculo');
        $this->adicionaRelacionamento('PDV_PedidoImpostoValor', 'PDV_PedidoImpostoValor');
        $this->adicionaRelacionamento('PDV_PedidoImpostoFiscal', 'PDV_PedidoImpostoFiscal');
        $this->adicionaRelacionamento('PDV_PedidoImpostoClasseNF', 'PDV_PedidoImpostoClasseNF');
        $this->adicionaRelacionamento('PDV_PedidoImpostoClasseFN', 'PDV_PedidoImpostoClasseFN');
        $this->adicionaRelacionamento('PDV_PedidoImpostoFatura', 'PDV_PedidoImpostoFatura');
        $this->adicionaRelacionamento('PDV_PedidoImpostoParcela', 'PDV_PedidoImpostoParcela');

        $this->setSTop('1000');
        $this->adicionaOrderBy('pdv_pedidocodigo', 0);
    }

}
