<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_CAD_Users extends View {

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

        $oFilcgc = new CampoConsulta('Empresa', 'empcnpj', CampoConsulta::TIPO_TEXTO);
        $oUsuCod = new CampoConsulta('Cód. User', 'coduser', CampoConsulta::TIPO_TEXTO);
        $oUsuNome = new CampoConsulta('Nome', 'nome', CampoConsulta::TIPO_TEXTO);
        $oUsuSobrenome = new CampoConsulta('Sobrenome', 'sobrenome', CampoConsulta::TIPO_TEXTO);
        $oCracha = new CampoConsulta('Crachá', 'cracha', CampoConsulta::TIPO_TEXTO);
        $oCodSetor = new CampoConsulta('Cód. Setor', 'codsetor', CampoConsulta::TIPO_TEXTO);

        $oFilCracha = new Filtro($oCracha, Filtro::CAMPO_INTEIRO, 1, 1, 12, 12);
        $oFilFilcgc = new Filtro($oFilcgc, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oFilNome = new Filtro($oUsuNome, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);


        $this->addFiltro($oFilCracha, $oFilFilcgc, $oFilNome);
        $this->addCampos($oFilcgc, $oCracha, $oUsuNome, $oUsuSobrenome, $oCodSetor, $oUsuCod);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
