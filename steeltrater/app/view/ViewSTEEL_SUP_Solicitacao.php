<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_SUP_Solicitacao extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);

        $oFilCod = new CampoConsulta('Empresa', 'FIL_Codigo');
        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');
        $oTipoSol = new CampoConsulta('Tipo', 'SUP_SolicitacaoTipo');
        $oSitSol = new CampoConsulta('Situacao', 'SUP_SolicitacaoSituacao');
        $oUsuSol = new CampoConsulta('UsuCadastro', 'SUP_SolicitacaoUsuCadastro');
        $oDataHoraSol = new CampoConsulta('Data/Hora', 'SUP_SolicitacaoDataHora');
        $oObsSol = new CampoConsulta('Observacao', 'SUP_SolicitacaoObservacao');
        $oObsEntregaSol = new CampoConsulta('ObsEntrega', 'SUP_SolicitacaoObsEntrega');

        $oFilFilCod = new Filtro($oFilCod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        
        $this->addFiltro($oFilFilCod);

        $this->addCampos($oFilCod, $oSeqSol, $oTipoSol, $oSitSol, $oUsuSol, $oDataHoraSol, $oObsSol, $oObsEntregaSol);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oFilCod = new Campo('FIL_Codigo', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCod->setBCampoBloqueado(true);
        $oFilCod->setSValor($_SESSION['filcgc']);

        $oSeqSol = new Campo('SUP_SolicitacaoSeq', 'SUP_SolicitacaoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSol->setBCampoBloqueado(true);

        $oDataHoraSol = new Campo('SUP_SolicitacaoDataHora', 'SUP_SolicitacaoDataHora', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDataHoraSol->setSValor(date('Y-d-m H:i:s'));
        $oDataHoraSol->setBCampoBloqueado(true);

        $oUsuSol = new Campo('SUP_SolicitacaoUsuCadastro', 'SUP_SolicitacaoUsuCadastro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuSol->setSValor($_SESSION['nome']);
        $oUsuSol->setBCampoBloqueado(true);

        $oSitSol = new Campo('SUP_SolicitacaoSituacao', 'SUP_SolicitacaoSituacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitSol->setSValor('A');
        $oSitSol->setBCampoBloqueado(true);

        $oTipoSol = new Campo('SUP_SolicitacaoTipo', 'SUP_SolicitacaoTipo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoSol->addItemSelect('E', 'E');

        $oObsSol = new Campo('SUP_SolicitacaoObservacao', 'SUP_SolicitacaoObservacao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oObsEntregaSol = new Campo('SUP_SolicitacaoObsEntrega', 'SUP_SolicitacaoObsEntrega', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oFaseAprSol = new Campo('SUP_SolicitacaoFaseApr', 'SUP_SolicitacaoFaseApr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFaseAprSol->setSValor(1);

        $oMrpSol = new Campo('SUP_SolicitacaoMRP', 'SUP_SolicitacaoMRP', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oMrpSol->setSValor(0);

        $oUsuAprovadorSol = new Campo('SUP_SolicitacaoUsuAprovador', 'SUP_SolicitacaoUsuAprovador', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCCTCodSol = new Campo('SUP_SolicitacaoCCTCod', 'SUP_SolicitacaoCCTCod', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCCTCodSol->setSValor(0);

        $oDataCancSol = new Campo('SUP_SolicitacaoDataCanc', 'SUP_SolicitacaoDataCanc', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oUsuCancSol = new Campo('SUP_SolicitacaoUsuCanc', 'SUP_SolicitacaoUsuCanc', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro de solicitação', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens da solicitação', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {

            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());

            $this->addCampos(array($oFilCod, $oSeqSol,$oDataHoraSol), $oAcao);
        } else {
            $this->addCampos(array($oFilCod, $oSeqSol));
        }
    }

}
