<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqPlan extends View {

    public function __construct() {
        parent::__construct();
    }

    function criaGridDetalhe($sAcaoRotina) {
        parent::criaGridDetalhe($sIdAba);

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(400);

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Plano de Ação');
        $oBotaoModal->addAcao('QualAqPlan', 'criaTelaModalAponta', 'modalAponta', '');
        $this->addModaisDetalhe($oBotaoModal);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oBotaoModal->setBDisabled(true);
        }

        $oNr = new CampoConsulta('Nr.', 'nr');

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oSituacao = new CampoConsulta('Situação', 'sitfim', CampoConsulta::TIPO_TEXTO);
        $oSituacao->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');

        $oPlano = new CampoConsulta('Plano', 'Plano');

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oDataFim = new CampoConsulta('Apontamento', 'datafim', CampoConsulta::TIPO_DATA);

        $oUsunome = new CampoConsulta('Quem', 'usunome');

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexoFim = new CampoConsulta('Anexo Aponta', 'anexofim', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCamposDetalhe($oBotaoModal, $oNr, $oSeq, $oSituacao, $oPlano, $oDataPrev, $oDataFim, $oUsunome, $oAnexo, $oAnexoFim);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();


        $aDados = $_REQUEST['parametros'];
        $aDados = explode(',', $aDados['parametros[']);


        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Apontar Plano de Ação');
        $oBotaoModal->addAcao('QualAqPlan', 'criaTelaModalAponta', 'modalAponta', '');
        $this->addModais($oBotaoModal);
        if ($aDados[6] == 'acaoVisualizar') {
            $oBotaoModal->setBDisabled(true);
        }

        $oNr = new CampoConsulta('Nr.', 'nr');

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oPlano = new CampoConsulta('Plano', 'Plano');

        $oDataPrev = new CampoConsulta('Previsão', 'dataprev', CampoConsulta::TIPO_DATA);

        $oDataFim = new CampoConsulta('Apontamento', 'datafim', CampoConsulta::TIPO_DATA);

        $oSituacao = new CampoConsulta('Situação', 'sitfim', CampoConsulta::TIPO_TEXTO);
        $oSituacao->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA, false, '');

        $oUsunome = new CampoConsulta('Quem', 'usunome');

        $oAnexo = new CampoConsulta('Anexo', 'anexoplan1', CampoConsulta::TIPO_DOWNLOAD);

        $oAnexoFim = new CampoConsulta('Anexo Aponta', 'anexofim', CampoConsulta::TIPO_DOWNLOAD);

        $this->addCampos($oBotaoModal, $oNr, $oSeq, $oSituacao, $oPlano, $oDataPrev, $oDataFim, $oUsunome, $oAnexo, $oAnexoFim);
    }

    public function criaTela() {
        parent::criaTela();

        $sAcaoRotina = $this->getSRotina();

        $this->criaGridDetalhe($sAcaoRotina);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

        $aValor = $this->getAParametrosExtras();

        $oFilcgc = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oPlano = new Campo('O que fazer', 'plano', Campo::TIPO_TEXTAREA, 12);
        $oPlano->setBFocus(true);
        $oPlano->setILinhasTextArea(5);
        $oPlano->setICaracter(500);

        $oAnexo = new Campo('Anexar plano de ação', 'anexoplan1', Campo::TIPO_UPLOAD, 2, 2, 12, 12);
        $oAnexo->setIMarginTop(3);

        $oResp = new campo('Cód.', 'usucodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');

        $oRespNome = new Campo('Quem', 'usunome', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '', '');
        $oRespNome->addCampoBusca('usunome', '', '');
        $oRespNome->setSIdTela($this->getTela()->getid());

        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo', $this->getTela()->getId());
        $oResp->addCampoBusca('usunome', $oRespNome->getId(), $this->getTela()->getId());

        $oTipo = new Campo('Tipo ação', 'tipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oTipo->setSValor('Aq');
        $oTipo->setBCampoBloqueado(true);

        $oDataPrev = new Campo('Previsão', 'dataprev', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBotConf->setIMarginTop(6);

        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oPlano->getId() . ',' . $oAnexo->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos(array($oFilcgc, $oNr, $oSeq), $oPlano, array($oResp, $oRespNome, $oTipo), array($oDataPrev, $oAnexo));
        } else {
            $this->addCampos(array($oFilcgc, $oNr, $oSeq), $oPlano, array($oResp, $oRespNome, $oTipo), array($oDataPrev, $oAnexo, $oBotConf));
        }
        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

    public function criaModalAponta() {
        parent::criaModal();

        $this->setBTela(true);
        $oDados = $this->getAParametrosExtras();

        $oEmpresa = new Campo('Empresa', 'filcgc', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEmpresa->setSValor($oDados->getFilcgc());
        $oEmpresa->setBCampoBloqueado(true);

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 1, 1, 1, 12, 12);
        $oNr->setSValor($oDados->getNr());
        $oNr->setBCampoBloqueado(true);

        $oSeqEnv = new Campo('Sêq. Plano de Ação', 'seq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeqEnv->setSValor($oDados->getSeq());
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oSeqEnv->setApenasTela(true);

        $oDataFim = new Campo('Data Finalização', 'datafim', Campo::TIPO_DATA, 2, 2, 2, 2);
        if ($oDados->getDatafim() != null) {
            $oDataFim->setSValor(Util::converteData($oDados->getDatafim()));
        }
        $oDataFim->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        $oDataFim->setSCorFundo(Campo::FUNDO_AMARELO);

        $oObsFim = new Campo('Observação final', 'obsfim', Campo::TIPO_TEXTAREA, 8, 8, 8, 8);
        $oObsFim->setICaracter(1000);
        if ($oDados->getObsfim() != null) {
            $oObsFim->setSValor(Util::limpaString($oDados->getObsfim()));
        }
        $oObsFim->setSCorFundo(Campo::FUNDO_AMARELO);
        $oObsFim->setILinhasTextArea(3);

        $oAnexoFim = new campo('Anexo', 'anexofim', Campo::TIPO_UPLOAD, 2);
        $oAnexoFim->setIMarginTop(3);


        $oDivisor = new Campo('Selecione abaixo se documentos foram alterados', '', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oProcedimento = new Campo('Procedimento', 'procedimento', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getProcedimento() != null) {
            $oProcedimento->setSValor($oDados->getProcedimento());
        }

        $oIT = new Campo('IT', 'it', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getIt() != null) {
            $oIT->setSValor($oDados->getIt());
        }

        $oPlanoControle = new Campo('Plano de Controle', 'planocontrole', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getPlanocontrole() != null) {
            $oPlanoControle->setSValor($oDados->getPlanocontrole());
        }

        $oFluxograma = new Campo('Fluxograma', 'fluxograma', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getFluxograma() != null) {
            $oFluxograma->setSValor($oDados->getFluxograma());
        }

        $oPPAP = new Campo('PPAP', 'ppap', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getPpap() != null) {
            $oPPAP->setSValor($oDados->getPpap());
        }

        $oContexto = new Campo('Riscos e Oportunidades', 'contexto', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getContexto() != null) {
            $oContexto->setSValor($oDados->getContexto());
        }

        $oPreventiva = new Campo('Manutenção Preventiva', 'preventiva', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getPreventiva() != null) {
            $oPreventiva->setSValor($oDados->getPreventiva());
        }

        $oFuncao = new Campo('Descrição de Função', 'funcao', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getFuncao() != null) {
            $oFuncao->setSValor($oDados->getFuncao());
        }

        $oTreinamentos = new Campo('Controle de Treinamento', 'treinamento', Campo::TIPO_CHECK, 4, 4, 12, 12);
        if ($oDados->getTreinamento() != null) {
            $oTreinamentos->setSValor($oDados->getTreinamento());
        }

        $oLinha = new Campo('', '', Campo::TIPO_LINHABRANCO);

        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $sAcaoAponta = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaPlanoAcao","' . $this->getTela()->getId() . '-form,' . $oAnexoFim->getId() . '","");';
        $oBtnInserir->getOBotao()->addAcao($sAcaoAponta);

        $oBtnNormal = new Campo('Ret. Aberta', 'btnNormal', Campo::TIPO_BOTAOSMALL, 2);
        $sAcaoRet = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","apontaRetAberto","' . $this->getTela()->getId() . '-form,' . $oAnexoFim->getId() . '","");';
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);

        $this->addCampos(array($oEmpresa, $oNr, $oSeqEnv), array($oDataFim, $oAnexoFim), $oDivisor, array($oProcedimento, $oIT, $oPlanoControle), array($oFluxograma, $oPPAP, $oContexto), array($oPreventiva, $oFuncao, $oTreinamentos), $oLinha, array($oObsFim, $oBtnInserir, $oBtnNormal));
    }

}
