<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Grafico extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Grafico');
    }

    public function relChamados($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorioGrafico($renderTo, 'relChamados');
    }

    public function graficoChamadoss() {
        
    }

}
