<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 21/11/2018
 */

class ViewSTEEL_PCP_PedCargaItens extends View {

    public function criaConsulta() {
        parent::criaConsulta();
                
        $oNr = new CampoConsulta('Nr Pedido Filial', 'PDV_PedidoFilial');
        $oCod = new CampoConsulta('Pedido', 'PDV_PedidoCodigo') ;
        $oSeq = new CampoConsulta('Seq', 'PDV_PedidoItemSeq');
        $oProduto = new CampoConsulta('Produto', 'PDV_PedidoItemProduto');
        $oProdNomeMan = new CampoConsulta('Descrição', 'PDV_PedidoItemProdutoNomeManua');
        $oQuantPed = new CampoConsulta('Qtd', 'PDV_PedidoItemQtdPedida',CampoConsulta::TIPO_DECIMAL);
        $oUn = new CampoConsulta('Un', 'PDV_PedidoItemProdutoUnidadeMa');
        $oVlr = new CampoConsulta('Valor', 'PDV_PedidoItemValorUnitario',CampoConsulta::TIPO_DECIMAL);
        
       /* $oQuantFat = new CampoConsulta('Qtd. Faturada', 'PDV_PedidoItemQtdFaturada',CampoConsulta::TIPO_DECIMAL);
        $oPed = new CampoConsulta('Valor Unitario', 'PDV_PedidoItemValorUnitario',CampoConsulta::TIPO_DECIMAL);
        $oSit = new CampoConsulta('Situacao', 'PDV_PedidoItemSituacao');
        $oApro = new CampoConsulta('Aprovacao', 'PDV_PedidoItemAprovacao');
        $oDtEntrega = new CampoConsulta('Data Entrega', 'PDV_PedidoItemDataEntrega',CampoConsulta::TIPO_DATA);
        $oItemProd = new CampoConsulta('Cod.Produto', 'PDV_PedidoItemProduto');
        $oProdNomeMan = new CampoConsulta('Des.Produto', 'PDV_PedidoItemProdutoNomeManua');
        $oUnidMa = new CampoConsulta('Unidade Md.', 'PDV_PedidoItemProdutoUnidadeMa');
        $oValorTotal = new CampoConsulta('Valor Total', 'PDV_PedidoItemValorTotal',CampoConsulta::TIPO_DECIMAL);
        $oCFOP = new CampoConsulta('CFOP', 'PDV_PedidoItemCFOP');
        $oOrdemComp = new CampoConsulta('Ordem Compra', 'PDV_PedidoItemOrdemCompra');
        $oMoedDat = new CampoConsulta('Moeda Data', 'PDV_PedidoItemMoedaData',CampoConsulta::TIPO_DATA);
        $oDataNeg = new CampoConsulta('Data Negociada', 'PDV_PedidoItemDataNegociada',CampoConsulta::TIPO_DATA);
        $oDtInclu = new CampoConsulta('Data Inclusao', 'PDV_PedidoItemDataInclusao',CampoConsulta::TIPO_DATA);   
        */
        
        $oFiltroProd = new Filtro($oProduto, Filtro::CAMPO_TEXTO_IGUAL, 5);
        

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroProd);

        $this->setBScrollInf(false);
        $this->addCampos($oNr,$oCod,$oSeq,$oProduto,$oProdNomeMan,$oQuantPed,$oUn,$oVlr);
    }

    public function criaTela() {
        parent::criaTela();

        $aValor = $this->getAParametrosExtras();
        
        $oFilial = new Campo('Filial', 'PDV_PedidoFilial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilial->setSValor($aValor[0]);
        $oFilial->setBCampoBloqueado(true);
        
        
        
        /*$oCod = new Campo('Cod. Pedido', 'PDV_PedidoCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12) ;
        $oItemSeq = new Campo('Pedido Item Seq', 'PDV_PedidoItemSeq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQuantPed = new Campo('Qtd. Pedida', 'PDV_PedidoItemQtdPedida', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oQuantFat = new Campo('Qtd. Faturada', 'PDV_PedidoItemQtdFaturada', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPed = new Campo('Valor Unitario', 'PDV_PedidoItemValorUnitario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSit = new Campo('Situacao', 'PDV_PedidoItemSituacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oApro = new Campo('Aprovacao', 'PDV_PedidoItemAprovacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDtEntrega = new Campo('Data Entrega', 'PDV_PedidoItemDataEntrega', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oItemProd = new Campo('Cod.Produto', 'PDV_PedidoItemProduto', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oProdNomeMan = new Campo('Des.Produto', 'PDV_PedidoItemProdutoNomeManua', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUnidMa = new Campo('Unidade Md.', 'PDV_PedidoItemProdutoUnidadeMa', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValorTotal = new Campo('Valor Total', 'PDV_PedidoItemValorTotal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCFOP = new Campo('CFOP', 'PDV_PedidoItemCFOP', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oOrdemComp = new Campo('Ordem Compra', 'PDV_PedidoItemOrdemCompra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMoedDat = new Campo('Moeda Data', 'PDV_PedidoItemMoedaData', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataNeg = new Campo('Data Negociada', 'PDV_PedidoItemDataNegociada', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDtInclu = new Campo('Data Inclusao', 'PDV_PedidoItemDataInclusao', Campo::TIPO_DATA, 2, 2, 12, 12); */ 
                
        $this->addCampos($oFilial/*array($oNr,$oCod,$oItemSeq),array($oItemProd,
                $oProdNomeMan,$oUnidMa),array($oSit,$oApro),
                array($oQuantPed,$oQuantFat,$oPed, 
                $oValorTotal),array($oCFOP,$oOrdemComp),array($oDtEntrega,$oMoedDat,$oDataNeg,$oDtInclu)*/);
    }
}