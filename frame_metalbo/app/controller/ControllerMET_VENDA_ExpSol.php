<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerMET_VENDA_ExpSol extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('MET_VENDA_ExpSol');
        $this->setControllerDetalhe('MET_VENDA_ExpItemSol');
        $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
  /**
   * Método para carregar o representante
   */  
    
  public function carregaRep($sDados){
      $aDados = explode(',', $sDados);
      if($aDados[2]<>''){
       $aRetorno =$this->Persistencia->buscaRep($aDados[2]);
       echo"$('#".$aDados[0]."').val('".$aRetorno[0]."');"
           ."$('#".$aDados[1]."').val('".$aRetorno[1]."');";
      }
      
        
  }
  
   public function adicionaFiltrosExtras() {
       parent::adicionaFiltrosExtras();
       
       $this->Persistencia->adicionaFiltro('nr',$this->Model->getNr());                   
      // $this->Persistencia->adicionaFiltro('',  $this->Model->getMencodigo());
   }
   
    /**
    * monta os campos para a próxima etapa
    */
   function montaProxEtapa() {
       parent::montaProxEtapa();
       $aRetorno[0]=  $this->Model->getCnpj();
       $aRetorno[1]= $this->Model->getCliente();
       $aRetorno[2]= $this->Model->getNr();
       return $aRetorno;
   }
   
   public function antesAlterar($sParametros = null) {
       parent::antesDeCriarTela($sParametros);
       
       $this->carregaModelString($sParametros[0]);
       $this->Model = $this->Persistencia->consultar();
       
        if($this->Model->getEmail()=='EV'){
         $aOrdem = explode('=',$sParametros[0]);
         $oMensagem = new Modal('Solicitação já encerrada!','A solicitação nº'.$aOrdem[1].' já foi liberada, não é permitido fazer alterações!', Modal::TIPO_ERRO,false,true,true);
         $this->setBDesativaBotaoPadrao(true);
         echo $oMensagem->getRender();
         //exit();
           
        }
        
   }
    
  /**
   * Libera solicitação para a metalbo
   */
   
  public function msgLiberaMetalbo($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       $this->carregaModelString($aDados[2]);
       $this->Model = $this->Persistencia->consultar();
       if($this->Model->getEmail()=='EV'){
         $oMensagem = new Modal('Solicitação já liberada','A solicitação nº'.$aCamposChave['nr'].' já está liberada!', Modal::TIPO_ERRO,false,true,true);
         echo $oMensagem->getRender();  
       }else{
           //verifica se nao existe bloqueio no financeiro
            $aNr = explode('=', $aDados[2]);
            $sEmpcod = $this->Persistencia->retCli($aNr[1]);
            $sBloq = $this->Persistencia->retBloq($sEmpcod);
             if($sBloq=='B'){
          $oMensagem = new Modal('Cópia de solicitação','O Cliente da solicitação nº'.$aCamposChave['nr'].' está com financeiro bloqueado', Modal::TIPO_AVISO,false,true,true);
          echo $oMensagem->getRender();
           }else{
            $oMensagem = new Modal('Liberar solicitação','Deseja liberar a solicitação nº'.$aCamposChave['nr'].' para a metalbo?', Modal::TIPO_AVISO,true,true,true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","liberaMetalbo","'.$sDados.'");');
       
            echo $oMensagem->getRender();
           }
       }
  }
  
  public function liberaMetalbo($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       $aRetorno = array();
       $aRetorno =$this->Persistencia->libMetalbo($aCamposChave);
       
       $oMensagem = new Modal('Atenção','A solicitação nº'.$aCamposChave['nr'].' foi liberada com sucesso', Modal::TIPO_SUCESSO,false,true,true);
       echo $oMensagem->getRender();
       echo"$('#".$aDados[1]."-pesq').click();";
  }
  
  public function msgCopiaSol($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       //verifica se nao existe bloqueio no financeiro
       $aNr = explode('=', $aDados[2]);
       $sEmpcod = $this->Persistencia->retCli($aNr[1]);
       $sBloq = $this->Persistencia->retBloq($sEmpcod);
       if($sBloq=='B'){
          $oMensagem = new Modal('Cópia de solicitação','O Cliente da solicitação nº'.$aCamposChave['nr'].' está com financeiro bloqueado', Modal::TIPO_AVISO,false,true,true);
         // $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","copiaSol","'.$sDados.'");'); 
       }else{
       
       $oMensagem = new Modal('Cópia de solicitação','Deseja gerar uma cópia da solicitação nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
       $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","copiaSol","'.$sDados.'");');
       }
       
       echo $oMensagem->getRender();
       
       
  }
  
  public function copiaSol($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       
      $aRetorno = $this->Persistencia->copiaSol($sChave);
      if($aRetorno[0]==true){
          $oMensagem = new Modal('Atenção','A solicitação nº'.$aRetorno[1].' copiada com sucesso', Modal::TIPO_SUCESSO,false,true,true);
          echo $oMensagem->getRender();
          echo"$('#".$aDados[1]."-pesq').click();"; 
      }else
      {
          $oMensagem = new Modal('Atenção','A solicitação nº'.$aCamposChave['nr'].' não foi copiado', Modal::TIPO_ERRO,false,true,true);
          echo $oMensagem->getRender();  
      }
       
  }
  
  public function envMailSol($sDados,$sRel){
      $aDados = explode(',',$sDados);
      $aNr = explode('=', $aDados[2]);
      
    
     // sleep(5);
      
      $oEmail = new Email();
      $oEmail->setMailer();
      /*testes*/
      $oEmail->setEnvioSMTP();
      $oEmail->setServidor(Config::SERVER_SMTP);
      $oEmail->setPorta(Config::PORT_SMTP);
      $oEmail->setAutentica(true);
      $oEmail->setUsuario(Config::EMAIL_SENDER);
      $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
      $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER),utf8_decode('Relatórios Web Metalbo'));
      
      $oEmail->setAssunto(utf8_decode('Solicitação de venda nº'.$aNr[1]));
      $oEmail->setMensagem(utf8_decode('Anexo solicitação de venda nº'.$aNr[1]));
      $oEmail->limpaDestinatariosAll();
        
        // Para
      $aEmails = array();
      $aEmails[] = $_SESSION['email'];
      foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        // Cópia
    //  $aCopia = array();
    //  $aCopia[] = 'avaneim@gmail.com';
    //  $aCopia[] = 'avanei@rexmaquinas.com.br';
      
        foreach ($aCopia as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }
        
        $oEmail->addAnexo('app/relatorio/representantes/'.$_SESSION['diroffice'].'/solvenda'.$aNr[1].'.pdf', utf8_decode('Solicitação nº'.$aNr[1]));
        $aRetorno = $oEmail->sendEmail();
        if($aRetorno[0]){
           $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
           echo $oMensagem->getRender();
        }else{
          $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - '.$aRetorno[1], Modal::TIPO_ERRO,false,true,true);
          echo $oMensagem->getRender();  
        }
      
  }
  /**
   * Efetua validaçoes necessárias
   */
  
  public function getVal($sDados) {
      parent::getVal($sDados);
      
      
  }
  
  /**
   * Retorna dados para get de relatórios
   */
  public function getSget() {
      parent::getSget();
      
      $sTabCab = $this->Persistencia->getTabela();
      $oSolIten = Fabrica::FabricarPersistencia('MET_VENDA_ExpItemSol');
      $sTabIten = $oSolIten->getTabela();
      
      $sCampos ='&tabcab='.$sTabCab;
      $sCampos .='&itencab='.$sTabIten;
      
      //busca a imagem padrão dos relatórios
      $oRepOffice = Fabrica::FabricarPersistencia('RepOffice');
      $sImg = $oRepOffice->imgRel(null);
      $sCampos .='&imgrel='.$sImg;
      
      return $sCampos;
  }
  
  public function beforeRel($sDados) {
      parent::beforeRel($sDados);
       $sGet = '';
      //Explode string parametros
        $aDados = explode(',', $sDados);
        $aNr = explode('=', $aDados[2]);
        
        //pega o cnpj da solicitacao
        $sCnpj = $this->Persistencia->retCli($aNr[1]);
        //verifica se tem st
        $oSt = Fabrica::FabricarPersistencia('St');
        $aRetSt = $oSt->contSt($sCnpj);
        //se tem mais de um  entra para gerar o cálculo
        if($aRetSt[0]>0){
            $oCalcSt = Fabrica::FabricarController('St');
            $sVlrSt = $oCalcSt->calculaSt($aRetSt[1],$aNr[1],'MET_VENDA_ExpItemSol',$aRetSt[2]);
            $sGet = '&st='.$sVlrSt;
        }
        
        return $sGet;
        
  }
  
  public function verifBloqCred(){
      $this->carregaModel();
      $sEmpcod = $this->Model->getCnpj();
      $sBloq = $this->Persistencia->retBloq($sEmpcod);
      
      if($sBloq == 'B'){
          $sRetorno = json_encode(['retorno' => 'false']);
         // $sRetorno = json_encode(['retorno' => 'true']);
      }else{
          $sRetorno = json_encode(['retorno' => 'true']);
      }
      
        
        echo $sRetorno;
      
      
  }
 
}
