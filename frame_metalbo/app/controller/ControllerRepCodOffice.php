<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerRepCodOffice extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('RepCodOffice');
    }
    
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
     /*   $oModelMenu = Fabrica::FabricarModel('Menu');
        $oPersMenu = Fabrica::FabricarPersistencia('Menu');
        $oPersMenu->setModel($oModelMenu);
        $oPersMenu->adicionaFiltro('modcod',$aChave[1]);            
        $oPersMenu->adicionaFiltro('mencodigo',$aChave[0]);
        $oModelMenu = $oPersMenu->consultarWhere();
        
        $aCampos[] = $oModelMenu->getModulo()->getModcod();
        $aCampos[] = $oModelMenu->getModulo()->getModescricao();
        $aCampos[] = $oModelMenu->getMencodigo();
        $aCampos[] = $oModelMenu->getMendes();*/
        
       
        
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