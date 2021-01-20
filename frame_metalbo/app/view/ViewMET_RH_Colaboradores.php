<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_RH_Colaboradores extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaFiltro(true);
        $this->getTela()->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oNumCad = new CampoConsulta('Crachá', 'numcad');
        $oNomFum = new CampoConsulta('Nome', 'nomfun');

        $oFilNumCad = new Filtro($oNumCad, Filtro::CAMPO_TEXTO, 1, 1, 12, 12);
        $oFilNomFum = new Filtro($oNomFum, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $this->addFiltro($oFilNumCad, $oFilNomFum);
        $this->addCampos($oNumCad, $oNomFum);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
