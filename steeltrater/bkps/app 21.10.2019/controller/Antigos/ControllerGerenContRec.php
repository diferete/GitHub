<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerGerenContRec extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('GerenContRec');
    }
    
    public function afterCommitUpdate() {
        parent::afterCommitUpdate();
        
        $sEmpcnpj = $this->Model->getEmpcnpj();
        $sPescnpj = $this->Model->getPessoa()->getPescnpj();
        $sRecDocto = $this->Model->getRecdocto();
        $sRecParc = $this->Model->getRecparc();
      
        //muda a situação para pago
        $this->Persistencia->mudaSitRec($sEmpcnpj,$sPescnpj,$sRecDocto, $sRecParc);
        
        
        return $aRetorno[0] = true;
    }
    
    public function depoisCarregarDados($sParametros = null) {
        parent::depoisCarregarDados($sParametros);
        
         foreach($this->View->getTela()->getCampos() as $oCampo){
             
         } 
    }
    
    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);
        
        $this->Model->setRecuserapont($_SESSION['nome']);
    }
}