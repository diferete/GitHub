<?php

class ViewModulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');

        $oCodigo = new CampoConsulta('Modulo', 'modcod');

        $oModulo = new CampoConsulta('Descrição', 'modescricao');

        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();

        $this->setTituloTela("Cadastro de Módulos");

        $oMod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMod->setBCampoBloqueado(true); //quando campo for pk
        $oMod->setBFocus(true);

        $oModdes = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModdes->addValidacao(false, Validacao::TIPO_STRING, 'Conteúdo Inválido!');
        $oModdes->setBFocus(true);

        $this->addCampos(array($oMod, $oModdes));
    }

}
