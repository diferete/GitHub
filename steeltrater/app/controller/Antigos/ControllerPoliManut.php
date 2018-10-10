<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerPoliManut  extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('PoliManut');
    }
    
    /**
     * Mensagem para liberar início da manutenção
     */
    public function msgLibManut($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $oMensagem = new Modal('Apontar início da manutenção','Deseja apontar o início da manutenção da ordem nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
       $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","liberaManut","'.$sDados.'");');
       
       echo $oMensagem->getRender();
    }
    public function liberaManut($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $aRetorno = array();
       $aRetorno =$this->Persistencia->apontaInicio($aCamposChave);
       
       $oMensagem = new Modal('Atenção','A ordem nº'.$aCamposChave['nr'].' foi iniciada a manutenção com sucesso', Modal::TIPO_SUCESSO,false,true,true);
       echo $oMensagem->getRender();
       echo"$('#".$aDados[1]."-pesq').click();";
    }
    
    /**
     * Mensagem para liberar início da manutenção
     */
    public function msgRetAberta($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $oMensagem = new Modal('Retornar para situação em aberta','Deseja retornar para aberta a ordem nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
       $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","retornaAberta","'.$sDados.'");');
       
       echo $oMensagem->getRender();
    }
    public function retornaAberta($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $aRetorno = array();
       $aRetorno =$this->Persistencia->apontaAberta($aCamposChave);
       
       $oMensagem = new Modal('Atenção','A ordem nº'.$aCamposChave['nr'].' foi retornada para aberta', Modal::TIPO_SUCESSO,false,true,true);
       echo $oMensagem->getRender();
       echo"$('#".$aDados[1]."-pesq').click();";
    }
    public function msgCancela($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $oMensagem = new Modal('Cancelamento','Deseja cancelar a ordem nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
       $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","cancela","'.$sDados.'");');
       
       echo $oMensagem->getRender();
    }
    public function cancela($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $aRetorno = array();
       $aRetorno =$this->Persistencia->cancela($aCamposChave);
       
       $oMensagem = new Modal('Atenção','A ordem nº'.$aCamposChave['nr'].' foi cancelada', Modal::TIPO_SUCESSO,false,true,true);
       echo $oMensagem->getRender();
       echo"$('#".$aDados[1]."-pesq').click();";
    }
    
    public function msgEnc($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $oMensagem = new Modal('Encerramento','Deseja encerrar a ordem nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
       $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","enc","'.$sDados.'");');
       
       echo $oMensagem->getRender();
    }
    public function enc($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $aRetorno = array();
       $aRetorno =$this->Persistencia->enc($aCamposChave);
       
       $oMensagem = new Modal('Encerramento','A ordem nº'.$aCamposChave['nr'].' foi encerrada!!!', Modal::TIPO_SUCESSO,false,true,true);
       echo $oMensagem->getRender();
       echo"$('#".$aDados[1]."-pesq').click();";
    }
    
    /**
     * Método para verificar se pode alterar um registro
     */
    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);
        
        $this->carregaModelString($sParametros[0]);
        $this->Model = $this->Persistencia->consultar();
        
        if($this->Model->getSituaca()=='Encerrada'){
         $aOrdem = explode('=',$sParametros[0]);
         $oMensagem = new Modal('Ordem já está encerrada','Ordem nº'.$aOrdem[1].' já está encerrada, não é permitido fazer alterações!', Modal::TIPO_ERRO,false,true,true);
         $this->setBDesativaBotaoPadrao(true);
         echo $oMensagem->getRender();
         //exit();
           
        }
        
        
    }
    
    public function relOs($renderTo, $sMetodo = ''){
       parent::mostraTelaRelatorio($renderTo, 'relOsPoli'); 
    }
}