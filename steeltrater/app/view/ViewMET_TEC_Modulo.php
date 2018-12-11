<?php

class ViewMET_TEC_Modulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

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
        
        $this->setBGravaHistorico(true);

        $this->setTituloTela("Cadastro de Módulos");

        //teste da gravação no banco
        $oMod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 3);
        $oMod->setBCampoBloqueado(true); //quando campo for pk
        $oMod->setBFocus(true);
        
        $oDivisor = new Campo('Divisão', '', Campo::DIVISOR_SUCCESS);
        
        $oModdes = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3);
        $oModdes->addValidacao(true, Validacao::TIPO_STRING, 'Conteúdo Inválido!');

        $oModdes->setBFocus(true);


        $oSelect = new Campo('Campo Select', 'select', Campo::TIPO_SELECT);
        $oSelect->addItemSelect('ac', 'Acre');
        $oSelect->addItemSelect('sc', 'Santa Catarina');



        $oFieldSet = new FieldSet('Módulos');
        $oFieldSet->addCampos($oMod,$oDivisor, $oModdes);

        $this->addCampos($oFieldSet);
    }

}
