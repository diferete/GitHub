<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewCondPag extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
        

        $this->setaTiluloConsulta('Condição de Pagamento');

        $oCpgCod = new CampoConsulta('Código', 'cpgcod');
        $oCpgDes = new CampoConsulta('Pagamento', 'cpgdes');

        
        $oFiltroCpgCod = new Filtro($oCpgCod, Filtro::CAMPO_TEXTO_IGUAL, 2);
        $oFiltroCpgDes = new Filtro($oCpgDes, Filtro::CAMPO_TEXTO, 3);

        $this->addFiltro($oFiltroCpgCod, $oFiltroCpgDes);
        $this->addCampos($oCpgCod, $oCpgDes);
       
        $this->setBScrollInf(true);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

    }

    public function criaTela() {
        parent::criaTela();

        $this->setTituloTela('Cadastro de condição de pagamento');

        $oCpgCod = new Campo('Código', 'cpgcod', Campo::TIPO_TEXTO, 2);
        $oCpgDes = new Campo('Cond. Pagamento', 'cpgdes', Campo::TIPO_TEXTO, 6);
        $this->addCampos($oCpgCod, $oCpgDes);
    }

}
