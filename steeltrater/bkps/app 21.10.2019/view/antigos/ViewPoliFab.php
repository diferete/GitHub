<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPoliFab extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oFabcod = new CampoConsulta('Código', 'fabcod');

        $oCnpj = new CampoConsulta('Cnpj', 'cnpj');

        $oFab = new CampoConsulta('Razão', 'fabdes');

        $oFiltro1 = new Filtro($oFab, Campo::TIPO_TEXTO, 3);
        $this->addFiltro($oFiltro1);

        $this->addCampos($oFabcod, $oCnpj, $oFab);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de Fabricantes');

        $oFabcod = new Campo('Código', 'fabcod', Campo::TIPO_TEXTO, 1);
        $oCnpj = new Campo('Cnpj', 'cnpj', Campo::TIPO_TEXTO, 2);
        $oCnpj->setBCNPJ(true);
        $oFab = new Campo('Razão', 'fabdes', Campo::TIPO_TEXTO, 6);

        $this->addCampos($oFabcod, $oCnpj, $oFab);
    }

}
