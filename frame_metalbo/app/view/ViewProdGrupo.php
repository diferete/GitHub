<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewProdGrupo extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de grupos de produtos');
        $oGrucod = new Campo('Código', 'grucod', Campo::TIPO_TEXTO, 1);
        $oGrudes = new Campo('Grupo', 'grudes', Campo::TIPO_TEXTO, 6);


        $this->addCampos($oGrucod, $oGrudes);
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $oGrucod = new CampoConsulta('Código', 'grucod');
        $oGrudes = new CampoConsulta('Grupo', 'grudes');

        $this->addCampos($oGrucod, $oGrudes);

        $oGrudesF = new Filtro($oGrudes, Campo::TIPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oGrudesF);
    }

}
