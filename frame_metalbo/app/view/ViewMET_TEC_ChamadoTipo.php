<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_ChamadoTipo extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oTipo = new CampoConsulta('Tipo', 'tipo');
        $oSubtipo = new CampoConsulta('Subtipo', 'subtipo');
        $oSubtipoNome = new CampoConsulta('Descrição', 'subtipo_nome');

        $this->addCampos($oTipo, $oSubtipo, $oSubtipoNome);
    }

    public function criaTela() {
        parent::criaTela();


        $oTipo = new Campo('Tipo', 'tipo', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTipo->addItemSelect('1', 'HARDWARE');
        $oTipo->addItemSelect('2', 'SOFTWARE');
        $oTipo->addItemSelect('3', 'SERVIÇOS');
        
        $oSubtipo = new Campo('Subtipo', 'subtipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        
        $oSubtipoNome = new Campo('Descrição', 'subtipo_nome', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos($oTipo, $oSubtipo, $oSubtipoNome);
    }

}
