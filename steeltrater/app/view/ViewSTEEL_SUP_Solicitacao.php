<?php

/* 
 *  
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
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oFilCod = new CampoConsulta('CNPJ', 'FIL_Codigo');

        $oSeqSol = new CampoConsulta('Seq.', 'SUP_SolicitacaoSeq');

        $oBotaoLiberaSol = new CampoConsulta('', '', CampoConsulta::TIPO_ACAO);
        $oBotaoLiberaSol->setSTitleAcao('Liberar Solicitação para Compras!');
        $oBotaoLiberaSol->addAcao('STEEL_SUP_Solicitacao', 'msgLiberarSol', '', '');
        $oBotaoLiberaSol->setBHideTelaAcao(true);

        $oTipoSol = new CampoConsulta('Tipo', 'SUP_SolicitacaoTipo');

        $oSitSol = new CampoConsulta('Situacao', 'SUP_SolicitacaoSituacao');
        $oSitSol->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROXO, CampoConsulta::MODO_COLUNA, true, 'EM ABERTO');
        $oSitSol->addComparacao('M', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_COLUNA, true, 'EM MONTAGEM');
        $oSitSol->addComparacao('L', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_COLUNA, true, 'LIBERADO');
        $oSitSol->addComparacao('O', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, true, 'EM COMPRAS');
        $oSitSol->addComparacao('D', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VDCLARO, CampoConsulta::MODO_COLUNA, true, 'COMPRADA PARCIAL');
        $oSitSol->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_ROSA, CampoConsulta::MODO_COLUNA, true, 'CANCELADO');
        $oSitSol->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_BLACK, CampoConsulta::MODO_COLUNA, true, 'ENCERRADO');
        $oSitSol->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_COLUNA, true, 'REPROVADO');
        $oSitSol->setBComparacaoColuna(true);

        $oUsuSol = new CampoConsulta('UsuCadastro', 'SUP_SolicitacaoUsuCadastro');

        $oDataHoraSol = new CampoConsulta('Data', 'SUP_SolicitacaoDataHora', CampoConsulta::TIPO_DATA);

        $oObsSol = new CampoConsulta('Observacao', 'SUP_SolicitacaoObservacao');

        //$oObsEntregaSol = new CampoConsulta('ObsEntrega', 'SUP_SolicitacaoObsEntrega');

        $oFilData = new Filtro($oDataHoraSol, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oFilUsuSol = new Filtro($oUsuSol, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);

        $oFilSitSol = new Filtro($oSitSol, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilSitSol->addItemSelect('', 'TODOS');
        $oFilSitSol->addItemSelect('A', 'EM ABERTO');
        $oFilSitSol->addItemSelect('L', 'LIBERADO');
        $oFilSitSol->addItemSelect('O', 'EM COMPRAS');
        $oFilSitSol->addItemSelect('C', 'CANCELADO');
        $oFilSitSol->addItemSelect('E', 'ENCERRADO');
        $oFilSitSol->addItemSelect('R', 'REPROVADO');

        $this->addFiltro($oFilData, $oFilUsuSol, $oFilSitSol);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Imprimir', Dropdown::TIPO_SUCESSO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMAGEM) . 'Visualizar', 'STEEL_SUP_Solicitacao', 'acaoMostraRelEspecifico', '', false, 'OpSteel1', false, '', false, '', true, false);
        $this->addDropdown($oDrop1);

        $this->addCampos($oFilCod, $oSeqSol, $oBotaoLiberaSol, $oTipoSol, $oSitSol, $oUsuSol, $oDataHoraSol, $oObsSol);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oDivisor = new Campo('Informações gerais', 'divisor', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oFilCod = new Campo('Empresa', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCod->setBOculto(true);
        $oFilCod->setSValor('8993358000174');

        $oSeqSol = new Campo('Sequencia', 'SUP_SolicitacaoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeqSol->setBOculto(true);

        $oDataHoraSol = new Campo('Data', 'SUP_SolicitacaoDataHora', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDataHoraSol->setSValor(date('d/m/Y H:i:s'));
        $oDataHoraSol->setBCampoBloqueado(true);

        $oUsuSol = new Campo('Usuário cadastro', 'SUP_SolicitacaoUsuCadastro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuSol->setSValor($_SESSION['nomedelsoft']);
        $oUsuSol->setBCampoBloqueado(true);

        $oDivisor1 = new Campo('Observações', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oObsSol = new Campo('Observação', 'SUP_SolicitacaoObservacao', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsSol->setILinhasTextArea(3);

        $oObsEntregaSol = new Campo('Obs. para entrega', 'SUP_SolicitacaoObsEntrega', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObsEntregaSol->setILinhasTextArea(3);

        $oDataCancelada = new Campo('', 'SUP_SolicitacaoDataCanc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCancelada->setSValor(date('01/01/1753'));
        $oDataCancelada->setBOculto(true);

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

            $this->addCampos($oDivisor, array($oFilCod, $oSeqSol, $oDataHoraSol, $oUsuSol, $oDataCancelada), $oDivisor1, array($oObsSol, $oObsEntregaSol), $oAcao);
        } else {
            $this->addCampos($oDivisor, array($oFilCod, $oSeqSol, $oDataHoraSol, $oUsuSol, $oDataCancelada), $oDivisor1, array($oObsSol, $oObsEntregaSol));
        }
    }

}
