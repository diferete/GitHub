<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_PCP_nfOd extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_nfOd');
    }
    
    public function consultaOd($sDados){
         $sId = $sDados;
         $sDados = $_REQUEST['campos'];
         $sCampos = htmlspecialchars_decode($sDados);
         $aCamposChave = array();
         parse_str($sCampos, $aCamposChave);
         
         if($aCamposChave['od']!==''){
         
         $sEmp = $this->Persistencia->buscaOd($aCamposChave['od']);
         
         if($sEmp){
            echo "$('#".$sId."').val('".$sEmp."');";
         }else{
             $oMensagem = new Mensagem('Atenção!','Ordem de compra não encontrada', Mensagem::TIPO_WARNING);
             echo $oMensagem->getRender();
             echo "$('#".$sId."').val('');";
         }
         }else{
             echo "$('#".$sId."').val('');";
         }
    }
    
    public function consultaNf($sDados){
         $sId = $sDados;
         $sDadosTela = $_REQUEST['campos'];
         $sCampos = htmlspecialchars_decode($sDadosTela);
         $aCamposChave = array();
         parse_str($sCampos, $aCamposChave);
         
         //verifica se foi informado nota fiscal
         if($aCamposChave['nf']!==''){
             $sNf = $aCamposChave['nf'];
             $sNota = $this->Persistencia->consultaNf($sNf);
             if($sNota){
                 echo "$('#".$sId."').val('".$sNota."');";
             }else{
                $oMensagem = new Mensagem('Atenção!','Nota Fiscal não encontrada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                echo "$('#".$sId."').val('');";  
             }
         }else{
             echo "$('#".$sId."').val('');";
         }
         
         
    }
    
    public function gravaOd($sDados){
         $aId = explode(',', $sDados);
         $sDadosTela = $_REQUEST['campos'];
         $sCampos = htmlspecialchars_decode($sDadosTela);
         $aCamposChave = array();
         parse_str($sCampos, $aCamposChave);
         
         //verifica se é od para steel
          $sEmp = $this->Persistencia->buscaOd($aCamposChave['od']);
          if($sEmp==null){
            $oMensagem = new Mensagem('Atenção!','Ordem de compra não encontrada', Mensagem::TIPO_WARNING);
            echo $oMensagem->getRender();
            exit();
          }
         
         //verifica se a nota é para a steel
         $sNota = $this->Persistencia->consultaNf($aCamposChave['nf']);
         
           if($sNota==null){
                $oMensagem = new Mensagem('Atenção!','Nota Fiscal não encontrada!', Mensagem::TIPO_WARNING);
                echo $oMensagem->getRender();
                exit();
             }
         //se passar gera a gravacao
         $aRetorno = $this->Persistencia->gravaXped($aCamposChave);
         
         if($aRetorno[0]){
             $oModal = new Modal('Sucesso!', 'Ordem de compra viculada com sucesso!', Modal::TIPO_SUCESSO,false,true);
             echo $oModal->getRender();
         }else{
             $oModal = new Modal('Atenção!', 'Houve algum problema!', Modal::TIPO_AVISO,false,true);
             echo $oModal->getRender();
         }
         
    }
}