<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_ISO_Treinamentos extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oNr = new CampoConsulta('Nr.', 'nr');
        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oCracha = new CampoConsulta('Crachá', 'cracha');
        $oNome = new CampoConsulta('Colaborador', 'nome');
        $oSit = new CampoConsulta('Sit', 'situacao');
        $oSetor = new CampoConsulta('Setor', 'descsetor');
        $oFuncao = new CampoConsulta('Função', 'funcao');

        $oFilNr = new Filtro($oNr, Filtro::CAMPO_INTEIRO);
        $oFilFilcgc = new Filtro($oFilcgc, Filtro::CAMPO_INTEIRO);
        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_TEXTO);


        $oFilSetor = new Filtro($oSetor, Filtro::CAMPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oFilSetor->setSClasseBusca('Setor');
        $oFilSetor->setSCampoRetorno('descsetor', $this->getTela()->getSId());
        $oFilSetor->setSIdTela($this->getTela()->getSId());
        
        $oFilFuncao = new Filtro($oSetor, Filtro::CAMPO_BUSCADOBANCOPK, 3, 3, 12, 12);
        $oFilFuncao->setSClasseBusca('MET_RH_FuncaoSetor');
        $oFilFuncao->setSCampoRetorno('descfunc', $this->getTela()->getSId());
        $oFilFuncao->setSIdTela($this->getTela()->getSId());
        


        $this->addFiltro($oFilNr, $oFilFilcgc, $oFilCracha,$oFilSetor,$oFilFuncao);

        $this->addCampos($oNr, $oFilcgc, $oCracha, $oNome, $oSetor, $oFuncao, $oSit);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();


        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($_SESSION['filcgc']);

        $oUser = new Campo('Usuário', 'usuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUser->setSValor($_SESSION['nome']);

        $oCracha = new Campo('Crachá', 'cracha', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oNome = new Campo('Colaborador', 'nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oSit = new Campo('Sit', 'situacao', Campo::CAMPO_SELECTSIMPLE, 1, 1, 12, 12);
        $oSit->addItemSelect('Ativo', 'Ativo');
        $oSit->addItemSelect('Inativo', 'Inativo');

        $oCodSetor = new Campo('', 'codsetor', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodSetor->setApenasTela(true);
        $oCodSetor->setBOculto(true);

        $oDescSetor = new Campo('Setor', 'descsetor', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDescSetor->setSIdPk($oCodSetor->getId());
        $oDescSetor->setClasseBusca('Setor');
        $oDescSetor->addCampoBusca('codsetor', '', '');
        $oDescSetor->addCampoBusca('descsetor', '', '');
        $oDescSetor->setSIdTela($this->getTela()->getid());

        $oCodSetor->setClasseBusca('Setor');
        $oCodSetor->setSCampoRetorno('codsetor', $this->getTela()->getId());
        $oCodSetor->addCampoBusca('descsetor', $oDescSetor->getId(), $this->getTela()->getId());



        $oFuncao = new Campo('Função', 'funcao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCracha->addEvento(Campo::EVENTO_SAIR, 'requestAjax("' . $this->getTela()->getid() . '-form","MET_ISO_Treinamentos","buscaDadosFunc","' . $oNome->getId() . ',' . $oSit->getId() . ',' . $oDescSetor->getId() . ',' . $oFuncao->getId() . '");');



        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Colaborador', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Registros de Treinamento', false, $this->addIcone(Base::ICON_CONFIRMAR));


        $this->addEtapa($oEtapas);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {
            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }$this->setSIdControleUpAlt($oAcao->getId());
            $this->addCampos(array($oNr, $oFilcgc, $oUser), $oCracha, array($oNome, $oDescSetor, $oFuncao, $oSit), $oAcao);
        } else {
            $this->addCampos(array($oNr, $oFilcgc, $oUser), $oCracha, array($oNome, $oDescSetor, $oFuncao, $oSit));
        }
    }

}
