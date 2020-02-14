<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerContpagar extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Contpagar');
        $this->setControllerDetalhe('ContPagItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);
        
        $aDados = explode(',', $sParametros);
        $sChave =htmlspecialchars_decode($aDados[2]);
        parse_str($sChave,$aParametros);  //parse_str($_REQUEST['campos'],$aCampos);
        
        $this->View->setAParametrosExtras($aParametros);//htmlspecialchars_decode
        
    }
    
    public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       
       $this->Persistencia->adicionaFiltro('empcnpj',$this->Model->getEmpcnpj());                   
       $this->Persistencia->adicionaFiltro('nfdoc',  $this->Model->getNfdoc());
       $this->Persistencia->adicionaFiltro('nfserie',  $this->Model->getNfserie());
       $this->Persistencia->adicionaFiltro('pescnpj',  $this->Model->getPescnpj());
       
   }
   
    /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getEmpcnpj();
       $aRetorno[1]=  $this->Model->getNfdoc();
       $aRetorno[2]=  $this->Model->getNfserie();
       $aRetorno[3]=  $this->Model->getPescnpj();
       return $aRetorno;
   }
}
