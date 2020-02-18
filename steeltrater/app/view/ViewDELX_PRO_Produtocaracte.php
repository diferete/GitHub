<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ViewDELX_PRO_Produtocaracte extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oProCodigo = new CampoConsulta('Pro.Cod', 'pro_codigo', CampoConsulta::TIPO_TEXTO);

        $oProCaracteristica = new CampoConsulta('Característica', 'pro_produtocaractecodigo', CampoConsulta::TIPO_TEXTO);

        $oVlrCaracte = new CampoConsulta('Vlr.Caracte', 'pro_produtocaractevalor', CampoConsulta::TIPO_TEXTO);

        $oFilProCod = new Filtro($oProCodigo, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilProCaracteristica = new Filtro($oProCaracteristica, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFilProCod, $oFilProCaracteristica);
        $this->addCampos($oProCodigo, $oProCaracteristica, $oVlrCaracte);
    }

    public function criaTela() {
        parent::criaTela();

        $oProCodigo = new Campo('Pro.Cod', 'pro_codigo', Campo::TIPO_TEXTO);

        $oProCaracteristica = new Campo('Característica', 'pro_produtocaractecodigo', Campo::TIPO_BUSCADOBANCO, 1, 1, 12, 12);
        $oProCaracteristica->setClasseBusca('DELX_PRO_Caracteristica');
        $oProCaracteristica->setSCampoRetorno('pro_caracteristicacodigo', $this->getTela()->getid());

        $oVlrCaracte = new Campo('Vlr.Caracte', 'pro_produtocaractevalor', Campo::TIPO_TEXTO);

        $oVlrDensidade = new Campo('Vlr é densidade', 'pro_produtocaractedensidade', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oVlrDensidade->addItemSelect('N', 'Não');
        $oVlrDensidade->addItemSelect('S', 'Sim');

        $this->addCampos($oProCodigo, $oProCaracteristica, $oVlrCaracte, $oVlrDensidade);
    }

}
