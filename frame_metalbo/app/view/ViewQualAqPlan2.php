<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqPlan extends View{
    public function __construct() {
        parent::__construct();
    }
    
    function criaGridDetalhe() {
        parent::criaGridDetalhe();
        
         /**
         * ESSE MÉTODO DE ESPELHAR O MOSTRACONSULTA SOMENTE POR ENQUANTO
         */
        $this->getOGridDetalhe()->setIAltura(200);
      
        $oNr = new CampoConsulta('Nr.','nr');
        $oNr->setILargura(30);
        $oSeq = new CampoConsulta('Seq.','seq');
        $oSeq->setILargura(30);
        $oPlan = new CampoConsulta('Plano','Plano');
        $oPlan->setILargura(500);
       
        $oDataPrev = new CampoConsulta('Previsão','dataprev', CampoConsulta::TIPO_DATA);
        $oUsunome = new CampoConsulta('Responsável','usunome');
        $oAnexo = new CampoConsulta('Anexo','anexoplan1', CampoConsulta::TIPO_DOWNLOAD);
        $this->addCamposDetalhe($oNr,$oSeq,$oPlan,$oDataPrev,$oUsunome,$oAnexo);
        $this->addGriTela($this->getOGridDetalhe());
        
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oNr = new CampoConsulta('Nr.','nr');
        $oNr->setILargura(30);
        $oSeq = new CampoConsulta('Seq.','seq');
        $oSeq->setILargura(30);
        $oPlan = new CampoConsulta('Plano','Plano');
        $oPlan->setILargura(500);
        
        $oDataPrev = new CampoConsulta('Previsão','dataprev', CampoConsulta::TIPO_DATA);
        
        $oUsunome = new CampoConsulta('Responsável','usunome');
       
        
        $oAnexo = new CampoConsulta('Anexo','anexoplan1', CampoConsulta::TIPO_DOWNLOAD);
        $this->addCampos($oNr,$oSeq,$oPlan,$oDataPrev,$oUsunome,$oAnexo);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->criaGridDetalhe();
        
        $aValor = $this->getAParametrosExtras();
        
        $oFieldInf = new FieldSet('Informações');
        
        $oFilcgc = new Campo('','filcgc', Campo::TIPO_TEXTO,1);
        $oFilcgc->setSValor($aValor[0]);
        $oFilcgc->setBCampoBloqueado(true);
        $oFilcgc->setBOculto(true);
        
        $oNr = new Campo('','nr', Campo::TIPO_TEXTO,1);
        $oNr->setSValor($aValor[1]);
        $oNr->setBCampoBloqueado(true);
        $oNr->setBOculto(true);
        
        $oSeq = new Campo('','seq', Campo::TIPO_TEXTO,1);
        $oSeq->setBCampoBloqueado(true);
        $oSeq->setBOculto(true);
        
        $oFieldInf->addCampos($oFilcgc,$oNr,$oSeq);
        
        $oPlano = new Campo('O que fazer','plano', Campo::TIPO_TEXTAREA,11);
        $oPlano->setBFocus(true);
        $oPlano->setILinhasTextArea(5);
        $oPlano->setICaracter(500);
        
        $oAnexo = new Campo('Anexar plano de ação','anexoplan1', Campo::TIPO_UPLOAD,2,2,2,2);
        $oAnexo->setIMarginTop(3);
       
        
        $oResp = new campo('Cód.','usucodigo', Campo::TIPO_BUSCADOBANCOPK,1,1,1,1);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
       
        $oRespNome = new Campo('Responsável','usunome', Campo::TIPO_BUSCADOBANCO,3,3,3,3);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '','');
        $oRespNome->addCampoBusca('usunome', '','');
        $oRespNome->setSIdTela($this->getTela()->getid());
        
        
        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oResp->addCampoBusca('usunome',$oRespNome->getId(),  $this->getTela()->getId());
       
        $oTipo = new Campo('', 'tipo', Campo::TIPO_TEXTO,1);
        $oTipo->setSValor('Aq');
        $oTipo->setBCampoBloqueado(true);
        $oTipo->setBOculto(true);
        
        
        $oDataPrev = new Campo('Previsão','dataprev', Campo::TIPO_DATA,2);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        
        $oBotConf = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $sGrid=$this->getOGridDetalhe()->getSId();
       //id form,id incremento,id do grid, id focus,    
        $sAcao = $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","acaoDetalheIten","'.$this->getTela()->getId().'-form,'.$oSeq->getId().','.$sGrid.','.$oPlano->getId().','.$oAnexo->getId().'","'.$oFilcgc->getSValor().','.$oNr->getSValor().'");';
        //$oBotConf->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBotConf->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
       
        
        
        $this->addCampos($oPlano,array($oResp,$oRespNome,$oTipo),array($oDataPrev,$oAnexo,$oBotConf,$oFilcgc,$oNr,$oSeq));
        
        
        
        $this->addCamposFiltroIni($oFilcgc,$oNr);
    }
    
    public function addeventoConc() {
        parent::addeventoConc();
        
        $aValor = $this->getAParametrosExtras();
        $sRequest = 'requestAjax("","QualAqPlan","geraRelPdfAq","'. $aValor[0].','.$aValor[1].',AqImp");';
        $sRequest .='requestAjax("","QualAq","envMailMsg","'. $aValor[0].','.$aValor[1].',AqImp");';
      
        return $sRequest;
    }
}