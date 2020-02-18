<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ViewMET_TEC_Emplogo extends View{
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oFilcgc = new CampoConsulta('Cnpj', 'filcgc');
      
        $oFilLogo = new CampoConsulta('Logo', 'fillogo');
        
   
        
      //  $this->addFiltro($oFiltro);
        
        $this->addCampos($oFilcgc,$oFilLogo);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $this->setTituloTela('Cadastro de logos das empresas');
        
        $oFilcgc = new Campo('Cnpj','filcgc', Campo::TIPO_BUSCADOBANCOPK,2);
        $oFilcgc->setClasseBusca('DELX_FIL_empresa');
        $oFilcgc->setSCampoRetorno('fil_codigo',$this->getTela()->getId());
      
        $oFilLogo = new Campo('Logo', 'fillogo', Campo::TIPO_UPLOAD);
        $oFilLogo->setExtensoesPermitidas('png','jpg','gif');
        
        $this->addCampos(array($oFilcgc),$oFilLogo);
        
    }
}
