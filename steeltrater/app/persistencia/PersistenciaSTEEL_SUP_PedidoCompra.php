<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_PedidoCompra extends Persistencia {

    public function __construct() {
        parent::__construct();


        $this->setTabela('SUP_PEDIDO');

        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_PedidoSeq', 'SUP_PedidoSeq', true, true, true);
        $this->adicionaRelacionamento('SUP_PedidoFornecedor', 'SUP_PedidoFornecedor');
        $this->adicionaRelacionamento('SUP_PedidoRepresentante', 'SUP_PedidoRepresentante');
        $this->adicionaRelacionamento('SUP_PedidoNegociador', 'SUP_PedidoNegociador');
        $this->adicionaRelacionamento('SUP_PedidoTransportador', 'SUP_PedidoTransportador');
        $this->adicionaRelacionamento('SUP_PedidoSituacao', 'SUP_PedidoSituacao');
        $this->adicionaRelacionamento('SUP_PedidoObservacao', 'SUP_PedidoObservacao');
        $this->adicionaRelacionamento('SUP_PedidoMoeda', 'SUP_PedidoMoeda');
        $this->adicionaRelacionamento('SUP_PedidoMoedaData', 'SUP_PedidoMoedaData');
        $this->adicionaRelacionamento('SUP_PedidoMoedaValor', 'SUP_PedidoMoedaValor');
        $this->adicionaRelacionamento('SUP_PedidoTipo', 'SUP_PedidoTipo');
        $this->adicionaRelacionamento('SUP_PedidoTipoFrete', 'SUP_PedidoTipoFrete');
        $this->adicionaRelacionamento('SUP_PedidoVlrFrete', 'SUP_PedidoVlrFrete');
        $this->adicionaRelacionamento('SUP_PedidoVlrDespesa', 'SUP_PedidoVlrDespesa');
        $this->adicionaRelacionamento('SUP_PedidoVlrSeguro', 'SUP_PedidoVlrSeguro');
        $this->adicionaRelacionamento('SUP_PedidoVlrDesconto', 'SUP_PedidoVlrDesconto');
        $this->adicionaRelacionamento('SUP_PedidoPerDesconto', 'SUP_PedidoPerDesconto');
        $this->adicionaRelacionamento('SUP_PedidoContrato', 'SUP_PedidoContrato');
        $this->adicionaRelacionamento('SUP_PedidoNotaAviso', 'SUP_PedidoNotaAviso');
        $this->adicionaRelacionamento('SUP_PedidoData', 'SUP_PedidoData');
        $this->adicionaRelacionamento('SUP_PedidoUsuario', 'SUP_PedidoUsuario');
        $this->adicionaRelacionamento('SUP_PedidoTipoMovimento', 'SUP_PedidoTipoMovimento');
        $this->adicionaRelacionamento('SUP_PedidoHora', 'SUP_PedidoHora');
        $this->adicionaRelacionamento('SUP_PedidoContato', 'SUP_PedidoContato');
        $this->adicionaRelacionamento('SUP_PedidoCondicaoPag', 'SUP_PedidoCondicaoPag');
        $this->adicionaRelacionamento('SUP_PedidoDestino', 'SUP_PedidoDestino');
        $this->adicionaRelacionamento('SUP_PedidoTipoDesconto', 'SUP_PedidoTipoDesconto');
        $this->adicionaRelacionamento('SUP_PedidoValorProduto', 'SUP_PedidoValorProduto');
        $this->adicionaRelacionamento('SUP_PedidoValorServico', 'SUP_PedidoValorServico');
        $this->adicionaRelacionamento('SUP_PedidoValorTotal', 'SUP_PedidoValorTotal');
        $this->adicionaRelacionamento('SUP_PedidoIdentificador', 'SUP_PedidoIdentificador');
        $this->adicionaRelacionamento('SUP_PedidoValorDescontoServico', 'SUP_PedidoValorDescontoServico');
        $this->adicionaRelacionamento('SUP_PedidoSeqAprovacao', 'SUP_PedidoSeqAprovacao');
        $this->adicionaRelacionamento('SUP_PedidoValorTotalDesconto', 'SUP_PedidoValorTotalDesconto');
        $this->adicionaRelacionamento('SUP_PedidoMRP', 'SUP_PedidoMRP');
        $this->adicionaRelacionamento('SUP_PedidoMoedaValorNeg', 'SUP_PedidoMoedaValorNeg');
        $this->adicionaRelacionamento('SUP_PedidoPessoaEntrega', 'SUP_PedidoPessoaEntrega');
        $this->adicionaRelacionamento('SUP_PedidoPessoaEntregaEnd', 'SUP_PedidoPessoaEntregaEnd');
        $this->adicionaRelacionamento('SUP_PedidoEntregaObs', 'SUP_PedidoEntregaObs');
        $this->adicionaRelacionamento('SUP_PedidoSitEnvEmailForn', 'SUP_PedidoSitEnvEmailForn');
        $this->adicionaRelacionamento('SUP_PedidoPessoaFaturamento', 'SUP_PedidoPessoaFaturamento');
        $this->adicionaRelacionamento('SUP_PedidoPessoaFaturamentoEnd', 'SUP_PedidoPessoaFaturamentoEnd');
        $this->adicionaRelacionamento('SUP_PedidoFaturamentoObs', 'SUP_PedidoFaturamentoObs');
        $this->adicionaRelacionamento('SUP_PedidoContratoEntregaFutur', 'SUP_PedidoContratoEntregaFutur');
        $this->adicionaRelacionamento('SUP_PedidoUsuNegacao', 'SUP_PedidoUsuNegacao');
        $this->adicionaRelacionamento('SUP_PedidoDataHoraNegacao', 'SUP_PedidoDataHoraNegacao');
        $this->adicionaRelacionamento('SUP_PedidoCCTCod', 'SUP_PedidoCCTCod');
        $this->adicionaRelacionamento('SUP_PedidoFornecedorEnd', 'SUP_PedidoFornecedorEnd');
        $this->adicionaRelacionamento('SUP_PedidoLiberadoAprovacao', 'SUP_PedidoLiberadoAprovacao');
        $this->adicionaRelacionamento('SUP_PedidoFornecedorAssociado', 'SUP_PedidoFornecedorAssociado');
        $this->adicionaRelacionamento('SUP_PedidoChassi', 'SUP_PedidoChassi');
        $this->adicionaRelacionamento('SUP_PedidoKM', 'SUP_PedidoKM');
        $this->adicionaRelacionamento('SUP_PedidoNSG', 'SUP_PedidoNSG');
        $this->adicionaRelacionamento('SUP_PedidoTipoControle', 'SUP_PedidoTipoControle');
        $this->adicionaRelacionamento('SUP_PedidoTipoPEC', 'SUP_PedidoTipoPEC');
        $this->adicionaRelacionamento('SUP_PedidoVia', 'SUP_PedidoVia');
        $this->adicionaRelacionamento('SUP_PedidoVlrAcrescimo', 'SUP_PedidoVlrAcrescimo');
        $this->adicionaRelacionamento('SUP_PedidoDataValidade', 'SUP_PedidoDataValidade');
        $this->adicionaRelacionamento('SUP_PedidoBxPrevisao', 'SUP_PedidoBxPrevisao');
        $this->adicionaRelacionamento('SUP_PedidoOrcamento', 'SUP_PedidoOrcamento');
        $this->adicionaRelacionamento('SUP_PedidoEnvEmaForn', 'SUP_PedidoEnvEmaForn');
        $this->adicionaRelacionamento('SUP_PedidoCondicaoPagDescritiv', 'SUP_PedidoCondicaoPagDescritiv');
        $this->adicionaRelacionamento('FIN_FormaPagamentoCodigo', 'FIN_FormaPagamentoCodigo');
        $this->adicionaRelacionamento('SUP_PedidoUsuarioAprovador', 'SUP_PedidoUsuarioAprovador');
        $this->adicionaRelacionamento('SUP_PedidoEquipamento', 'SUP_PedidoEquipamento');
        $this->adicionaRelacionamento('SUP_PedidoUsuarioResponsavel', 'SUP_PedidoUsuarioResponsavel');

        $this->adicionaOrderBy('sup_pedidoseq', 1);
        $this->adicionaFiltro('FIL_Codigo', '8993358000174');
    }

}
