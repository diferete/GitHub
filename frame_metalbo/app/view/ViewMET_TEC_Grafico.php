<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Grafico extends View {

    public function __construct() {
        parent::__construct();
    }

    public function relChamados() {
        parent::criaTelaRelatorioGrafico();

        $this->setTituloTela('Relatório em gráfico');
        $this->setBTela(true);

        $oDivisor1 = new Campo('Situações por Setor', 'divisor1', Campo::DIVISOR_INFO, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(TRUE);

        $oDataIni = new Campo('Data Inicial', 'dataini', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oDataFin = new Campo('Data Final', 'datafim', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataFin->setSValor(date('d/m/Y'));

        $oSituacao = new Campo('Situação da Ação', 'situacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oSituacao->addItemSelect('0', 'Selecione...');
        $oSituacao->addItemSelect('T', 'Todas');
        $oSituacao->addItemSelect('A', 'Aguardando');
        $oSituacao->addItemSelect('I', 'Iniciadas');
        $oSituacao->addItemSelect('F', 'Finalizadas');


        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","graficoChamadoss","' . $this->getTela()->getId() . '-form");';


        $oSituacao->addEvento(Campo::EVENTO_CHANGE, $sAcao);

        $this->addCampos(array($oDataIni, $oDataFin), $oSituacao);
    }

}
