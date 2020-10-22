<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqEficaz extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $aDados = $_REQUEST['parametros'];
        $aDados = explode(',', $aDados['parametros[']);


        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Avaliação da Eficácia');
        $oBotaoModal->addAcao('QualAqEficaz', 'criaTelaModalApontaEficaz', 'modalApontaEficaz', '');
        if ($aDados[6] == 'acaoVisualizar') {
            $oBotaoModal->setBDisabled(true);
        }


        $oSeqGrid = new CampoConsulta('Seq.', 'seq');

        $oNrGrid = new CampoConsulta('Nr', 'nr');

        $oAcaoGrid = new CampoConsulta('O que verificar', 'acao');

        $oDataPrevGrid = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oDataApontaGrid = new CampoConsulta('Apontamento', 'datareal', CampoConsulta::TIPO_DATA);

        $oRespNomeGrid = new CampoConsulta('Quem', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'sit', CampoConsulta::TIPO_TEXTO);
        $oSituacao->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');

        $this->addCampos($oBotaoModal, $oNrGrid, $oSeqGrid, $oSituacao, $oAcaoGrid, $oDataPrevGrid, $oDataApontaGrid, $oRespNomeGrid);
    }

    public function criaGridDetalhe($sAcaoRotina) {
        parent::criaGridDetalhe($sIdAba);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Avaliação da Eficácia');
        $oBotaoModal->addAcao('QualAqEficaz', 'criaTelaModalApontaEficaz', 'modalApontaEficaz', '');
        $this->addModaisDetalhe($oBotaoModal);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oBotaoModal->setBDisabled(true);
        }


        $oSeqGrid = new CampoConsulta('Seq.', 'seq');

        $oNrGrid = new CampoConsulta('Nr', 'nr');

        $oAcaoGrid = new CampoConsulta('O que verificar', 'acao');

        $oDataPrevGrid = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oDataApontaGrid = new CampoConsulta('Apontamento', 'datareal', CampoConsulta::TIPO_DATA);

        $oRespNomeGrid = new CampoConsulta('Quem', 'usunome');

        $oSituacao = new CampoConsulta('Situação', 'sit', CampoConsulta::TIPO_TEXTO);
        $oSituacao->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');

        $this->addCamposDetalhe($oBotaoModal, $oNrGrid, $oSeqGrid, $oSituacao, $oAcaoGrid, $oDataPrevGrid, $oDataApontaGrid, $oRespNomeGrid);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();
        $sAcaoRotina = $this->getSRotina();

        $this->criaGridDetalhe($sAcaoRotina);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

        $aDados = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2);
        $oFilcgc->setSValor($aDados[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr.', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aDados[1]);
        $oNr->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oAcao = new Campo('O que verificar', 'acao', Campo::TIPO_TEXTAREA, 6);
        $oAcao->setSCorFundo(Campo::FUNDO_AMARELO);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 1, 1);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Quem', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 3, 3);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());
        $oRespNome->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oDataPrev = new Campo('Previsão', 'dataprev', Campo::TIPO_DATA, 2);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oEficaz = new Campo('', 'eficaz', Campo::TIPO_TEXTO, 1);
        $oEficaz->setSValor(' ');
        $oEficaz->setBOculto(TRUE);

        $oBtnConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $sGrid = $this->getOGridDetalhe()->getSId();

        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBtnConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos(array($oFilcgc, $oNr, $oSeq), $oAcao, array($oResp, $oRespNome), array($oDataPrev, $oEficaz));
        } else {
            $this->addCampos(array($oFilcgc, $oNr, $oSeq), $oAcao, array($oResp, $oRespNome), array($oDataPrev, $oEficaz), $oBtnConf);
        }
    }

    public function addeventoConc() {
        parent::addeventoConc();

        $aValor = $this->getAParametrosExtras();
        $sRequest = 'requestAjax("","QualAq","envMailTodosMsg","' . $aValor[0] . ',' . $aValor[1] . ',concluir");';

        return $sRequest;
    }

    public function criaModalApontaEficaz() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFilcgc());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oSeqEnv = new Campo('Sequência', 'seq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeqEnv->setSValor($oDados->getSeq());
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oSeqEnv->setApenasTela(true);

        $oEficaz = new Campo('Eficaz?', 'eficaz', Campo::TIPO_RADIO, 4, 4, 12, 12);
        $oEficaz->addItenRadio('Sim', 'Sim! foi eficaz.');
        $oEficaz->addItenRadio('Não', 'Não! não foi eficaz!');
        if ($oDados->getEficaz() != null) {
            $oEficaz->setSValor($oDados->getEficaz());
        }

        $oObs = new Campo('Observação final', 'obs', Campo::TIPO_TEXTAREA, 6, 6, 12, 12);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        if ($oDados->getObs() != null) {
            $oObs->setSValor(Util::limpaString($oDados->getObs()));
        }

        $oDataReali = new Campo('Data realização', 'datareal', Campo::TIPO_DATA, 3, 3, 12, 12);
        $oDataReali->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oDataReali->setSValor(date('d/m/Y'));
        if ($oDados->getDatareal() != null) {
            $oDataReali->setSValor(Util::converteData($oDados->getDatareal()));
        }

        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaEfi","' . $this->getTela()->getId() . '-form","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);


        $oBtnNormal = new Campo('Ret. Aberta', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $sAcaoRet = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRetEfi","' . $this->getTela()->getId() . '-form","");';
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        $this->addCampos(array($oEmpresa, $oNr, $oSeqEnv), $oEficaz, $oDataReali, array($oObs, $oBtnInserir, $oBtnNormal));
    }

}
