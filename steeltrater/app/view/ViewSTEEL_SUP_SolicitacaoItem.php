<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_SUP_SolicitacaoItem extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilCodigo = new CampoConsulta('Empresa', 'FIL_Codigo');

        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');

        $oSeqSolItem = new CampoConsulta('Seq. Item', 'SUP_SolicitacaoItemSeq');

        $oProCod = new CampoConsulta('Codigo', 'PRO_Codigo');

        $oItemDesc = new CampoConsulta('Descricao', 'SUP_SolicitacaoItemDescricao');

        $oItemQnt = new CampoConsulta('Qnt.', 'SUP_SolicitacaoItemComQtd', CampoConsulta::TIPO_DECIMAL);
        $oItemQnt->setICasaDecimal(0);

        $oPrioridade = new CampoConsulta('Prioridade', 'SUP_PrioridadeCodigo');

        $oItemUnidade = new CampoConsulta('Unidade', 'SUP_SolicitacaoItemUnidade');

        $this->addCampos($oFilCodigo, $oSeqSol, $oSeqSolItem, $oProCod, $oItemDesc, $oItemQnt, $oPrioridade, $oItemUnidade);
    }

    function criaGridDetalhe($sIdAba) {
        parent::criaGridDetalhe($sIdAba);

        $this->getOGridDetalhe()->setIAltura(200);

        $oFilCodigo = new CampoConsulta('Empresa', 'FIL_Codigo');

        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');

        $oSeqSolItem = new CampoConsulta('Seq. Item', 'SUP_SolicitacaoItemSeq');

        $oProCod = new CampoConsulta('Codigo', 'PRO_Codigo');

        $oItemDesc = new CampoConsulta('Descricao', 'SUP_SolicitacaoItemDescricao');

        $oItemQnt = new CampoConsulta('Qnt.', 'SUP_SolicitacaoItemComQtd');

        $oPrioridade = new CampoConsulta('Prioridade', 'SUP_PrioridadeCodigo');

        $oItemUnidade = new CampoConsulta('Unidade', 'SUP_SolicitacaoItemUnidade');

        $this->addCamposDetalhe($oFilCodigo, $oSeqSol, $oSeqSolItem, $oProCod, $oItemDesc, $oItemQnt, $oPrioridade, $oItemUnidade);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }


        $this->criaGridDetalhe($sIdAba);
        $aDadosPrioridade = $this->getOObjTela();

        $aDados = $this->getAParametrosExtras();

        $oFilCodigo = new Campo('Empresa', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCodigo->setSValor($aDados[0]);
        $oFilCodigo->setBCampoBloqueado(true);

        $oSeqSol = new Campo('Seq.', 'SUP_SolicitacaoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSol->setSValor($aDados[1]);
        $oSeqSol->setBCampoBloqueado(true);

        $oSeqSolItem = new Campo('Seq.Item', 'SUP_SolicitacaoItemSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSolItem->setBCampoBloqueado(true);

        $oProCod = new Campo('Código', 'PRO_Codigo', Campo::TIPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oProCod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oProCod->setBFocus(true);

        $oItemDesc = new Campo('Descrição', 'SUP_SolicitacaoItemDescricao', Campo::TIPO_BUSCADOBANCO, 5, 5, 12, 12);
        $oItemDesc->setSIdPk($oProCod->getId());
        $oItemDesc->setClasseBusca('DELX_PRO_Produtos');
        $oItemDesc->addCampoBusca('pro_codigo', '', '');
        $oItemDesc->addCampoBusca('pro_descricao', '', '');
        $oItemDesc->setSIdTela($this->getTela()->getid());

        $oProCod->setClasseBusca('DELX_PRO_Produtos');
        $oProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oProCod->addCampoBusca('pro_descricao', $oItemDesc->getId(), $this->getTela()->getId());

        $oItemUnidade = new Campo('Un.Medida', 'SUP_SolicitacaoItemUnidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oItemUnidade->setBCampoBloqueado(true);

        $oQuantItem = new Campo('Quantidade', 'SUP_SolicitacaoItemComQtd', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oQuantItem->setSCorFundo(Campo::FUNDO_AMARELO);
        $oQuantItem->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', '1');

        $oLinha = new campo('', 'linha', Campo::TIPO_LINHA);
        $oLinha->setApenasTela(true);

        $oPrioridade = new Campo('Prioridade', 'SUP_PrioridadeCodigo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        foreach ($aDadosPrioridade as $key => $oPrioridadeVal) {
            $oPrioridade->addItemSelect($oPrioridadeVal->sup_prioridadecodigo, $oPrioridadeVal->sup_prioridadedescricao);
        }

        $oProCod->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","STEEL_SUP_SolicitacaoItem","buscaDadosProd","' . $oItemUnidade->getId() . '");');
        $oItemDesc->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","STEEL_SUP_SolicitacaoItem","buscaDadosProd","' . $oItemUnidade->getId() . '");');

        $oDataNecessidade = new campo('Dt da necessidade', 'SUP_SolicitacaoItemDataNecessi', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataNecessidade->setSValor(date('d/m/Y', strtotime('+5 days')));

        $oDataEntrega = new Campo('Dt de entrega', 'SUP_SolicitacaoItemDataEntrega', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataEntrega->setSValor(date('d/m/Y', strtotime('+15 days')));

        $oUsuSol = new Campo('Solicitante', 'SUP_SolicitacaoItemUsuSol', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuSol->setBCampoBloqueado(true);
        $oUsuSol->setSValor($_SESSION['nomedelsoft']);

        $oUsuComprador = new Campo('Usuário comprador', 'SUP_SolicitacaoItemUsuCom', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oUsuComprador->setSValor('Amanda.Pisetta');
        $oUsuComprador->setBCampoBloqueado(true);

        $oObsItem = new Campo('Observação', 'SUP_SolicitacaoItemObservacao', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oObsItem->setILinhasTextArea(3);

        $oTipoDespesa = new Campo('Tipo de despesa', 'SUP_SolicitacaoItemTipoDespCod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oTipoDespesa->setSIdHideEtapa($this->getSIdHideEtapa());
        $oTipoDespesa->setSValor('649');
        $oTipoDespesa->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oDespDesc = new Campo('Descrição', 'tipodespesa', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDespDesc->setSIdPk($oTipoDespesa->getId());
        $oDespDesc->setClasseBusca('DELX_TDS_TipoDespesa');
        $oDespDesc->addCampoBusca('tds_codigo', '', '');
        $oDespDesc->addCampoBusca('tds_descricao', '', '');
        $oDespDesc->setSIdTela($this->getTela()->getid());
        $oDespDesc->setBCampoBloqueado(true);
        $oDespDesc->setApenasTela(true);

        $oTipoDespesa->setClasseBusca('DELX_TDS_TipoDespesa');
        $oTipoDespesa->setSCampoRetorno('tds_codigo', $this->getTela()->getId());
        $oTipoDespesa->addCampoBusca('tds_descricao', $oDespDesc->getId(), $this->getTela()->getId());

        $oSitItem = new Campo('Usuário comprador', 'SUP_SolicitacaoItemSituacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSitItem->setSValor('A');
        $oSitItem->setBOculto(true);

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->setIMarginTop(6);

        $sGrid = $this->getOGridDetalhe()->getSId();
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeqSolItem->getId() . ',' . $sGrid . ',' . $oProCod->getId() . '","' . $aDados[0] . ',' . $oSeqSol->getSValor() . ',' . $oSeqSolItem->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos(array($oFilCodigo, $oSeqSol, $oSeqSolItem), array($oProCod, $oItemDesc, $oItemUnidade, $oQuantItem), $oLinha, array($oPrioridade, $oDataNecessidade, $oDataEntrega), $oLinha, array($oTipoDespesa, $oDespDesc), $oLinha, array($oUsuSol, $oUsuComprador), $oObsItem, $oSitItem);
        } else {
            $this->addCampos(array($oFilCodigo, $oSeqSol, $oSeqSolItem), array($oProCod, $oItemDesc, $oItemUnidade, $oQuantItem), $oLinha, array($oPrioridade, $oDataNecessidade, $oDataEntrega), $oLinha, array($oTipoDespesa, $oDespDesc), $oLinha, array($oUsuSol, $oUsuComprador), $oObsItem, $oBotConf, $oSitItem);
        }
        $this->addCamposFiltroIni($oSeqSol);
    }

}
