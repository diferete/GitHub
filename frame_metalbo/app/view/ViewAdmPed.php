<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewAdmPed extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oData = new CampoConsulta('Data', 'data');
        $oNr = new CampoConsulta('Nr.Ped', 'nr');
        $oPeso = new CampoConsulta('Peso', 'peso', CampoConsulta::TIPO_DECIMAL);
        $oAcumula = new CampoConsulta('Acumulado Peso', 'contpeso', CampoConsulta::TIPO_DECIMAL);
        $oValor = new CampoConsulta('Valor', 'vlr', CampoConsulta::TIPO_MONEY);
        // $ipi = new CampoConsulta('IPI', 'ipi', CampoConsulta::TIPO_MONEY);
        $VlrComIpi = new CampoConsulta('Valor C/Ipi', 'vlrcomipi', CampoConsulta::TIPO_MONEY);
        $oAcumulaVlr = new CampoConsulta('Acumulado Vlr', 'contvlr', CampoConsulta::TIPO_MONEY);
        $oMedSipi = new CampoConsulta('Média S/Ipi', 'mediaSipi', CampoConsulta::TIPO_MONEY);
        $oMedCipi = new CampoConsulta('Média C/Ipi', 'mediaCipi', CampoConsulta::TIPO_MONEY);

        $this->addCampos($oData, $oNr, $oPeso, $oAcumula, $oValor, $VlrComIpi, $oAcumulaVlr, $oMedSipi, $oMedCipi);

        $oDataFiltro = new Filtro($oData, Filtro::CAMPO_DATA_ENTRE, 2);
        $oDataFiltro->addFiltroValor(Util::getPrimeiroDiaMes());
        $oDataFiltro->addFiltroValor(Util::getDataAtual());
        $this->addFiltro($oDataFiltro);

        $this->setUsaDropdown(true);
        $oDrop1 = new Dropdown('Ped Mobile', Dropdown::TIPO_INFO);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_CONFIG) . 'Pedidos Mobile', 'AdmPed', 'getPedidos', '', false);

        $this->addDropdown($oDrop1);

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
    }

}
