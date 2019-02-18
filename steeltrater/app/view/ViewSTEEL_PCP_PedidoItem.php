<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/11/2018
 */

class ViewSTEEL_PCP_PedidoItem extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPed = new CampoConsulta('PedidoFilial', 'pdv_pedidofilial');
        $oPedCod = new CampoConsulta('PedCod', 'pdv_pedidocodigo');
        $oPedIteSeq = new CampoConsulta('PedItemSeq', 'pdv_pedidoitemseq');
        $oPedIteImp = new CampoConsulta('ItemImp', 'pdv_pedidoitemiimposto');
        $oPedIteReg = new CampoConsulta('Regra', 'PDV_PedidoItemIRegra');
        $oPedIteCal = new CampoConsulta('Calculo', 'PDV_PedidoItemIBCalculo');
        $oPedIteVal = new CampoConsulta('Valor', 'PDV_PedidoItemIValor');
        $oPedfiltro = new Filtro($oPed,Filtro::CAMPO_TEXTO_IGUAL,3);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->addFiltro($oPedfiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oPed,$oPedCod,$oPedIteSeq,$oPedIteImp,$oPedIteReg,$oPedIteCal,$oPedIteVal);
    }

    public function criaTela() {
        parent::criaTela();

    }

}
