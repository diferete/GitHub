<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewSTEEL_CCT_CentroCustoFilial
 *
 * @author Alexandre
 */
class ViewSTEEL_CCT_CentroCustoFilial extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        $oCCT_Codigo = new CampoConsulta('Código', 'cct_codigo');
        $oCCT_FilCodigo = new CampoConsulta('Empresa', 'fil_codigo');

        $this->addCampos($oCCT_Codigo, $oCCT_FilCodigo);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
