<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewQualAqEficazApont extends View{
    public function criaTela() {
        parent::criaTela();
        
        $aDados = $this->getAParametrosExtras();
        $oEmpresa = new Campo('Empresa','filcgc', Campo::TIPO_TEXTO,2,2,2,2);
        $oEmpresa->setSValor($aDados['EmpRex_filcgc']);
        $oEmpresa->setBCampoBloqueado(true);
        $oNr = new Campo('Nr AQ','nr', Campo::TIPO_TEXTO,1,1,1,1,1);
        $oNr->setSValor($aDados['nr']);
        $oNr->setBCampoBloqueado(true);
        
        /*------------grid----------------------*/
        $oGridAq = new campo('Avaliação da eficácia','griEf', Campo::TIPO_GRID,12,12,12,12,150);
        
        $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);
        $oAcao = new CampoConsulta('O que verificar','acao');
        $oAcao->setILargura(500);
        
        $oQuando = new CampoConsulta('Quando','dataprev', CampoConsulta::TIPO_DATA);
        $oDataRelGrid = new CampoConsulta('Data Realização','datareal', CampoConsulta::TIPO_DATA,2);
        $oSit = new CampoConsulta('Situação','sit');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        
        $oUsuGrid = new CampoConsulta('Quem','usunome');
        
        $oGridAq->addCampos($oSeq,$oAcao,$oQuando,$oDataRelGrid,$oSit,$oUsuGrid);
        $oGridAq->setSController('QualAqApont');
        $oGridAq->addParam('seq','0');
        /*------campos que vao receber os dados do grid---------*/
        
        $oSeqEnv = new Campo('Sêquencia','seq', Campo::TIPO_TEXTO,1);
        $oSeqEnv->setBCampoBloqueado(true);
        $oSeqEnv->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        
        $oAcaoEnv = new Campo('O que verificar','acao', Campo::TIPO_TEXTAREA,6);
        $oAcaoEnv->setBCampoBloqueado(true);
       
        $oDataPrev = new Campo('Quando','dataprev', Campo::TIPO_TEXTO,2);
        $oDataPrev->setBCampoBloqueado(true);
        
        $oEficaz = new Campo('Eficaz?','eficaz', Campo::TIPO_SELECT,2);
        $oEficaz->addItemSelect('Sim', 'Sim! foi eficaz.');
        $oEficaz->addItemSelect('Não', 'Não! não foi eficaz!');
        
        $oObs = new Campo('Observação final','obs', Campo::TIPO_TEXTAREA,6);
        $oObs->setSCorFundo(Campo::FUNDO_AMARELO);
        
        $oDataReali = new Campo('Data realização','datareal', Campo::TIPO_DATA,2);
        $oDataReali->addValidacao(false, Validacao::TIPO_STRING, '', '1');
        
        $sAcaoBusca = 'requestAjax("'.$this->getTela()->getId().'-form","QualAqEficazApont","getDadosGrid","'.$oGridAq->getId().'","criaConsultaEf"); ';
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        
        
         $oGridAq->getOGrid()->setSEventoClick('var chave=""; $("#'.$oGridAq->getId().' tbody .selected").each(function(){chave = $(this).find(".chave").html();}); '
                . 'requestAjax("","QualAqEficazApont","sendaDadosCampos","'.$oGridAq->getId().'"+","+chave+","+"'.$oSeqEnv->getId().'"+","+""+","+"'.$oDataPrev->getId().'"+","+"'.$oAcaoEnv->getId().'"+","+"'.$oDataReali->getId().'"+","+"'.$oObs->getId().'"); ');//$oObs
        
        //botão inserir os dados
        $oBtnInserir = new Campo('Gravar','',  Campo::TIPO_BOTAOSMALL_SUB,1);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId()); 
       //id do grid
        $sGrid=$oGridAq->getId();
        $sAcao = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","apontaEfi","'.$this->getTela()->getId().'-form,'.$sGrid.'","");';
       
        $oBtnInserir->setSAcaoBtn($sAcao);
        $this->getTela()->setIdBtnConfirmar($oBtnInserir->getId());
        $this->getTela()->setAcaoConfirmar($sAcao);
        $this->getTela()->setSAcaoShow($sAcaoBusca);
        
        $sAcaoRet = 'requestAjax("'.$this->getTela()->getId().'-form","'.$this->getController().'","apontaRetEfi","'.$this->getTela()->getId().'-form,'.$sGrid.'","");';
        $oBtnNormal = new Campo('Ret. Aberta','btnNormal', Campo::TIPO_BOTAOSMALL,2);
        $oBtnNormal->getOBotao()->addAcao($sAcaoRet);
        $oBtnNormal->getOBotao()->setSStyleBotao(Botao::TIPO_DEFAULT);
         
         
         $this->addCampos(array($oEmpresa,$oNr),$oGridAq,array($oSeqEnv,$oDataPrev),$oAcaoEnv,$oEficaz,$oDataReali,array($oObs, $oBtnInserir,$oBtnNormal));
    }
    
    public function criaConsultaEf(){
        $oGridAq = new Grid("");
        
         $oSeq = new CampoConsulta('Seq.', 'seq');
        $oSeq->setILargura(30);
        $oAcao = new CampoConsulta('O que verificar','acao');
        $oAcao->setILargura(550);
        
        $oQuando = new CampoConsulta('Quando','dataprev', CampoConsulta::TIPO_DATA);
        $oDataRelGrid = new CampoConsulta('Data Realização','datareal', CampoConsulta::TIPO_DATA);
        $oSit = new CampoConsulta('Situação','sit');
        $oSit->addComparacao('Finalizado', CampoConsulta::COMPARACAO_IGUAL, CampoConsulta::COR_VERDE, CampoConsulta::MODO_LINHA);
        
       $oUsuGrid = new CampoConsulta('Quem','usunome');
        
        $oGridAq->addCampos($oSeq,$oAcao,$oQuando,$oDataRelGrid,$oSit,$oUsuGrid);
        $aCampos = $oGridAq->getArrayCampos();
        return $aCampos;
        
    }


    
}