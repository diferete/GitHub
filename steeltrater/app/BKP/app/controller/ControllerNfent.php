<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerNfent extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Nfent');
        $this->setControllerDetalhe('NfentItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    /**
    * adiciona filtros extras
    */
   public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       
       $this->Persistencia->adicionaFiltro('empcnpj',$this->Model->getEmpcnpj()); 
       $this->Persistencia->adicionaFiltro('nfdoc',$this->Model->getNfdoc());                   
       $this->Persistencia->adicionaFiltro('nfserie',  $this->Model->getNfserie());
       $this->Persistencia->adicionaFiltro('pescnpj',  $this->Model->getPescnpj());
   }
   /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getNfdoc();
       $aRetorno[1]=  $this->Model->getNfserie();
       $aRetorno[2]=  $this->Model->getPescnpj();
       $aRetorno[3]=  $this->Model->getEmpcnpj();
       return $aRetorno;
   }
   /**
    * Muda a situação da nota para com financeiro
    */
   public function mudaSitFinan($sChave){
       $oPers = Fabrica::FabricarPersistencia('Nfent');
       $aRetorno =$oPers->mudaSitFinan($sChave);
       $oPersContPagItem = Fabrica::FabricarPersistencia('ContPagItem');
       $aRetorno =$oPersContPagItem->insSitFinan($sChave);
   }
   
   public function antesExcluir($sParametros = null) {
       parent::antesExcluir($sParametros);
       //verificar se há financeiro antes
       $oPers = Fabrica::FabricarPersistencia('Contpagar');
       $contador = $oPers->verificaFinan($sParametros);
       if($contador > 0){
        $oMensagem = new Modal('Nota com financeiro', 'Essa nota tem contas a pagar atreladas!', Modal::TIPO_INFO, false, true, true);
        echo $oMensagem->getRender();
        exit();
       }
   }
   
}