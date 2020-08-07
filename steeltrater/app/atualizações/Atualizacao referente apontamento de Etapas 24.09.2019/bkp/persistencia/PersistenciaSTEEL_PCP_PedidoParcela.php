<?php

/*
 * Classe que implementa a persistencia 
 * 
 * @author Cleverton Hoffmann
 * @since 30/01/2019
 */

class PersistenciaSTEEL_PCP_PedidoParcela extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PDV_PEDIDOPARCELA');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo', true, true);
        $this->adicionaRelacionamento('pdv_pedidoparcelaseq', 'pdv_pedidoparcelaseq', true, true);
        $this->adicionaRelacionamento('PDV_PedidoParcelaVencimento', 'PDV_PedidoParcelaVencimento');
        $this->adicionaRelacionamento('PDV_PedidoParcelaValor', 'PDV_PedidoParcelaValor');
        $this->adicionaRelacionamento('PDV_PedidoParcelaPercentual', 'PDV_PedidoParcelaPercentual');
        $this->adicionaRelacionamento('PDV_PedidoParcelaAntecipada', 'PDV_PedidoParcelaAntecipada');
        $this->adicionaRelacionamento('PDV_PedidoParcelaDias', 'PDV_PedidoParcelaDias');
        $this->adicionaRelacionamento('PDV_PedidoParcelaObs', 'PDV_PedidoParcelaObs');
        $this->adicionaRelacionamento('PDV_PedidoParcelaAdiantamento', 'PDV_PedidoParcelaAdiantamento');
        $this->adicionaRelacionamento('PDV_PedidoParcelaAlteradaManua', 'PDV_PedidoParcelaAlteradaManua');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaPadrao', 'PDV_PedidoParcelaMoedaPadrao');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaCodigo', 'PDV_PedidoParcelaMoedaCodigo');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaData', 'PDV_PedidoParcelaMoedaData');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaValorCot', 'PDV_PedidoParcelaMoedaValorCot');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaVlrCotNe', 'PDV_PedidoParcelaMoedaVlrCotNe');
        $this->adicionaRelacionamento('PDV_PedidoParcelaMoedaValor', 'PDV_PedidoParcelaMoedaValor');
        $this->adicionaRelacionamento('PDV_PedidoParcelaValorImposto', 'PDV_PedidoParcelaValorImposto');
        $this->adicionaRelacionamento('PDV_PedidoParcelaValorFrete', 'PDV_PedidoParcelaValorFrete');
        
        $this->setSTop('100');
        
        $this->adicionaOrderBy('pdv_pedidocodigo',1);
    }

}