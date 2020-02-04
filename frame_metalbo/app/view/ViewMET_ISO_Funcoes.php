<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_Funcoes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);

        $oNr = new CampoConsulta('Nr', 'nr', CampoConsulta::TIPO_TEXTO);

        $oFilcgc = new CampoConsulta('Empresa', 'filcgc', CampoConsulta::TIPO_TEXTO);

        $oCodSetor = new CampoConsulta('Cód. Setor', 'codsetor', CampoConsulta::TIPO_TEXTO);

        $oDescSetor = new CampoConsulta('Setor', 'descsetor', CampoConsulta::TIPO_TEXTO);

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilSetor = new Filtro($oDescSetor, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $this->addFiltro($oFilNr, $oFilSetor);

        $this->addCampos($oNr, $oFilcgc, $oCodSetor, $oDescSetor);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setSValor($_SESSION['nome']);

        $oCodSetor = new Campo('Cód. Setor', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodSetor->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodSetor->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCodSetor->setBFocus(true);
        $oCodSetor->setSCorFundo(Campo::FUNDO_AMARELO);

        $oDescSetor = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oDescSetor->setSIdPk($oCodSetor->getId());
        $oDescSetor->setClasseBusca('Setor');
        $oDescSetor->addCampoBusca('codsetor', '', '');
        $oDescSetor->addCampoBusca('descsetor', '', '');
        $oDescSetor->setSIdTela($this->getTela()->getid());
        $oDescSetor->setITamanho(Campo::TAMANHO_PEQUENO);
        $oDescSetor->setSCorFundo(Campo::FUNDO_AMARELO);

        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('descsetor', $oDescSetor->getId(), $this->getTela()->getId());

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro do setor', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Descrição de funções', false, $this->addIcone(Base::ICON_CONFIRMAR));

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

            $this->addCampos(array($oNr, $oFilcgc, $oUser), array($oCodSetor, $oDescSetor), $oAcao);
        } else {
            $this->addCampos(array($oNr, $oFilcgc, $oUser), array($oCodSetor, $oDescSetor));
        }
    }

}
