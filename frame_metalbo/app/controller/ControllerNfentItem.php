<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerNfentItem extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('NfentItem');
    }
   
  public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
        
        $aCampos[] = $aChave[0];
        $aCampos[] =$aChave[1];
        $aCampos[] =$aChave[2];
        $aCampos[] =$aChave[3];
       
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    }  
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = explode(',',$this->getParametros());
        
       $this->Persistencia->adicionaFiltro('nfdoc',$aparam[0]);
       $this->Persistencia->adicionaFiltro('nfserie',$aparam[1]);
       $this->Persistencia->adicionaFiltro('pescnpj',$aparam[2]);
       $this->Persistencia->adicionaFiltro('empcnpj',$aparam[3]);
        
       // $this->Persistencia->setChaveIncremento(false);
        
        
    }
    
    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('nfseq',  $this->Model->getNfseq());
    }
    
    
   public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[4]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
          // $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aCampoAtual[0], $aCampoAtual[1]);
          
        }
        
    
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
}