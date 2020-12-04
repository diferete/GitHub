<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_PedCargaItens
 * 
 * @author Cleverton Hoffmann
 * @since 21/11/2018
 */

class PersistenciaSTEEL_PCP_PedCargaItens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PDV_PEDIDOITEM');

        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial', true, true);
        $this->adicionaRelacionamento('pdv_pedidofilial', 'STEEL_PCP_CargaInsumoServ.pdv_pedidofilial', false, false);

        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo', true, true);
        $this->adicionaRelacionamento('pdv_pedidoitemseq', 'pdv_pedidoitemseq', true, true, true);
        $this->adicionaRelacionamento('PDV_PedidoItemMoeda', 'PDV_PedidoItemMoeda');
        $this->adicionaRelacionamento('PDV_PedidoItemValorMoeda', 'PDV_PedidoItemValorMoeda');
        $this->adicionaRelacionamento('PDV_PedidoItemQtdPedida', 'PDV_PedidoItemQtdPedida');
        $this->adicionaRelacionamento('PDV_PedidoItemQtdFaturada', 'PDV_PedidoItemQtdFaturada');
        $this->adicionaRelacionamento('PDV_PedidoItemFreteRateado', 'PDV_PedidoItemFreteRateado');
        $this->adicionaRelacionamento('PDV_PedidoItemDespesasRateado', 'PDV_PedidoItemDespesasRateado');
        $this->adicionaRelacionamento('PDV_PedidoItemSeguroRateado', 'PDV_PedidoItemSeguroRateado');
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoRateado', 'PDV_PedidoItemAcrescimoRateado');
        $this->adicionaRelacionamento('PDV_PedidoItemDescontoPercentu', 'PDV_PedidoItemDescontoPercentu');
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoPercent', 'PDV_PedidoItemAcrescimoPercent');
        $this->adicionaRelacionamento('PDV_PedidoItemValorUnitario', 'PDV_PedidoItemValorUnitario');

        $this->adicionaRelacionamento('PDV_PedidoItemTabela', 'PDV_PedidoItemTabela');
        $this->adicionaRelacionamento('PDV_PedidoItemOrdemImpressao', 'PDV_PedidoItemOrdemImpressao');
        $this->adicionaRelacionamento('PDV_PedidoItemSituacao', 'PDV_PedidoItemSituacao');
        $this->adicionaRelacionamento('PDV_PedidoItemAprovacao', 'PDV_PedidoItemAprovacao');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoCliente', 'PDV_PedidoItemProdutoCliente');
        $this->adicionaRelacionamento('PDV_PedidoItemDataEntrega', 'PDV_PedidoItemDataEntrega');
        $this->adicionaRelacionamento('PDV_PedidoItemProduto', 'PDV_PedidoItemProduto');
        $this->adicionaRelacionamento('PDV_PedidoItemProduto', 'DELX_PRO_Produtos.pro_codigo', false, false);

        $this->adicionaRelacionamento('PDV_PedidoItemProdutoNomeManua', 'PDV_PedidoItemProdutoNomeManua');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoUnidadeMa', 'PDV_PedidoItemProdutoUnidadeMa');
        $this->adicionaRelacionamento('PDV_PedidoItemMovimentaEstoque', 'PDV_PedidoItemMovimentaEstoque');
        $this->adicionaRelacionamento('PDV_PedidoItemGeraFinanceiro', 'PDV_PedidoItemGeraFinanceiro');
        $this->adicionaRelacionamento('PDV_PedidoItemConsideraVenda', 'PDV_PedidoItemConsideraVenda');
        $this->adicionaRelacionamento('PDV_PedidoItemConvCodigo', 'PDV_PedidoItemConvCodigo');
        $this->adicionaRelacionamento('PDV_PedidoItemValorTotal', 'PDV_PedidoItemValorTotal');
        $this->adicionaRelacionamento('PDV_PedidoItemSeqOrdemCompra', 'PDV_PedidoItemSeqOrdemCompra');
        $this->adicionaRelacionamento('PDV_PedidoItemGrade', 'PDV_PedidoItemGrade');
        $this->adicionaRelacionamento('PDV_PedidoItemValorTabela', 'PDV_PedidoItemValorTabela');
        $this->adicionaRelacionamento('PDV_PedidoItemQtdLiberada', 'PDV_PedidoItemQtdLiberada');
        $this->adicionaRelacionamento('PDV_PedidoItemCFOP', 'PDV_PedidoItemCFOP');

        $this->adicionaRelacionamento('PDV_PedidoItemDescontoValor', 'PDV_PedidoItemDescontoValor');
        $this->adicionaRelacionamento('PDV_PedidoItemAcrescimoValor', 'PDV_PedidoItemAcrescimoValor');
        $this->adicionaRelacionamento('PDV_PedidoItemAlm', 'PDV_PedidoItemAlm');
        $this->adicionaRelacionamento('PDV_PedidoItemPosicao', 'PDV_PedidoItemPosicao');
        $this->adicionaRelacionamento('PDV_PedidoItemLote', 'PDV_PedidoItemLote');
        $this->adicionaRelacionamento('PDV_PedidoItemRua', 'PDV_PedidoItemRua');
        $this->adicionaRelacionamento('PDV_PedidoItemDtFabr', 'PDV_PedidoItemDtFabr');
        $this->adicionaRelacionamento('PDV_PedidoItemDtVali', 'PDV_PedidoItemDtVali');
        $this->adicionaRelacionamento('PDV_PedidoItemCerQua', 'PDV_PedidoItemCerQua');
        $this->adicionaRelacionamento('PDV_PedidoItemTipoEmiNF', 'PDV_PedidoItemTipoEmiNF');
        $this->adicionaRelacionamento('PDV_PedidoItemOrdemServicoOS', 'PDV_PedidoItemOrdemServicoOS');

        $this->adicionaRelacionamento('PDV_PedidoItemOrdemServicoNume', 'PDV_PedidoItemOrdemServicoNume');
        $this->adicionaRelacionamento('PDV_PedidoItemOrdemServicoItem', 'PDV_PedidoItemOrdemServicoItem');
        $this->adicionaRelacionamento('PDV_PedidoItemCancelado', 'PDV_PedidoItemCancelado');
        $this->adicionaRelacionamento('PDV_PedidoItemConvQtde', 'PDV_PedidoItemConvQtde');
        $this->adicionaRelacionamento('PDV_PedidoItemValorOriginal', 'PDV_PedidoItemValorOriginal');
        $this->adicionaRelacionamento('PDV_PedidoItemContratoServico', 'PDV_PedidoItemContratoServico');
        $this->adicionaRelacionamento('PDV_PedidoItemDiasEntrega', 'PDV_PedidoItemDiasEntrega');
        $this->adicionaRelacionamento('PDV_PedidoItemAlmOrig', 'PDV_PedidoItemAlmOrig');
        $this->adicionaRelacionamento('PDV_PedidoItemLoteOrig', 'PDV_PedidoItemLoteOrig');
        $this->adicionaRelacionamento('PDV_PedidoItemRuaOrig', 'PDV_PedidoItemRuaOrig');
        $this->adicionaRelacionamento('PDV_PedidoItemPosicaoOrig', 'PDV_PedidoItemPosicaoOrig');
        $this->adicionaRelacionamento('PDV_PedidoItemVlrFaturado', 'PDV_PedidoItemVlrFaturado');
        $this->adicionaRelacionamento('PDV_PedidoItemValorCusto', 'PDV_PedidoItemValorCusto');
        $this->adicionaRelacionamento('PDV_PedidoItemPercentualCusto', 'PDV_PedidoItemPercentualCusto');
        $this->adicionaRelacionamento('PDV_PedidoItemProjeto', 'PDV_PedidoItemProjeto');
        $this->adicionaRelacionamento('PDV_PedidoItemDimGQtd', 'PDV_PedidoItemDimGQtd');
        $this->adicionaRelacionamento('PDV_PedidoItemDimGFormula', 'PDV_PedidoItemDimGFormula');
        $this->adicionaRelacionamento('PDV_PedidoItemDimGExpres', 'PDV_PedidoItemDimGExpres');
        $this->adicionaRelacionamento('PDV_PedidoItemQtdPecas', 'PDV_PedidoItemQtdPecas');

        $this->adicionaRelacionamento('PDV_PedidoItemObsDescricao', 'PDV_PedidoItemObsDescricao');
        $this->adicionaRelacionamento('PDV_PedidoItemObsOF', 'PDV_PedidoItemObsOF');
        $this->adicionaRelacionamento('PDV_PedidoItemPercentualPromoc', 'PDV_PedidoItemPercentualPromoc');
        $this->adicionaRelacionamento('PDV_PedidoItemValorMotagemRate', 'PDV_PedidoItemValorMotagemRate');
        $this->adicionaRelacionamento('PDV_PedidoItemValorFreteAuxRat', 'PDV_PedidoItemValorFreteAuxRat');
        $this->adicionaRelacionamento('PDV_PedidoItemOrdemCompra', 'PDV_PedidoItemOrdemCompra');
        $this->adicionaRelacionamento('PDV_PedidoItemConfigSalvaSeq', 'PDV_PedidoItemConfigSalvaSeq');
        $this->adicionaRelacionamento('PDV_PedidoItemEstruturaNumero', 'PDV_PedidoItemEstruturaNumero');
        $this->adicionaRelacionamento('PDV_PedidoItemEntregaAntecipad', 'PDV_PedidoItemEntregaAntecipad');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoCusto', 'PDV_PedidoItemProdutoCusto');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoMarkup', 'PDV_PedidoItemProdutoMarkup');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoReferenci', 'PDV_PedidoItemProdutoReferenci');
        $this->adicionaRelacionamento('PDV_PedidoItemTipoFornecimento', 'PDV_PedidoItemTipoFornecimento');
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaPadrao', 'PDV_PedidoItemMoedaPadrao');
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaData', 'PDV_PedidoItemMoedaData');
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaValorCotaca', 'PDV_PedidoItemMoedaValorCotaca');
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaValorCotNeg', 'PDV_PedidoItemMoedaValorCotNeg');
        $this->adicionaRelacionamento('PDV_PedidoItemMoedaValor', 'PDV_PedidoItemMoedaValor');
        $this->adicionaRelacionamento('PDV_PedidoItemConfigProcessada', 'PDV_PedidoItemConfigProcessada');

        $this->adicionaRelacionamento('PDV_PedidoItemEspecie', 'PDV_PedidoItemEspecie');
        $this->adicionaRelacionamento('PDV_PedidoItemVolumes', 'PDV_PedidoItemVolumes');
        $this->adicionaRelacionamento('PDV_PedidoItemDescFormulaSeq', 'PDV_PedidoItemDescFormulaSeq');
        $this->adicionaRelacionamento('PDV_PedidoItemDescFormulaExpre', 'PDV_PedidoItemDescFormulaExpre');
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
        $this->adicionaRelacionamento('PDV_PedidoItemTaxaTecnologica', 'PDV_PedidoItemTaxaTecnologica');
        $this->adicionaRelacionamento('PDV_PedidoItemValorTratamento', 'PDV_PedidoItemValorTratamento');
        $this->adicionaRelacionamento('PDV_PedidoItemProdutoImportado', 'PDV_PedidoItemProdutoImportado');
        $this->adicionaRelacionamento('PDV_PedidoItemTabelaFreteKM', 'PDV_PedidoItemTabelaFreteKM');
        $this->adicionaRelacionamento('PDV_PedidoItemFilialDistancia', 'PDV_PedidoItemFilialDistancia');
        $this->adicionaRelacionamento('PDV_PedidoItemFreteUnitario', 'PDV_PedidoItemFreteUnitario');
        $this->adicionaRelacionamento('PDV_PedidoItemDataNegociada', 'PDV_PedidoItemDataNegociada');
        $this->adicionaRelacionamento('PDV_PedidoItemSeqOptyWay', 'PDV_PedidoItemSeqOptyWay');
        $this->adicionaRelacionamento('PDV_PedidoItemDataInclusao', 'PDV_PedidoItemDataInclusao');
        $this->adicionaRelacionamento('PDV_PedidoItemJustificativa', 'PDV_PedidoItemJustificativa');
        $this->adicionaRelacionamento('PDV_PedidoItemMotivo', 'PDV_PedidoItemMotivo');
        $this->adicionaRelacionamento('PDV_PedidoItemValorFreteTabela', 'PDV_PedidoItemValorFreteTabela');
        $this->adicionaRelacionamento('PDV_PedidoItemAlturaComercial', 'PDV_PedidoItemAlturaComercial');
        $this->adicionaRelacionamento('PDV_PedidoItemLarguraComercial', 'PDV_PedidoItemLarguraComercial');
        $this->adicionaRelacionamento('PDV_PedidoItemDescProdComercia', 'PDV_PedidoItemDescProdComercia');

        //campos para uso de campos agregados
        $this->adicionaRelacionamento('insumoCod', 'insumoCod', false, false);
        $this->adicionaRelacionamento('insumoNome', 'insumoNome', false, false);
        $this->adicionaRelacionamento('insumoQt', 'insumoQt', false, false);
        $this->adicionaRelacionamento('insumoVlr', 'insumoVlr', false, false);

        $this->adicionaRelacionamento('servicoCod', 'servicoCod', false, false);
        $this->adicionaRelacionamento('servicoDes', 'servicoDes', false, false);
        $this->adicionaRelacionamento('servicoQt', 'servicoQt', false, false);
        $this->adicionaRelacionamento('servicoVlr', 'servicoVlr', false, false);

        //tipo do model atual
        $this->adicionaRelacionamento('pdv_insserv', 'pdv_insserv', false, false);
        $this->adicionaRelacionamento('op', 'op', false, false);
        $this->adicionaRelacionamento('pesoOp', 'pesoOp', false, false);

        //adiciona o left outer join na tabela de insumos
        $sEnd = 'and pdv_pedidoitem.PDV_PedidoCodigo = steel_pcp_cargainsumoserv.pdv_pedidocodigo
        and pdv_pedidoitem.PDV_PedidoItemSeq = steel_pcp_cargainsumoserv.pdv_pedidoitemseq';




        $this->adicionaJoin('STEEL_PCP_CargaInsumoServ', null, 1, 'pdv_pedidofilial', 'pdv_pedidofilial', $sEnd);
        $this->adicionaJoin('DELX_PRO_Produtos', null, 1, 'PDV_PedidoItemProduto', 'pro_codigo');


        $this->setSTop('1000');
        $this->adicionaOrderBy('pdv_pedidoitemseq', 1);
    }

    /**
     * Retorna o peso pelos insumos
     */
    public function pesoInsumo($aDados) {
        $sSql = "select STEEL_PCP_CargaInsumoServ.pdv_insserv,sum(PDV_PedidoItemQtdPedida)as total 
                from pdv_pedidoitem left outer join STEEL_PCP_CargaInsumoServ
                on pdv_pedidoitem.pdv_pedidofilial = STEEL_PCP_CargaInsumoServ.pdv_pedidofilial
                and pdv_pedidoitem.pdv_pedidocodigo = STEEL_PCP_CargaInsumoServ.pdv_pedidocodigo
                and pdv_pedidoitem.pdv_pedidoitemseq = STEEL_PCP_CargaInsumoServ.pdv_pedidoitemseq
                where pdv_pedidoitem.pdv_pedidofilial = '8993358000174' 
                and pdv_pedidoitem.pdv_pedidocodigo = '" . $aDados[1] . "'
                group by STEEL_PCP_CargaInsumoServ.pdv_insserv";

        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aRetorno[] = $oRowBD;
        }
        return $aRetorno;
    }

    /**
     * Retorna as parcelas 
     */
    public function parcCondPag($aChave) {

        $sSql = "select CPG_Codigo,CPG_NumeroParcela,CPG_DiasParcela
                from cpg_condicaopagamentoparcelas where CPG_Codigo ='" . $aChave[3] . "' 
                order by cpg_condicaopagamentoparcelas.CPG_NumeroParcela ";
        $result = $this->getObjetoSql($sSql);

        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $aRetorno[] = $oRowBD;
        }
        return $aRetorno;
    }

    /**
     * Faz o somatório para o peso bruto e para o peso líquido
     */
    public function pesoCarga($aChave) {
        
    }

    public function alteraOd($sValor, $sFilial, $sCod, $sSeq) {
        $sSql = "update PDV_PEDIDOITEM set pdv_pedidoitemordemcompra = '" . $sValor . "'"
                . " where pdv_pedidofilial= " . $sFilial
                . " and pdv_pedidocodigo = " . $sCod . " "
                . " and pdv_pedidoitemseq = " . $sSeq . " ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function alteraSeqOd($iValor, $sFilial, $sCod, $sSeq) {
        if ($iValor == "") {
            $sSql = "update PDV_PEDIDOITEM set pdv_pedidoitemseqordemcompra = null"
                    . " where pdv_pedidofilial= " . $sFilial
                    . " and pdv_pedidocodigo = " . $sCod . " "
                    . " and pdv_pedidoitemseq = " . $sSeq . "  ";
            $aRetorno = $this->executaSql($sSql);
        } else {
            $sSql = "update PDV_PEDIDOITEM set pdv_pedidoitemseqordemcompra = '" . $iValor . "'"
                    . " where pdv_pedidofilial= " . $sFilial
                    . " and pdv_pedidocodigo = " . $sCod . " "
                    . " and pdv_pedidoitemseq = " . $sSeq . "  ";
            $aRetorno = $this->executaSql($sSql);
        }
        return $aRetorno;
    }

}
