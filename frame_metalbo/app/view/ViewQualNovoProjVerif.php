<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualNovoProjVerif extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaTela() {
        parent::criaTela();

        $oFilcgc = new Campo('Empresa', 'EmpRex.filcgc', Campo::TIPO_TEXTO, 2);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Número', 'nr', Campo::TIPO_TEXTO, 1);
        $oNr->setBCampoBloqueado(true);

        $oLinha1 = new campo('', 'linha1', Campo::TIPO_LINHA, 12);
        $oLinha1->setApenasTela(true);

        $oLinhaBranco = new campo('', 'linha1', Campo::TIPO_LINHABRANCO, 12);
        $oLinhaBranco->setApenasTela(true);

        //###################################################################################################  
        $oFiedVerif = new FieldSet('Controle de verificação de projeto');


        $oLabel1 = new Campo('Verificação dos desenhos do produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel1->setIMarginTop(28);
        $oVerifDesenPrev = new Campo('Previsão', 'verifDesenhoPrev', Campo::TIPO_DATA, 2);
        $oVerifDesenTer = new Campo('Término', 'verifDesenhoTer', Campo::TIPO_DATA, 2);
        $oVerifDesenResp = new Campo('Responsável', 'verifDesenhoResp', Campo::TIPO_TEXTO, 2);
        $oVerifDesenResp->setIMarginTop(3);
        $oVerifDesenAnx = new Campo('Anexo', 'verifDesenhoAnex', Campo::TIPO_UPLOAD, 2);



        $oLabel2 = new Campo('Verificação da relação de ferramentas por produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel2->setIMarginTop(28);
        $oVerifRelFerrPrev = new Campo('Previsão', 'verifRelFerrPrev', Campo::TIPO_DATA, 2);
        $oVerifRelFerrTer = new Campo('Término', 'verifRelFerrter', Campo::TIPO_DATA, 2);
        $oVerifRelFerrResp = new Campo('Responsável', 'verifRelFerrResp', Campo::TIPO_TEXTO, 2);
        $oVerifRelFerrResp->setIMarginTop(3);
        $oVerifRelFerrAnx = new Campo('Anexo', 'verifRelFerrAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel3 = new Campo('Análise dimensional e desenhos das ferramentas', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel3->setIMarginTop(28);
        $oVerifDesenFerrPrev = new Campo('Previsão', 'verifDesenhoFerrPrev', Campo::TIPO_DATA, 2);
        $oVerifDesenFerrTer = new Campo('Término', 'verifDesenhoFerrTer', Campo::TIPO_DATA, 2);
        $oVerifDesenFerrResp = new Campo('Responsável', 'verifDesenhoFerrResp', Campo::TIPO_TEXTO, 2);
        $oVerifDesenFerrResp->setIMarginTop(3);
        $oVerifDesenFerrAnx = new Campo('Anexo', 'verifDesenhoFerrAnex', Campo::TIPO_UPLOAD, 2);

        /* $oLabel4 = new Campo('Análise do dimensional das ferramentas','label1', Campo::TIPO_LABEL,3);
          $oLabel4->setIMarginTop(28);
          $oDimenFerrPrev = new Campo('Previsão','dimenFerrPrev', Campo::TIPO_DATA,2);
          $oDimenFerrTer = new Campo('Término','dimenFerrTer', Campo::TIPO_DATA,2);
          $oDimenFerrResp = new Campo('Responsável','dimenFerrResp', Campo::TIPO_TEXTO,2);
          $oDimenFerrResp->setIMarginTop(3);
          $oDimenFerrAnex = new Campo('Anexo','dimenFerrAnex', Campo::TIPO_UPLOAD,2);
         * 
         */

        $oLabel5 = new Campo('Análise dimensional do produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel5->setIMarginTop(28);
        $oDimenProdPrev = new Campo('Previsão', 'dimenProdPrev', Campo::TIPO_DATA, 2);
        $oDimenProdTer = new Campo('Término', 'dimenProdTer', Campo::TIPO_DATA, 2);
        $oDimenProdResp = new Campo('Responsável', 'dimenProdResp', Campo::TIPO_TEXTO, 2);
        $oDimenProdResp->setIMarginTop(3);
        $oDimenProdAnex = new Campo('Anexo', 'dimenProdAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel6 = new Campo('Ensaio da camada de zinco', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel6->setIMarginTop(28);
        $oCamadaZincoPrev = new Campo('Previsão', 'camadaZincoPrev', Campo::TIPO_DATA, 2);
        $oCamadaZincoTer = new Campo('Término', 'camadaZincoTer', Campo::TIPO_DATA, 2);
        $oCamadaZincoResp = new Campo('Responsável', 'camadaZincoResp', Campo::TIPO_TEXTO, 2);
        $oCamadaZincoResp->setIMarginTop(3);
        $oCamadaZincoAnex = new Campo('Anexo', 'camadaZincoAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel7 = new Campo('Ensaio de dureza', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel7->setIMarginTop(28);
        $oEnsaioDurezaPrev = new Campo('Previsão', 'ensaioDurezaPrev', Campo::TIPO_DATA, 2);
        $oEnsaioDurezaTer = new Campo('Término', 'ensaioDurezaTer', Campo::TIPO_DATA, 2);
        $oEnsaioDurezaResp = new Campo('Responsável', 'ensaioDurezaResp', Campo::TIPO_TEXTO, 2);
        $oEnsaioDurezaResp->setIMarginTop(3);
        $oEnsaioDurezaAnex = new Campo('Anexo', 'ensaioDurezaAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel8 = new Campo('Ensaio de carga de prova', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel8->setIMarginTop(28);
        $oCargaprovaPrev = new Campo('Previsão', 'cargaprovaPrev', Campo::TIPO_DATA, 2);
        $oCargaprovaTer = new Campo('Término', 'cargaprovaTer', Campo::TIPO_DATA, 2);
        $oCargaprovaResp = new Campo('Responsável', 'cargaprovaResp', Campo::TIPO_TEXTO, 2);
        $oCargaprovaResp->setIMarginTop(3);
        $oCargaprovaAnex = new Campo('Anexo', 'cargaprovaAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel9 = new Campo('Processo realizado por terceiro', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel9->setIMarginTop(28);
        $oTerceiroPrev = new Campo('Previsão', 'terceiroPrev', Campo::TIPO_DATA, 2);
        $oTerceiroTer = new Campo('Término', 'terceiroTer', Campo::TIPO_DATA, 2);
        $oTerceiroResp = new Campo('Responsável', 'terceiroResp', Campo::TIPO_TEXTO, 2);
        $oTerceiroResp->setIMarginTop(3);
        $oTerceiroAnex = new Campo('Anexo', 'terceiroAnex', Campo::TIPO_UPLOAD, 2);



        $oFiedVerif->setOculto(true);

        $oFiedVerif->addCampos($oLinhaBranco, array($oLabel1, $oVerifDesenPrev, $oVerifDesenTer,
            $oVerifDesenResp, $oVerifDesenAnx), $oLinha1, array($oLabel2, $oVerifRelFerrPrev, $oVerifRelFerrTer, $oVerifRelFerrResp, $oVerifRelFerrAnx), $oLinha1, array($oLabel3, $oVerifDesenFerrPrev, $oVerifDesenFerrTer, $oVerifDesenFerrResp, $oVerifDesenFerrAnx), $oLinha1,
                //array($oLabel4,$oDimenFerrPrev,$oDimenFerrTer,$oDimenFerrResp,$oDimenFerrAnex),$oLinha1,
                array($oLabel5, $oDimenProdPrev, $oDimenProdTer, $oDimenProdResp, $oDimenProdAnex), $oLinha1, array($oLabel6, $oCamadaZincoPrev, $oCamadaZincoTer, $oCamadaZincoResp, $oCamadaZincoAnex), $oLinha1, array($oLabel7, $oEnsaioDurezaPrev, $oEnsaioDurezaTer, $oEnsaioDurezaResp, $oEnsaioDurezaAnex), $oLinha1, array($oLabel8, $oCargaprovaPrev, $oCargaprovaTer, $oCargaprovaResp, $oCargaprovaAnex), $oLinha1, array($oLabel9, $oTerceiroPrev, $oTerceiroTer, $oTerceiroResp, $oTerceiroAnex));

        //###################################################################################################  

        $oFieldAnalise = new FieldSet('Análise crítica de verificação do projeto');
        $oFieldAnalise->setOculto(true);

        $oEnsReq = new Campo('Os ensaios requeridos foram realizados?', 'ensReq', Campo::TIPO_RADIO, 3);
        $oEnsReq->addItenRadio('Sim', 'Sim');
        $oEnsReq->addItenRadio('Não', 'Não');
        $oEnsReq->addItenRadio('Na', 'NA');

        $oEnsReqDef = new Campo('Os resultados atenderam ao requisito definido pela empresa?', 'ensReqDef', Campo::TIPO_RADIO, 4);
        $oEnsReqDef->addItenRadio('Sim', 'Sim');
        $oEnsReqDef->addItenRadio('Não', 'Não');
        $oEnsReqDef->addItenRadio('Na', 'NA');

        $oEnsReqLegal = new Campo('Os resultados atenderam ao requisitos legais aplicáveis?', 'ensReqLegal', Campo::TIPO_RADIO, 3);
        $oEnsReqLegal->addItenRadio('Sim', 'Sim');
        $oEnsReqLegal->addItenRadio('Não', 'Não');
        $oEnsReqLegal->addItenRadio('Na', 'NA');

        $oEnsPlan = new Campo('As etapas definidas no planejamento foram cumpridas conforme cronograma?', 'ensPlan', Campo::TIPO_RADIO, 3);
        $oEnsPlan->addItenRadio('Sim', 'Sim');
        $oEnsPlan->addItenRadio('Não', 'Não');
        $oEnsPlan->addItenRadio('Na', 'NA');

        $oEnsComem = new Campo('Comentário', 'ensComem', Campo::TIPO_TEXTAREA, 5);
        $oRespEnsAnalise = new Campo('Responsável', 'respEns', Campo::TIPO_TEXTO, 3);

        $oFieldAnalise->addCampos(array($oEnsReq, $oEnsReqDef), $oLinha1, array($oEnsReqLegal, $oEnsPlan), $oLinha1, $oEnsComem, $oRespEnsAnalise);


        //###################################################################################################  
        $oFieldValProjeto = new FieldSet('Controle de validação do projeto');
        $oFieldValProjeto->setOculto(true);

        $oValNf = new Campo('Nota fiscal nº', 'valNf', Campo::TIPO_TEXTO, 2);
        $oValNfPrev = new Campo('Previsão', 'valNfPrev', Campo::TIPO_DATA, 2);
        $oValNfTer = new Campo('Término', 'valNfTer', Campo::TIPO_DATA, 2);
        $oValNfResp = new Campo('Responsável', 'valNfResp', Campo::TIPO_TEXTO, 3);

        $oValOd = new Campo('Ordem de fabricação nº', 'valOd', Campo::TIPO_TEXTO, 2);
        $oValOdPrev = new Campo('Previsão', 'valOdPrev', Campo::TIPO_DATA, 2);
        $oValOdTer = new Campo('Término', 'valOdTer', Campo::TIPO_DATA, 2);
        $oValOdResp = new Campo('Responsável', 'valODResp', Campo::TIPO_TEXTO, 3);

        $oValPed = new Campo('Pedido nº', 'valPed', Campo::TIPO_TEXTO, 2);
        $oValPedPrev = new Campo('Previsão', 'valPedPrev', Campo::TIPO_DATA, 2);
        $oValPedTer = new Campo('Término', 'valPedTer', Campo::TIPO_DATA, 2);
        $oValPedResp = new Campo('Responsável', 'valPedResp', Campo::TIPO_TEXTO, 3);

        $oValPapp = new Campo('PAPP nº', 'valPapp', Campo::TIPO_TEXTO, 2);
        $oValPappPrev = new Campo('Previsão', 'valPappPrev', Campo::TIPO_DATA, 2);
        $oValPappTer = new Campo('Término', 'valPappTer', Campo::TIPO_DATA, 2);
        $oValPappResp = new Campo('Responsável', 'valPappResp', Campo::TIPO_TEXTO, 3);


        $oFieldValProjeto->addCampos(array($oValNf, $oValNfPrev, $oValNfTer, $oValNfResp), array($oValOd, $oValOdPrev, $oValOdTer, $oValOdResp), array($oValPed, $oValPedPrev, $oValPedTer, $oValPedResp), array($oValPapp, $oValPappPrev, $oValPappTer, $oValPappResp));

        //###################################################################################################  
        $oFieldAnaCrit = new FieldSet('Análise crítica de validação do projeto');
        $oFieldAnaCrit->setOculto(true);

        $oEtapProj = new Campo('As etapas do projeto foram realizadas conforme planejamento?', 'etapProj', Campo::TIPO_RADIO, 3);
        $oEtapProj->addItenRadio('Sim', 'Sim');
        $oEtapProj->addItenRadio('Não', 'Não');
        $oEtapProj->addItenRadio('Na', 'NA');

        $oResultProj = new Campo('Os resultados atenderam ao requisito definido pelo cliente?', 'result', Campo::TIPO_RADIO, 3);
        $oResultProj->addItenRadio('Sim', 'Sim');
        $oResultProj->addItenRadio('Não', 'Não');
        $oResultProj->addItenRadio('Na', 'NA');

        $oCliProj = new Campo('O cliente aprovou o produto?', 'cliprov', Campo::TIPO_RADIO, 3);
        $oCliProj->addItenRadio('Sim', 'Sim');
        $oCliProj->addItenRadio('Não', 'Não');
        $oCliProj->addItenRadio('Na', 'NA');

        $oValProj = new Campo('Consideramos o projeto validado?', 'valproj', Campo::TIPO_RADIO, 3);
        $oValProj->addItenRadio('Sim', 'Sim');
        $oValProj->addItenRadio('Não', 'Não');
        $oValProj->addItenRadio('Na', 'NA');

        $oComenValProj = new Campo('Comentários / Alterações Propostas', 'comenvalproj', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);

        $oRespVal = new campo('Responsável', 'respvalproj', Campo::TIPO_TEXTO, 3, 3, 12, 12);

        $oFieldAnaCrit->addCampos($oEtapProj, $oResultProj, $oCliProj, $oValProj, $oComenValProj, $oRespVal);

        $this->addCampos(array($oFilcgc, $oNr), $oLinha1, $oFiedVerif, $oFieldAnalise, $oFieldValProjeto, $oFieldAnaCrit);
    }

}
