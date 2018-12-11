<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 04/09/2018
 */

class ControllerSTEEL_PCP_prodMatReceita extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_prodMatReceita');
    }
    
    public function beforeInsert() {
        parent::beforeInsert();
        
        $this->Persistencia->adicionaFiltro('prod', $this->Model->getProd());
        $this->Persistencia->adicionaFiltro('matcod', $this->Model->getMatcod());
        $this->Persistencia->adicionaFiltro('cod', $this->Model->getCod());
        
        $iCont =$this->Persistencia->getCount();
        if($iCont>0){
            $oModal = new Modal('Atenção!','Já existe uma registro desse produto, material, receita!', Modal::TIPO_INFO);
            echo $oModal->getRender();
            exit();
        }
        $this->Persistencia->limpaFiltro();
        $aRetorno[0] = true;
         return $aRetorno;
    }
    
    public function afterGetdadoGrid($sParametros = null) {
        parent::afterGetdadoGrid();
        
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        
        if($aCamposChave['prod']==''){
          $oMensagem = new Mensagem('Atenção!', 'Informe um código para pesquisar seu material e receita!', Mensagem::TIPO_WARNING);
          echo $oMensagem->getRender();
          exit();
        }else{
          $this->Persistencia->adicionaFiltro('prod',$aCamposChave['prod']);
          $iCout = $this->Persistencia->getCount();
          if ($iCout==0){
              $oModal = new Modal('Atenção!', 'Não há vínculo do produto com o Material e sua Receita!', Modal::TIPO_AVISO);
              echo $oModal->getRender();
             
          } 
        }
    }
    
    public function sendDadosCampos($sDados){
      $aDados = explode(',',$sDados);
        
      $sChave = htmlspecialchars_decode($aDados[1]);
      $aChaveAq = array();
      parse_str($sChave,$aChaveAq);
      $this->Persistencia->adicionaFiltro('seqmat',$aChaveAq['seqmat']);
      $this->Model = $this->Persistencia->consultarWhere();
      
      if(count($aChaveAq)>0){
          

           
            echo "$('#".$aDados[2]."').val('".$this->Model->getMatcod()."');";
            echo "$('#".$aDados[3]."').val('".$this->Model->getSTEEL_PCP_material()->getMatdes()."');";
            echo "$('#".$aDados[4]."').val('".$this->Model->getCod()."');";
            echo "$('#".$aDados[5]."').val('".$this->Model->getSTEEL_PCP_receitas()->getPeca()."');";
            echo "$('#".$aDados[6]."').val('".$this->Model->getSeqmat()."');";
            echo "$('#".$aDados[7]."').val('".number_format($this->Model->getSTEEL_PCP_receitas()->getTemprev(),3,',','.')."');";
           
            
            
        }else{
            echo "$('#".$aDados[2]."').val('');";
            echo "$('#".$aDados[3]."').val('');";
            echo "$('#".$aDados[4]."').val('');";
            echo "$('#".$aDados[5]."').val('');";
            echo "$('#".$aDados[6]."').val('');";
            echo "$('#".$aDados[7]."').val('0');";
        }
        
      
    }
    
    public function antesExcluir($sParametros = null) {
        parent::antesExcluir($sParametros);
        
        $oProduto = Fabrica::FabricarController('STEEL_PCP_OrdensFab');
        $oProduto->Persistencia->adicionaFiltro('seqmat',$this->Model->getSeqmat());
        $iContVinculo = $oProduto->Persistencia->getCount();
        
        if($iContVinculo==0){
            
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
            
        }else{
            
            $oModal = new Modal('Atenção', 'Esse produto não pode ser excluído, pois está vinculado a uma Ordem de Produção!', Modal::TIPO_ERRO);
            echo $oModal->getRender();
            exit();
        }
       }
    
       
    public function mostraRelItensPPAP($renderTo, $sMetodo = '') {                
        parent::mostraTelaRelatorio($renderTo, 'RelItensPPAP');                          
           
    }  
         
}
