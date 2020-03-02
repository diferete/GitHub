<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_FIN_VisualizaNFE extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaDropdown(true);
        $this->setUsaFiltro(true);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setBMostraFiltro(true);

        $oFilcgc = new CampoConsulta('Emp.', 'nfsfilcgc');
        $oFilcgc->setBColOculta(true);
        $oNf = new CampoConsulta('Nr. NF', 'nfsnfnro');
        $oNfSerie = new CampoConsulta('Série', 'nfsnfser');
        $oCliNome = new CampoConsulta('Cliente', 'nfsclinome');
        $oNfDtEmiss = new CampoConsulta('Data Emiss.', 'nfsdtemiss', CampoConsulta::TIPO_DATA);

        $oNfEnvEmail = new CampoConsulta('Email', 'NfsEmailEn');
        $oNfEnvEmail->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_LINHA, false, '');
        
        $oFilEMP = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilEMP->setSLabel('');
        $oFilEMP->addItemSelect('', 'Todas');
        $oFilEMP->addItemSelect('75483040000211', 'FILIAL');
        $oFilEMP->addItemSelect('75483040000130', 'REX');

        $oFilNF = new Filtro($oNf, Filtro::CAMPO_TEXTO_IGUAL, 1, 1, 12, 12, false);

        $oFilCliNome = new Filtro($oCliNome, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $oFilData = new Filtro($oNfDtEmiss, Filtro::CAMPO_DATA_ENTRE, 2, 2, 12, 12, false);

        $oDrop1 = new Dropdown('Visualizar Danfe', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Visualizar', $this->getController(), 'acaoMostraRelConsulta', '', false, 'DANFE2', false, '', false, '', false, false);

        $this->addFiltro($oFilEMP, $oFilNF, $oFilCliNome, $oFilData);
        $this->addDropdown($oDrop1);
        $this->addCampos($oNf, $oNfSerie, $oCliNome, $oNfDtEmiss, $oNfEnvEmail, $oFilcgc);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
