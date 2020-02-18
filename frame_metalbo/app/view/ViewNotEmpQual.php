<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewNotEmpQual extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oEmpcod = new CampoConsulta('Cnpj', 'empcod');
        $oEmpcod->setILargura(600);

        $oEmpdes = new CampoConsulta('Empresa', 'empdes');
        $oEmpdes->setILargura(600);

        $oFiltro = new Filtro($oEmpdes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);



        $this->addFiltro($oFiltro);

        $this->addCampos($oEmpcod, $oEmpdes);
    }

    public function criaTela() {
        parent::criaTela();

        $oCnpj = new Campo('Cliente', 'empcod', Campo::TIPO_BUSCADOBANCOPK, 2);

        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBFocus(true);
        $oCnpj->setSCorFundo(Campo::FUNDO_AMARELO);

        $oEmpresa = new Campo('Razão Social', 'empdes', Campo::TIPO_BUSCADOBANCO, 4);
        $oEmpresa->setSIdPk($oCnpj->getId());
        $oEmpresa->setClasseBusca('Pessoa');
        $oEmpresa->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        /* definir sempre código pk e descrição */
        $oEmpresa->addCampoBusca('empcod', '', '');
        $oEmpresa->addCampoBusca('empdes', '', '');
        $oEmpresa->setSIdTela($this->getTela()->getid());
        $oEmpresa->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpresa->setSCorFundo(Campo::FUNDO_AMARELO);
        /* declara as informações */
        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpresa->getId(), $this->getTela()->getId());

        $this->addCampos(array($oCnpj, $oEmpresa));
    }

}
