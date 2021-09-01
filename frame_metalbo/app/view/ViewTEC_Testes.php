<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewTEC_Testes extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBTela(true);
        $this->setBOcultaFechar(true);
        $this->setBOcultaBotTela(true);

        $oDivisor = new Campo('Alterar preços vendas', '', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);
        $oDivisor1 = new Campo('', '', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oBotPopula = new Campo('Popula tabela temporaria', '', Campo::TIPO_BOTAOSMALL_SUB, 2, 2, 12, 12);
        $oBotPopula->getOBotao()->setSStyleBotao(Botao::TIPO_PRIMARY);
        $sAcaoPopula = 'requestAjax("' . $this->getTela()->getId() . '-form","TEC_Testes","populaTabelaPrecoNovo","");';
        $oBotPopula->getOBotao()->addAcao($sAcaoPopula);
        $oBotPopula->setApenasTela(true);

        $oBotMovimentacao = new Campo('Verifica movimentação de produtos', '', Campo::TIPO_BOTAOSMALL_SUB, 2, 2, 12, 12);
        $oBotMovimentacao->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
        $sAcaoMovimentacao = 'requestAjax("' . $this->getTela()->getId() . '-form","TEC_Testes","verificaMovProduto","");';
        $oBotMovimentacao->getOBotao()->addAcao($sAcaoMovimentacao);
        $oBotMovimentacao->setApenasTela(true);

        $this->addCampos($oDivisor, array($oBotPopula, $oBotMovimentacao), $oDivisor1);
    }

}
