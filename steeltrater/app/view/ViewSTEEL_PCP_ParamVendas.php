<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */

class ViewSTEEL_PCP_ParamVendas extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oId = new CampoConsulta('Id', 'id');
        $oNome = new CampoConsulta('Nome', 'nome');

        $oCodfiltro = new Filtro($oId, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oDescricaoFiltro = new Filtro($oNome, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(false);
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

        $oLabel1 = new Campo('', 'Linha1', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLabel1->setApenasTela(true);
        //-----------------------------------------------------------
        $oNome = new Campo('Nome', 'nome', Campo::TIPO_TEXTO, 3, 3, 3, 3);
        //-----------------------------------------------------------
        $oDescontoPerc = new Campo('DescontoPercentual', 'PDV_PedidoDescontoPerc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescontoPerc->setSValor('0');
        //----------------------------------------------------------
        $oPedidoSomaFrete = new Campo('SomaFrete', 'PDV_PedidoSomaFrete', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oPedidoSomaFrete->addItemSelect('N', 'N');
        $oPedidoSomaFrete->addItemSelect('S', 'S');
        $oPedidoSomaFrete->setSValor('N');
        //-----------------------------------------------------------
        $oPedidoSomaSt = new Campo('SomaST', 'PDV_PedidoSomaST', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oPedidoSomaSt->addItemSelect('N', 'N');
        $oPedidoSomaSt->addItemSelect('S', 'S');
        $oPedidoSomaSt->setSValor('N');
        //-----------------------------------------------------------
        $oPedidoEnd = new Campo('PedidoEnd', 'PDV_PedidoEndereco', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedidoEnd->setSValor('1');
        //-----------------------------------------------------------
        $oConsumidorFinal = new Campo('ConsumidorFinal', 'PDV_PedidoConsumidorFinal', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oConsumidorFinal->addItemSelect('N', 'N');
        $oConsumidorFinal->addItemSelect('S', 'S');
        $oConsumidorFinal->setSValor('N');
        //-----------------------------------------------------------
        $oAreaRestrita = new Campo('ÁreaRestrita', 'PDV_PedidoAreaRestrita', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oAreaRestrita->addItemSelect('N', 'N');
        $oAreaRestrita->addItemSelect('S', 'S');
        $oAreaRestrita->setSValor('N');
        //-----------------------------------------------------------
        $oPedidoTipoPag = new Campo('TipoPag', 'PDV_PedidoTipoPagamento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedidoTipoPag->setSValor('D');
        //-----------------------------------------------------------
        $oComissaoPerc = new Campo('ComissãoPerc', 'PDV_PedidoComissaoPerc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oComissaoPerc->setSValor('0');
        //-----------------------------------------------------------
        //PDV_PedidoTipoCod
        $oPedidoTipoCod = new Campo('TipoPedido', 'PDV_PedidoTipoCod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedidoTipoCod->setSValor('1');
        //----------------------------------------------------------

        $oBancoCobranca = new Campo('BancoCobrança', 'PDV_PedidoBancoCobranca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oBancoCobranca->setSValor('2');
        //----------------------------------------------------------
        $oCarteiraCobranca = new Campo('CarteiraCobrança', 'PDV_PedidoCarteiraCobranca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCarteiraCobranca->setSValor('1');
        //----------------------------------------------------------
        //PDV_PedidoOrcamentoAno
        $oPedOrcamentoAno = new Campo('PedOrcamentoAno', 'PDV_PedidoOrcamentoAno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcamentoAno->setSValor('0');
        //----------------------------------------------------------
        //PDV_PedidoOrcamentoNumero
        $oPedOrcamentoNr = new Campo('PedOrcamentoNr', 'PDV_PedidoOrcamentoNumero', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcamentoNr->setSValor('0');
        //-----------------------------------------------------------
        //PDV_PedidoOrcamentoVersao
        $oPedOrcamentoVersao = new Campo('PedOrcamentoVersão', 'PDV_PedidoOrcamentoVersao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcamentoVersao->setSValor(' ');
        //------------------------------------------------------------
        $oPedOrcamentoImp = new Campo('PedOrcamentoImp', 'PDV_PedidoContadorImpressao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcamentoImp->setSValor('0');
        //------------------------------------------------------------

        $oPedObsImp = new Campo('PedObsImp', 'PDV_PedidoObsImp', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedObsImp->setSValor('1');
        //------------------------------------------------------------
        //PDV_PedidoOrcamentoConvertido
        $oPedOrcConv = new Campo('PedOrcConv', 'PDV_PedidoOrcamentoConvertido', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oPedOrcConv->addItemSelect('N', 'N');
        $oPedOrcConv->addItemSelect('S', 'S');
        $oPedOrcConv->setSValor('N');
        //------------------------------------------------------------
        //PDV_PedidoEmpreitada
        $oPedEmpreitada = new Campo('PedEmpreitada', 'PDV_PedidoEmpreitada', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedEmpreitada->addItemSelect('N', 'N');
        $oPedEmpreitada->addItemSelect('S', 'S');
        $oPedEmpreitada->setSValor('N');
        //------------------------------------------------------------
        $oPedNumOriginal = new Campo('PedNumOriginal', 'PDV_PedidoNumeroOriginal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedNumOriginal->setSValor('0');
        //------------------------------------------------------------
        $oPedEmpOriginal = new Campo('PedEmpOriginal', 'PDV_PedidoEmpresaOriginal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedEmpOriginal->setSValor('0');
        //------------------------------------------------------------
        $oPedDimensoes = new Campo('PedDimensoes', 'PDV_PedidoDimensoes', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedDimensoes->setSValor(' ');
        //------------------------------------------------------------
        $oPedDataFinal = new Campo('PedDataFinal', 'PDV_PedidoDataFinal', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        //------------------------------------------------------------
        $oPedContato = new Campo('PedContato', 'PDV_PedidoContato', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedContato->setSValor(' ');
        //------------------------------------------------------------
        $oPedContaDeposito = new Campo('PedContaDeposito', 'PDV_PedidoContaDeposito', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedContaDeposito->setSValor(' ');
        //------------------------------------------------------------
        $oPedContaCobranca = new Campo('PedContaCobranca', 'PDV_PedidoContaCobranca', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedContaCobranca->setSValor('CX');
        //------------------------------------------------------------
        $oPedContaMot = new Campo('PedMotoristaNome', 'PDV_PedidoMotoristaNome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedContaMot->setSValor(' ');
        //------------------------------------------------------------         
        $oPedTipoFreteCod = new Campo('PedTipoFreteCod', 'PDV_PedidoTipoFreteCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedTipoFreteCod->setSValor('4');
        //------------------------------------------------------------    
        $oPedCondPagCod = new Campo('PedCondPagCod', 'PDV_PedidoCondicaoPgtoCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedCondPagCod->setSValor('7');
        //------------------------------------------------------------  
        $oPedMoedaCod = new Campo('PedMoedaCodigo', 'PDV_PedidoMoedaCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedMoedaCod->setSValor('REAL');
        //------------------------------------------------------------  
        $oPedTipoEmiNF = new Campo('PedTipoEmiNF', 'PDV_PedidoTipoEmiNF', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedTipoEmiNF->addItemSelect('N', 'N');
        $oPedTipoEmiNF->addItemSelect('S', 'S');
        $oPedTipoEmiNF->setSValor('N');
        //------------------------------------------------------------  
        $oPedSitAltera = new Campo('PedSitAltera', 'PDV_PedidoSituacaoAltera', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedSitAltera->addItemSelect('N', 'N');
        $oPedSitAltera->addItemSelect('S', 'S');
        $oPedSitAltera->setSValor('S');
        //------------------------------------------------------------  
        $oPedExcluido = new Campo('PedExcluido', 'PDV_PedidoExcluido', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedExcluido->addItemSelect('N', 'N');
        $oPedExcluido->addItemSelect('S', 'S');
        $oPedExcluido->setSValor('N');
        //------------------------------------------------------------  
        $oPedEmpFisJur = new Campo('PedEmpFisJur', 'PDV_PedidoEmpFisJur', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedEmpFisJur->addItemSelect('F', 'FÍSICA');
        $oPedEmpFisJur->addItemSelect('J', 'JURÍDICA');
        $oPedEmpFisJur->setSValor('J');
        //-----------------------------------------------------------
        $oPedDispCodigo = new Campo('PedDispositivoCodigo', 'PDV_PedidoDispositivoCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedDispCodigo->setSValor('0');
        //-----------------------------------------------------------
        $oPedDispNrPedido = new Campo('PedDispositivoNroPed', 'PDV_PedidoDispositivoNroPedido', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedDispNrPedido->setSValor('0');
        //------------------------------------------------------------  
        $oPedDispAlter = new Campo('PedDispositivoAltera', 'PDV_PedidoDispositivoAltera', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedDispAlter->addItemSelect('N', 'N');
        $oPedDispAlter->addItemSelect('S', 'S');
        $oPedDispAlter->setSValor('N');
        //------------------------------------------------------------ 
        $oPedEmEntrega = new Campo('PedEmEntrega', 'PDV_PedidoEmEntrega', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedEmEntrega->addItemSelect('N', 'N');
        $oPedEmEntrega->addItemSelect('S', 'S');
        $oPedEmEntrega->setSValor('N');
        //------------------------------------------------------------ 
        $oPedNomeSuspect = new Campo('PedNomeSuspect', 'PDV_PedidoNomeSuspect', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedNomeSuspect->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedMetrosCubicos = new Campo('PedMetrosCúbicos', 'PDV_PedidoMetrosCubicos', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedMetrosCubicos->setSValor('0');
        //------------------------------------------------------------ 
        $oPedOrcAno = new Campo('PedOrcAno', 'PDV_PedidoOrcAno', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcAno->setSValor('0');
        //------------------------------------------------------------ 
        $oPedOrcNum = new Campo('PedOrcNúmero', 'PDV_PedidoOrcNumero', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcNum->setSValor('0');
        //------------------------------------------------------------ 
        $oPedOrcVersao = new Campo('PedOrcVersão', 'PDV_PedidoOrcVersao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOrcVersao->setSValor('0');
        //------------------------------------------------------------ 
        $oPedOperadora = new Campo('PedOperadora', 'PDV_PedidoOperadora', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOperadora->setSValor('0');
        //------------------------------------------------------------ 
        $oPedValAdiant = new Campo('PedValorAdiantamento', 'PDV_PedidoValorAdiantamento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedValAdiant->setSValor('0');
        //------------------------------------------------------------ 
        $oPedDiasEntrega = new Campo('PedDiasEntrega', 'PDV_PedidoDiasEntrega', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedDiasEntrega->setSValor('0');
        //------------------------------------------------------------ 
        $oPedLibProd = new Campo('PedLiberadoProdução', 'PDV_PedidoLiberadoParaProducao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedLibProd->addItemSelect('N', 'N');
        $oPedLibProd->addItemSelect('S', 'S');
        $oPedLibProd->setSValor('N');
        //------------------------------------------------------------ 
        $oPedComissaoPercManual = new Campo('PedComissaoPercManual', 'PDV_PedidoComissaoPercManual', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedComissaoPercManual->addItemSelect('N', 'N');
        $oPedComissaoPercManual->addItemSelect('S', 'S');
        $oPedComissaoPercManual->setSValor('N');
        //------------------------------------------------------------ 
        $oPedSimuladorVendaSeq = new Campo('PedSimuladorVendaSeq', 'PDV_PedidoSimuladorVendaSeq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedSimuladorVendaSeq->setSValor('0');
        //------------------------------------------------------------ 
        $oPedCRMCodigo = new Campo('PedCRMCodigo', 'PDV_PedidoCRMCodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedCRMCodigo->setSValor('0');
        //------------------------------------------------------------ 
        $oPedOperadoraBandeira = new Campo('PedOperadoraBandeira', 'PDV_PedidoOperadoraBandeira', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedOperadoraBandeira->setSValor('0');
        //------------------------------------------------------------ 
        $oPedContratoConstrucao = new Campo('PedContratoConstrução', 'PDV_PedidoContratoConstrucao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedContratoConstrucao->addItemSelect('N', 'N');
        $oPedContratoConstrucao->addItemSelect('S', 'S');
        $oPedContratoConstrucao->setSValor('N');
        //------------------------------------------------------------ 
        $oPedEmpAtividadeEconomic = new Campo('PedEmpAtividadeEconomic', 'PDV_PedidoEmpAtividadeEconomic', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedEmpAtividadeEconomic->setSValor('0');
        //------------------------------------------------------------ 
        $oPedEmbalagem = new Campo('PedEmbalagem', 'PDV_PedidoEmbalagem', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedEmbalagem->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedFinMovimentoSeq = new Campo('PedFinMovimentoSeq', 'PDV_PedidoFinMovimentoSeq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedFinMovimentoSeq->setSValor('0');
        //------------------------------------------------------------ 
        $oPedAssociado = new Campo('PedAssociado', 'PDV_PedidoEmpAssociado', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedAssociado->addItemSelect('N', 'N');
        $oPedAssociado->addItemSelect('S', 'S');
        $oPedAssociado->setSValor('N');
        //------------------------------------------------------------ 
        $oPedTipoFornecimento = new Campo('PedTipoFornecimento', 'PDV_PedidoTipoFornecimento', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedTipoFornecimento->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedCodigoInformado = new Campo('PedCodigoInformado', 'PDV_PedidoCodigoInformado', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedCodigoInformado->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedCodigoCR = new Campo('PedCodigoCR', 'PDV_PedidoCodigoCR', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedCodigoCR->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedCodigoAF = new Campo('PedCodigoAF', 'PDV_PedidoCodigoAF', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedCodigoAF->setSValor(' ');
        //------------------------------------------------------------ 
        $oPedCarenciaNegociada = new Campo('PedCarênciaNegociada', 'PDV_PedidoCarenciaNegociada', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oPedCarenciaNegociada->addItemSelect('N', 'N');
        $oPedCarenciaNegociada->addItemSelect('S', 'S');
        $oPedCarenciaNegociada->setSValor('N');
        //------------------------------------------------------------ 
        $oPedDiasCarenciaJuros = new Campo('PedDiasCarenciaJuros', 'PDV_PedidoDiasCarenciaJuros', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedDiasCarenciaJuros->setSValor('0');
        //------------------------------------------------------------ 
        $oPedEmbalagemManual = new Campo('PedEmbalagemManual', 'PDV_PedidoEmbalagemManual', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPedEmbalagemManual->setSValor(' ');

        $this->addCampos(array($oId, $oNome), $oLabel1, array($oDescontoPerc, $oPedidoSomaFrete, $oPedidoSomaSt, $oPedidoEnd, $oConsumidorFinal, $oAreaRestrita, $oPedidoTipoPag), $oLabel1, array($oComissaoPerc, $oPedidoTipoCod), $oLabel1, array($oBancoCobranca, $oCarteiraCobranca, $oPedContaCobranca), $oLabel1, array($oPedOrcamentoAno, $oPedOrcamentoNr, $oPedOrcamentoVersao, $oPedOrcamentoImp), $oLabel1, array($oPedObsImp, $oPedOrcConv, $oPedEmpreitada, $oPedNumOriginal), $oLabel1, array($oPedEmpOriginal, $oPedDimensoes, $oPedDataFinal, $oPedContato, $oPedContaDeposito), $oLabel1, array($oPedContaMot, $oPedTipoFreteCod, $oPedCondPagCod, $oPedMoedaCod), $oLabel1, array($oPedTipoEmiNF, $oPedSitAltera, $oPedExcluido, $oPedEmpFisJur), $oLabel1, array($oPedDispCodigo, $oPedDispNrPedido, $oPedDispAlter, $oPedEmEntrega), $oLabel1, array($oPedNomeSuspect, $oPedMetrosCubicos, $oPedOrcAno, $oPedOrcNum), $oLabel1, array($oPedOrcVersao, $oPedOperadora, $oPedValAdiant, $oPedDiasEntrega), $oLabel1, array($oPedLibProd, $oPedComissaoPercManual, $oPedSimuladorVendaSeq, $oPedCRMCodigo), $oLabel1, array($oPedOperadoraBandeira, $oPedContratoConstrucao, $oPedEmpAtividadeEconomic, $oPedEmbalagem), $oLabel1, array($oPedFinMovimentoSeq, $oPedAssociado, $oPedTipoFornecimento, $oPedCodigoInformado), $oLabel1, array($oPedCodigoCR, $oPedCodigoAF, $oPedCarenciaNegociada, $oPedDiasCarenciaJuros, $oPedEmbalagemManual));
    }

}
