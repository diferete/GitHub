<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ViewMET_TEC_Mobile extends View{
    public function __construct() {
        parent::__construct();
    }
    
   public function criaTela() {
        parent::criaTela();
        
       $this->setBTela(true); 
       $this->setBOcultaBotTela(true);
       $this->setBOcultaFechar(true);
       
       $oCampo1 = new Campo('Nome','nome', Campo::TIPO_TEXTO,2,2,2,2);
       
       $oBotao = new Campo('Chamar classe','', Campo::TIPO_BOTAOSMALL_SUB,2);
       $sAcao ='requestAjaxMobile("'.$this->getTela()->getId().'-form","MobileMetalbo","getRequisicao");'; 
       $oBotao->addAcaoBotao($sAcao);
       $oBotao->setApenasTela(true);
       
       $this->addCampos($oCampo1,$oBotao);
    }
}