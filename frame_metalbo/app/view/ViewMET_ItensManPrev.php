<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ViewMET_ItensManPrev extends View {

    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);

        $oBotaoFinalizar = new CampoConsulta('Finalizar', 'teste', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar item!');
        $oBotaoFinalizar->addAcao('MET_ItensManPrev', 'msgFinalizaServ');
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_ServicoMaquina.codsit');
        $oServ = new CampoConsulta('Serviço', 'MET_ServicoMaquina.servico');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->addCamposDetalhe($oBotaoFinalizar, $oSeq, $oCodmaq, $oCodSit, $oServ, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal/* , $oObs */);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oBotaoFinalizar = new CampoConsulta('Finalizar', 'teste', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar item!');
        $oBotaoFinalizar->addAcao('MET_ItensManPrev', 'msgFinalizaServ');
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);

        // $oFilcgc = new CampoConsulta('Empresa', 'filcgc');
        // $oNr = new CampoConsulta('Nr', 'nr');
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Sit.', 'MET_ServicoMaquina.codsit');
        $oServ = new CampoConsulta('Serviço.', 'MET_ServicoMaquina.servico');
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');
        // $oObs = new CampoConsulta ('obs','obs');

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oBotaoFinalizar, $oSeq, $oCodmaq, $oCodSit, $oServ, $oSitmp, $oDias, $oDatabert, $oUserinic, $oDatafech, $oUserfinal/* , $oObs */);
    }

    public function criaTela() {
        parent::criaTela();


        //novo---------------------------------------------------
        $this->criaGridDetalhe();
        //-------------------------------------------------------

        $this->getTela()->setBUsaDelGrid(false);

        $aValor = $this->getAParametrosExtras();

        $sAcaoRotina = $this->getSRotina();

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

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
        $oCodSit->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodSit->addValidacao(true, Validacao::TIPO_STRING);
        $oCodSit->setSCampoRetorno('codsit', $this->getTela()->getId());

        //campo descrição da maquina adicionando o campo de busca
        $oServ = new Campo('Serviço', 'MET_ServicoMaquina.servico', Campo::TIPO_BUSCADOBANCO, 8, 8, 12, 12);
        $oServ->setSIdPk($oCodSit->getId());
        $oServ->setClasseBusca('MET_ServicoMaquina');
        $oServ->addCampoBusca('codsit', '', '');
        $oServ->addCampoBusca('servico', '', '');
        $oServ->setSIdTela($this->getTela()->getId());
        $oServ->addValidacao(true, Validacao::TIPO_STRING);

        //declarando no campo código a classe de busca, campo chave e campo de retorno
        $oCodSit->setClasseBusca('MET_ServicoMaquina');
        $oCodSit->setSCampoRetorno('codsit', $this->getTela()->getId());
        $oCodSit->addCampoBusca('servico', $oServ->getId(), $this->getTela()->getId());

        $oDias = new Campo('Dias p/ Manutenção', 'dias', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDias->setBCampoBloqueado(true);

        $oResponsavel = new Campo('Responsável', 'MET_ServicoMaquina.resp', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oResponsavel->setBCampoBloqueado(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","MET_ItensManPrev","buscaDados","' . $oDias->getId() . ',' . $oResponsavel->getId() . '");';

        $oCodSit->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oQueFazer = new Campo('O que fazer', 'oqfazer', Campo::TIPO_SELECT, 5, 5, 12, 12);
        $oQueFazer->addItemSelect('AJUSTE', 'AJUSTE');
        $oQueFazer->addItemSelect('ENGRAXE', 'ENGRAXE');
        $oQueFazer->addItemSelect('LIMPAR', 'LIMPAR');
        $oQueFazer->addItemSelect('LIMPAR OU TROCAR', 'LIMPAR OU TROCAR');
        $oQueFazer->addItemSelect('LIMPEZA', 'LIMPEZA');
        $oQueFazer->addItemSelect('LIMPEZA E ENGRAXE', 'LIMPEZA E ENGRAXE');
        $oQueFazer->addItemSelect('LUBRIFICACAO', 'LUBRIFICACAO');
        $oQueFazer->addItemSelect('LUBRIFICAR', 'LUBRIFICAR');
        $oQueFazer->addItemSelect('REPOSICAO', 'REPOSICAO');
        $oQueFazer->addItemSelect('TROCA', 'TROCA');
        $oQueFazer->addItemSelect('VERIFICAR', 'VERIFICAR');
        $oQueFazer->addItemSelect('VERIFICAR CONDICOES', 'VERIFICAR CONDICOES');
        $oQueFazer->addItemSelect('VERIFICAR DESGASTE', 'VERIFICAR DESGASTE');
        $oQueFazer->addItemSelect('VERIFICAR DESGASTE E AJUSTAR SE NECESSARIO', 'VERIFICAR DESGASTE E AJUSTAR SE NECESSARIO');
        $oQueFazer->addItemSelect('VERIFICAR ESTADO', 'VERIFICAR ESTADO');
        $oQueFazer->addItemSelect('VERIFICAR FOLGA', 'VERIFICAR FOLGA');
        $oQueFazer->addItemSelect('VERIFICAR FOLGAS', 'VERIFICAR FOLGAS');
        $oQueFazer->addItemSelect('VERIFICAR NECESSIDADE DE TROCA', 'VERIFICAR NECESSIDADE DE TROCA');
        $oQueFazer->addItemSelect('VERIFICAR VAZAMENTO', 'VERIFICAR VAZAMENTO');
        $oQueFazer->setApenasTela(true);

        $oSitmp = new Campo('Situação', 'sitmp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitmp->setSValor('ABERTO');
        $oSitmp->addValidacao(false, Validacao::TIPO_STRING);
        $oSitmp->setBCampoBloqueado(true);


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


        $oL = new Campo('', '', Campo::TIPO_LINHA, 12, 12, 12, 12);


        //NOVO-------------------------------------------------------------------------------------------
        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1);
        $oBotConf->setIMarginTop(6);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oBotConf->getOBotao()->setBDesativado(true);
        }


        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form, id incremento, id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' .
                $oSeq->getId() . ',' . $sGrid . ',' . $oCodSit->getId() . ',' . $oServ->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        //-----------------------------------------------------------------------------------------------

        $this->addCampos(array($oNr, $oFilcgc, $oCodmaq, $oMaqDes), array($oDatabert, $oUserinic, $oDatafech, $oUserfinal, $oSitmp), $oL, array($oSeq, $oCodSit, $oServ), array($oQueFazer, $oDias, $oResponsavel), $oObs, $oBotConf);

        //-novo-----------------------------------------
        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

}
