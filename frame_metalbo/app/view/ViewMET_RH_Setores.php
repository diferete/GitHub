<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_RH_Setores extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);


        $oCodCcu = new CampoConsulta('Cod. setor', 'codccu');
        $oNomCcu = new CampoConsulta('Setor', 'nomccu');

        $this->addCampos($oCodCcu, $oNomCcu);
    }

}
