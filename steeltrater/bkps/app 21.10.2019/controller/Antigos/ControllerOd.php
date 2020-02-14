<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerOd extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('Od');
        $this->setControllerDetalhe('OdItem');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
    /**
    * adiciona filtros extras
    */
   public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       
       $this->Persistencia->adicionaFiltro('empcnpj',$this->Model->getEmpcnpj()); 
       $this->Persistencia->adicionaFiltro('odnr',$this->Model->getOdnr());                   
       
   }
   
   /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getEmpcnpj();
       $aRetorno[1]=  $this->Model->getOdnr();
       
       return $aRetorno;
   }
   /**
    * Libera faturamento
    */
   function liberaFat($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
        
        $oMensagem = new Modal('Liberar Faturamento', 'Deseja liberar para faturamento a ordem nº'.$aCamposChave['odnr'].'?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","geraFat","'.$sDados.'");');
        
        echo $oMensagem->getRender();
   }
   /**
    * Gera o faturamento
    */
   public function geraFat($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
       //muda a situação da ordem de serviço
        $aRetorno = $this->Persistencia->libFat($aCamposChave);
        
        if($aRetorno[0]){
            echo"$('#".$aDados[1]."-pesq').click();";
            $oMensagem = new Modal('Atenção!', 'A ordem nº'.$aCamposChave['odnr'].' foi liberado com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
            echo $oMensagem->getRender();  
        }else
        {
          $oMensagem = new Modal('Atenção!', 'A ordem nº'.$aCamposChave['odnr'].' já está liberada para faturamento!', Modal::TIPO_AVISO, false, true, true);
          echo $oMensagem->getRender();  
        }
        
        //insere o cabeçalho da nota fiscal
        if($aRetorno[0]){
            $this->Persistencia->geraCabFat($aCamposChave);
        }
        
        
   }
   
   /**
    * Método para vizualizar tela de relatório
    */
   
   public function mostraOrdem($renderTo, $sMetodo = ''){
       parent::mostraTelaRelatorio($renderTo, 'mostraOrdem');
   }
   
   /**
    * Método para fechar ordem de serviço
    */
   /**
    * Libera faturamento
    */
   function fechaOdmsg($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
        
        $oMensagem = new Modal('Fechar Ordem', 'Deseja encerrar a ordem nº'.$aCamposChave['odnr'].' sem faturamento?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","fecharOd","'.$sDados.'");');
        
        echo $oMensagem->getRender();
   }
   public function fecharOd($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
       //muda a situação da ordem de serviço
        $aRetorno = $this->Persistencia->fechaOd($aCamposChave);
        echo"$('#".$aDados[1]."-pesq').click();";
        
       
   }
   
   function retAbertaMsg($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
        
        $oMensagem = new Modal('Retorna Situação', 'Deseja retornar a ordem nº'.$aCamposChave['odnr'].' para aberta?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","retAberta","'.$sDados.'");');
        
        echo $oMensagem->getRender();
   }
   public function retAberta($sDados){
        $aDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        $sClasse = $this->getNomeClasse();  
       //muda a situação da ordem de serviço
        $aRetorno = $this->Persistencia->retOd($aCamposChave);
        echo"$('#".$aDados[1]."-pesq').click();";
        
       
   }
}