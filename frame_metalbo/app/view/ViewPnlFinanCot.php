<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewPnlFinanCot extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();
    }

    public function criaTela() {
        parent::criaTela();
        $aValor = $this->getAParametrosExtras();

        $oCnpj = new Campo('Cliente', '', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCnpj->setITamanho(Campo::TAMANHO_PEQUENO);
        $oCnpj->setBCampoBloqueado(true);
        $oCnpj->setSValor($aValor[0]);

        $oNr = new Campo('Solicitação', '', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setITamanho(Campo::TAMANHO_PEQUENO);
        $oNr->setBCampoBloqueado(true);
        $oNr->setSValor($aValor[2]);

        $oEmpDes = new campo('Razão Social', '', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oEmpDes->setITamanho(Campo::TAMANHO_PEQUENO);
        $oEmpDes->setBCampoBloqueado(true);
        $oEmpDes->setSValor($aValor[1]);
        //$oEmpDes->addEvento(Campo::EVENTO_SAIR, '$("#' . $oNr->getId() . '").focus();');
        //---Adiciona uma linha em branco---///
        $oLinha = new campo('', 'linha', Campo::TIPO_LINHABRANCO, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oGrid = new Campo('Títulos a receber', 'rec', Campo::TIPO_GRID, 12, 12, 12, 12, 250);

        $oDataEmiss = new CampoConsulta('Emissão', 'recdtemiss', CampoConsulta::TIPO_DATA);

        $oSerie = new CampoConsulta('Documento', 'recdocto');

        $oVenc = new CampoConsulta('Vencimento', 'recprdtpro', CampoConsulta::TIPO_DATA);

        $oVlr = new CampoConsulta('Valor', 'recprvlr', CampoConsulta::TIPO_MONEY);
        $oVlr->setSOperacao('personalizado');
        $oVlr->setSTituloOperacao('Total:');

        $oDiasVenc = new CampoConsulta('Dias para vencer', 'diasvenc');
        $oDiasVenc->addComparacao('0', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');
        $oDiasVenc->addComparacao('0', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA, false, '');

        $oParcela = new CampoConsulta('Parcela', 'recparnro');

        $oBanco = new CampoConsulta('Banco', 'bcodes');

        $oGrid->addCampos($oDataEmiss, $oSerie, $oVenc, $oVlr, $oDiasVenc, $oParcela, $oBanco);
        $oGrid->setSController('PnlFinanCot');
        $oGrid->addParam('empcod', $aValor[0]);

        $this->addCampos(array($oNr, $oCnpj, $oEmpDes), array($oGrid));
    }

}
