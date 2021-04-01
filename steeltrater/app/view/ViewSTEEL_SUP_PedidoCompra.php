<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewSTEEL_SUP_PedidoCompra extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $this->setUsaFiltro(true);
        $this->setUsaDropdown(true);
        $this->setUsaAcaoExcluir(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oFil_Codigo = new CampoConsulta('CNPJ', 'fil_codigo');
        $oFil_Codigo->setILargura(80);

        $oPedidoSeq = new CampoConsulta('Pedido', 'sup_pedidoseq');
        $oPedidoSeq->setILargura(5);

        $oSituacao = new CampoConsulta('Situacao', 'sup_pedidosituacao');
        $oSituacao->addComparacao('A', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_LINHA, true, 'Aberto');
        $oSituacao->addComparacao('L', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_LINHA, true, 'Liberado');
        $oSituacao->addComparacao('E', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Encerrado');
        $oSituacao->addComparacao('C', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_LINHA, true, 'Cancelado');
        $oSituacao->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_LINHA, true, 'Reprovado');
        $oSituacao->setBComparacaoColuna(true);
        $oSituacao->setILargura(20);

        $oPedidoTipo = new CampoConsulta('Tipo', 'sup_pedidotipo');
        $oPedidoTipo->addComparacao('M', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Manual');
        $oPedidoTipo->addComparacao('S', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_PADRAO, CampoConsulta::MODO_LINHA, true, 'Solicitação');

        $oPedidoData = new CampoConsulta('Data', 'sup_pedidodata', CampoConsulta::TIPO_DATA);

        $oPedidoHora = new CampoConsulta('Hora', 'sup_pedidohora');

        $oPedidoFornecedor = new CampoConsulta('Fornecedor', 'DELX_CAD_Pessoa.emp_razaosocial');

        /*         * ********** DAR JOIN TABELA DE FORNECEDORES ************* */
        $oPedidoFornecedorRazao = new CampoConsulta('Fornecedor', 'sup_pedidofornecedorrazao');
        /*         * ******************************************************************* */

        /*         * *************** DAR JOIN TABELA ITENS ***************************** */
        $oPedidoValorTotalItens = new CampoConsulta('Valor itens', 'sup_pedidovalortotalitens');
        /*         * ********************************************* */

        $oPedidoValorTotal = new CampoConsulta('Valor total', 'sup_pedidovalortotal', CampoConsulta::TIPO_DECIMAL);

        $oDrop1 = new Dropdown('IMPRIMIR PEDIDO DE COMPRA', Dropdown::TIPO_PRIMARY, Dropdown::TIPO_PADRAO, 3, 3, 12, 12);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Imprimir', $this->getController(), 'acaoMostraRelConsulta', '', false, 'RelPedidoCompra', false, '', false, '', false, false);

        $oFilPedidoSeq = new Filtro($oPedidoSeq, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addDropdown($oDrop1);
        $this->addFiltro($oFilPedidoSeq);

        $this->addCampos($oFil_Codigo, $oPedidoSeq, $oSituacao, $oPedidoTipo, $oPedidoData, $oPedidoFornecedor, $oPedidoValorTotal);
    }

    public function criaTela() {
        parent::criaTela();
    }

}
