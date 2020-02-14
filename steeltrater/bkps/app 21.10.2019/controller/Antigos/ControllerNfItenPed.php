<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerNfItenPed extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('NfItenPed');
    }
   
    
    public function antesDetalhe($sParametros = null) {
        parent::antesDetalhe($sDados);
        if($sParametros==""){
        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('nfsitpdvnr','9999999');    
        }else{
        $this->Persistencia->limpaFiltro();
        $this->Persistencia->adicionaFiltro('nfsitpdvnr',$sParametros);
        }
    }
    
  
}