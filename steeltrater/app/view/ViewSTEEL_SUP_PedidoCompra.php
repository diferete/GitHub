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
        $this->setUsaAcaoVisualizar(true);
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
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Imprimir últimos 6 mêses', $this->getController(), 'acaoMostraRelConsulta', '', false, 'RelPedidoCompra,mes=6', false, '', false, '', false, false);
        $oDrop1->addItemDropdown($this->addIcone(Base::ICON_IMPRESSORA) . 'Imprimir últimos 12 mêses', $this->getController(), 'acaoMostraRelConsulta', '', false, 'RelPedidoCompra,mes=12', false, '', false, '', false, false);
        $oFilPedidoSeq = new Filtro($oPedidoSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addDropdown($oDrop1);
        $this->addFiltro($oFilPedidoSeq);

        $this->addCampos($oFil_Codigo, $oPedidoSeq, $oSituacao, $oPedidoTipo, $oPedidoData, $oPedidoFornecedor, $oPedidoValorTotal);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $aCondPag = $this->getOObjTela();

        $oFilCodigo = new Campo('Empresa', 'FIL_Codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilCodigo->setSValor($_SESSION['filcgc']);

        $oSeq = new Campo('Seq.', 'SUP_PedidoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oSupPedidoData = new Campo('Data', 'SUP_PedidoData', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oSupPedidoData->setSValor(date('d/m/Y'));

        $oSupPedidoHora = new Campo('Hora', 'SUP_PedidoHora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSupPedidoHora->setSValor(date('H:i:s'));

        $oSupPedidoUsuario = new Campo('User', 'SUP_PedidoUsuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSupPedidoUsuario->setSValor($_SESSION['nomedelsoft']);

        $oSupPedidoSituacao = new Campo('', 'sup_pedidosituacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSupPedidoSituacao->setSValor('A');
        $oSupPedidoSituacao->setBOculto(true);

        $oFieldInfoGeral = new FieldSet('Informações Gerais');
        $oFieldInfoGeral->setOculto(false);
        $oFieldMoeda = new FieldSet('Moeda');
        $oFieldValores = new FieldSet('Valores');


        $oIdentificador = new Campo('Identificador', 'SUP_PedidoIdentificador', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oIdentificador->setILinhasTextArea(3);

        $oTipoControle = new Campo('Tipo de controle', 'SUP_PedidoTipoControle', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoControle->addItemSelect('Q', 'Quantidade');
        $oTipoControle->addItemSelect('N', 'Normal');
        $oTipoControle->addItemSelect('U', 'Valor unitário');
        $oTipoControle->addItemSelect('E', 'Edital');
        $oTipoControle->addItemSelect('C', 'Contrato sem vínculo');

        $oFornecedorCNPJ = new Campo('CNPJ Fornecedor', 'SUP_PedidoFornecedor', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oFornecedorDESC = new Campo('Razão Social', 'emp_razaosocial', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oFornecedorDESC->setSIdPk($oFornecedorCNPJ->getId());
        $oFornecedorDESC->setClasseBusca('DELX_CAD_Pessoa');
        $oFornecedorDESC->addCampoBusca('emp_codigo', '', '');
        $oFornecedorDESC->addCampoBusca('emp_razaosocial', '', '');
        $oFornecedorDESC->setSIdTela($this->getTela()->getId());
        $oFornecedorDESC->setSValor('');
        $oFornecedorDESC->setApenasTela(true);

        $oFornecedorCNPJ->setClasseBusca('DELX_CAD_Pessoa');
        $oFornecedorCNPJ->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oFornecedorCNPJ->addCampoBusca('emp_razaosocial', $oFornecedorDESC->getId(), $this->getTela()->getId());


        $oFornecedorCTT = new Campo('Contato', 'SUP_PedidoContato', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);

        $oFornecedorCTTNome = new Campo('Nome', 'emp_contatonome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFornecedorCTTNome->setSIdPk($oFornecedorCTT->getId());
        $oFornecedorCTTNome->setClasseBusca('DELX_EMP_PessoaContato');
        $oFornecedorCTTNome->addCampoBusca('emp_contatoseq', '', '');
        $oFornecedorCTTNome->addCampoBusca('emp_contatonome', '', '');
        $oFornecedorCTTNome->setSIdTela($this->getTela()->getId());
        $oFornecedorCTTNome->setSValor('');
        $oFornecedorCTTNome->setApenasTela(true);

        $oFornecedorCTT->setClasseBusca('DELX_EMP_PessoaContato');
        $oFornecedorCTT->setSCampoRetorno('emp_contatoseq', $this->getTela()->getId());
        $oFornecedorCTT->addCampoBusca('emp_contatonome', $oFornecedorCTTNome->getId(), $this->getTela()->getId());

        $oTipoFrete = new Campo('Tipo do frete', 'SUP_PedidoTipoFrete', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoFrete->addItemSelect('1', 'CIF (POR CONTA DO EMITENTE)');
        $oTipoFrete->addItemSelect('2', 'FOB (POR CONTA DO DESTINATARIO/REMETENTE)');
        $oTipoFrete->addItemSelect('3', 'POR CONTA DE TERCEIRO');
        $oTipoFrete->addItemSelect('4', 'SEM COBRANÇA DO FRETE');

        $oTransportadorCNPJ = new Campo('CNPJ Transportador', 'SUP_PedidoTransportador', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oTransportadorDESC = new Campo('Trasnportador', 'trasnportador', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oTransportadorDESC->setSIdPk($oTransportadorCNPJ->getId());
        $oTransportadorDESC->setClasseBusca('DELX_CAD_Pessoa');
        $oTransportadorDESC->addCampoBusca('emp_codigo', '', '');
        $oTransportadorDESC->addCampoBusca('emp_razaosocial', '', '');
        $oTransportadorDESC->setSIdTela($this->getTela()->getId());
        $oTransportadorDESC->setSValor('');
        $oTransportadorDESC->setApenasTela(true);

        $oTransportadorCNPJ->setClasseBusca('DELX_CAD_Pessoa');
        $oTransportadorCNPJ->setSCampoRetorno('emp_codigo', $this->getTela()->getId());
        $oTransportadorCNPJ->addCampoBusca('emp_razaosocial', $oTransportadorDESC->getId(), $this->getTela()->getId());

        $oCondicaoPagamento = new Campo('Cond. pagamento', 'SUP_PedidoCondicaoPag', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oCondicaoPagamento->addItemSelect('selecione', 'Selecionar cond. pag.');
        foreach ($aCondPag as $key => $value) {
            $oCondicaoPagamento->addItemSelect($value['cpg_codigo'], $value['cpg_descricao']);
        }

        $oTipoMovimento = new Campo('Tipo de movimento', 'SUP_PedidoTipoMovimento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipoMovimento->setSValor('310');
        $oTipoMovimento->setBCampoBloqueado(true);

        $oMoeda = new Campo('Moeda', 'SUP_PedidoMoeda', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oMoeda->setSValor('REAL');
        $oMoeda->setBCampoBloqueado(true);

        $oValorFrete = new Campo('Valor Frete', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorDespesa = new Campo('Valor Despesa', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorSeguro = new Campo('Valor Seguro', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorAcrescimo = new Campo('Valor Acréscimo', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oTipoDesconto = new Campo('Tipo Desconto', 'SUP_PedidoVlrFrete', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oTipoDesconto->addItemSelect('V', 'Valor');
        $oTipoDesconto->addItemSelect('P', 'Percentual');

        $oPercentualDesconto = new Campo('% Desconto', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorDesconto = new Campo('Valor Desconto', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oValorDescontoServico = new Campo('Desconto Serviço', 'SUP_PedidoVlrFrete', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oFieldInfoGeral->addCampos($oIdentificador, $oTipoControle, array($oFornecedorCNPJ, $oFornecedorDESC, $oFornecedorCTT, $oFornecedorCTTNome), array($oTipoFrete, $oTransportadorCNPJ, $oTransportadorDESC), array($oCondicaoPagamento, $oTipoMovimento));
        $oFieldMoeda->addCampos($oMoeda);
        $oFieldValores->addCampos(array($oValorFrete, $oValorDespesa), array($oValorSeguro, $oValorAcrescimo), array($oTipoDesconto, $oPercentualDesconto, $oValorDesconto), $oValorDescontoServico);

        $oEtapas = new FormEtapa(2, 2, 12, 12);
        $oEtapas->addItemEtapas('Cadastro de pedido', true, $this->addIcone(Base::ICON_EDITAR));
        $oEtapas->addItemEtapas('Itens do pedido', false, $this->addIcone(Base::ICON_CONFIRMAR));

        $this->addEtapa($oEtapas);

        if ((!$sAcaoRotina != null || $sAcaoRotina != 'acaoVisualizar') && ($sAcaoRotina == 'acaoIncluir' || $sAcaoRotina == 'acaoAlterar' )) {

            //monta campo de controle para inserir ou alterar
            $oAcao = new campo('', 'acao', Campo::TIPO_CONTROLE, 2, 2, 12, 12);
            $oAcao->setApenasTela(true);
            if ($this->getSRotina() == View::ACAO_INCLUIR) {
                $oAcao->setSValor('incluir');
            } else {
                $oAcao->setSValor('alterar');
            }
            $this->setSIdControleUpAlt($oAcao->getId());

            $this->addCampos($oSupPedidoSituacao, array($oFilCodigo, $oSeq, $oSupPedidoUsuario, $oSupPedidoData, $oSupPedidoHora), $oFieldInfoGeral, $oFieldMoeda, $oFieldValores, $oAcao);
        } else {
            $this->addCampos($oSupPedidoSituacao, array($oFilCodigo, $oSeq, $oSupPedidoUsuario, $oSupPedidoData, $oSupPedidoHora), $oFieldInfoGeral, $oFieldMoeda, $oFieldValores);
        }
    }

}
