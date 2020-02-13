<?php

/* 
 *Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRncVenda extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('QualRncVenda');
    }
    public function buscaNf($sDados){
        $aParam= explode(',',$sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $oRow = $this->Persistencia->consultaNf($aCamposChave['nf']);
        
        echo"$('#".$aParam[0]."').val('".$oRow->data."');"
           ."$('#".$aParam[1]."').val('".number_format($oRow->nfsvlrtot,2,',','.')."');"
           ."$('#".$aParam[2]."').val('".number_format($oRow->nfspesolq,2,',','.')."');";
    }
    
    
     public function beforeInsert() {
        parent::beforeInsert();
        
        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        
         $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));
       /*$date = new DateTime( '2014-08-19' );
echo $date-> format( 'd-m-Y' );*/

        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->Model->setValor($this->ValorSql($this->Model->getValor()));
        $this->Model->setPeso($this->ValorSql($this->Model->getPeso()));
        
        $this->Model->setQuant($this->ValorSql($this->Model->getQuant()));
        
        $this->Model->setQuantnconf($this->ValorSql($this->Model->getQuantnconf()));
        
        //Quantnconf
        
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
     public function depoisCarregarModelAlterar($sParametros = null) {
        parent::depoisCarregarModelAlterar($sParametros);
        
     
        
        $this->Model->setValor(number_format($this->Model->getValor(),2,',','.'));
        $this->Model->setPeso(number_format($this->Model->getPeso(),2,',','.'));
        
        $this->Model->setQuant(number_format($this->Model->getQuant(),2,',','.'));
        
        $this->Model->setQuantnconf(number_format($this->Model->getQuantnconf(),2,',','.'));
        
        
        
        
    }
    
    public function limpaUploads($aIds) {
      parent::limpaUploads($aIds);
      
      
            $sRetorno = "$('#".$aIds[3]."').fileinput('clear');"
                        ."$('#".$aIds[4]."').fileinput('clear');"
                        ."$('#".$aIds[5]."').fileinput('clear');";
                        
          echo $sRetorno;
      
      
  }
  
   /**
       * finaliza uma rnc
       */
      /**
   * Cria a tela Modal para a proposta
   * @param type $sDados
   */
    public function criaTelaModalFinaliza($sDados){
       $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $aCamposChave['id'] = $aDados[1];
        
       $aRet = $this->Persistencia->verificaFim($aCamposChave);
        if($aRet[0]){
        $this->Persistencia->adicionaFiltro('filcgc',$aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
        
        $oDados = $this->Persistencia->consultarWhere();
        $this->View->setAParametrosExtras($oDados);
        
        $this->View->criaModalFinaliza($sDados);
       
         //adiciona onde será renderizado
        $sLimpa ="$('#".$aDados[1]."-modal').empty();";
        echo $sLimpa;
        $this->View->getTela()->setSRender($aDados[1].'-modal');
      
       //renderiza a tela
        $this->View->getTela()->getRender();
        }else{
            $oMens = new Modal('Atenção, reclamação já finalizada!', '', Modal::TIPO_AVISO, false, true, false);
            echo $oMens->getRender();
            echo'$("#'.$aDados[1].'-btn").click();';
        }
            
        }
        
        /**
    * Aprova final rnc 
    * @param type $sDados
    */ 
   public function finalizaRnc($sDados){
      $aDados = explode(',', $sDados);
      $sClasse = $this->getNomeClasse();
      $aCampos = array();
      parse_str($_REQUEST['campos'],$aCampos);
      
     $aRet = $this->Persistencia->finalizaAcao($aCampos);
      
      
      if($aRet[0]){
          $oMsg = new Mensagem('Reclamação finalizada com sucesso!','Reclamação nº'.$aCampos['nr'].' foi finalizada com sucesso!', Mensagem::TIPO_SUCESSO);
          echo $oMsg->getRender();
          echo'$("#'.$aDados[2].'-btn").click();';
      }else{
          
      }
      
      /*$aRetorno = $this->Persistencia->aprovCli($aCampos['EmpRex_filcgc'],$aCampos['nr'],$aCampos['obsaprovcli']);
      if($aRetorno[0]){
          echo'$("#'.$aDados[1].'-btn").click();';
          $oMsg = new Mensagem('Aprovado com sucesso','Projeto nº'.$aCampos['nr'].' foi aprovado com sucesso!', Mensagem::TIPO_SUCESSO);
          echo $oMsg->getRender();
          echo 'requestAjax("","'.$sClasse.'","mensEmailAprov","'.$sCampos.'");';
      }else{
          $oMsg = new Mensagem('Erro no apontamento', 'Projeto não aprovado com sucesso!', Mensagem::TIPO_ERROR);
          echo $oMsg->getRender();
      }*/
  }
        
}

