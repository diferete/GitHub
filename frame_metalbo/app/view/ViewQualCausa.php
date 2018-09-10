<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualCausa extends View {

    function criaGridDetalhe() {
        parent::criaGridDetalhe();

        /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(160);

        $oNr = new CampoConsulta('AQ', 'nr');

        $oSeq = new CampoConsulta('Seq', 'seq');

        $oCausa = new CampoConsulta('Causa', 'causa');

        $oCausaDesc = new CampoConsulta('Descrição causa', 'causades');

        $oOcorrencia = new CampoConsulta('Ocorrência 6M', 'ocorrencia', CampoConsulta::TIPO_DESTAQUE1);
        $oOcorrencia->addComparacao('1', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);


        $this->addCamposDetalhe($oNr, $oSeq, $oCausa, $oOcorrencia, $oCausaDesc);
        $this->addGriTela($this->getOGridDetalhe());
    }

    public function criaTela() {
        parent::criaTela();

        $this->criaGridDetalhe();

        $aValor = $this->getAParametrosExtras();

        $oFieldInf = new FieldSet('....');

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

        $oFieldInf->addCampos();

        $oCausa = new Campo('Selecione a causa', 'causa', Campo::TIPO_SELECTMULTI, 2, 2, 12, 12);
        $oCausa->addItemSelect('Matéria prima', 'Matéria prima');
        $oCausa->addItemSelect('Meio ambiente', 'Meio ambiente');
        $oCausa->addItemSelect('Mão de obra', 'Mão de obra');
        $oCausa->addItemSelect('Método', 'Método');
        $oCausa->addItemSelect('Máquinas', 'Máquinas');
        $oCausa->addItemSelect('Medida', 'Medida');
        $oCausa->setBFocus(true);
        $oCausa->setSValor('Matéria prima');

        $oCausaDes = new Campo('Informe descrição', 'causades', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
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

        $oGridOcorr = new Campo('Ocorrência 6M', '6m', Campo::TIPO_GRIDVIEW, 2, 2, 12, 12);
        $oGridOcorr->addCabGridView('Causa');
        $oGridOcorr->addCabGridView('Ocorrências');
        $oGridOcorr->addLinhasGridView(1, '');
        $oGridOcorr->addLinhasGridView(1, '0');
        $oGridOcorr->addLinhasGridView(2, '');
        $oGridOcorr->addLinhasGridView(2, '0');

        $oBotConf = new Campo('Inserir', '', Campo::TIPO_BOTAOSMALL_SUB, 1, 1, 12, 12);

        $sGrid = $this->getOGridDetalhe()->getSId();

        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("' . $this->getTela()->getId() . '-form","' . $this->getController() . '","acaoDetalheIten","' . $this->getTela()->getId() . '-form,' . $oSeq->getId() . ',' . $sGrid . ',' . $oCausa->getId() . ',' . $oCausa->getId() . '","' . $oFilcgc->getSValor() . ',' . $oNr->getSValor() . '");';

        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);

        $this->addCampos(array($oCausa, $oCausaDes, $oPq1, $oPq2, $oPq3), array($oPq4, $oPq5, $oBotConf, $oFilcgc, $oNr, $oSeq));

        $this->addCamposFiltroIni($oFilcgc, $oNr);
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $oNr = new CampoConsulta('AQ', 'nr');
        $oNr->setILargura(30);

        $oCausa = new CampoConsulta('Causa', 'causa');
        $oCausa->setILargura(150);
        $oSeq = new CampoConsulta('Seq', 'seq');
        $oSeq->setILargura(30);
        $oCausaDesc = new CampoConsulta('Descrição causa', 'causades');
        $oCausaDesc->setILargura(800);
        $oOcorrencia = new CampoConsulta('Ocorrência 6M', 'ocorrencia', CampoConsulta::TIPO_DESTAQUE1);
        $oOcorrencia->addComparacao('1', CampoConsulta::COMPARACAO_MAIOR, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_LINHA);
        $oOcorrencia->setILargura(120);


        $this->addCampos($oNr, $oSeq, $oCausa, $oOcorrencia, $oCausaDesc);
    }

}
