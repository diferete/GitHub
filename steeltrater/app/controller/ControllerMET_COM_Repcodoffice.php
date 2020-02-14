<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_COM_Repcodoffice extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_COM_Repcodoffice');
    }
    
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
    
        
        $this->View->setAParametrosExtras($aChave);
        
       
    }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
        $this->Persistencia->adicionaFiltro('filcgc',$aparam[0]);
        $this->Persistencia->adicionaFiltro('officecod',$aparam[1]);
        $this->Persistencia->setChaveIncremento(false);
        }  else {
        $this->Persistencia->adicionaFiltro('filcgc',$aparam[0]);
        $this->Persistencia->adicionaFiltro('officecod',$aparam[1]);
        $this->Persistencia->setChaveIncremento(false); 
        }
        
    }
}