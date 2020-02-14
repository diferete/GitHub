<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualCausa extends View{
    
    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);
      
        $oNr = new CampoConsulta('AQ','nr');
        $oNr->setILargura(30);
        
        $oSeq = new CampoConsulta('Seq','seq');
        $oSeq->setILargura(30);
        $oCausa = new CampoConsulta('Causa','causa');
        $oCausa->setILargura(250);
        $oCausaDesc = new CampoConsulta('Descrição causa','causades');
        $oCausaDesc->setILargura(500);
        $oAnexo1 = new CampoConsulta('Anexo','anexocausa1',CampoConsulta::TIPO_DOWNLOAD);
        
        
        
        
        $this->addCamposDetalhe($oNr,$oSeq,$oCausa,$oCausaDesc,$oAnexo1);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->criaGridDetalhe();
        
        $aValor = $this->getAParametrosExtras();
        
        
        $oFilcgc = new Campo('Empresa','filcgc', Campo::TIPO_TEXTO,2);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);
        
        $oNr = new Campo('AQ','nr', Campo::TIPO_TEXTO,1);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);
        
        $oSeq = new Campo('Seq','seq', Campo::TIPO_TEXTO,1);
        $oSeq->setBCampoBloqueado(true);
        $oSeq->setSValor('0');
        
        $oCausa = new Campo('Causa','causa', Campo::TIPO_SELECT,2);
        $oCausa->addItemSelect('Matéria prima', 'Matéria prima');
        $oCausa->addItemSelect('Meio ambiente', 'Meio ambiente');
        $oCausa->addItemSelect('Mão de obra', 'Mão de obra');
        $oCausa->addItemSelect('Método', 'Método');
        $oCausa->addItemSelect('Máquinas', 'Máquinas');
        $oCausa->addItemSelect('Medida', 'Medida');
        $oCausa->setBFocus(true);
        
        $oCausaDes = new Campo('Descrição','causades', Campo::TIPO_TEXTAREA,7);
        $oCausaDes->setILinhasTextArea(2);
        $oCausaDes->setICaracter(500);
        
        $oAnexo1 = new Campo('Anexar causa raiz','anexocausa1', Campo::TIPO_UPLOAD,4,4,4,4);
        
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $sGrid=$this->getOGridDetalhe()->getSId();
       
        //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oSeq->getId().','.$sGrid.','.$oCausa->getId().','.$oAnexo1->getId().'","'.$oFilcgc->getSValor().','.$oNr->getSValor().'");';
        
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
       $oCausaProv = new Campo('Causa provável','causaprov', Campo::TIPO_TEXTAREA,8,8,8,8);
       $oCausaProv->setSCorFundo(Campo::FUNDO_AMARELO);
        
        
       $oFieldPq = new FieldSet('Análise dos porquês');
       $oPq1 = new Campo('1º Porque','pq1', Campo::TIPO_TEXTO,12,12,12,12);
       $oPq1->setSCorFundo(Campo::FUNDO_VERDE);
       $oPq2 = new Campo('2º Porque','pq2', Campo::TIPO_TEXTO,12,12,12,12);
       $oPq2->setSCorFundo(Campo::FUNDO_VERDE);
       $oPq3 = new Campo('3º Porque','pq3', Campo::TIPO_TEXTO,12,12,12,12);
       $oPq3->setSCorFundo(Campo::FUNDO_VERDE);
       $oPq4 = new Campo('4º Porque','pq4', Campo::TIPO_TEXTO,12,12,12,12);
       $oPq4->setSCorFundo(Campo::FUNDO_VERDE);
       $oPq5 = new Campo('5º Porque','pq5', Campo::TIPO_TEXTO,12,12,12,12);
       $oPq5->setSCorFundo(Campo::FUNDO_VERDE);
       $oFieldPq->addCampos($oCausaProv,$oPq1,$oPq2,$oPq3,$oPq4,$oPq5/*array($oPq1,$oPq2),array($oPq3,$oPq4),$oPq5*/);
       $oFieldPq->setOculto(true);
        
        
        $this->addCampos(array($oFilcgc,$oNr,$oSeq,$oAnexo1),$oCausa,$oFieldPq,array($oCausaDes,$oBotConf));
        
        $this->addCamposFiltroIni($oFilcgc,$oNr);
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('AQ','nr');
        $oNr->setILargura(30);
        
        $oCausa = new CampoConsulta('Causa','causa');
        $oCausa->setILargura(250);
        $oSeq = new CampoConsulta('Seq','seq');
        $oSeq->setILargura(30);
        $oCausaDesc = new CampoConsulta('Descrição causa','causades');
        $oCausaDesc->setILargura(500);
        $oAnexo1 = new CampoConsulta('Anexo','anexocausa1', CampoConsulta::TIPO_DOWNLOAD);
        
        $this->addCampos($oNr,$oSeq,$oCausa,$oCausaDesc,$oAnexo1);
    }
    
    
}