<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_COM_Repcodoffice extends View{
  
   
      public function criaConsulta() {
        parent::criaConsulta();
        
        $this->getTela()->setILarguraGrid(1200);
        
        $oFilcgc = new CampoConsulta('Empresa do Escritório','filcgc');
        $oFilcgc->setILargura(150);
        $officecod = new CampoConsulta('Escritório','officecod');
        $officecod->setILargura(50);
        $officeseq = new CampoConsulta('Seq.','officeseq');
        $oRepcod = new CampoConsulta('Representante','repcod');
        $oRepcod->setILargura(75);
        
        $oRepcodF = new Filtro($oRepcod, Filtro::CAMPO_TEXTO_IGUAL,2);
        
        $oEscritorio = new Filtro($officecod, Filtro::CAMPO_TEXTO_IGUAL,1);
        
        $this->addFiltro($oRepcodF,$oEscritorio);
        
        
        
        $this->addCampos($oRepcod,$oFilcgc,$officecod,$officeseq);
        
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de códigos de representantes por escritório');
        $officecod = new Campo('Código do Escritório','officecod', Campo::TIPO_BUSCADOBANCOPK,2);
        $officecod->setSIdHideEtapa($this->getSIdHideEtapa());
        $officecod->setITamanho(Campo::TAMANHO_PEQUENO);
        $officecod->setBFocus(true);
        $officecod->addValidacao(false, Validacao::TIPO_STRING);
     
        
        $officecod->setClasseBusca('MET_COM_Repoffice');
        $officecod->setSCampoRetorno('officecod',$this->getTela()->getId());
     
        $oFilcgc = new Campo('Empresa do Escritório','filcgc', Campo::TIPO_BUSCADOBANCOPK,2);
        $oFilcgc->setSIdHideEtapa($this->getSIdHideEtapa());
        $oFilcgc->setITamanho(Campo::TAMANHO_PEQUENO);
        $oFilcgc->addValidacao(false, Validacao::TIPO_STRING);
       
     
        
        $oFilcgc->setClasseBusca('MET_COM_Repoffice');
        $oFilcgc->setSCampoRetorno('filcgc',$this->getTela()->getId());
        
      
       
      
        $officeseq = new Campo('Seq.','officeseq', Campo::TIPO_TEXTO,1);
        $officeseq->setBCampoBloqueado(true);
        
        $oRepcod = new Campo('Código Representante','repcod', Campo::TIPO_BUSCADOBANCOPK,2);
        $oRepcod->setSIdHideEtapa($this->getSIdHideEtapa());
        $oRepcod->setITamanho(Campo::TAMANHO_PEQUENO);
        $oRepcod->addValidacao(false, Validacao::TIPO_STRING);
        $oRepcod->setClasseBusca('DELX_COM_Repcod');
        $oRepcod->setSCampoRetorno('rep_codigo',$this->getTela()->getId());
      
        $this->addCampos(array($officecod,$oFilcgc),$oRepcod,$officeseq);
       
    }
}