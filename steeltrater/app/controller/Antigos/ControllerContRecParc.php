<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerContRecParc extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('ContRecParc');
    }
    
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        
        
        $aCampos[] = $aChave[0];
        $aCampos[] =$aChave[1];
        $aCampos[] =$aChave[2];
        
         //pega os valores do model sol fat
        $oModelContRec = Fabrica::FabricarModel('ContRec');
        $oPersContRec = Fabrica::FabricarPersistencia('ContRec');
        $oPersContRec->setModel($oModelContRec);
        $oPersContRec->adicionaFiltro('empcnpj',$aCampos[0]);
        $oPersContRec->adicionaFiltro('pescnpj',$aCampos[1]);
        $oPersContRec->adicionaFiltro('recdocto',$aCampos[2]);
        $oDados = $oPersContRec->consultarWhere();
     
        $aCampos[3] = $oDados->getRecvlrtot();
        
      
       
       
        
        $this->View->setAParametrosExtras($aCampos);
        
       
    } 
    
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam = explode(',',$this->getParametros());
        
         if(is_array($aparam)){
           $this->Persistencia->adicionaFiltro('empcnpj',$aparam[0]);
           $this->Persistencia->adicionaFiltro('pescnpj',$aparam[1]); 
           $this->Persistencia->adicionaFiltro('recdocto',$aparam[2]);
          }else
        {
          $aparam = $this->getParametros();
          $this->Persistencia->adicionaFiltro('empcnpj',$aparam[0]);
          $this->Persistencia->adicionaFiltro('pescnpj',$aparam[1]); 
          $this->Persistencia->adicionaFiltro('recdocto',$aparam[2]);
        }
        
     
        
        
    }
    
     public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('recparc',  $this->Model->getRecparc());
    }
    
     public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[3]);
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
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
       
        
       
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $sDados = $this->getParametros();
        $oPersPessoa = Fabrica::FabricarPersistencia('SolFat');
        $aRetorno = $oPersPessoa->mudaSitFinan( $sDados);
        return $aRetorno;
        
    }
    
    
    
    
    
    
}
