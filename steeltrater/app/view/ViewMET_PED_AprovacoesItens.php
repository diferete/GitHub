<?php

/*
 * Implementa a classe view MET_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class ViewMET_PED_AprovacoesItens extends View {

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
        $oEmpresa->setSValor($aDados['filcgc']);
        $oEmpresa->setBCampoBloqueado(true);
        $oEmpresa->setApenasTela(true);

        $oPedSeq = new Campo('Pedido', 'nrped', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPedSeq->setSValor($aDados['pdcnro']);
        $oPedSeq->setBCampoBloqueado(true);
        $oPedSeq->setApenasTela(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);
        $oUsunome->setApenasTela(true);

        $oGridItens = new campo('Listagem dos itens do pedido nr: ' . $aDados['pdcnro'], 'gridItens', Campo::TIPO_GRID, 12, 12, 12, 12);
        $oGridItens->getOGrid()->setITipoGrid(2);
        $oGridItens->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());


        $oFilCodigo = new CampoConsulta('CNPJ', 'filcgc');
        $oFilCodigo->setILargura(100);

        $oSeqPed = new CampoConsulta('Seq.', 'pdcnro');

        $oSeqPedItem = new CampoConsulta('Seq. Item', 'pdcproseq');

        $oProCodigo = new CampoConsulta('Codigo', 'procod');

        $oProDescricao = new CampoConsulta('Descrição', 'Produto.prodes');

        $oProQuant = new CampoConsulta('Qt.', 'pdcproqtdp');

        $oProVlr = new CampoConsulta('Vlr Un.', 'pdcprovlru', CampoConsulta::TIPO_DECIMAL);

        $oProUnd = new CampoConsulta('UN', 'Produto.pround');

        $oGridItens->addCampos($oFilCodigo, $oSeqPed, $oSeqPedItem, $oProCodigo, $oProDescricao, $oProQuant, $oProVlr, $oProUnd);

        $oGridItens->setSController('MET_PED_AprovacoesItens');
        $oGridItens->getOGrid()->setIAltura(500);
        $oGridItens->getOGrid()->setBGridResponsivo(false);
        $oGridItens->getOGrid()->setILarguraGrid(1800);
        $oGridItens->setApenasTela(true);

        $oGridItens->addParam('filcgc', $aDados['filcgc']);
        $oGridItens->addParam('pdcnro', $aDados['pdcnro']);

        $oBotAprova = new Campo('APROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PED_Aprovacoes","gerenPedidoCompra","A,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBotAprova->setApenasTela(true);

        $oBotReprova = new Campo('REPROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_PED_Aprovacoes","gerenPedidoCompra","R,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBotReprova->setApenasTela(true);


        if ($aDados['sit'] != 'N') {
            $this->addCampos(array($oEmpresa, $oPedSeq), $oUsunome, $oGridItens);
        } else {
            $this->addCampos(array($oEmpresa, $oPedSeq), $oUsunome, $oGridItens, array($oBotAprova, $oBotReprova));
        }
    }

}
