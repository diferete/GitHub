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

        $oCodDesenResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodDesenResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodDesenResp->setBOculto(true);

        $oDesenResp = new Campo('Responsável', 'desenho_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oDesenResp->setSIdPk($oCodDesenResp->getId());
        $oDesenResp->setClasseBusca('User');
        $oDesenResp->addCampoBusca('usucodigo', '', '');
        $oDesenResp->addCampoBusca('usunome', '', '');
        $oDesenResp->setSIdTela($this->getTela()->getid());
        $oDesenResp->setIMarginTop(2);

        $oCodDesenResp->setClasseBusca('User');
        $oCodDesenResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodDesenResp->addCampoBusca('usunome', $oDesenResp->getId(), $this->getTela()->getId());

        $oLabel2 = new Campo('Definir etapas do processo de fabricação', 'label2', Campo::TIPO_LABEL, 3);
        $oLabel2->setIMarginTop(30);
        $oEtapaFabPrev = new campo('Previsão', 'etapasfab_prev', Campo::TIPO_DATA, 2);
        $oEtapaFabTer = new campo('Término', 'etapasfab_ter', Campo::TIPO_DATA, 2);

        $oCodEtapaFabResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodEtapaFabResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodEtapaFabResp->setBOculto(true);

        $oEtapaFabResp = new Campo('Responsável', 'etapas_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oEtapaFabResp->setSIdPk($oCodEtapaFabResp->getId());
        $oEtapaFabResp->setClasseBusca('User');
        $oEtapaFabResp->addCampoBusca('usucodigo', '', '');
        $oEtapaFabResp->addCampoBusca('usunome', '', '');
        $oEtapaFabResp->setSIdTela($this->getTela()->getid());
        $oEtapaFabResp->setIMarginTop(2);

        $oCodEtapaFabResp->setClasseBusca('User');
        $oCodEtapaFabResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodEtapaFabResp->addCampoBusca('usunome', $oEtapaFabResp->getId(), $this->getTela()->getId());

        $oLabel3 = new Campo('Elaborar relação de ferramentas do produto', 'label3', Campo::TIPO_LABEL, 3);
        $oLabel3->setIMarginTop(30);
        $oFerrPrev = new Campo('Previsão', 'relFerr_prev', Campo::TIPO_DATA, 2);
        $oFerrTer = new Campo('Término', 'relFerr_ter', Campo::TIPO_DATA, 2);

        $oCodFerrResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodFerrResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodFerrResp->setBOculto(true);

        $oFerrResp = new Campo('Responsável', 'relFerr_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFerrResp->setSIdPk($oCodFerrResp->getId());
        $oFerrResp->setClasseBusca('User');
        $oFerrResp->addCampoBusca('usucodigo', '', '');
        $oFerrResp->addCampoBusca('usunome', '', '');
        $oFerrResp->setSIdTela($this->getTela()->getid());
        $oFerrResp->setIMarginTop(2);

        $oCodFerrResp->setClasseBusca('User');
        $oCodFerrResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodFerrResp->addCampoBusca('usunome', $oFerrResp->getId(), $this->getTela()->getId());

        $oLabel4 = new Campo('Elaborar desenhos de ferramentas', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel4->setIMarginTop(30);
        $oFerrDesenPrev = new Campo('Previsão', 'relFerrDesen_prev', Campo::TIPO_DATA, 2);
        $oFerrDesenTer = new Campo('Término', 'relFerrDesen_ter', Campo::TIPO_DATA, 2);

        $oCodFerrDesenResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodFerrDesenResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodFerrDesenResp->setBOculto(true);

        $oFerrDesenResp = new Campo('Responsável', 'relFerrDesen_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFerrDesenResp->setSIdPk($oCodFerrDesenResp->getId());
        $oFerrDesenResp->setClasseBusca('User');
        $oFerrDesenResp->addCampoBusca('usucodigo', '', '');
        $oFerrDesenResp->addCampoBusca('usunome', '', '');
        $oFerrDesenResp->setSIdTela($this->getTela()->getid());
        $oFerrDesenResp->setIMarginTop(2);

        $oCodFerrDesenResp->setClasseBusca('User');
        $oCodFerrDesenResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodFerrDesenResp->addCampoBusca('usunome', $oFerrDesenResp->getId(), $this->getTela()->getId());

        $oLabel5 = new Campo('Distrubuição de desenhos na ferramentaria', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel5->setIMarginTop(30);
        $oFerrDistPrev = new Campo('Previsão', 'relFerrDist_prev', Campo::TIPO_DATA, 2);
        $oFerrDistTer = new Campo('Término', 'relFerrDist_ter', Campo::TIPO_DATA, 2);

        $oCodFerrDistResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodFerrDistResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodFerrDistResp->setBOculto(true);

        $oFerrDistResp = new Campo('Responsável', 'relFerrDist_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFerrDistResp->setSIdPk($oCodFerrDistResp->getId());
        $oFerrDistResp->setClasseBusca('User');
        $oFerrDistResp->addCampoBusca('usucodigo', '', '');
        $oFerrDistResp->addCampoBusca('usunome', '', '');
        $oFerrDistResp->setSIdTela($this->getTela()->getid());
        $oFerrDistResp->setIMarginTop(2);

        $oCodFerrDistResp->setClasseBusca('User');
        $oCodFerrDistResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodFerrDistResp->addCampoBusca('usunome', $oFerrDistResp->getId(), $this->getTela()->getId());

        $oLabel6 = new Campo('Confeccionar ferramentas', 'label4', Campo::TIPO_LABEL, 3);
        $oLabel6->setIMarginTop(30);
        $oFerrConfPrev = new Campo('Previsão', 'relFerrConf_prev', Campo::TIPO_DATA, 2);
        $oFerrContTer = new Campo('Término', 'relFerrConf_ter', Campo::TIPO_DATA, 2);

        $oCodFerrConfResp = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodFerrConfResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodFerrConfResp->setBOculto(true);

        $oFerrConfResp = new Campo('Responsável', 'relFerrConf_resp', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFerrConfResp->setSIdPk($oCodFerrConfResp->getId());
        $oFerrConfResp->setClasseBusca('User');
        $oFerrConfResp->addCampoBusca('usucodigo', '', '');
        $oFerrConfResp->addCampoBusca('usunome', '', '');
        $oFerrConfResp->setSIdTela($this->getTela()->getid());
        $oFerrConfResp->setIMarginTop(2);

        $oCodFerrConfResp->setClasseBusca('User');
        $oCodFerrConfResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodFerrConfResp->addCampoBusca('usunome', $oFerrConfResp->getId(), $this->getTela()->getId());

        $oFieldDetProj->addCampos(array($oLabel1, $oDesenPrev, $oDesenTer, $oDesenResp), $oLinha2, array($oLabel2, $oEtapaFabPrev, $oEtapaFabTer, $oEtapaFabResp), $oLinha2, array($oLabel3, $oFerrPrev, $oFerrTer, $oFerrResp), $oLinha2, array($oLabel4, $oFerrDesenPrev, $oFerrDesenTer, $oFerrDesenResp), $oLinha2, array($oLabel5, $oFerrDistPrev, $oFerrDistTer, $oFerrDistResp), $oLinha2, array($oLabel6, $oFerrConfPrev, $oFerrContTer, $oFerrConfResp), $oLinha2);
        $oFieldDetProj->setOculto(true);

        $oFieldCrit = new FieldSet('Análise crítica do detalhamento do projeto');

        $oFerrElaboradas = new Campo('Todas as ferramentas foram elaboradas?', 'ferrElaboradas', Campo::TIPO_RADIO, 3);
        $oFerrElaboradas->addItenRadio('Sim', 'Sim');
        $oFerrElaboradas->addItenRadio('Não', 'Não');
        $oFerrElaboradas->addItenRadio('NA', 'NA');

        $oDesenAcordo = new campo('O desenho do produto está de acordo conforme requisitos do cliente?', 'desenAcordo', Campo::TIPO_RADIO, 5);
        $oDesenAcordo->addItenRadio('Sim', 'Sim');
        $oDesenAcordo->addItenRadio('Não', 'Não');
        $oDesenAcordo->addItenRadio('NA', 'NA');

        $oComenCrit = new Campo('Comentários', 'comenCrit', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);

        $oCodRespCrit = new campo('...', 'codresp', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodRespCrit->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oCodRespCrit->setBOculto(true);

        $oRespCrit = new Campo('Responsável', 'respAnaliseCri', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespCrit->setSIdPk($oCodRespCrit->getId());
        $oRespCrit->setClasseBusca('User');
        $oRespCrit->addCampoBusca('usucodigo', '', '');
        $oRespCrit->addCampoBusca('usunome', '', '');
        $oRespCrit->setSIdTela($this->getTela()->getid());
        $oRespCrit->setIMarginTop(2);

        $oCodFerrConfResp->setClasseBusca('User');
        $oCodFerrConfResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oCodFerrConfResp->addCampoBusca('usunome', $oRespCrit->getId(), $this->getTela()->getId());

        $oRespCrit->setSValor($_SESSION['nome']);


        $oDataCrit = new Campo('Data da análise', 'dtanalisecritica', Campo::TIPO_DATA, 1, 1, 12, 12);


        $oFieldCrit->setOculto(true);

        $oFieldCrit->addCampos(array($oFerrElaboradas, $oDesenAcordo), $oComenCrit, array($oRespCrit, $oDataCrit));



        $this->addCampos(array($oFilcgc, $oNr), $oLinha1, $oFieldDetProj, $oFieldCrit, $oLinha2);
    }

}
