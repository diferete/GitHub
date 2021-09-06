<?php

/*
 * Implementa a classe view MET_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class ViewMET_SOL_AprovacoesItens extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
    }

    public function criaTela() {
        parent::criaTela();

        $aDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('CNPJ', 'cnpj', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($aDados['filcgc']);
        $oEmpresa->setBCampoBloqueado(true);
        $oEmpresa->setApenasTela(true);

        $oSolSeq = new Campo('Solicitação', 'nrsol', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSolSeq->setSValor($aDados['solcod']);
        $oSolSeq->setBCampoBloqueado(true);
        $oSolSeq->setApenasTela(true);

        $oUsunome = new Campo('', 'usunome', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsunome->setSValor($_SESSION['nomedelsoft']);
        $oUsunome->setBOculto(true);
        $oUsunome->setApenasTela(true);

        $oGridItens = new campo('Listagem dos itens da solicitação nr: ' . $aDados['solcod'], 'gridItens', Campo::TIPO_GRID, 12, 12, 12, 12);
        $oGridItens->getOGrid()->setITipoGrid(2);
        $oGridItens->getOGrid()->setAbaSel($this->getSIdAbaSelecionada());

        $oFilCodigo = new CampoConsulta('CNPJ', 'filcgc');
        $oFilCodigo->setILargura(100);

        $oSeqSol = new CampoConsulta('Seq.', 'solcod');

        $oSeqSolItem = new CampoConsulta('Seq. Item', 'solproseq');

        $oProCodigo = new CampoConsulta('Codigo', 'procod');

        $oProDescricao = new CampoConsulta('Descrição', 'Produto.prodes');

        if ($aDados['sit'] != 'I') {
            $oProQuant = new CampoConsulta('Qt.', 'solproqtda');
        } else {
            $oProQuant = new CampoConsulta('Qt.', 'solproqtda', CampoConsulta::TIPO_EDITTEXTO);
            $oProQuant->addAcao('MET_SOL_AprovacoesItens', 'gravaQnt', '', '');
            $oProQuant->setILargura(100);
        }

        $oProUnd = new CampoConsulta('UN', 'Produto.pround');

        $oGridItens->addCampos($oFilCodigo, $oSeqSol, $oSeqSolItem, $oProCodigo, $oProDescricao, $oProQuant, $oProUnd);

        $oGridItens->setSController('MET_SOL_AprovacoesItens');
        $oGridItens->getOGrid()->setIAltura(500);
        $oGridItens->getOGrid()->setBGridResponsivo(false);
        $oGridItens->getOGrid()->setILarguraGrid(1800);
        $oGridItens->setApenasTela(true);

        $oGridItens->addParam('filcgc', $aDados['filcgc']);
        $oGridItens->addParam('solcod', $aDados['solcod']);

        $oBotAprova = new Campo('APROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotAprova->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoAprova = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_SOL_Aprovacoes","gerenSolicitacaoCompra","A,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotAprova->getOBotao()->addAcao($sAcaoAprova);
        $oBotAprova->setApenasTela(true);

        $oBotReprova = new Campo('REPROVAR', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotReprova->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $sAcaoReprova = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_SOL_Aprovacoes","gerenSolicitacaoCompra","R,N,' . $this->getTela()->getId() . ',' . $aDados['idtela'] . '");';
        $oBotReprova->getOBotao()->addAcao($sAcaoReprova);
        $oBotReprova->setApenasTela(true);

        if ($aDados['sit'] != 'I') {
            $this->addCampos(array($oEmpresa, $oSolSeq, $oUsunome), $oGridItens);
        } else {
            $this->addCampos(array($oEmpresa, $oSolSeq, $oUsunome), $oGridItens, array($oBotAprova, $oBotReprova));
        }
    }

}
