<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewCidcep extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        $oCidcep = new CampoConsulta('Cep', 'cidcep');
        $oCidNome = new CampoConsulta('Cidade', 'cidnome');
        $oEstCod = new CampoConsulta('Estado', 'estcod');

        $oFilNome = new Filtro($oCidNome, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);
        $this->addFiltro($oFilNome);

        $this->addCampos($oCidcep, $oCidNome, $oEstCod);
        $this->setBScrollInf(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoIncluir(false);
    }

    public function criaTela() {
        parent::criaTela();
        $this->setTituloTela('Cidades e Estados');

        $oCidcep = new Campo('Cep', 'cidcep', Campo::TIPO_TEXTO, 2);
        $oCidNome = new Campo('Cidade', 'cidnome', Campo::TIPO_TEXTO, 3);
        $oEstCod = new Campo('Estado', 'estcod');
        $oIbge = new Campo('Ibge', 'cidIBGE', Campo::TIPO_TEXTO, 2);
        $this->addCampos($oCidcep, $oCidNome, $oEstCod, $oIbge);
    }

}
