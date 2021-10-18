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
        $this->getTela()->setiAltura(800);

        $oFil_Codigo = new CampoConsulta('CNPJ', 'fil_codigo');
        $oFil_Codigo->setILargura(80);

        $oPedidoSeq = new CampoConsulta('Seq', 'sup_pedidoseq');
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
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Imprimir últimos 6 mêses', $this->getController(), 'acaoMostraRelConsulta', '', false, 'RelPedidoCompra,mes=6', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Imprimir últimos 12 mêses', $this->getController(), 'acaoMostraRelConsulta', '', false, 'RelPedidoCompra,mes=12', false, '', false, '', false, false);
        $oFilPedidoSeq = new Filtro($oPedidoSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addDropdown($oDrop1);
        $this->addFiltro($oFilPedidoSeq);

        $this->addCampos($oFil_Codigo, $oPedidoSeq, $oSituacao, $oPedidoTipo, $oPedidoData, $oPedidoFornecedor, $oPedidoValorTotal);
    }

    public function criaTela() {
        parent::criaTela();
    }

    public function relPedidosCompra() {
        parent::criaTelaRelatorio();

        $this->setTituloTela('Relatório de Pedidos de Compras');
        $this->setBTela(true);

        $oPdcInicial = new Campo('Pedido:', 'pedini', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPdcFinal = new Campo('até:', 'pedfim', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oDatainicial = new Campo('Entre data inicial:', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatainicial->setSValor(Util::getPrimeiroDiaMes());
        $oDatainicial->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $oDatafinal = new Campo('e data final:', 'datafinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDatafinal->setSValor(Util::getDataAtual());
        $oDatafinal->addValidacao(true, Validacao::TIPO_STRING, '', '2', '100');

        $oCCT_Codigo = new campo('Centro de Custo', 'cct_codigo', Campo::TIPO_BUSCADOBANCOPK, 2, 4, 4, 4);

        $oCCT_Descricao = new Campo('Descrição', 'cct_descricao', Campo::TIPO_BUSCADOBANCO, 3, 8, 8, 8);
        $oCCT_Descricao->setSIdPk($oCCT_Codigo->getId());
        $oCCT_Descricao->setClasseBusca('STEEL_CCT_CentroCusto');
        $oCCT_Descricao->addCampoBusca('cct_codigo', '', '');
        $oCCT_Descricao->addCampoBusca('cct_descricao', '', '');
        $oCCT_Descricao->setSIdTela($this->getTela()->getid());
        $oCCT_Descricao->setApenasTela(true);

        $oCCT_Codigo->setClasseBusca('STEEL_CCT_CentroCusto');
        $oCCT_Codigo->setSCampoRetorno('cct_codigo', $this->getTela()->getId());
        $oCCT_Codigo->addCampoBusca('cct_descricao', $oCCT_Descricao->getId(), $this->getTela()->getId());
        $oCCT_Codigo->setApenasTela(true);

        $oCcts = new campo('Lista CCT', 'cct_codigos', Campo::TIPO_TAGS, 6, 6, 12, 12);
        $oCcts->setILinhasTextArea(5);
        $oCcts->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCcts->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5);

        $oBotConf = new Campo('Adicionar CCT', 'botao', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->getOBotao()->setSStyleBotao(Botao::TIPO_SUCCESS);

        $sAcao = 'insereCCT($("#' . $oCCT_Codigo->getId() . '").val(),'
                . '$("#' . $oCCT_Descricao->getId() . '").val(),'
                . '"' . $oCcts->getId() . '",'
                . '"' . $oCCT_Codigo->getId() . '",'
                . '"' . $oCCT_Descricao->getId() . '",'
                . '"' . $this->getController() . '")';
        $oBotConf->getOBotao()->addAcao($sAcao);
        $oBotConf->setApenasTela(true);

        $oLinha1 = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha1->setApenasTela(true);

        $this->addCampos(array($oPdcInicial, $oPdcFinal), $oLinha1, array($oDatainicial, $oDatafinal), $oLinha1, array($oCCT_Codigo, $oCCT_Descricao, $oBotConf), $oLinha1, $oCcts);
    }

}
