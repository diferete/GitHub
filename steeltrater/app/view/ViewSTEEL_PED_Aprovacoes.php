<?php

/*
 * Implementa a classe view STEEL_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ViewSTEEL_PED_Aprovacoes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->setUsaDropdown(true);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setiAltura(800);

        $oFil_Codigo = new CampoConsulta('CNPJ', 'fil_codigo');
        $oFil_Codigo->setILargura(80);

        $oPedidoSeq = new CampoConsulta('Seq', 'sup_pedidoseq');
        $oPedidoSeq->setILargura(5);

        $oBotaoGerencia = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL,  CampoConsulta::ICONE_MARTELO);
        $oBotaoGerencia->setBHideTelaAcao(true);
        $oBotaoGerencia->setILargura(15);
        $oBotaoGerencia->setSTitleAcao('Gerenciar');
        $oBotaoGerencia->addAcao('STEEL_PED_Aprovacoes', 'criaTelaModalSteelGerenciaPedido', 'criaModalSteelGerenciaPedido', '');
        $this->addModais($oBotaoGerencia);

        $oBtnItens = new CampoConsulta('', '', CampoConsulta::TIPO_MVC,CampoConsulta::ICONE_APONTAR);
        $oBtnItens->addDadosConsultaMVC('STEEL_PED_AprovacoesItens', 'TelaVisualizaItens', 'Visualizar itens!');
        $oBtnItens->setILargura(15);

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
        
        $oFilPedidoSituacao = new Filtro($oSituacao, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilPedidoSituacao->addItemSelect('', 'Todos');
        $oFilPedidoSituacao->addItemSelect('A', 'Aberto');
        $oFilPedidoSituacao->addItemSelect('L', 'Liberado');
        $oFilPedidoSituacao->addItemSelect('E', 'Encerrado');
        $oFilPedidoSituacao->addItemSelect('C', 'Cancelado');
        $oFilPedidoSituacao->addItemSelect('R', 'Reprovado');
        $oFilPedidoSituacao->setSLabel('');
        

        $this->addDropdown($oDrop1);
        $this->addFiltro($oFilPedidoSeq,$oFilPedidoSituacao);

        $this->addCampos($oFil_Codigo, $oPedidoSeq, $oBotaoGerencia, $oBtnItens, $oSituacao, $oPedidoTipo, $oPedidoData, $oPedidoFornecedor, $oPedidoValorTotal);
    }

    public function criaTela() {
        parent::criaTela();
    }

    public function criaModalSteelGerenciaPedido() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFIL_Codigo());
        $oEmpresa->setBCampoBloqueado(true);

        $oPedSeq = new Campo('Ped.', 'nrped', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedSeq->setSValor($oDados->getSUP_PedidoSeq());
        $oPedSeq->setBCampoBloqueado(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);

        //botão inserir os dados
        $oBtnAprova = new Campo('Aprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenSteelPedidoCompra","A,S");';
        $oBtnAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBtnAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);

        //botão inserir os dados
        $oBtnReprova = new Campo('Reprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenSteelPedidoCompra","R,S");';
        $oBtnReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBtnReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);



        $this->addCampos(array($oEmpresa, $oPedSeq), array($oBtnAprova, $oBtnReprova), $oUsunome);
    }

}
