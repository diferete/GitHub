<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */

class ViewSTEEL_PCP_ParamVendasItem extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oId = new CampoConsulta('Id', 'id');
        $oNome = new CampoConsulta('Nome', 'nome');

        $oCodfiltro = new Filtro($oId, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oDescricaoFiltro = new Filtro($oNome, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodfiltro, $oDescricaoFiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oId, $oNome);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Parametros de montagem de cargas STEEL');
        $oId = new Campo('Id', 'id', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oId->setBCampoBloqueado(true);

        $oNome = new Campo('Nome', 'nome', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oLabel1 = new Campo('', 'Linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLabel1->setApenasTela(true);
        //-----------------------------------------------------------
        $oMoeda = new Campo('Moeda', 'PDV_PedidoItemMoeda', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //-----------------------------------------------------------
        $oFreteRateado = new Campo('Frete Rateado', 'PDV_PedidoItemFreteRateado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDesRat = new Campo('Despesas Rateado', 'PDV_PedidoItemDespesasRateado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //-----------------------------------------------------------
        $oSegRat = new Campo('Seguro Rateado', 'PDV_PedidoItemSeguroRateado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oAcrRat = new Campo('Acrescimo Rateado', 'PDV_PedidoItemAcrescimoRateado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDesPer = new Campo('Desconto Percentual', 'PDV_PedidoItemDescontoPercentu', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oAcrPer = new Campo('Acrescimo Percentual', 'PDV_PedidoItemAcrescimoPercent', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oOrdImp = new Campo('Ordem Impressão', 'PDV_PedidoItemOrdemImpressao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oQntLib = new Campo('Quantidade Liberada', 'PDV_PedidoItemQtdLiberada', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDesVal = new Campo('Desconto Valor', 'PDV_PedidoItemDescontoValor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oAcrVal = new Campo('Acrescimo Valor', 'PDV_PedidoItemAcrescimoValor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oEmisNF = new Campo('Tipo Emi. NF', 'PDV_PedidoItemTipoEmiNF', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oCancel = new Campo('Cancelado', 'PDV_PedidoItemCancelado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDiaEnt = new Campo('Dias Entrega', 'PDV_PedidoItemDiasEntrega', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oValFat = new Campo('Valor Faturado', 'PDV_PedidoItemVlrFaturado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oValCus = new Campo('Valor Custo', 'PDV_PedidoItemValorCusto', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oPerCus = new Campo('Percentual Custo', 'PDV_PedidoItemPercentualCusto', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDimGQt = new Campo('Dim.G.Qtd.', 'PDV_PedidoItemDimGQtd', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDimGFo = new Campo('Dim.G.Formula', 'PDV_PedidoItemDimGFormula', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDimGEx = new Campo('Dim.G.Expres', 'PDV_PedidoItemDimGExpres', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oQntPec = new Campo('Qtd.Pecas', 'PDV_PedidoItemQtdPecas', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oObseOF = new Campo('Obs OF', 'PDV_PedidoItemObsOF', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oPerPro = new Campo('Percentual Promoc.', 'PDV_PedidoItemPercentualPromoc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oValMon = new Campo('Valor Motagem Rate.', 'PDV_PedidoItemValorMotagemRate', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oValFre = new Campo('Valor Frete Aux. Rat.', 'PDV_PedidoItemValorFreteAuxRat', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oConSal = new Campo('Config. Salva Seq.', 'PDV_PedidoItemConfigSalvaSeq', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oEstNum = new Campo('Estrutura Numero', 'PDV_PedidoItemEstruturaNumero', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oEntAnt = new Campo('Entrega Antecipada', 'PDV_PedidoItemEntregaAntecipad', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProCus = new Campo('Produto Custo', 'PDV_PedidoItemProdutoCusto', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProMar = new Campo('Produto Markup', 'PDV_PedidoItemProdutoMarkup', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProRef = new Campo('Produto Referenci', 'PDV_PedidoItemProdutoReferenci', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oTipFor = new Campo('Tipo Fornecimento', 'PDV_PedidoItemTipoFornecimento', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oMoePad = new Campo('Moeda Padrao', 'PDV_PedidoItemMoedaPadrao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oMoeCot = new Campo('Moeda Valor Cotaca', 'PDV_PedidoItemMoedaValorCotaca', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oMoeVal = new Campo('Moeda Valor', 'PDV_PedidoItemMoedaValor', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oConPro = new Campo('Config Processada', 'PDV_PedidoItemConfigProcessada', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oPedIEs = new Campo('Especie', 'PDV_PedidoItemEspecie', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oVolume = new Campo('Volumes', 'PDV_PedidoItemVolumes', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDesFor = new Campo('Desc. Formula Seq.', 'PDV_PedidoItemDescFormulaSeq', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oAprAlt = new Campo('Aprov. Altera Ped.', 'PDV_AprovacaoAlteraPedido', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oOrigem = new Campo('Origem', 'PDV_PedidoItemOrigem', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oPedVen = new Campo('Ped.Venda Cli.', 'PDV_PedidoItemPedidoVendaCli', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProObs = new Campo('Prod. Obsoleto', 'PDV_PedidoItemProdObsoleto', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oSerMod = new Campo('Serie Modelo', 'PDV_PedidoItemSerieModelo', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProgra = new Campo('Programação', 'PDV_PedidoItemIdenProgramacao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oMarVal = new Campo('Margem Vlr.Unit.Jur.', 'PDV_PedidoItemMargemVlrUnitJur', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oEntFin = new Campo('Dias Entrega Final', 'PDV_PedidoItemDiasEntregaFinal', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oQntEnc = new Campo('Qtd Encerrada', 'PDV_PedidoItemQtdEncerrada', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oConSeq = new Campo('Contrato Seq', 'PDV_PedidoItemContratoSeq', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oValTra = new Campo('Valor Tratamento', 'PDV_PedidoItemValorTratamento', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oProImp = new Campo('Produto Importado', 'PDV_PedidoItemProdutoImportado', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oTabFre = new Campo('Tabela Frete KM', 'PDV_PedidoItemTabelaFreteKM', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oFilDis = new Campo('Filial Distancia', 'PDV_PedidoItemFilialDistancia', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oFreUni = new Campo('Frete Unitario', 'PDV_PedidoItemFreteUnitario', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oSeqOpt = new Campo('Seq.Opty.Way', 'PDV_PedidoItemSeqOptyWay', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDatInc = new Campo('DataInclusao', 'PDV_PedidoItemDataInclusao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oJustif = new Campo('Justificativa', 'PDV_PedidoItemJustificativa', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oMotivo = new Campo('Motivo', 'PDV_PedidoItemMotivo', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oFreTab = new Campo('Valor Frete Tabela', 'PDV_PedidoItemValorFreteTabela', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oAltCom = new Campo('Altura Comercial', 'PDV_PedidoItemAlturaComercial', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oLarCom = new Campo('Largura Comercial', 'PDV_PedidoItemLarguraComercial', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        //----------------------------------------------------------- 
        $oDesPro = new Campo('Desc.Prod.Comercial', 'PDV_PedidoItemDescProdComercia', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        /* $oDescontoPerc = new Campo('DescontoPercentual','PDV_PedidoDescontoPerc', Campo::TIPO_TEXTO, 2,2,2,2);
          $oDescontoPerc->setSValor('0');
          //----------------------------------------------------------
          $oPedidoSomaFrete = new Campo('SomaFrete','PDV_PedidoSomaFrete', Campo::TIPO_SELECT,1,1,1,1);
          $oPedidoSomaFrete->addItemSelect('N','N');
          $oPedidoSomaFrete->addItemSelect('S','S');
          $oPedidoSomaFrete->setSValor('N')
          //-----------------------------------------------------------
          $oComissaoPerc = new Campo('ComissãoPerc','PDV_PedidoComissaoPerc', Campo::TIPO_TEXTO,1,1,1,1);
          $oComissaoPerc->setSValor('0');
         */
        $this->addCampos(array($oId, $oNome), $oLabel1, array($oMoeda, $oFreteRateado, $oDesRat, $oSegRat, $oAcrRat, $oDesPer, $oAcrPer, $oOrdImp, $oQntLib, $oDesVal, $oAcrVal, $oEmisNF, $oCancel, $oDiaEnt, $oValFat, $oValCus, $oPerCus, $oDimGQt, $oDimGFo, $oDimGEx, $oQntPec, $oObseOF, $oPerPro, $oValMon, $oValFre, $oConSal, $oEstNum, $oEntAnt, $oProCus, $oProMar, $oProRef, $oTipFor, $oMoePad, $oMoeCot,
            $oMoeVal, $oConPro, $oPedIEs, $oVolume, $oDesFor, $oAprAlt,
            $oOrigem, $oPedVen, $oProObs, $oSerMod, $oProgra, $oMarVal, $oEntFin,
            $oQntEnc, $oConSeq, $oValTra, $oProImp, $oTabFre, $oFilDis, $oFreUni,
            $oSeqOpt, $oDatInc, $oJustif, $oMotivo, $oFreTab, $oAltCom, $oLarCom, $oDesPro));
    }

}
