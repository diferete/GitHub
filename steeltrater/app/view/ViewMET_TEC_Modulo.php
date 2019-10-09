<?php

class ViewMET_TEC_Modulo extends View {

    function __construct() {
        parent::__construct();
    }

    function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Modulo', 'modcod');
        $oModulo = new CampoConsulta('Descrição', 'modescricao');


        $this->addCampos($oCodigo, $oModulo);

        $oModuloF = new Filtro($oModulo, Filtro::CAMPO_TEXTO, 4);
        $this->addFiltro($oModuloF);

        $this->setUsaAcaoVisualizar(true);
    }

    function criaTela() {
        parent::criaTela();


        $oModCod = new Campo('Código', 'modcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oModDescricao = new Campo('Descrição', 'modescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);


        $oVlrUnit = new Campo('Val. Unit.', 'vlrUnit', Campo::TIPO_DECIMAL_COMPOSTO, 1, 1, 12, 12);
        $oVlrUnit->setICasaDecimal(4);

        $this->addCampos(array($oModCod, $oModDescricao), $oVlrUnit);
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

