<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerQualCausa extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('QualCausa');
        $this->setControllerDetalhe('QualAqPlan');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $aCampos = $aChave;
        $this->View->setAParametrosExtras($aCampos);
        }
    
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
        $this->Persistencia->adicionaFiltro('filcgc',$aparam[0]);
        $this->Persistencia->adicionaFiltro('nr',$aparam[1]);
        $this->Persistencia->setChaveIncremento(false);
        }  else {
        $this->Persistencia->adicionaFiltro('filcgc',$aparam1[0]);
        $this->Persistencia->adicionaFiltro('nr',$aparam1[1]);
        $this->Persistencia->setChaveIncremento(false); 
        }
        
    }
    
     public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('seq',  $this->Model->getSeq());
    }
    
    public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $aParam = explode(',', $sDados);
        
        //verifica se está como 
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
          
            
       
        echo $sScript;
        
    }
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
           $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
          
        }
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
    public function criaPainelCausa($sDados,$sCampos){
     $aDados = explode(',', $sDados);
     $aCampos = explode(',', $sCampos);
     $this->pkDetalhe($aCampos);
     $this->parametros = $sCampos;
    
     $this->View->criaTela();
     $this->View->getTela()->setSRender($aDados[3]);
     //define o retorno somente do form
     $this->View->getTela()->setBSomanteForm(true);
     //seta o controler na view
     $this->View->setTelaController($this->View->getController());
     $this->View->adicionaBotoesEtapas($aDados[0],$aDados[1],$aDados[2],$aDados[3],$aDados[4],$aDados[5],$this->getControllerDetalhe());
     $this->View->getTela()->getRender();
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
      
        
       
        return $aCampos;
        
        
    }
    
    public function afterInsert() {
        parent::afterInsert();
        
        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
       //$sRetorno = "$('#".$aDados[4]."').fileinput('clear');";
      // echo $sRetorno;
       //atualiza ocorrencias
        $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();
        
        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc,$sNr,$sSeq);
        
        //marca o campo select
         $sTrigger= '$("#'.$aDados[4].'").val("Matéria prima").trigger("change");';
         echo $sTrigger;
       
       
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterUpdate() {
        parent::afterUpdate();
        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        //marca o campo select
         $sTrigger= '$("#'.$aDados[4].'").val("Matéria prima").trigger("change");';
         echo $sTrigger;
        
        $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();
        
        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc,$sNr,$sSeq);
        
         $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    public function afterDelete() {
        parent::afterDelete();
        
         $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();
        
        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc,$sNr,$sSeq);
        
         $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function afterResetForm($sDados) {
        parent::afterResetForm($sDados);
        
        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        //marca o campo select
         $sTrigger= '$("#'.$aDados[4].'").val("Matéria prima").trigger("change");';
         echo $sTrigger;
    }

}
