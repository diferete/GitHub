<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewProduto extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        // $this->setaTiluloConsulta('Consulta Produtos');
        $oProcod = new CampoConsulta('Código', 'procod', CampoConsulta::TIPO_LARGURA, 20);

        $oProdes = new CampoConsulta('Descrição', 'prodes', CampoConsulta::TIPO_LARGURA, 20);

        $FiltroProcod = new Filtro($oProcod, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $FiltroProdes = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);


        $this->addFiltro($FiltroProcod, $FiltroProdes);
        $this->addCampos($oProcod, $oProdes, $oUn);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
