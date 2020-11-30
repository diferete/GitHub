<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualCausa extends View {

    function criaGridDetalhe() {
        parent::criaGridDetalhe($sIdAba);

        $this->getOGridDetalhe()->setIAltura(220);

        $oNr = new CampoConsulta('AQ', 'nr');
        $oNr->setILargura(10);

        $oSeq = new CampoConsulta('Seq', 'seq');
        $oSeq->setILargura(10);

        $oCausaDesc = new CampoConsulta('Descrição causa', 'causades');

        $this->addCamposDetalhe($oNr, $oSeq, $oCausaDesc/* , $oOcorrencia */);

        $oLinhaWhite = new Campo('', '', Campo::TIPO_LINHABRANCO);

        $oDivisor2 = new Campo('Visualizar porques', 'divisor2', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor2->setApenasTela(true);

        $oPq1 = new Campo('1º Porque', '', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq1->setILinhasTextArea(6);
        $oPq1->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPq1->setApenasTela(true);
        $oPq1->setBCampoBloqueado(true);

        $oPq2 = new Campo('2º Porque', '', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq2->setILinhasTextArea(6);
        $oPq2->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPq2->setApenasTela(true);
        $oPq2->setBCampoBloqueado(true);

        $oPq3 = new Campo('3º Porque', '', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq3->setILinhasTextArea(6);
        $oPq3->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPq3->setApenasTela(true);
        $oPq3->setBCampoBloqueado(true);

        $oPq4 = new Campo('4º Porque', '', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq4->setILinhasTextArea(6);
        $oPq4->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPq4->setApenasTela(true);
        $oPq4->setBCampoBloqueado(true);

        $oPq5 = new Campo('5º Porque', '', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq5->setILinhasTextArea(6);
        $oPq5->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPq5->setApenasTela(true);
        $oPq5->setBCampoBloqueado(true);

        $this->addCamposGridDetalhe($oDivisor2, array($oPq1, $oPq2, $oPq3, $oPq4, $oPq5), $oLinhaWhite);

        $this->getOGridDetalhe()->setSEventoClick('var chave=""; $("#' . $this->getOGridDetalhe()->getSId() . ' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'var idCampos ="' . $oPq1->getId() . ',' . $oPq2->getId() . ',' . $oPq3->getId() . ',' . $oPq4->getId() . ',' . $oPq5->getId() . '";'
                . 'requestAjax("","QualCausa","carregaCausa","' . $this->getOGridDetalhe()->getSId() . '"+","+chave+","+idCampos+"");');

        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setIAltura(220);

        $oNr = new CampoConsulta('AQ', 'nr');
        $oNr->setILargura(10);

        $oSeq = new CampoConsulta('Seq', 'seq');
        $oSeq->setILargura(10);

        $oCausaDesc = new CampoConsulta('Descrição causa', 'causades');

        $this->addCampos($oNr, $oSeq, $oCausaDesc/* , $oOcorrencia */);
    }

    public function criaTela() {
        parent::criaTela();


        $this->criaGridDetalhe();


        $sAcaoRotina = $this->getSRotina();
        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->getTela()->setBUsaAltGrid(false);
            $this->getTela()->setBUsaDelGrid(false);
        }

        $aValor = $this->getAParametrosExtras();

        $oFilcgc = new Campo('', 'filcgc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);

        $oNr = new Campo('', 'nr', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);

        $oSeq = new Campo('', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);
        $oSeq->setSValor('0');
        $oSeq->setBOculto(true);

        $oDivisor1 = new Campo('Diagrama da Causa', 'divisor1', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor1->setApenasTela(true);

        $oMatPrimaDes = new Campo('Mat.Prima', 'matprimades', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oMatPrimaDes->setILinhasTextArea(5);
        $oMetodoDes = new Campo('Método', 'metododes', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oMetodoDes->setILinhasTextArea(5);
        $oMaoDeObraDes = new Campo('Mão-de-obra', 'maodeobrades', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oMaoDeObraDes->setILinhasTextArea(5);
        $oEquipamentoDes = new Campo('Equipamento', 'equipamentodes', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oEquipamentoDes->setILinhasTextArea(5);
        $oMeioAmbienteDes = new Campo('Meio Ambiente', 'meioambientedes', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oMeioAmbienteDes->setILinhasTextArea(5);
        $oMedidaDes = new Campo('Medida', 'medidades', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oMedidaDes->setILinhasTextArea(5);

        $oBtnInsereCausa = new Campo('Inserir diagrama da causa', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBtnInsereCausa->setApenasTela(true);
        $sAcaoInserirCausa = 'requestAjax("' . $this->getTela()->getId() . '-form","QualDiagramaCausa","insereDiagrama","' . $this->getTela()->getId() . '-form,' . $oMatPrimaDes->getId() . ',' . $oMetodoDes->getId() . ',' . $oMaoDeObraDes->getId() . ',' . $oEquipamentoDes->getId() . ',' . $oMeioAmbienteDes->getId() . ',' . $oMedidaDes->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $oBtnInsereCausa->getOBotao()->addAcao($sAcaoInserirCausa);
        if ($sAcaoRotina == 'acaoVisualizar') {
            $oBtnInsereCausa->getOBotao()->setBDesativado(true);
        }

        $oDivisor = new Campo('Descrição da Causa', 'divisor', Campo::DIVISOR_DARK, 12, 12, 12, 12);
        $oDivisor->setApenasTela(true);

        $oCausaDes = new Campo('Descrição da causa', 'causades', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oCausaDes->setILinhasTextArea(5);
        $oCausaDes->setICaracter(500);
        $oCausaDes->setSCorFundo(Campo::FUNDO_VERDE);
        $oCausaDes->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar vazio!', '3', '500');

        $oPq1 = new Campo('1º Porque', 'pq1', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq1->setILinhasTextArea(5);

        $oPq2 = new Campo('2º Porque', 'pq2', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq2->setILinhasTextArea(5);

        $oPq3 = new Campo('3º Porque', 'pq3', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq3->setILinhasTextArea(5);

        $oPq4 = new Campo('4º Porque', 'pq4', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq4->setILinhasTextArea(5);

        $oPq5 = new Campo('5º Porque', 'pq5', Campo::TIPO_TEXTAREA, 2, 2, 12, 12);
        $oPq5->setILinhasTextArea(5);


        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);
        $oBotConf->setApenasTela(true);

        $sGrid = $this->getOGridDetalhe()->getSId();
        //id form,id incremento,id do grid, id focus,    
        $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oMatPrimaDes->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        if ($sAcaoRotina == 'acaoVisualizar') {
            $this->addCampos($oDivisor1, array($oMatPrimaDes, $oMetodoDes, $oMaoDeObraDes, $oEquipamentoDes, $oMeioAmbienteDes, $oMedidaDes), $oDivisor, array($oCausaDes), array($oPq1, $oPq2, $oPq3, $oPq4, $oPq5), array($oFilcgc, $oNr, $oSeq));
        } else {
            $this->addCampos($oDivisor1, array($oMatPrimaDes, $oMetodoDes, $oMaoDeObraDes, $oEquipamentoDes, $oMeioAmbienteDes, $oMedidaDes), $oBtnInsereCausa, $oDivisor, array($oCausaDes), array($oPq1, $oPq2, $oPq3, $oPq4, $oPq5), array($oBotConf, $oFilcgc, $oNr, $oSeq));
        }

        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

}
