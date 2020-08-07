<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_Parametros
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */

class PersistenciaSTEEL_PCP_ParamVendasItem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ParamVendasItem');

        $this->adicionaRelacionamento('id', 'id', true, true,true);
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('PDV_PedidoItemMoeda','PDV_PedidoItemMoeda');
        $this->adicionaRelacionamento('PDV_PedidoItemFreteRateado', 'PDV_PedidoItemFreteRateado'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDespesasRateado', 'PDV_PedidoItemDespesasRateado');  
        $this->adicionaRelacionamento('PDV_PedidoItemSeguroRateado', 'PDV_PedidoItemSeguroRateado'); 
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoRateado', 'PDV_PedidoItemAcrescimoRateado'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDescontoPercentu', 'PDV_PedidoItemDescontoPercentu');
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoPercent', 'PDV_PedidoItemAcrescimoPercent'); 
        $this->adicionaRelacionamento('PDV_PedidoItemOrdemImpressao', 'PDV_PedidoItemOrdemImpressao'); 
        $this->adicionaRelacionamento('PDV_PedidoItemQtdLiberada', 'PDV_PedidoItemQtdLiberada'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDescontoValor', 'PDV_PedidoItemDescontoValor');
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoValor', 'PDV_PedidoItemAcrescimoValor'); 
        $this->adicionaRelacionamento('PDV_PedidoItemTipoEmiNF', 'PDV_PedidoItemTipoEmiNF');
        $this->adicionaRelacionamento('PDV_PedidoItemCancelado', 'PDV_PedidoItemCancelado'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDiasEntrega', 'PDV_PedidoItemDiasEntrega'); 
        $this->adicionaRelacionamento('PDV_PedidoItemVlrFaturado', 'PDV_PedidoItemVlrFaturado'); 
        $this->adicionaRelacionamento('PDV_PedidoItemValorCusto', 'PDV_PedidoItemValorCusto'); 
        $this->adicionaRelacionamento('PDV_PedidoItemPercentualCusto', 'PDV_PedidoItemPercentualCusto'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDimGQtd', 'PDV_PedidoItemDimGQtd');
        $this->adicionaRelacionamento('PDV_PedidoItemDimGFormula', 'PDV_PedidoItemDimGFormula'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDimGExpres', 'PDV_PedidoItemDimGExpres'); 
        $this->adicionaRelacionamento('PDV_PedidoItemQtdPecas', 'PDV_PedidoItemQtdPecas');
        $this->adicionaRelacionamento('PDV_PedidoItemObsOF', 'PDV_PedidoItemObsOF'); 
        $this->adicionaRelacionamento('PDV_PedidoItemPercentualPromoc', 'PDV_PedidoItemPercentualPromoc'); 
        $this->adicionaRelacionamento('PDV_PedidoItemValorMotagemRate', 'PDV_PedidoItemValorMotagemRate'); 
        $this->adicionaRelacionamento('PDV_PedidoItemValorFreteAuxRat', 'PDV_PedidoItemValorFreteAuxRat'); 
        $this->adicionaRelacionamento('PDV_PedidoItemConfigSalvaSeq', 'PDV_PedidoItemConfigSalvaSeq'); 
        $this->adicionaRelacionamento('PDV_PedidoItemEstruturaNumero', 'PDV_PedidoItemEstruturaNumero'); 
        $this->adicionaRelacionamento('PDV_PedidoItemEntregaAntecipad', 'PDV_PedidoItemEntregaAntecipad'); 
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoCusto', 'PDV_PedidoItemProdutoCusto'); 
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoMarkup', 'PDV_PedidoItemProdutoMarkup'); 
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoReferenci', 'PDV_PedidoItemProdutoReferenci'); 
        $this->adicionaRelacionamento('PDV_PedidoItemTipoFornecimento', 'PDV_PedidoItemTipoFornecimento'); 
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaPadrao', 'PDV_PedidoItemMoedaPadrao'); 
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaValorCotaca', 'PDV_PedidoItemMoedaValorCotaca'); 
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaValor', 'PDV_PedidoItemMoedaValor'); 
        $this->adicionaRelacionamento('PDV_PedidoItemConfigProcessada', 'PDV_PedidoItemConfigProcessada'); 
        $this->adicionaRelacionamento('PDV_PedidoItemEspecie', 'PDV_PedidoItemEspecie'); 
        $this->adicionaRelacionamento('PDV_PedidoItemVolumes', 'PDV_PedidoItemVolumes'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDescFormulaSeq', 'PDV_PedidoItemDescFormulaSeq'); 
        $this->adicionaRelacionamento('PDV_AprovacaoAlteraPedido', 'PDV_AprovacaoAlteraPedido'); 
        $this->adicionaRelacionamento('PDV_PedidoItemOrigem', 'PDV_PedidoItemOrigem'); 
        $this->adicionaRelacionamento('PDV_PedidoItemPedidoVendaCli', 'PDV_PedidoItemPedidoVendaCli'); 
        $this->adicionaRelacionamento('PDV_PedidoItemProdObsoleto', 'PDV_PedidoItemProdObsoleto'); 
        $this->adicionaRelacionamento('PDV_PedidoItemSerieModelo', 'PDV_PedidoItemSerieModelo'); 
        $this->adicionaRelacionamento('PDV_PedidoItemIdenProgramacao', 'PDV_PedidoItemIdenProgramacao');
        $this->adicionaRelacionamento('PDV_PedidoItemMargemVlrUnitJur', 'PDV_PedidoItemMargemVlrUnitJur'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDiasEntregaFinal', 'PDV_PedidoItemDiasEntregaFinal');
        $this->adicionaRelacionamento('PDV_PedidoItemQtdEncerrada', 'PDV_PedidoItemQtdEncerrada');
        $this->adicionaRelacionamento('PDV_PedidoItemContratoSeq', 'PDV_PedidoItemContratoSeq'); 
        $this->adicionaRelacionamento('PDV_PedidoItemValorTratamento', 'PDV_PedidoItemValorTratamento'); 
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoImportado', 'PDV_PedidoItemProdutoImportado');
        $this->adicionaRelacionamento('PDV_PedidoItemTabelaFreteKM', 'PDV_PedidoItemTabelaFreteKM'); 
        $this->adicionaRelacionamento('PDV_PedidoItemFilialDistancia', 'PDV_PedidoItemFilialDistancia'); 
        $this->adicionaRelacionamento('PDV_PedidoItemFreteUnitario', 'PDV_PedidoItemFreteUnitario');
        $this->adicionaRelacionamento('PDV_PedidoItemSeqOptyWay', 'PDV_PedidoItemSeqOptyWay'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDataInclusao', 'PDV_PedidoItemDataInclusao'); 
        $this->adicionaRelacionamento('PDV_PedidoItemJustificativa', 'PDV_PedidoItemJustificativa'); 
        $this->adicionaRelacionamento('PDV_PedidoItemMotivo', 'PDV_PedidoItemMotivo');
        $this->adicionaRelacionamento('PDV_PedidoItemValorFreteTabela', 'PDV_PedidoItemValorFreteTabela');
        $this->adicionaRelacionamento('PDV_PedidoItemAlturaComercial', 'PDV_PedidoItemAlturaComercial'); 
        $this->adicionaRelacionamento('PDV_PedidoItemLarguraComercial', 'PDV_PedidoItemLarguraComercial'); 
        $this->adicionaRelacionamento('PDV_PedidoItemDescProdComercia', 'PDV_PedidoItemDescProdComercia');
           
        $this->setSTop('100');
        
        $this->adicionaOrderBy('id',1);
    }

}