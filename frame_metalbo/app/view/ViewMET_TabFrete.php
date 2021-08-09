<?php

/*
 * Classe que gerencia a View da MET_TabFrete
 * @author: Cleverton Hoffmann
 * @since: 14/10/2019
 */

class ViewMET_TabFrete extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCnpj = new CampoConsulta('CNPJ', 'cnpj');
        $oEmpDes = new CampoConsulta('Empresa', 'Pessoa.empdes');
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oCodtip = new CampoConsulta('Cod Tipo', 'codtipo');
        $oRef = new CampoConsulta('Referência', 'ref');
        $oTaxMin = new CampoConsulta('Taxa Min', 'taxamin', CampoConsulta::TIPO_DECIMAL);
        $oFreteValor = new CampoConsulta('Frete Valor', 'fretevalor', CampoConsulta::TIPO_DECIMAL);
        $oFretePeso = new CampoConsulta('Frete Peso', 'fretepeso', CampoConsulta::TIPO_DECIMAL);
        $oPedagio = new CampoConsulta('Pedagio', 'pedagio', CampoConsulta::TIPO_DECIMAL);
        $oTaxa2 = new CampoConsulta('Taxa2', 'taxa2', CampoConsulta::TIPO_DECIMAL);
        $oTas = new CampoConsulta('Tas', 'tas', CampoConsulta::TIPO_DECIMAL);
        $oGris = new CampoConsulta('Gris', 'gris', CampoConsulta::TIPO_DECIMAL);
        $oTaxa = new CampoConsulta('Taxa', 'taxa', CampoConsulta::TIPO_DECIMAL);
        $oImposto = new CampoConsulta('Imposto', 'imposto', CampoConsulta::TIPO_DECIMAL);

        $oFiltroCnpj = new Filtro($oCnpj, Filtro::CAMPO_TEXTO_IGUAL, 2, 2, 12, 12, false);
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroEmpDes = new Filtro($oEmpDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFiltroCodtip = new Filtro($oCodtip, Filtro::CAMPO_INTEIRO, 2, 2, 12, 12, false);
        $oFiltroRef = new Filtro($oRef, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFiltroCnpj, $oFiltroSeq, $oFiltroEmpDes, $oFiltroCodtip, $oFiltroRef);

        $this->setBScrollInf(true);

        $this->addCampos($oCnpj, $oEmpDes, $oSeq, $oCodtip, $oRef, $oTaxMin, $oFreteValor, $oFretePeso, $oPedagio, $oTaxa2, $oTas, $oGris, $oTaxa, $oImposto);
    }

    public function criaTela() {
        parent::criaTela();

        $oCnpj = new Campo('CNPJ', 'cnpj', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 2, 2);
        $oCnpj->addValidacao(false);

        $oEmpDes = new campo('Empresa', 'Pessoa.empdes', Campo::TIPO_BUSCADOBANCO, 3, 3, 3, 3);
        $oEmpDes->setSIdPk($oCnpj->getId());
        $oEmpDes->setClasseBusca('Pessoa');
        $oEmpDes->addCampoBusca('empcod', '', '');
        $oEmpDes->addCampoBusca('empdes', '', '');
        $oEmpDes->setSIdTela($this->getTela()->getid());
        $oEmpDes->addValidacao(false);

        $oCnpj->setClasseBusca('Pessoa');
        $oCnpj->setSCampoRetorno('empcod', $this->getTela()->getId());
        $oCnpj->addCampoBusca('empdes', $oEmpDes->getId(), $this->getTela()->getId());

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1);
        $oSeq->setBCampoBloqueado(true);
        $oCodtip = new Campo('Tipo', 'codtipo', Campo::TIPO_SELECT, 2);
        $oCodtip->addItemSelect('1', 'Venda');
        $oCodtip->addItemSelect('2', 'Compra');
        $oCodtip->addValidacao(false);

        $oRef = new Campo('Referência', 'ref', Campo::TIPO_TEXTO, 2);
        $oRef->addValidacao(false);

        $oTaxMin = new Campo('Taxa Min', 'taxamin', Campo::TIPO_DECIMAL, 2);
        $oTaxMin->addValidacao(false);
        $oFreteValor = new Campo('Frete Valor', 'fretevalor', Campo::TIPO_DECIMAL_COMPOSTO, 2);
        $oFreteValor->setICasaDecimal(5);
        $oFreteValor->addValidacao(false);
        $oFretePeso = new Campo('Frete Peso', 'fretepeso', Campo::TIPO_DECIMAL_COMPOSTO, 2);
        $oFretePeso->setICasaDecimal(4);
        $oFretePeso->addValidacao(false);
        $oPedagio = new Campo('Pedagio', 'pedagio', Campo::TIPO_DECIMAL, 2);
        $oPedagio->addValidacao(false);
        $oTaxa2 = new Campo('Taxa2', 'taxa2', Campo::TIPO_DECIMAL, 2);
        $oTaxa2->addValidacao(false);
        $oTas = new Campo('Tas', 'tas', Campo::TIPO_DECIMAL, 2);
        $oTas->addValidacao(false);
        $oGris = new Campo('Gris', 'gris', Campo::TIPO_DECIMAL_COMPOSTO, 2);
        $oGris->setICasaDecimal(4);
        $oGris->addValidacao(false);
        $oTaxa = new Campo('Taxa', 'taxa', Campo::TIPO_DECIMAL, 2);
        $oTaxa->addValidacao(false);
        $oImposto = new Campo('Imposto', 'imposto', Campo::TIPO_DECIMAL, 2);
        $oImposto->addValidacao(false);

        $oL = new Campo('', 'tes', Campo::TIPO_LINHABRANCO);
        $oL->setApenasTela(true);

        $this->addCampos(array($oSeq, $oCnpj, $oEmpDes), $oL, array($oCodtip, $oRef), $oL, array($oTaxMin, $oTaxa, $oTaxa2), $oL, array($oFreteValor, $oFretePeso, $oPedagio), $oL, array($oTas, $oGris, $oImposto));
    }

}
