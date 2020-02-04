<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSolFatItem extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('SolFatItem');
    }
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
        
        $aCampos[] = $aChave[0];
        $aCampos[] =$aChave[1];
        $aCampos[] = $aChave[2];
       
       
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    } 
    
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = explode(',',$this->getParametros());
        
         if(is_array($aparam)){
           $this->Persistencia->adicionaFiltro('empcnpj',$aparam[0]);
           $this->Persistencia->adicionaFiltro('fatsol',$aparam[1]); 
           $this->Persistencia->adicionaFiltro('pescnpj',$aparam[2]);
          }else
        {
          $aparam = $this->getParametros();
          $this->Persistencia->adicionaFiltro('empcnpj',$aparam[0]);
          $this->Persistencia->adicionaFiltro('fatsol',$aparam[1]);
          $this->Persistencia->adicionaFiltro('pescnpj',$aparam[2]);
        }
        
     
        
        
    }
    
     public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('fatseq',  $this->Model->getFatseq());
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
