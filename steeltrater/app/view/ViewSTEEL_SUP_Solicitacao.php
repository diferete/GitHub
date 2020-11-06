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
        $oSitSol->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, true, 'EM ABERTO');
        $oSitSol->addComparacao('L', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, true, 'LIBERADO');
        $oSitSol->addComparacao('O', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, true, 'EM COMPRAS');
        $oSitSol->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, true, 'CANCELADO');
        $oSitSol->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_BLACK, CampoConsulta::MODO_COLUNA, true, 'ENCERRADO');
        $oSitSol->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'REPROVADO');
        $oSitSol->setBComparacaoColuna(true);

        $oUsuSol = new CampoConsulta('UsuCadastro', 'SUP_SolicitacaoUsuCadastro');

        $oDataHoraSol = new CampoConsulta('Data/Hora', 'SUP_SolicitacaoDataHora', CampoConsulta::TIPO_DATA);

        $oObsSol = new CampoConsulta('Observacao', 'SUP_SolicitacaoObservacao');

        $oObsEntregaSol = new CampoConsulta('ObsEntrega', 'SUP_SolicitacaoObsEntrega');

        $oFilFilCod = new Filtro($oFilCod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);

        $this->addFiltro($oFilFilCod);

        $this->addCampos($oFilCod, $oSeqSol, $oTipoSol, $oSitSol, $oUsuSol, $oDataHoraSol, $oObsSol, $oObsEntregaSol);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oDivisor = new Campo('Informações gerais', 'divisor', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oFilCod = new Campo('Empresa', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCod->setBOculto(true);
        $oFilCod->setSValor($_SESSION['filcgc']);

        $oSeqSol = new Campo('Sequencia', 'SUP_SolicitacaoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSol->setBOculto(true);

        $oDataHoraSol = new Campo('Data e hora', 'SUP_SolicitacaoDataHora', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDataHoraSol->setSValor(date('Y-d-m H:i:s'));
        $oDataHoraSol->setBCampoBloqueado(true);

        $oUsuSol = new Campo('Usuário cadastro', 'SUP_SolicitacaoUsuCadastro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuSol->setSValor($_SESSION['nome']);
        $oUsuSol->setBCampoBloqueado(true);

        $oSitSol = new Campo('Situacção', 'SUP_SolicitacaoSituacao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitSol->setSValor('A');
        $oSitSol->setBOculto(true);

        $oTipoSol = new Campo('Tipo', 'SUP_SolicitacaoTipo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTipoSol->setSValor('E');
        $oTipoSol->setBOculto(true);

        $oDivisor1 = new Campo('Observações', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oObsSol = new Campo('Observação', 'SUP_SolicitacaoObservacao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsSol->setILinhasTextArea(3);

        $oObsEntregaSol = new Campo('Obs. para entrega', 'SUP_SolicitacaoObsEntrega', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsEntregaSol->setILinhasTextArea(3);
        
        $oMrpSol = new Campo('MRP', 'SUP_SolicitacaoMRP', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMrpSol->setSValor(0);
        $oMrpSol->setBOculto(true);

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

            $this->addCampos($oDivisor, array($oFilCod, $oSeqSol, $oDataHoraSol, $oUsuSol), $oSitSol, $oTipoSol, $oDivisor1, array($oObsSol, $oObsEntregaSol), $oMrpSol, $oAcao);
        } else {
            $this->addCampos($oDivisor, array($oFilCod, $oSeqSol, $oDataHoraSol, $oUsuSol, $oSitSol), $oTipoSol, $oDivisor1, array($oObsSol, $oObsEntregaSol), array($oMrpSol));
        }
    }

}
