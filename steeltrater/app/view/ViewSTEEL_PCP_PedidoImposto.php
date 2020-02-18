<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class ViewSTEEL_PCP_PedidoImposto extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPed = new CampoConsulta('PedidoFilial', 'pdv_pedidofilial');
        $oCod = new CampoConsulta('Código', 'pdv_pedidocodigo');
        $oImpCod = new CampoConsulta('ImpostoCod', 'pdv_pedidoimpostocodigo');
        $oImpCal = new CampoConsulta('Imp.Calc.', 'PDV_PedidoImpostoBCalculo');
        $oImpVal = new CampoConsulta('Imp.Val..', 'PDV_PedidoImpostoValor');
        $oPedfiltro = new Filtro($oPed, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oPedfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oPed, $oCod, $oImpCod, $oImpCal, $oImpVal);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
