<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualNovoProjDet extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $oFilcgc = new Campo('Empresa', 'EmpRex.filcgc', Campo::TIPO_TEXTO, 2);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oFieldDetProj = new FieldSet('Detalhamento do Projeto');

        $oLinha1 = new campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);
        $oLinha2 = new campo('', 'linha2', Campo::TIPO_LINHA, 12);
        $oLinha2->setApenasTela(true);


        $oLabel1 = new Campo('Elaborar os desenhos do produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel1->setIMarginTop(30);
        $oDesenPrev = new Campo('Previsão', 'desenho_prev', Campo::TIPO_DATA, 2);
        $oDesenTer = new Campo('Término', 'desenho_ter', Campo::TIPO_DATA, 2);
        $oDesenResp = new campo('Responsável', 'desenho_resp', Campo::TIPO_TEXTO, 3);
        $oDesenResp->setIMarginTop(2);

        $oLabel2 = new Campo('Definir etapas do processo de fabricação', 'label2', Campo::TIPO_LABEL, 3);
        $oLabel2->setIMarginTop(30);
        $oEtapaFabPrev = new campo('Previsão', 'etapasfab_prev', Campo::TIPO_DATA, 2);
        $oEtapaFabTer = new campo('Término', 'etapasfab_ter', Campo::TIPO_DATA, 2);
        $oEtapaFabResp = new campo('Responsável', 'etapas_resp', Campo::TIPO_TEXTO, 3);
        $oEtapaFabResp->setIMarginTop(2);

        $oLabel3 = new Campo('Elaborar relação de ferramentas do produto', 'label3', Campo::TIPO_LABEL, 3);
        $oLabel3->setIMarginTop(30);
        $oFerrPrev = new Campo('Previsão', 'relFerr_prev', Campo::TIPO_DATA, 2);
        $oFerrTer = new Campo('Término', 'relFerr_ter', Campo::TIPO_DATA, 2);
        $oFerrResp = new Campo('Responsável', 'relFerr_resp', Campo::TIPO_TEXTO, 3);
        $oFerrResp->setIMarginTop(2);

        $oLabel4 = new Campo('Elaborar desenhos de ferramentas', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel4->setIMarginTop(30);
        $oFerrDesenPrev = new Campo('Previsão', 'relFerrDesen_prev', Campo::TIPO_DATA, 2);
        $oFerrDesenTer = new Campo('Término', 'relFerrDesen_ter', Campo::TIPO_DATA, 2);
        $oFerrDesenResp = new Campo('Responsável', 'relFerrDesen_resp', Campo::TIPO_TEXTO, 3);
        $oFerrDesenResp->setIMarginTop(2);

        $oLabel5 = new Campo('Distrubuição de desenhos na ferramentaria', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel5->setIMarginTop(30);
        $oFerrDistPrev = new Campo('Previsão', 'relFerrDist_prev', Campo::TIPO_DATA, 2);
        $oFerrDistTer = new Campo('Término', 'relFerrDist_ter', Campo::TIPO_DATA, 2);
        $oFerrDistResp = new Campo('Responsável', 'relFerrDist_resp', Campo::TIPO_TEXTO, 3);
        $oFerrDistResp->setIMarginTop(2);

        $oLabel6 = new Campo('Confeccionar ferramentas', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel6->setIMarginTop(30);
        $oFerrConfPrev = new Campo('Previsão', 'relFerrConf_prev', Campo::TIPO_DATA, 2);
        $oFerrContTer = new Campo('Término', 'relFerrConf_ter', Campo::TIPO_DATA, 2);
        $oFerrConfResp = new Campo('Responsável', 'relFerrConf_resp', Campo::TIPO_TEXTO, 3);
        $oFerrConfResp->setIMarginTop(2);

        $oFieldDetProj->addCampos(array($oLabel1, $oDesenPrev, $oDesenTer, $oDesenResp), $oLinha2, array($oLabel2, $oEtapaFabPrev, $oEtapaFabTer, $oEtapaFabResp), $oLinha2, array($oLabel3, $oFerrPrev, $oFerrTer, $oFerrResp), $oLinha2, array($oLabel4, $oFerrDesenPrev, $oFerrDesenTer, $oFerrDesenResp), $oLinha2, array($oLabel5, $oFerrDistPrev, $oFerrDistTer, $oFerrDistResp), $oLinha2, array($oLabel6, $oFerrConfPrev, $oFerrContTer, $oFerrConfResp), $oLinha2);
        $oFieldDetProj->setOculto(true);

        $oFieldCrit = new FieldSet('Análise crítica do detalhamento do projeto');

        $oFerrElaboradas = new Campo('Todas as ferramentas foram elaboradas?', 'ferrElaboradas', Campo::TIPO_RADIO, 3);
        $oFerrElaboradas->addItenRadio('Sim', 'Sim');
        $oFerrElaboradas->addItenRadio('Não', 'Não');
        $oFerrElaboradas->addItenRadio('Nd', 'NA');

        $oDesenAcordo = new campo('O desenho do produto está de acordo conforme requisitos do cliente?', 'desenAcordo', Campo::TIPO_RADIO, 5);
        $oDesenAcordo->addItenRadio('Sim', 'Sim');
        $oDesenAcordo->addItenRadio('Não', 'Não');
        $oDesenAcordo->addItenRadio('Nd', 'NA');

        $oComenCrit = new Campo('Comentários', 'comenCrit', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);

        $oRespCrit = new Campo('Responsável', 'respAnaliseCri', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oRespCrit->setBCampoBloqueado(true);


        $oDataCrit = new Campo('Data da análise', 'dtanalisecritica', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDataCrit->setBCampoBloqueado(true);


        $oFieldCrit->setOculto(true);

        $oFieldCrit->addCampos(array($oFerrElaboradas, $oDesenAcordo), $oComenCrit, array($oRespCrit, $oDataCrit));



        $this->addCampos(array($oFilcgc, $oNr), $oLinha1, $oFieldDetProj, $oFieldCrit, $oLinha2);
    }

}
