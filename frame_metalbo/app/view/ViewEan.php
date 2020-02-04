<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewEan extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setaTiluloConsulta('Consulta de códigos de barra');

        $oEan = new CampoConsulta('Ean', 'ean', CampoConsulta::TIPO_LARGURA, 20);
        $oProcod = new CampoConsulta('Código', 'Produto.procod', CampoConsulta::TIPO_LARGURA, 20);
        $oProdes = new CampoConsulta('Descrição', 'Produto.prodes', CampoConsulta::TIPO_LARGURA, 20);
        $oQt = new CampoConsulta('Peças', 'pcs', CampoConsulta::TIPO_LARGURA, 20);


        $oFiltroDes = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);
        $oFiltroProcod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oFiltroEan = new Filtro($oEan, Filtro::CAMPO_TEXTO_IGUAL, 4, 4, 12, 12, false);

        $this->addCampos($oEan, $oQt, $oProcod, $oProdes);
        $this->addFiltro($oFiltroProcod, $oFiltroEan, $oFiltroDes);

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
    }

}
