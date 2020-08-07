<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerContRec extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('ContRec');
        $this->setControllerDetalhe('ContRecParc');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
     /**
    * adiciona filtros extras
    */
   public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       
       $this->Persistencia->adicionaFiltro('empcnpj',$this->Model->getEmpcnpj()); 
       $this->Persistencia->adicionaFiltro('pescnpj',$this->Model->getPessoa()->getPescnpj());                   
       $this->Persistencia->adicionaFiltro('recdocto',$this->Model->getRecdocto());
      
   }
   
   /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getEmpcnpj();
       $aRetorno[1]=  $this->Model->getPessoa()->getPescnpj();
       $aRetorno[2]=  $this->Model->getRecdocto();
       
       return $aRetorno;
   }
   
   public function antesDeCriarTela($sParametros = null) {
       parent::antesDeCriarTela($sParametros);
       
       $aDados = explode(',', $sParametros);
       if(count($aDados)>1){
       
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $oModelPessoa = Fabrica::FabricarModel('Pessoa');
        $oPersPessoa = Fabrica::FabricarPersistencia('Pessoa');
        $oPersPessoa->setModel($oModelPessoa );
        $oPersPessoa->adicionaFiltro('pescnpj',$aCamposChave['Pessoa_pescnpj']);
        $oDados = $oPersPessoa->consultarWhere();
       
        $aCamposChave['razao'] = $oDados->getPesnome_razao();
        
        //pega os valores do model sol fat
        $oModelFatSol = Fabrica::FabricarModel('SolFat');
        $oPersFatSol = Fabrica::FabricarPersistencia('SolFat');
        $oPersFatSol->setModel($oModelFatSol);
        $oPersFatSol->adicionaFiltro('empcnpj',$aCamposChave['empcnpj']);
        $oPersFatSol->adicionaFiltro('fatsol',$aCamposChave['fatsol']);
        $oPersPessoa->adicionaFiltro('pescnpj',$aCamposChave['Pessoa_pescnpj']);
        $oDadosSol = $oPersFatSol->consultarWhere();
     
        $aCamposChave['valor'] = $oDadosSol->getFatvlrtot();
        
        $this->View->setAParametrosExtras($aCamposChave);
       }
   }
    
    
}
