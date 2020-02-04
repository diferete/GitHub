<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_EXPORTA_Preco extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setaTiluloConsulta('Consulta de preços do sistema');


        $oProcod = new CampoConsulta('Código', 'Produto.procod', CampoConsulta::TIPO_LARGURA, 15);
        $oPreco = new CampoConsulta('Preço', 'preco', CampoConsulta::TIPO_MONEY);
        $oProdes = new CampoConsulta('Descrição', 'Produto.prodes', CampoConsulta::TIPO_LARGURA, 20);
        $oRevisao = new CampoConsulta('Revisão', 'revisao', CampoConsulta::TIPO_TEXTO);

        $oFiltroDes = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $oFiltroCod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);

        $this->addCampos($oProcod, $oProdes, $oPreco, $oRevisao);
        $this->addFiltro($oFiltroCod, $oFiltroDes);
        $this->setBScrollInf(true);
    }

    public function criaTela() {
        parent::criaTela();

        $oProcod = new Campo('Código.', 'procod', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProcod->setSCorFundo(Campo::FUNDO_AMARELO);

        $oProdes = new campo('Desc. Prod.', 'prodes', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oProdes->setSCorFundo(Campo::FUNDO_AMARELO);
        $oProdes->setSIdPk($oProcod->getId());
        $oProdes->setClasseBusca('Produto');
        $oProdes->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        $oProdes->addCampoBusca('procod', '', '');
        $oProdes->addCampoBusca('prodes', '', '');
        $oProdes->setSIdTela($this->getTela()->getid());
        $oProdes->setApenasTela(true);


        $oProcod->setClasseBusca('Produto');
        $oProcod->setSCampoRetorno('procod', $this->getTela()->getId());
        $oProcod->addCampoBusca('prodes', $oProdes->getId(), $this->getTela()->getId());



        $oPreco = new Campo('Preço', 'preco', Campo::TIPO_MONEY, 1, 1, 12, 12);
        $oRevisao = new Campo('Revisão', 'revisao', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos(array($oProcod, $oProdes), $oPreco, $oRevisao);
    }

}
