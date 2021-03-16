<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_PedidoCompraItem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('SUP_PEDIDOITEM');

        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('sup_pedidoseq', 'sup_pedidoseq', true, true);
        $this->adicionaRelacionamento('sup_pedidoitemseq', 'sup_pedidoitemseq', true, true, true);
        $this->adicionaRelacionamento('sup_pedidoitemcomvalor', 'sup_pedidoitemcomvalor');
        $this->adicionaRelacionamento('sup_pedidoitemqtd', 'sup_pedidoitemqtd');
        $this->adicionaRelacionamento('sup_pedidoitemvalortotal', 'sup_pedidoitemvalortotal');
    }

}
