<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');

        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);

        $oModuloCod = new Filtro($oCodigo, Filtro::CAMPO_MONEY, 2, 2, 12, 12, true);
        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 3, 4, 12, 12);

        $this->addFiltro($oModuloCod, $oModuloF);
        $this->addCampos($oCodigo, $oModulo);
    }

    function criaTela() {
        parent::criaTela();


        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Aba Geral');
        $oAbaGeral->setBActive(true);

        $oAbaObs = new AbaTabPanel('Obs.');
        $this->addLayoutPadrao('Aba');


        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '2', '15');

        $oObs = new Campo('Obs', 'obs', Campo::TIPO_TEXTO, 3);


        $oAbaGeral->addCampos(array($oModCod, $oModDescricao));
        $oAbaObs->addCampos($oObs);

        $oTab->addItems($oAbaGeral, $oAbaObs);


        $this->addCampos($oTab);
    }

}
