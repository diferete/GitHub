<?php

/*
 * Implementa a classe view STEEL_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class ViewSTEEL_PED_AprovacoesItens extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoVisualizar(true);
    }

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($aDados['FIL_Codigo']);
        $oEmpresa->setBCampoBloqueado(true);
        $oEmpresa->setApenasTela(true);

        $oPedSeq = new Campo('Pedido', 'nrped', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedSeq->setSValor($aDados['SUP_PedidoSeq']);
        $oPedSeq->setBCampoBloqueado(true);
        $oPedSeq->setApenasTela(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);
        $oUsunome->setApenasTela(true);

        $oGridItens = new campo('Listagem dos itens do pedido nr: ' . $aDados['SUP_PedidoSeq'], 'gridItens', Campo::TIPO_GRID, 12, 12, 12, 12);
        $oGridItens->getOGrid()->setITipoGrid(2);
        $oGridItens->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());


        $oFilCodigo = new CampoConsulta('CNPJ', 'FIL_Codigo');
        $oFilCodigo->setILargura(100);

        $oSeqPed = new CampoConsulta('Seq.', 'SUP_PedidoSeq');

        $oSeqPedItem = new CampoConsulta('Seq. Item', 'SUP_PedidoItemSeq');

        $oProCodigo = new CampoConsulta('Codigo', 'pro_codigo');

        $oProDescricao = new CampoConsulta('Descrição', 'sup_pedidoitemdescricao');

        $oProQuant = new CampoConsulta('Qt.', 'sup_pedidoitemcomqtd');

        $oProUnd = new CampoConsulta('UN', 'sup_pedidoitemcomund');

        $oGridItens->addCampos($oFilCodigo, $oSeqPed, $oSeqPedItem, $oProCodigo, $oProDescricao, $oProQuant, $oProUnd);

        $oGridItens->setSController('STEEL_PED_AprovacoesItens');
        $oGridItens->getOGrid()->setIAltura(500);
        $oGridItens->getOGrid()->setBGridResponsivo(false);
        $oGridItens->getOGrid()->setILarguraGrid(1800);
        $oGridItens->setApenasTela(true);

        $oGridItens->addParam('FIL_Codigo', $aDados['FIL_Codigo']);
        $oGridItens->addParam('SUP_PedidoSeq', $aDados['SUP_PedidoSeq']);

        $oBotAprova = new Campo('APROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PED_Aprovacoes","gerenPedidoCompra","A,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBotAprova->setApenasTela(true);

        $oBotReprova = new Campo('REPROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PED_Aprovacoes","gerenPedidoCompra","R,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBotReprova->setApenasTela(true);


        if ($aDados['sit'] != 'A') {
            $this->addCampos(array($oEmpresa, $oPedSeq), $oUsunome, $oGridItens);
        } else {
            $this->addCampos(array($oEmpresa, $oPedSeq), $oUsunome, $oGridItens, array($oBotAprova, $oBotReprova));
        }
    }

}
