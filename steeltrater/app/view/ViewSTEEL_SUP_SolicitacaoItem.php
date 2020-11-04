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

        $oPrioridade = new CampoConsulta('Prioridade', 'SUP_PrioridadeCodigo');

        $oItemUnidade = new CampoConsulta('Unidade', 'SUP_SolicitacaoItemUnidade');

        $this->addCampos($oFilCodigo, $oSeqSol, $oSeqSolItem, $oProCod, $oItemDesc, $oPrioridade, $oItemUnidade);
    }

    function criaGridDetalhe($sIdAba) {
        parent::criaGridDetalhe($sIdAba);

        $this->getOGridDetalhe()->setIAltura(200);

        $oFilCodigo = new CampoConsulta('Empresa', 'FIL_Codigo');

        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');

        $oSeqSolItem = new CampoConsulta('Seq. Item', 'SUP_SolicitacaoItemSeq');

        $oProCod = new CampoConsulta('Codigo', 'PRO_Codigo');

        $oItemDesc = new CampoConsulta('Descricao', 'SUP_SolicitacaoItemDescricao');

        $oPrioridade = new CampoConsulta('Prioridade', 'SUP_PrioridadeCodigo');

        $oItemUnidade = new CampoConsulta('Unidade', 'SUP_SolicitacaoItemUnidade');

        $this->addCamposDetalhe($oFilCodigo, $oSeqSol, $oSeqSolItem, $oProCod, $oItemDesc, $oPrioridade, $oItemUnidade);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe($sIdAba);

        $aDados = $this->getAParametrosExtras();

        $oFilCodigo = new Campo('Empresa', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCodigo->setSValor($aDados[0]);
        $oFilCodigo->setBCampoBloqueado(true);

        $oSeqSol = new Campo('Seq.', 'SUP_SolicitacaoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSol->setSValor($aDados[1]);
        $oSeqSol->setBCampoBloqueado(true);

        $oSeqSolItem = new Campo('Seq.Item', 'SUP_SolicitacaoItemSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSolItem->setBCampoBloqueado(true);

        $oProCod = new Campo('Código', 'PRO_Codigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oProCod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oProCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oItemDesc = new Campo('Descrição', 'SUP_SolicitacaoItemDescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oItemDesc->setSIdPk($oProCod->getId());
        $oItemDesc->setClasseBusca('DELX_PRO_Produtos');
        $oItemDesc->addCampoBusca('pro_codigo', '', '');
        $oItemDesc->addCampoBusca('pro_descricao', '', '');
        $oItemDesc->setSIdTela($this->getTela()->getid());
        $oItemDesc->setBCampoBloqueado(true);
        $oItemDesc->setApenasTela(true);

        $oProCod->setClasseBusca('DELX_PRO_Produtos');
        $oProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oProCod->addCampoBusca('pro_descricao', $oItemDesc->getId(), $this->getTela()->getId());

        $oPrioridade = new Campo('Prioridade', 'SUP_PrioridadeCodigo', Campo::TIPO_SELECT, 2, 2, 12, 12);

        $oItemUnidade = new Campo('Un.Medida', 'SUP_SolicitacaoItemUnidade', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oItemUnidade->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oItemUnidade->setSCampoRetorno('pro_unidademedida', $this->getTela()->getid());
        $oItemUnidade->addValidacao(FALSE, Validacao::TIPO_STRING, '', '2', '2');


        $oBtnConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);

        $sGrid = $this->getOGridDetalhe()->getSId();
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeqSolItem->getId() . ',' . $sGrid . '","' . $oSeqSol->getSValor() . ',' . $oSeqSolItem->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBtnConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oFilCodigo, $oSeqSol, $oSeqSolItem), array($oProCod, $oItemDesc), $oPrioridade, $oItemUnidade);

        $this->addCamposFiltroIni($oSeqSol);
    }

}
