<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqEficaz extends View{
    public function __construct() {
        parent::__construct();
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $aDados = $this->getAParametrosExtras();
        $oFilcgc = new Campo('Empresa','filcgc', Campo::TIPO_TEXTO,2);
        $oFilcgc->setSValor($aDados['EmpRex_filcgc']);
        $oFilcgc->setBCampoBloqueado(true);
        $oNr = new Campo('Nr.','nr', Campo::TIPO_TEXTO,1);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBCampoBloqueado(true);
        
        $oSeq = new Campo('','seq', Campo::TIPO_TEXTO,1);
        $oSeq->setBOculto(true);
        
        $oAcao = new Campo('O que verificar','acao', Campo::TIPO_TEXTAREA,6);
        $oAcao->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oResp = new campo('Cód.','usucodigo', Campo::TIPO_BUSCADOBANCOPK,1,1,1,1);
        $oResp->setSIdHideEtapa($this->getSIdHideEtapa());
        $oResp->addValidacao(false, Validacao::TIPO_STRING, '', '1');
       
        $oRespNome = new Campo('Responsável','usunome', Campo::TIPO_BUSCADOBANCO,3,3,3,3);
        $oRespNome->setSIdPk($oResp->getId());
        $oRespNome->setClasseBusca('User');
        $oRespNome->addCampoBusca('usucodigo', '','');
        $oRespNome->addCampoBusca('usunome', '','');
        $oRespNome->setSIdTela($this->getTela()->getid());
        $oRespNome->addValidacao(false, Validacao::TIPO_STRING, '', '2');
        
        $oResp->setClasseBusca('User');
        $oResp->setSCampoRetorno('usucodigo',$this->getTela()->getId());
        $oResp->addCampoBusca('usunome',$oRespNome->getId(),  $this->getTela()->getId());
       
        
        $oDataPrev = new Campo('Quando','dataprev', Campo::TIPO_DATA,2);
        $oDataPrev->addValidacao(false, Validacao::TIPO_STRING, '', '1');
      
        
        $oGridAq = new campo('Eficácia','gridEficaz', Campo::TIPO_GRID,12,12,12,12,150);
        
        $oSeqGrid = new CampoConsulta('Seq.', 'seq');
        $oSeqGrid->setILargura(30);
        
        $oNrGrid = new CampoConsulta('Nr','nr');
        $oNrGrid->setILargura(30);
        
        $oAcaoGrid = new CampoConsulta('O que verificar','acao');
        $oAcaoGrid->setILargura(600);
        
       $oRespNomeGrid = new CampoConsulta('Quem','usunome');
        
        
      
        
        $oDataPrevGrid = new CampoConsulta('Previsão','dataprev', CampoConsulta::TIPO_DATA);
        
        
        $oGridAq->addCampos($oNrGrid,$oSeqGrid,$oAcaoGrid,$oDataPrevGrid,$oRespNomeGrid);
        $oGridAq->setSController('QualAqEficaz');
        $oGridAq->addParam('seq','0');
        
        //botão inserir os dados
        $oBtnInserir = new Campo('Inserir','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId()); 
       //id do grid
        $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","apontEficaz","'.$this->getTela()->getId().'-form,'.$sGrid.','.$oSeq->getId().'","");';
       
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        
        /*botão excluir*/
       $sAcao = 'var chave=""; $("#'.$oGridAq->getId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("'.$this->getTela()->getId().'-form","QualAqEficaz","excluirEf","'.$this->getTela()->getId().'-form,'.$oGridAq->getId().'"+","+chave+""); ';// excluirEf
       $oBtnDelete = new Campo('Deletar','btnNormal', Campo::TIPO_BOTAOSMALL,2);
       $oBtnDelete->getOBotao()->setSStyleBotao(Botao::TIPO_DANGER);
       $oBtnDelete->getOBotao()->addAcao($sAcao);
       
       $oLinha = new Campo('','', Campo::TIPO_LINHA);
       
    
       $sAcaoBusca = 'requestAjax("'.$this->getTela()->getId().'-form","QualAqEficaz","getDadosGrid","'.$oGridAq->getId().'","consultaEficaz");'; 
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        
        $this->addCampos(array($oFilcgc,$oNr,$oSeq),$oAcao,array($oResp,$oRespNome),array($oDataPrev,$oBtnInserir),$oLinha,$oBtnDelete,$oGridAq);
    }
    
      public function consultaEficaz(){
        $oGridEf = new Grid("");
        
       
        
        $oSeqGrid = new CampoConsulta('Seq.', 'seq');
        $oSeqGrid->setILargura(30);
        
        $oNrGrid = new CampoConsulta('Nr','nr');
        $oNrGrid->setILargura(30);
        
        $oAcaoGrid = new CampoConsulta('O que verificar','acao');
        $oAcaoGrid->setILargura(600);
        
        $oDataPrevGrid = new CampoConsulta('Previsão','dataprev', CampoConsulta::TIPO_DATA);
        
        $oRespNomeGrid = new CampoConsulta('Quem','usunome');
        
        $oGridEf->addCampos($oNrGrid,$oSeqGrid,$oAcaoGrid,$oDataPrevGrid,$oRespNomeGrid);
        
        
        $aCampos = $oGridEf->getArrayCampos();
        return $aCampos;
        
    }
}