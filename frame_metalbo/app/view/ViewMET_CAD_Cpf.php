<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_CAD_Cpf extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoVisualizar(true);
        
        $this->getTela()->setBMostraFiltro(true);

        $oFilcgc = new CampoConsulta('Emp.Cad.', 'filcgc', CampoConsulta::TIPO_TEXTO);
        $oCPF = new CampoConsulta('CPF', 'cpf', CampoConsulta::TIPO_TEXTO);
        $oNome = new CampoConsulta('Nome', 'nome', CampoConsulta::TIPO_TEXTO);
        $oEmpFant = new CampoConsulta('Emp.Fant', 'empfant', CampoConsulta::TIPO_TEXTO);

        $oFiltroEmpFant = new Filtro($oEmpFant, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);
        $oFiltroCPF = new Filtro($oCPF, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oFiltroNome = new Filtro($oNome, Filtro::CAMPO_TEXTO, 3, 3, 12, 12);

        $this->addFiltro($oFiltroEmpFant, $oFiltroNome, $oFiltroCPF);

        $this->addCampos($oFilcgc, $oCPF, $oNome, $oEmpFant);
        $this->getTela()->setBGridResponsivo(true);
    }

    public function criaTela() {
        parent::criaTela();

        $oFilcgc = new Campo('Emp.Cad.', 'filcgc', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCPF = new Campo('CPF', 'cpf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNome = new Campo('Nome', 'nome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oEmpFant = new Campo('Emp.Fant', 'empfant', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $this->addCampos($oFilcgc, $oCPF, $oNome, $oEmpFant);
    }

}
