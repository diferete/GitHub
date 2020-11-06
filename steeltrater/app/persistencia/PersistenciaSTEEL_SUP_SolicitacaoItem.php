<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_SolicitacaoItem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('sup_solicitacaoitem');

        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoSeq', 'SUP_SolicitacaoSeq', true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoItemSeq', 'SUP_SolicitacaoItemSeq', true, true, true);
        $this->adicionaRelacionamento('PRO_Codigo', 'PRO_Codigo');
        $this->adicionaRelacionamento('SUP_PrioridadeCodigo', 'SUP_PrioridadeCodigo');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDescricao', 'SUP_SolicitacaoItemDescricao');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemUnidade', 'SUP_SolicitacaoItemUnidade');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimPecas', 'SUP_SolicitacaoItemDimPecas');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimComprime', 'SUP_SolicitacaoItemDimComprime');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimLargura', 'SUP_SolicitacaoItemDimLargura');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimEspessur', 'SUP_SolicitacaoItemDimEspessur');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemComQtd', 'SUP_SolicitacaoItemComQtd');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemComConv', 'SUP_SolicitacaoItemComConv');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemComUnd', 'SUP_SolicitacaoItemComUnd');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemQtd', 'SUP_SolicitacaoItemQtd');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDataNecessi', 'SUP_SolicitacaoItemDataNecessi');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemUsuSol', 'SUP_SolicitacaoItemUsuSol');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemUsuCom', 'SUP_SolicitacaoItemUsuCom');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemObservacao', 'SUP_SolicitacaoItemObservacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemReferencia', 'SUP_SolicitacaoItemReferencia');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemValor', 'SUP_SolicitacaoItemValor');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemPesoLiq', 'SUP_SolicitacaoItemPesoLiq');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemPesoBru', 'SUP_SolicitacaoItemPesoBru');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimUnidade', 'SUP_SolicitacaoItemDimUnidade');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDataAprVerb', 'SUP_SolicitacaoItemDataAprVerb');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemValorTotal', 'SUP_SolicitacaoItemValorTotal');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemSituacao', 'SUP_SolicitacaoItemSituacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemGrade', 'SUP_SolicitacaoItemGrade');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemTipoDespCod', 'SUP_SolicitacaoItemTipoDespCod');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemCCTCodigo', 'SUP_SolicitacaoItemCCTCodigo');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemPlano', 'SUP_SolicitacaoItemPlano');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemConta', 'SUP_SolicitacaoItemConta');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemProjeto', 'SUP_SolicitacaoItemProjeto');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemOriTipo', 'SUP_SolicitacaoItemOriTipo');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemOriNumero', 'SUP_SolicitacaoItemOriNumero');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemOriItem', 'SUP_SolicitacaoItemOriItem');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemConversor', 'SUP_SolicitacaoItemConversor');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimConv', 'SUP_SolicitacaoItemDimConv');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimUndConv', 'SUP_SolicitacaoItemDimUndConv');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimGQtd', 'SUP_SolicitacaoItemDimGQtd');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimGFormula', 'SUP_SolicitacaoItemDimGFormula');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDimGExpres', 'SUP_SolicitacaoItemDimGExpres');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemDataEntrega', 'SUP_SolicitacaoItemDataEntrega');
        $this->adicionaRelacionamento('SUP_SolicitacaoItemPosicao', 'SUP_SolicitacaoItemPosicao');

        $this->adicionaOrderBy('SUP_SolicitacaoItemSeq', 1);

        $this->setSTop(50);
    }

    public function buscaDadosUnidade($aDados) {
        $sSql = "select PRO_UnidadeMedida from pro_produto where pro_codigo = " . $aDados['PRO_Codigo'] . "";

        $oObj = $this->consultaSql($sSql);

        return $oObj;
    }

}
