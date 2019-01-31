<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ViewMET_ItensManPrev extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oNr = new CampoConsulta('Nr', 'nr');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_ServicoMaquina.codsit');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');
        $oObs = new CampoConsulta('obs', 'obs');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oFilcgc, $oNr, $oSeq, $oCodmaq, $oCodSit, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal, $oObs);
    }

    public function criaTela() {
        parent::criaTela();
        //novo---------------------------------------------------
        $this->criaGridDetalhe();
        //-------------------------------------------------------

        $aValor = $this->getAParametrosExtras();

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr->setBCampoBloqueado(true);
        $oNr->setSValor($aValor[1]);

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setSValor($aValor[0]);

        $oCodmaq = new Campo('Cod.Maq.', 'codmaq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodmaq->setSValor($aValor[2]);
        $oCodmaq->setBCampoBloqueado(true);

        $oMaqDes = new Campo('Maquina', 'maquina', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMaqDes->setSValor($aValor[3]);
        $oMaqDes->setApenasTela(true);
        $oMaqDes->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oCodSit = new Campo('Codsit', 'codsit', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodSit->addValidacao(true, Validacao::TIPO_STRING);

        //campo descrição da maquina adicionando o campo de busca
        $oServ = new Campo('Serviço', 'MET_ServicoMaquina.servico', Campo::TIPO_BUSCADOBANCO, 4, 4, 12, 12);
        $oServ->setSIdPk($oCodSit->getId());
        $oServ->setClasseBusca('MET_ServicoMaquina');
        $oServ->addCampoBusca('codsit', '', '');
        $oServ->addCampoBusca('servico', '', '');
        $oServ->setSIdTela($this->getTela()->getId());
        $oServ->setApenasTela(true);

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodSit->setClasseBusca('MET_ServicoMaquina');
        $oCodSit->setSCampoRetorno('codsit', $this->getTela()->getId());
        $oCodSit->addCampoBusca('servico', $oServ->getId(), $this->getTela()->getId());

        $oDias = new Campo('', 'dias', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDias->setBOculto(true);

        $oSitmp = new Campo('Situação', 'sitmp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitmp->setSValor('ABERTO');
        /* $oSitmp->addItemSelect('ABERTO','ABERTO');
          $oSitmp->addItemSelect('FECHADO', 'FECHADO');
          $oSitmp->addItemSelect('PROCESSO', 'PROCESSO'); */
        $oSitmp->addValidacao(false, Validacao::TIPO_STRING);
        $oSitmp->setBCampoBloqueado(true);

        //NOVO-------------------------------------------------------------------------------------------
        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBotConf->setIMarginTop(6);

        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oCodSit->getId() . ',' . $oServ->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        //-----------------------------------------------------------------------------------------------

        $oDatabert = new Campo('DataAbert.', 'databert', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDatabert->setSValor(date('d/m/Y'));
        $oDatabert->setBCampoBloqueado(true);
        $oUserinic = new Campo('Usuario Inicial.', 'userinicial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserinic->setSValor($_SESSION['nome']);
        $oUserinic->setBCampoBloqueado(true);
        $oDatafech = new Campo('DataFech', 'datafech', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDatafech->setBCampoBloqueado(true);
        $oUserfinal = new Campo('Usuario Final', 'userfinal', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserfinal->setBCampoBloqueado(true);
        $oObs = new Campo('Obs', 'obs', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oObs->setILinhasTextArea(2);

        $this->addCampos(array($oNr, $oFilcgc, $oCodmaq, $oMaqDes), array($oDatabert, $oUserinic, $oDatafech, $oUserfinal, $oSitmp), array($oSeq, $oCodSit, $oServ, $oDias), $oObs, $oBotConf);
        //-novo-----------------------------------------
        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);

        $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        $oNr = new CampoConsulta('Nr', 'nr');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_ServicoMaquina.codsit');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');
        $oObs = new CampoConsulta('obs', 'obs');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->addCamposDetalhe($oFilcgc, $oNr, $oSeq, $oCodmaq, $oCodSit, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal, $oObs);
        $this->addGriTela($this->getOGridDetalhe());
    }

}
