<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerContPagItem extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('ContPagItem');
    }
  
     public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
        $aParam = $this->getParametros();
        
         $oModelNf = Fabrica::FabricarModel('Nfent');
         $oPersNf = Fabrica::FabricarPersistencia('Nfent');
         $oPersNf->setModel($oModelNf);
         
         $this->Persistencia->adicionaFiltro('empcnpj',$aParam[0]);
         $this->Persistencia->adicionaFiltro('nfdoc',$aParam[1]);
         $this->Persistencia->adicionaFiltro('nfserie',$aParam[2]);
         $this->Persistencia->adicionaFiltro('pescnpj',$aParam[3]); 
         
         $oPersNf->adicionaFiltro('empcnpj',$aParam[0]);
         $oPersNf->adicionaFiltro('nfdoc',$aParam[1]);
         $oPersNf->adicionaFiltro('nfserie',$aParam[2]);
         $oPersNf->adicionaFiltro('pescnpj',$aParam[3]);
         
         
         $oModelNf =$oPersNf->consultarWhere();
        
        
        
        $aCampos[] = $aChave[0];
        $aCampos[] =$aChave[1];
        $aCampos[] =$aChave[2];
        $aCampos[] =$aChave[3];
        $aCampos[]= $oModelNf->getNfvlrtot();
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    }  
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = $this->getParametros();
        if(is_array($aparam)){
          $this->Persistencia->adicionaFiltro('nfdoc',$aparam[1]);
          $this->Persistencia->adicionaFiltro('nfserie',$aparam[2]);
          $this->Persistencia->adicionaFiltro('pescnpj',$aparam[3]); 
          }else
        {
          $aparam = explode(',', $this->getParametros()) ; 
          $this->Persistencia->adicionaFiltro('nfdoc',$aparam[0]);
          $this->Persistencia->adicionaFiltro('nfserie',$aparam[1]);
          $this->Persistencia->adicionaFiltro('pescnpj',$aparam[2]); 
        }
        
        
    }
    
     public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('contseq',  $this->Model->getContseq());
    }
    
    public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sForm, $sCampos);
        $aParam = explode(',', $sDados);
        
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
            
           
            
       
        echo $sScript;
        
    }
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        
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