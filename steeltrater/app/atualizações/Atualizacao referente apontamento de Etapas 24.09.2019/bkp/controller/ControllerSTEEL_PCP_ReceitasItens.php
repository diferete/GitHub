<?php

/* 
 *@author Avanei Martendal
 *@since 15/06/2018
 */

class ControllerSTEEL_PCP_ReceitasItens extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ReceitasItens');
    }
    
    public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $this->View->setAParametrosExtras($aChave);
        
        }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
          $this->Persistencia->adicionaFiltro('cod',$aparam[0]);
            }  else {
          $this->Persistencia->adicionaFiltro('cod',$aparam1[0]);
          $this->Persistencia->setChaveIncremento(false); 
        }
        
    }
    
    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
       
         $this->Persistencia->adicionaFiltro('seq',  $this->Model->getSeq());
    }
    
    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&',$aChave);
        unset($aCampos[1]);
        foreach ($aCampos as $key => $sCampoAtual) {
           $aCampoAtual = explode('=',$sCampoAtual);
           $aModel = explode('.',$aCampoAtual[0] );
           $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
          
        }
        
        $this->Persistencia->setChaveIncremento(false);
        
    }
    
     public function acaoLimpar($sForm,$sDados) {
        parent::acaoLimpar($sDados);
        $sScript = '$("#'.$sForm.'").each (function(){ this.reset();});';
        echo $sScript;
       }
    
     public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setCamada_min($this->ValorSql($this->Model->getCamada_min()));
        $this->Model->setCamada_max($this->ValorSql($this->Model->getCamada_max()));
        
        $this->Model->setTemperatura($this->ValorSql($this->Model->getTemperatura()));
        $this->Model->setTempo($this->ValorSql($this->Model->getTempo()));
        
        
        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;


    }
   
    
    
    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setCamada_min($this->ValorSql($this->Model->getCamada_min()));
        $this->Model->setCamada_max($this->ValorSql($this->Model->getCamada_max()));
        
        $this->Model->setTemperatura($this->ValorSql($this->Model->getTemperatura()));
        $this->Model->setTempo($this->ValorSql($this->Model->getTempo()));

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }
    
    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        
        $this->Model->setCamada_min(number_format($this->Model->getCamada_min(), 2, ',', '.'),0,0,'L' );
        $this->Model->setCamada_max(number_format($this->Model->getCamada_max(), 2, ',', '.'),0,0,'L');
        
        $this->Model->setTemperatura(number_format($this->Model->getTemperatura(), 2, ',', '.'),0,0,'L');
        $this->Model->setTempo(number_format($this->Model->getTempo(), 2, ',', '.'),0,0,'L');
        
        return $aCampos;
    }
    public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);
        
        $this->Model->setMetanol(number_format($this->Model->getMetanol(), 2, ',', '.'),0,0,'L' );
        $this->Model->setOxigenio(number_format($this->Model->getOxigenio(), 2, ',', '.'),0,0,'L');
        $this->Model->setNitrogenio(number_format($this->Model->getNitrogenio(), 2, ',', '.'),0,0,'L');
        $this->Model->setAmonia(number_format($this->Model->getAmonia(), 2, ',', '.'),0,0,'L');//Glp
        $this->Model->setGlp(number_format($this->Model->getGlp(), 2, ',', '.'),0,0,'L');
        $this->Model->setCo(number_format($this->Model->getCo(), 2, ',', '.'),0,0,'L');
        $this->Model->setCarbono(number_format($this->Model->getCarbono(), 2, ',', '.'),0,0,'L');
        
        
        
    }
    
    public function retornaReceita($sReceita){
        $this->Persistencia->adicionaFiltro('cod',$sReceita);
        $aModel = $this->Persistencia->getArrayModel();
        return $aModel;
    }
    
  
}
