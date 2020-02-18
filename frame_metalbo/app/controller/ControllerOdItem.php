<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerOdItem extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('OdItem');
     
    }
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
        
        $aCampos[] = $aChave[0];
        $aCampos[] =$aChave[1];
       
       
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    }  
    
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
       if(count($aparam)>0){ 
       $this->Persistencia->adicionaFiltro('empcnpj',$aparam[0]);
       $this->Persistencia->adicionaFiltro('odnr',$aparam[1]);
       }else
       {
         $this->Persistencia->adicionaFiltro('empcnpj',$aparam1[0]);
         $this->Persistencia->adicionaFiltro('odnr',$aparam1[1]);  
       }
      $this->Persistencia->setChaveIncremento(false);
    }
    
     public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('odseq',  $this->Model->getOdseq());
    }
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
          // $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aCampoAtual[0], $aCampoAtual[1]);
          
        }
        
    
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
     public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $aParam = explode(',', $sDados);
       
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
            
            
       
        echo $sScript;
        
    }
    
}