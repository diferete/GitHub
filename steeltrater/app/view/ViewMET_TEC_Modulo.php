<?php

class ViewMET_TEC_Modulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaDropdown(true);
        $this->setUsaAcaoVisualizar(true);


        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModApp = new CampoConsulta('Módulo do App', 'modApp');

        $oDropDown = new Dropdown('Testar Email', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Testar Email', 'MET_TEC_Modulo', 'testarEmail', '', false, '', false, '', false, '', false, false);


        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $this->addFiltro($oModuloF);

        $this->addDropdown($oDropDown);

        $this->addCampos($oCodigo, $oModulo, $oModApp);
    }

    function criaTela() {
        parent::criaTela();

        
        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 4, 4, 4, 4);
        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oModApp = new Campo('Módulo App', 'modApp', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oModApp->addItemSelect('Não', 'Não');
        $oModApp->addItemSelect('Sim', 'Sim');

        $oTeste = new Campo('teste', 'teste', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTeste->setId('testeBalanca');
        $oTeste->setApenasTela(true);


        $this->addCampos(array($oModCod, $oModDescricao), $oTeste, $oLinha, $oModApp, $oLinha);
    }

}
