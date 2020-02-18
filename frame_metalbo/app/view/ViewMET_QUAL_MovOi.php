<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_QUAL_MovOi extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);

        $oNrOi = new CampoConsulta('Nr', 'nroi');
        $oCorrida = new CampoConsulta('Corrida', 'corrida');

        $this->addCampos($oNrOi, $oCorrida);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
