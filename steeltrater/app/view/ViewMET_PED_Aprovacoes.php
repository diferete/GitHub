<?php

/*
 * Implementa a classe view MET_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ViewMET_PED_Aprovacoes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->setUsaAcaoVisualizar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->getTela()->setiAltura(700);

        $oFilcgc = new CampoConsulta('CNPJ', 'filcgc');
        $oFilcgc->setILargura(80);

        $oPedidoSeq = new CampoConsulta('Nr', 'pdcnro');
        $oPedidoSeq->setILargura(5);

        $oBotaoGerencia = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_MARTELO);
        $oBotaoGerencia->setBHideTelaAcao(true);
        $oBotaoGerencia->setILargura(15);
        $oBotaoGerencia->setSTitleAcao('Gerenciar');
        $oBotaoGerencia->addAcao('MET_PED_Aprovacoes', 'criaTelaModalMetGerenciaPedido', 'criaModalMetGerenciaPedido', '');
        $this->addModais($oBotaoGerencia);

        $oBtnItens = new CampoConsulta('', '', CampoConsulta::TIPO_MVC, CampoConsulta::ICONE_APONTAR);
        $oBtnItens->addDadosConsultaMVC('MET_PED_AprovacoesItens', 'TelaVisualizaItens', 'Visualizar itens!');
        $oBtnItens->setILargura(15);

        $oSituacao = new CampoConsulta('Situacao', 'pdcsituaca');
        $oSituacao->addComparacao('0', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AZUL, CampoConsulta::MODO_LINHA, true, 'Aberto');
        $oSituacao->addComparacao('N', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_LARANJA, CampoConsulta::MODO_LINHA, true, 'Não Liberado');
        $oSituacao->addComparacao('2', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERDE, CampoConsulta::MODO_LINHA, true, 'Ent. Total');
        $oSituacao->addComparacao('3', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_AMARELO, CampoConsulta::MODO_LINHA, true, 'Ent. Parcial');
        $oSituacao->addComparacao('', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_LINHA, true, 'Cancelado');
        $oSituacao->addComparacao('R', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COL_VERMELHO, CampoConsulta::MODO_LINHA, true, 'Cancelado');
        $oSituacao->setBComparacaoColuna(true);
        $oSituacao->setILargura(20);

        $oPedidoData = new CampoConsulta('Data', 'pdcimplant');
        $oPedidoData->setILargura(20);

        /**         * ********* DAR JOIN TABELA DE FORNECEDORES ************* */
        $oPedidoFornecedorRazao = new CampoConsulta('Fornecedor', 'empdes');
        /*         * ******************************************************************* */

        /*         * *************** DAR JOIN TABELA ITENS ***************************** */
        $oPedidoValorTotalItens = new CampoConsulta('Valor total', 'valortotal', CampoConsulta::TIPO_DECIMAL);
        /*         * ********************************************* */

        $oFilFilcgc = new Filtro($oFilcgc, Filtro::CAMPO_SELECT, 2, 2, 12, 12, false);
        $oFilFilcgc->addItemSelect('', 'Todas as Empresas');
        $oFilFilcgc->addItemSelect('75483040000211', 'Filial');
        $oFilFilcgc->addItemSelect('75483040000130', 'Matriz');
        $oFilFilcgc->setSLabel('');

        $oFilPedidoSeq = new Filtro($oPedidoSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $oFilPedidoSituacao = new Filtro($oSituacao, Filtro::CAMPO_SELECT, 1, 1, 12, 12, false);
        $oFilPedidoSituacao->addItemSelect('', 'Todas as situações  ');
        $oFilPedidoSituacao->addItemSelect('0', 'Aberto');
        $oFilPedidoSituacao->addItemSelect('N', 'Não Liberado');
        $oFilPedidoSituacao->addItemSelect('2', 'Ent. Total');
        $oFilPedidoSituacao->addItemSelect('3', 'Ent. Parcial');
        $oFilPedidoSituacao->addItemSelect('R', 'Cancelado');
        $oFilPedidoSituacao->setSLabel('');

        $this->addFiltro($oFilFilcgc, $oFilPedidoSeq, $oFilPedidoSituacao);

        $this->addCampos($oFilcgc, $oPedidoSeq, $oBotaoGerencia, $oBtnItens, $oSituacao, $oPedidoData, $oPedidoFornecedorRazao, $oPedidoValorTotalItens);
    }

    public function criaTela() {
        parent::criaTela();
    }

    public function criaModalMetGerenciaPedido() {
        parent::criaModal();

        $this->setBTela(true);
        $aDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($aDados['filcgc']);
        $oEmpresa->setBCampoBloqueado(true);

        $oPedSeq = new Campo('Ped.', 'nrped', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedSeq->setSValor($aDados['pdcnro']);
        $oPedSeq->setBCampoBloqueado(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);

        //botão inserir os dados
        $oBtnAprova = new Campo('Aprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenMetPedidoCompra","A,S");';
        $oBtnAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBtnAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);

        //botão inserir os dados
        $oBtnReprova = new Campo('Reprovar', '', Campo::TIPO_BOTAOSMALL_SUB, 2);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","gerenMetPedidoCompra","R,S");';
        $oBtnReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBtnReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);



        $this->addCampos(array($oEmpresa, $oPedSeq), array($oBtnAprova, $oBtnReprova), $oUsunome);
    }

}
