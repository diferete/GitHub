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
            
        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();

        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModCod->setBCampoBloqueado(true);

        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oModDescricao->addValidacao(false, Validacao::TIPO_STRING, '', '2', '15');

        $this->addCampos(array($oModCod, $oModDescricao));
    }

}
