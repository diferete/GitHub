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

        $oCodVerifDesenResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodVerifDesenResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodVerifDesenResp->setBOculto(true);

        $oVerifDesenResp = new Campo('Responsável', 'verifDesenhoResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oVerifDesenResp->setSIdPk($oCodVerifDesenResp->getId());
        $oVerifDesenResp->setClasseBusca('User');
        $oVerifDesenResp->addCampoBusca('usucodigo', '', '');
        $oVerifDesenResp->addCampoBusca('usunome', '', '');
        $oVerifDesenResp->setSIdTela($this->getTela()->getid());
        $oVerifDesenResp->setIMarginTop(3);

        $oCodVerifDesenResp->setClasseBusca('User');
        $oCodVerifDesenResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodVerifDesenResp->addCampoBusca('usunome', $oVerifDesenResp->getId(), $this->getTela()->getId());

        $oVerifDesenAnx = new Campo('Anexo', 'verifDesenhoAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel2 = new Campo('Verificação da relação de ferramentas por produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel2->setIMarginTop(28);
        $oVerifRelFerrPrev = new Campo('Previsão', 'verifRelFerrPrev', Campo::TIPO_DATA, 2);
        $oVerifRelFerrTer = new Campo('Término', 'verifRelFerrter', Campo::TIPO_DATA, 2);

        $oCodVerifRelFerrResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodVerifRelFerrResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodVerifRelFerrResp->setBOculto(true);

        $oVerifRelFerrResp = new Campo('Responsável', 'verifRelFerrResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oVerifRelFerrResp->setSIdPk($oCodVerifRelFerrResp->getId());
        $oVerifRelFerrResp->setClasseBusca('User');
        $oVerifRelFerrResp->addCampoBusca('usucodigo', '', '');
        $oVerifRelFerrResp->addCampoBusca('usunome', '', '');
        $oVerifRelFerrResp->setSIdTela($this->getTela()->getid());
        $oVerifRelFerrResp->setIMarginTop(3);

        $oCodVerifRelFerrResp->setClasseBusca('User');
        $oCodVerifRelFerrResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodVerifRelFerrResp->addCampoBusca('usunome', $oVerifRelFerrResp->getId(), $this->getTela()->getId());

        $oVerifRelFerrAnx = new Campo('Anexo', 'verifRelFerrAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel3 = new Campo('Análise dimensional e desenhos das ferramentas', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel3->setIMarginTop(28);
        $oVerifDesenFerrPrev = new Campo('Previsão', 'verifDesenhoFerrPrev', Campo::TIPO_DATA, 2);
        $oVerifDesenFerrTer = new Campo('Término', 'verifDesenhoFerrTer', Campo::TIPO_DATA, 2);

        $oCodVerifDesenFerrResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodVerifDesenFerrResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodVerifDesenFerrResp->setBOculto(true);

        $oVerifDesenFerrResp = new Campo('Responsável', 'verifDesenhoFerrResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oVerifDesenFerrResp->setSIdPk($oCodVerifDesenFerrResp->getId());
        $oVerifDesenFerrResp->setClasseBusca('User');
        $oVerifDesenFerrResp->addCampoBusca('usucodigo', '', '');
        $oVerifDesenFerrResp->addCampoBusca('usunome', '', '');
        $oVerifDesenFerrResp->setSIdTela($this->getTela()->getid());
        $oVerifDesenFerrResp->setIMarginTop(3);

        $oCodVerifDesenFerrResp->setClasseBusca('User');
        $oCodVerifDesenFerrResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodVerifDesenFerrResp->addCampoBusca('usunome', $oVerifDesenFerrResp->getId(), $this->getTela()->getId());

        $oVerifDesenFerrAnx = new Campo('Anexo', 'verifDesenhoFerrAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel5 = new Campo('Análise dimensional do produto', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel5->setIMarginTop(28);
        $oDimenProdPrev = new Campo('Previsão', 'dimenProdPrev', Campo::TIPO_DATA, 2);
        $oDimenProdTer = new Campo('Término', 'dimenProdTer', Campo::TIPO_DATA, 2);

        $oCodDimenProdResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodDimenProdResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodDimenProdResp->setBOculto(true);

        $oDimenProdResp = new Campo('Responsável', 'dimenProdResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oDimenProdResp->setSIdPk($oCodDimenProdResp->getId());
        $oDimenProdResp->setClasseBusca('User');
        $oDimenProdResp->addCampoBusca('usucodigo', '', '');
        $oDimenProdResp->addCampoBusca('usunome', '', '');
        $oDimenProdResp->setSIdTela($this->getTela()->getid());
        $oDimenProdResp->setIMarginTop(3);

        $oCodDimenProdResp->setClasseBusca('User');
        $oCodDimenProdResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodDimenProdResp->addCampoBusca('usunome', $oDimenProdResp->getId(), $this->getTela()->getId());

        $oDimenProdAnex = new Campo('Anexo', 'dimenProdAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel6 = new Campo('Ensaio da camada de zinco', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel6->setIMarginTop(28);
        $oCamadaZincoPrev = new Campo('Previsão', 'camadaZincoPrev', Campo::TIPO_DATA, 2);
        $oCamadaZincoTer = new Campo('Término', 'camadaZincoTer', Campo::TIPO_DATA, 2);

        $oCodCamadaZincoResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodCamadaZincoResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodCamadaZincoResp->setBOculto(true);

        $oCamadaZincoResp = new Campo('Responsável', 'camadaZincoResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oCamadaZincoResp->setSIdPk($oCodCamadaZincoResp->getId());
        $oCamadaZincoResp->setClasseBusca('User');
        $oCamadaZincoResp->addCampoBusca('usucodigo', '', '');
        $oCamadaZincoResp->addCampoBusca('usunome', '', '');
        $oCamadaZincoResp->setSIdTela($this->getTela()->getid());
        $oCamadaZincoResp->setIMarginTop(3);

        $oCodCamadaZincoResp->setClasseBusca('User');
        $oCodCamadaZincoResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodCamadaZincoResp->addCampoBusca('usunome', $oCamadaZincoResp->getId(), $this->getTela()->getId());

        $oCamadaZincoAnex = new Campo('Anexo', 'camadaZincoAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel7 = new Campo('Ensaio de dureza', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel7->setIMarginTop(28);
        $oEnsaioDurezaPrev = new Campo('Previsão', 'ensaioDurezaPrev', Campo::TIPO_DATA, 2);
        $oEnsaioDurezaTer = new Campo('Término', 'ensaioDurezaTer', Campo::TIPO_DATA, 2);

        $oCodEnsaioDurezaResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodEnsaioDurezaResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodEnsaioDurezaResp->setBOculto(true);

        $oEnsaioDurezaResp = new Campo('Responsável', 'ensaioDurezaResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oEnsaioDurezaResp->setSIdPk($oCodEnsaioDurezaResp->getId());
        $oEnsaioDurezaResp->setClasseBusca('User');
        $oEnsaioDurezaResp->addCampoBusca('usucodigo', '', '');
        $oEnsaioDurezaResp->addCampoBusca('usunome', '', '');
        $oEnsaioDurezaResp->setSIdTela($this->getTela()->getid());
        $oEnsaioDurezaResp->setIMarginTop(3);

        $oCodEnsaioDurezaResp->setClasseBusca('User');
        $oCodEnsaioDurezaResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodEnsaioDurezaResp->addCampoBusca('usunome', $oEnsaioDurezaResp->getId(), $this->getTela()->getId());

        $oEnsaioDurezaAnex = new Campo('Anexo', 'ensaioDurezaAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel8 = new Campo('Ensaio de carga de prova', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel8->setIMarginTop(28);
        $oCargaprovaPrev = new Campo('Previsão', 'cargaprovaPrev', Campo::TIPO_DATA, 2);
        $oCargaprovaTer = new Campo('Término', 'cargaprovaTer', Campo::TIPO_DATA, 2);

        $oCodCargaprovaResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodCargaprovaResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodCargaprovaResp->setBOculto(true);

        $oCargaprovaResp = new Campo('Responsável', 'cargaprovaResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oCargaprovaResp->setSIdPk($oCodCargaprovaResp->getId());
        $oCargaprovaResp->setClasseBusca('User');
        $oCargaprovaResp->addCampoBusca('usucodigo', '', '');
        $oCargaprovaResp->addCampoBusca('usunome', '', '');
        $oCargaprovaResp->setSIdTela($this->getTela()->getid());
        $oCargaprovaResp->setIMarginTop(3);

        $oCodCargaprovaResp->setClasseBusca('User');
        $oCodCargaprovaResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodCargaprovaResp->addCampoBusca('usunome', $oCargaprovaResp->getId(), $this->getTela()->getId());

        $oCargaprovaAnex = new Campo('Anexo', 'cargaprovaAnex', Campo::TIPO_UPLOAD, 2);

        $oLabel9 = new Campo('Processo realizado por terceiro', 'label1', Campo::TIPO_LABEL, 3);
        $oLabel9->setIMarginTop(28);
        $oTerceiroPrev = new Campo('Previsão', 'terceiroPrev', Campo::TIPO_DATA, 2);
        $oTerceiroTer = new Campo('Término', 'terceiroTer', Campo::TIPO_DATA, 2);

        $oCodTerceiroResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodTerceiroResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodTerceiroResp->setBOculto(true);

        $oTerceiroResp = new Campo('Responsável', 'terceiroResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oTerceiroResp->setSIdPk($oCodTerceiroResp->getId());
        $oTerceiroResp->setClasseBusca('User');
        $oTerceiroResp->addCampoBusca('usucodigo', '', '');
        $oTerceiroResp->addCampoBusca('usunome', '', '');
        $oTerceiroResp->setSIdTela($this->getTela()->getid());
        $oTerceiroResp->setIMarginTop(3);

        $oCodTerceiroResp->setClasseBusca('User');
        $oCodTerceiroResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodTerceiroResp->addCampoBusca('usunome', $oTerceiroResp->getId(), $this->getTela()->getId());

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

        /*
          $oEnsPlan = new Campo('As etapas definidas no planejamento foram cumpridas conforme cronograma?', 'ensPlan', Campo::TIPO_RADIO, 3);
          $oEnsPlan->addItenRadio('Sim', 'Sim');
          $oEnsPlan->addItenRadio('Não', 'Não');
          $oEnsPlan->addItenRadio('Na', 'NA');
         * 
         */

        $oEnsComem = new Campo('Comentário', 'ensComem', Campo::TIPO_TEXTAREA, 5);

        $oCodRespEnsAnalise = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodRespEnsAnalise->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodRespEnsAnalise->setBOculto(true);

        $oRespEnsAnalise = new Campo('Responsável', 'respEns', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oRespEnsAnalise->setSIdPk($oCodRespEnsAnalise->getId());
        $oRespEnsAnalise->setClasseBusca('User');
        $oRespEnsAnalise->addCampoBusca('usucodigo', '', '');
        $oRespEnsAnalise->addCampoBusca('usunome', '', '');
        $oRespEnsAnalise->setSIdTela($this->getTela()->getid());
        $oRespEnsAnalise->setIMarginTop(3);
        $oRespEnsAnalise->setSValor($_SESSION['nome']);

        $oCodRespEnsAnalise->setClasseBusca('User');
        $oCodRespEnsAnalise->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodRespEnsAnalise->addCampoBusca('usunome', $oRespEnsAnalise->getId(), $this->getTela()->getId());

        $oDataEnsAnalise = new Campo('Data da análise', 'dtanaliseens', Campo::TIPO_DATA, 1, 1, 12, 12);

        $oFieldAnalise->addCampos(array($oEnsReq, $oEnsReqDef), $oLinha1, array($oEnsReqLegal/* , $oEnsPlan */), $oLinha1, $oEnsComem, array($oRespEnsAnalise, $oDataEnsAnalise));


        //###################################################################################################  
        $oFieldValProjeto = new FieldSet('Controle de validação do projeto');
        $oFieldValProjeto->setOculto(true);

        $oValNf = new Campo('Nota fiscal nº', 'valNf', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValNfPrev = new Campo('Previsão', 'valNfPrev', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oValNfTer = new Campo('Término', 'valNfTer', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oCodValNfResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodValNfResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodValNfResp->setBOculto(true);

        $oValNfResp = new Campo('Responsável', 'valNfResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oValNfResp->setSIdPk($oCodValNfResp->getId());
        $oValNfResp->setClasseBusca('User');
        $oValNfResp->addCampoBusca('usucodigo', '', '');
        $oValNfResp->addCampoBusca('usunome', '', '');
        $oValNfResp->setSIdTela($this->getTela()->getid());
        $oValNfResp->setIMarginTop(3);

        $oCodValNfResp->setClasseBusca('User');
        $oCodValNfResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodValNfResp->addCampoBusca('usunome', $oValNfResp->getId(), $this->getTela()->getId());

        $oValOd = new Campo('Ordem de fabricação nº', 'valOd', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValOdPrev = new Campo('Previsão', 'valOdPrev', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oValOdTer = new Campo('Término', 'valOdTer', Campo::TIPO_DATA, 2, 2, 12, 12);

        $oCodValOdResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodValOdResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodValOdResp->setBOculto(true);

        $oValOdResp = new Campo('Responsável', 'valODResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oValOdResp->setSIdPk($oCodValOdResp->getId());
        $oValOdResp->setClasseBusca('User');
        $oValOdResp->addCampoBusca('usucodigo', '', '');
        $oValOdResp->addCampoBusca('usunome', '', '');
        $oValOdResp->setSIdTela($this->getTela()->getid());
        $oValOdResp->setIMarginTop(3);

        $oCodValOdResp->setClasseBusca('User');
        $oCodValOdResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodValOdResp->addCampoBusca('usunome', $oValOdResp->getId(), $this->getTela()->getId());

        $oValPed = new Campo('Pedido nº', 'valPed', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oValPedPrev = new Campo('Previsão', 'valPedPrev', Campo::TIPO_DATA, 2);
        $oValPedTer = new Campo('Término', 'valPedTer', Campo::TIPO_DATA, 2);

        $oCodValPedResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodValPedResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodValPedResp->setBOculto(true);

        $oValPedResp = new Campo('Responsável', 'valPedResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oValPedResp->setSIdPk($oCodValPedResp->getId());
        $oValPedResp->setClasseBusca('User');
        $oValPedResp->addCampoBusca('usucodigo', '', '');
        $oValPedResp->addCampoBusca('usunome', '', '');
        $oValPedResp->setSIdTela($this->getTela()->getid());
        $oValPedResp->setIMarginTop(3);

        $oCodValPedResp->setClasseBusca('User');
        $oCodValPedResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodValPedResp->addCampoBusca('usunome', $oValPedResp->getId(), $this->getTela()->getId());

        $oValPapp = new Campo('PAPP nº', 'valPapp', Campo::TIPO_TEXTO, 2);
        $oValPappPrev = new Campo('Previsão', 'valPappPrev', Campo::TIPO_DATA, 2);
        $oValPappTer = new Campo('Término', 'valPappTer', Campo::TIPO_DATA, 2);

        $oCodValPappResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodValPappResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodValPappResp->setBOculto(true);

        $oValPappResp = new Campo('Responsável', 'valPappResp', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oValPappResp->setSIdPk($oCodValPappResp->getId());
        $oValPappResp->setClasseBusca('User');
        $oValPappResp->addCampoBusca('usucodigo', '', '');
        $oValPappResp->addCampoBusca('usunome', '', '');
        $oValPappResp->setSIdTela($this->getTela()->getid());
        $oValPappResp->setIMarginTop(3);

        $oCodValPappResp->setClasseBusca('User');
        $oCodValPappResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodValPappResp->addCampoBusca('usunome', $oValPappResp->getId(), $this->getTela()->getId());

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

        $oCodRespVal = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodRespVal->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodRespVal->setBOculto(true);

        $oRespVal = new Campo('Responsável', 'respvalproj', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oRespVal->setSIdPk($oCodRespVal->getId());
        $oRespVal->setClasseBusca('User');
        $oRespVal->addCampoBusca('usucodigo', '', '');
        $oRespVal->addCampoBusca('usunome', '', '');
        $oRespVal->setSIdTela($this->getTela()->getid());
        $oRespVal->setIMarginTop(3);
        $oRespVal->setSValor($_SESSION['nome']);

        $oCodRespVal->setClasseBusca('User');
        $oCodRespVal->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodRespVal->addCampoBusca('usunome', $oRespVal->getId(), $this->getTela()->getId());


        $oDataVal = new Campo('Data da análise', 'dtanalisevalproj', Campo::TIPO_DATA, 1, 1, 12, 12);

        $oFieldAnaCrit->addCampos($oEtapProj, $oResultProj, $oCliProj, $oValProj, $oComenValProj, array($oRespVal, $oDataVal));

        $this->addCampos(array($oFilcgc, $oNr), $oLinha1, $oFiedVerif, $oFieldAnalise, $oFieldValProjeto, $oFieldAnaCrit);
    }

}
