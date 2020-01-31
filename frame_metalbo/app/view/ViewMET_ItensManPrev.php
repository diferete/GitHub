<?php

/*
 * Implementa a classe view
 * 
 * @author Cleverton Hoffmann
 * @since 10/09/2018
 */

class ViewMET_ItensManPrev extends View {

    function criaGridDetalhe() {
        
        $aIdsTela = $this->getSIdsTelas();
        parent::criaGridDetalhe($aIdsTela[6]);
        
        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(100);
        $this->getOGridDetalhe()->setSNomeGrid('itensManPrev');
        
       // $this->getOGridDetalhe()->setBGridResponsivo(false);
        
        $oBotaoFinalizar = new CampoConsulta('Finalizar', 'teste', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setILargura(15);
        $oBotaoFinalizar->setSTitleAcao('Finalizar item!');
        $oBotaoFinalizar->addAcao('MET_ItensManPrev', 'msgFinalizaServ');
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);
        $oBotaoFinalizar->setSNomeGrid('itensManPrev');

        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(15);
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodmaq->setILargura(15);
        $oCodSit = new CampoConsulta('Cod.Serviço', 'MET_ServicoMaquina.codsit');
        $oCodSit->setILargura(15);

       // $oServ1 = new Campo('Serviço', 'MET_ServicoMaquina.servico');
        
        $oServ = new Campo('Serviço', 'ser', Campo::TIPO_TEXTO,10,10,10,10);
        $oServ->setSCorFundo(Campo::FUNDO_AMARELO);
        $oServ->setBCampoBloqueado(true);
        
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oSitmp->setILargura(15);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDias->setILargura(15);
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oDatabert->setILargura(15);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oUserinic->setILargura(15);
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');
        $oQueFazer = new Campo('O que fazer', 'oqfaz', Campo::TIPO_TEXTO,2,2,2,2);
        $oQueFazer->setSCorFundo(Campo::FUNDO_AMARELO);
        $oQueFazer->setBCampoBloqueado(true);

        $this->getOGridDetalhe()->setSEventoClick('var chave=""; $("#'.$this->getOGridDetalhe()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_ItensManPrev","camposGrid","'.$this->getOGridDetalhe()->getSId().'"+","+chave+","+"'.$oServ->getId().'"+","+"'.$oQueFazer->getId().'");');
        
        $this->getOGridDetalhe()->addCamposGrid(array($oQueFazer, $oServ));
        
        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->addCamposDetalhe($oBotaoFinalizar, $oSeq, $oCodmaq, $oCodSit,/* $oServ,*/ $oSitmp, $oDias, $oDatabert, $oUserinic/*, $oDatafech, $oUserfinal , $oObs */);
        
        $this->addGriTela($this->getOGridDetalhe());
        
    }

    public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setSNomeGrid('itensManPrev');
        
      //  $this->getTela()->setBGridResponsivo(false);

        $oBotaoFinalizar = new CampoConsulta('Finalizar', 'teste', CampoConsulta::TIPO_FINALIZAR);
        $oBotaoFinalizar->setSTitleAcao('Finalizar item!');
        $oBotaoFinalizar->addAcao('MET_ItensManPrev', 'msgFinalizaServ');
        $oBotaoFinalizar->setBHideTelaAcao(true);
        $oBotaoFinalizar->setILargura(30);
        $oBotaoFinalizar->setSNomeGrid('itensManPrev');
        
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oCodmaq = new CampoConsulta('Cod.Maq.', 'codmaq');
        $oCodSit = new CampoConsulta('Cod.Serviço', 'MET_ServicoMaquina.codsit');
       
        $oServ = new Campo('Serviço', 'MET_ServicoMaquina.servico', Campo::TIPO_TEXTO,5);
        $oSitmp = new CampoConsulta('Situação', 'sitmp');
        $oSitmp->addComparacao('ABERTO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_AZUL, CampoConsulta::MODO_COLUNA);
        $oSitmp->addComparacao('FINALIZADO', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_ROXO, CampoConsulta::MODO_COLUNA);
        $oDias = new CampoConsulta('Dias Restantes', 'dias');
        $oDias->addComparacao('0', CampoConsulta::COMPARACAO_MENOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA);
        $oDatabert = new CampoConsulta('DataAbert.', 'databert', CampoConsulta::TIPO_DATA);
        $oUserinic = new CampoConsulta('Usuario Inicial.', 'userinicial');
        $oDatafech = new CampoConsulta('DataFech', 'datafech', CampoConsulta::TIPO_DATA);
        $oUserfinal = new CampoConsulta('Usuario Final', 'userfinal');
        // $oObs = new CampoConsulta ('obs','obs');
        
        $this->getTela()->setSEventoClick('var chave=""; $("#'.$this->getTela()->getSId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","MET_ItensManPrev","camposGrid","'.$this->getTela()->getSId().'"+","+chave+","+"'.$oServ->getId().'");');
        
        $this->getTela()->addCamposGrid($oServ);

        $oFiltroSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroSeq);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oBotaoFinalizar, $oSeq, $oCodmaq, $oCodSit, /*$oServ,*/ $oSitmp, $oDias, $oDatabert, $oUserinic/*, $oDatafech, $oUserfinal , $oObs */);
        
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
        }

        $oNr = new Campo('Nr', 'nr', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oNr->setBCampoBloqueado(true);
        $oNr->setSValor($aValor[1]);
        $oNr->setBOculto(true);

        $oFilcgc = new Campo('Filcgc', 'filcgc', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBOculto(true);


        $oCodmaq = new Campo('Cod.Maq.', 'codmaq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodmaq->setSValor($aValor[2]);
        $oCodmaq->setBCampoBloqueado(true);

        $oMaqDes = new Campo('Máquina', 'maquina', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oMaqDes->setSValor($aValor[3]);
        $oMaqDes->setApenasTela(true);
        $oMaqDes->setBCampoBloqueado(true);

        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oCodSit = new Campo('Código Serviço', 'codsit', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodSit->setSIdHideEtapa($this->getSIdHideEtapa());
        $oCodSit->addValidacao(true, Validacao::TIPO_STRING);
        $oCodSit->setSCampoRetorno('codsit', $this->getTela()->getId());
       // $oCodSit->setBCampoBloqueado(true);

        //campo descrição da maquina adicionando o campo de busca
        $oServ = new Campo('Serviço', 'MET_ServicoMaquina.servico', Campo::TIPO_BUSCADOBANCO, 8, 8, 12, 12);
        $oServ->setSIdPk($oCodSit->getId());
        $oServ->setClasseBusca('MET_ServicoMaquina');
        $oServ->addCampoBusca('codsit', '', '');
        $oServ->addCampoBusca('servico', '', '');
        $oServ->setSIdTela($this->getTela()->getId());
        $oServ->addValidacao(true, Validacao::TIPO_STRING);
       // $oServ->setBCampoBloqueado(true);

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

        $oQueFazer = new Campo('O que fazer', 'oqfazer', Campo::CAMPO_SELECTSIMPLE, 5, 5, 12, 12);
        $oQueFazer->addItemSelect('', '');
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
        $oQueFazer->addValidacao(false, Validacao::TIPO_STRING);

        $oSitmp = new Campo('Situação', 'sitmp', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSitmp->setSValor('ABERTO');
        $oSitmp->addValidacao(false, Validacao::TIPO_STRING);
        $oSitmp->setBCampoBloqueado(true);

        $oDatabert = new Campo('DataAbert.', 'databert', Campo::TIPO_DATA, 2, 2, 12, 12);
        date_default_timezone_set('America/Sao_Paulo');
        $oDatabert->setSValor(date('d/m/Y'));
        $oUserinic = new Campo('Usuario Inicial.', 'userinicial', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUserinic->setSValor($_SESSION['nome']);
        $oUserinic->setBCampoBloqueado(true);
        $oObs = new Campo('Observação', 'obs', Campo::TIPO_TEXTAREA, 8, 8, 8, 8);
        $oObs->setILinhasTextArea(1);

        $oL = new Campo('', '', Campo::TIPO_LINHA, 12, 12, 12, 12);

        //NOVO-------------------------------------------------------------------------------------------
        $oBotConf = new Campo('INSERIR', '', Campo::TIPO_BOTAOSMALL, 1,1,2,2);
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
        $oFezManut = new Campo('Realizou Tarefa', 'fezmanut', Campo::CAMPO_SELECTSIMPLE, 2, 2, 12, 12);
        $oFezManut->setSValor('SIM');
        $oFezManut->addItemSelect('SIM', 'SIM'); 
        $oFezManut->addItemSelect('NAO', 'NAO'); 
      //  $oFezManut->setITamanho(Campo::TAMANHO_GRANDE);
        
        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos(array($oNr, $oFilcgc, $oCodmaq, $oMaqDes, $oDatabert, $oUserinic, $oSitmp), $oL, array($oSeq, $oCodSit, $oServ), array($oQueFazer, $oDias, $oResponsavel), $oObs, $oFezManut);
        }else{
            $this->addCampos(array($oNr, $oFilcgc, $oCodmaq, $oMaqDes, $oDatabert, $oUserinic, $oSitmp), $oL, array($oSeq, $oCodSit, $oServ), array($oQueFazer, $oDias, $oResponsavel), array($oObs),array($oFezManut, $oBotConf));
        }
     
        
        //-novo-----------------------------------------
        $this->addCamposFiltroIni($oFilcgc, $oNr, $oCodmaq);
    }
    
}
