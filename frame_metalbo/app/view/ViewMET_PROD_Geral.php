<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_PROD_Geral extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);

        $this->setUsaFiltro(true);

        $oProcod = new CampoConsulta('Código', 'procod');
        $oProdes = new CampoConsulta('Descrição', 'prodes');

        $oFilProcod = new Filtro($oProcod, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilProdes = new Filtro($oProdes, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oFilProcod, $oFilProdes);

        $this->addCampos($oProcod, $oProdes);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
