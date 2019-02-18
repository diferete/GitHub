<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaDropdown(true);

        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);

        $oDropDown = new Dropdown('Testar Email', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Testar Email', 'Modulo', 'testarEmail', '', false, '', false, '', false, '', false, false);

        $this->addDropdown($oDropDown);
        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();



        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Cadastro');
        $oAbaGeral->setBActive(true);
        $this->addLayoutPadrao('Aba');




        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '', '2', '15');

        $oBotaoGrupo = new Campo('Add Grupo', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoGrupo = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo");';
        $oBotaoGrupo->getOBotao()->addAcao($sAcaoGrupo);

        $oBotaoXML = new Campo('XML', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoXML = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","converteXML");';
        $oBotaoXML->getOBotao()->addAcao($sAcaoXML);

        $oBotaoPlaca = new Campo('PLACA', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoPlaca = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","inserePlaca");';
        $oBotaoPlaca->getOBotao()->addAcao($sAcaoPlaca);

        $oBotaoGrupo2 = new Campo('Add Grupo 2', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoGrupo2 = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","insereGrupo2");';
        $oBotaoGrupo2->getOBotao()->addAcao($sAcaoGrupo2);

        $oBotaoExpira = new Campo('Expira', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sAcaoExpira = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","expiraProd");';
        $oBotaoExpira->getOBotao()->addAcao($sAcaoExpira);

        $oAbaGeral->addCampos(array($oModCod, $oModDescricao), $oBotaoExpira);

        $oTab->addItems($oAbaGeral);


        $this->addCampos($oTab);
    }

}
