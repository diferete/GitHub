<?php

class ViewMET_TEC_Modulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();
		
        $this->setUsaDropdown(true);

        $this->setaTiluloConsulta('Pesquisa de Módulos do Sistema');
        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oModulo = new CampoConsulta('Descrição', 'modescricao');

		$oDropDown = new Dropdown('Testar Email', Dropdown::TIPO_PRIMARY, Dropdown::ICON_EMAIL);
        $oDropDown->addItemDropdown($this->addIcone(Base::ICON_EMAIL) . 'Testar Email', 'MET_TEC_Modulo', 'testarEmail', '', false, '',false,'',false,'',false,false);

        $this->addDropdown($oDropDown);

        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

     function criaTela() {
        parent::criaTela();
		
        $oModCod = new Campo('Código','modcod', Campo::TIPO_TEXTO,1,1,12,12);
		$oModCod->setBCampoBloqueado(true);
		
        $oModDescricao = new Campo('Descrição','modescricao',  Campo::TIPO_TEXTO,3,3,12,12);
		
		$this->addCampos(array($oModCod, $oModDescricao));
    }


}
