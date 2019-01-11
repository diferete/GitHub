<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualCorrecao extends View {

    public function __construct() {
        parent::__construct();
    }

    function criaGridDetalhe() {
        parent::criaGridDetalhe();

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(30);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);

        $oPlan = new CampoConsulta('Ação', 'plano');
        $oPlan->setILargura(500);

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oUsunome = new CampoConsulta('Responsável', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'situaca');

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCamposDetalhe($oNr, $oSeq, $oSituacao, $oPlan, $oDataPrev, $oUsunome, $oAnexo);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('Nr.', 'nr');
        $oNr->setILargura(30);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);

        $oPlan = new CampoConsulta('Ação', 'plano');
        $oPlan->setILargura(500);

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oUsunome = new CampoConsulta('Responsável', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'situaca');

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCampos($oNr, $oSeq, $oSituacao, $oPlan, $oDataPrev, $oUsunome, $oAnexo);
    }

    public function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe();

        $aValor = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);

        $oSeq = new Campo('Sequência', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oPlano = new Campo('Ação efetuada', 'plano', Campo::TIPO_TEXTAREA, 12);
        $oPlano->setILinhasTextArea(5);
        $oPlano->setICaracter(500);

        $oAnexo = new Campo('Anexo', 'anexoplan1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo->setIMarginTop(3);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oResp->setBFocus(true);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Responsável', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());

        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oTipo = new Campo('Tipo ação', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor($aValor[3]);
        $oTipo->setBCampoBloqueado(true);
        if ($aValor[3] == 'Ação Preventiva') {
            $oTipo->setSCorFundo(Campo::FUNDO_VERDE);
            $oDivisor = new Campo('Tela com preenchimento OPCIONAL, Ação Preventiva não necessita preenchimento.', 'divisor1', Campo::DIVISOR_SUCCESS, 12, 12, 12, 12);
            
        } else {
            $oTipo->setSCorFundo(Campo::FUNDO_VERMELHO);
            $oDivisor = new Campo('Tela com preenchimento OPCIONAL, Ação Preventiva não necessita preenchimento.', 'divisor1', Campo::DIVISOR_WARNING, 12, 12, 12, 12);
        }
        
        $oDivisor->setApenasTela(true);

        $oDataPrev = new Campo('Previsão', 'dataprev', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBotConf->setIMarginTop(6);

        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oPlano->getId() . ',' . $oAnexo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos($oDivisor, array($oFilcgc, $oNr, $oSeq, $oTipo), array($oResp, $oRespNome), $oPlano, array($oDataPrev, $oAnexo, $oBotConf));
        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

}
