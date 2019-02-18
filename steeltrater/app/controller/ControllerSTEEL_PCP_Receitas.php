<?php

/* 
 * Classe que implementa model das receitas das ofs
 * 
 * @author Avanei Martendal
 * @since 15/16/2018
 * 
 */


class ControllerSTEEL_PCP_Receitas extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Receitas');
        $this->setControllerDetalhe('STEEL_PCP_ReceitasItens');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
       
    }
    
    
     public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       $this->Persistencia->adicionaFiltro('cod',$this->Model->getCod());                   
       }
   /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getCod();
       return $aRetorno;
   }
    
    
    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->Model->setMetanol($this->ValorSql($this->Model->getMetanol()));
        $this->Model->setOxigenio($this->ValorSql($this->Model->getOxigenio()));
        $this->Model->setNitrogenio($this->ValorSql($this->Model->getNitrogenio()));
        $this->Model->setAmonia($this->ValorSql($this->Model->getAmonia()));//Glp
        $this->Model->setGlp($this->ValorSql($this->Model->getGlp()));
        $this->Model->setCo($this->ValorSql($this->Model->getCo()));
        $this->Model->setCarbono($this->ValorSql($this->Model->getCarbono()));
        $this->Model->setTemprev($this->ValorSql($this->Model->getTemprev()));
        

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;


    }
   
    
    
    public function beforeInsert() {
        parent::beforeInsert();

        $this->Model->setMetanol($this->ValorSql($this->Model->getMetanol()));
        $this->Model->setOxigenio($this->ValorSql($this->Model->getOxigenio()));
        $this->Model->setNitrogenio($this->ValorSql($this->Model->getNitrogenio()));
        $this->Model->setAmonia($this->ValorSql($this->Model->getAmonia()));//Glp
        $this->Model->setGlp($this->ValorSql($this->Model->getGlp()));
        $this->Model->setCo($this->ValorSql($this->Model->getCo()));
        $this->Model->setCarbono($this->ValorSql($this->Model->getCarbono()));
        $this->Model->setTemprev($this->ValorSql($this->Model->getTemprev()));
        

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
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
        $this->Model->setTemprev(number_format($this->Model->getTemprev(), 2, ',', '.'),0,0,'L');
        
      
        
    }
    
      public function buscaTempPadrao($sDados){
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        $this->Persistencia->adicionaFiltro('cod',$aCamposChave['receita']);
        $oDados = $this->Persistencia->consultarWhere();
        $iTemp = $oDados->getTemprev();
        
       
        echo '$("#'.$sDados.'").val("'.number_format($iTemp, 2, ',', '.').'");';
        
        }
        
       public function mostraTelaRelReceitasItens($renderTo, $sMetodo = '') {                
           parent::mostraTelaRelatorio($renderTo, 'RelOpSteelReceitasItens');                          
           
       }  
             
       public function antesExcluir($sParametros = null) {
           parent::antesExcluir($sParametros);
          
            $oReceita = Fabrica::FabricarController('STEEL_PCP_prodMatReceita');
            $oReceita->Persistencia->adicionaFiltro('cod',$sParametros['cod']);
            $iContReceita = $oReceita->Persistencia->getCount();
            
            $oProduto = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
            $oProduto->Persistencia->adicionaFiltro('receita',$sParametros['cod']);
            $iContProduto = $oProduto->Persistencia->getCount();            

            if(($iContReceita==0)&&($iContProduto==0)){
            
                //monta o delete dos itens da receita
                $oItens = Fabrica::FabricarController('STEEL_PCP_ReceitasItens');
                $oItens->Persistencia->AdicionaFiltro('cod', $sParametros['cod']);
                $oItens->Persistencia->excluir();
           
                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';
                return $aRetorno;
            
            }else{
            
                $oModal = new Modal('Atenção', 'Essa receita não pode ser excluída, pois está vinculada a um produto!', Modal::TIPO_ERRO);
                echo $oModal->getRender();
                exit();
            }  
       }
         
}
