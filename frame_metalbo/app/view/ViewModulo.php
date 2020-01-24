<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
        $this->setUsaDropdown(true);



        $oDrop3 = new Dropdown('Teste', Dropdown::TIPO_DARK);
        //$oDrop3->addItemDropdown($this->addIcone(Base::ICON_LAPIS) . 'Teste', 'Modulo', 'teste', '', false, '', false, '', false, true);


        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oCodigo->setILargura(500);

        $oModulo = new CampoConsulta('Descrição', 'modescricao');
        $oModulo->setILargura(500);



        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);
        $this->addDropdown($oDrop3);
        $this->addCampos($oCodigo, $oModulo);
    }

    function criaTela() {
        parent::criaTela();

        $oTeste = new Campo('Cad. User', 'teste', Campo::TIPO_BOTAO_MOSTRACONSULTA, 1, 1, 12, 12);
        $oTeste->setApenasTela(true);
        $oTeste->setClasseBusca('User');
        $oTeste->setSCampoRetorno('usucodigo', $this->getTela()->getId());

        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '', '2', '15');

        $this->addCampos(array($oModCod, $oModDescricao), $oTeste);
    }

}
