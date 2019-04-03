<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerGerenContPagar extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('GerenContPagar');
    }
    /**
     * Muda a situação do pagamento
     */
    
    public function afterCommitUpdate() {
        parent::afterUpdate();
        $this->Persistencia->mudasitTitulo();
    }
    
    public function retornoPag($sDados1){
      $aDados = explode(',', $sDados1);  
      $sChave =htmlspecialchars_decode($aDados[2]);
      $aCamposChave = array();
      parse_str($sChave,$aCamposChave);
      
      
      $this->Persistencia->retornaSitTitulo($aCamposChave);
      
      echo"$('#".$aDados[1]."-pesq').click();";
      
      $oMensagem = new Modal('Sucesso', 'Pagamento retornado!', Modal::TIPO_SUCESSO, false, true, true);
        //$oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","acaoExcluirRegistro","'.$sDados.'");');
        //$oMensagem->setSBtnCancelarFunction('alert("Cancelouuu")');
        echo $oMensagem->getRender();
      
    }
    
    
}