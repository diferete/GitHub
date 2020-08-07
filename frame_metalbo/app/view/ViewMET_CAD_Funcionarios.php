<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_CAD_Funcionarios extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaFiltro(true);
        $this->setUsaAcaoVisualizar(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $this->getTela()->setBMostraFiltro(true);

        $oCracha = new CampoConsulta('Crachá', 'numcad', CampoConsulta::TIPO_TEXTO);
        $oNome = new CampoConsulta('Nome', 'nomfun', CampoConsulta::TIPO_TEXTO);
        $oCpf = new CampoConsulta('CPF', 'cpf', CampoConsulta::TIPO_TEXTO);

        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_INTEIRO, 1, 1, 12, 12, false);
        $oFilCpf = new Filtro($oCpf, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFilNome = new Filtro($oNome, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);


        $this->addFiltro($oFilCracha, $oFilCpf, $oFilNome);
        $this->addCampos($oCracha, $oNome, $oCpf);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
