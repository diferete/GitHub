<?php

/* 
 *Implementa controller da classe QualRnc
 * @author Avanei Martendal
 * $since 10/09/2017
 */

class ControllerQualRnc extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('QualRnc');
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
   * msgLibMetalbo
   */
  
      //mensagem para liberar para o setor de vendas
     public function msgliberaMet($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
       
       
      $this->Persistencia->adicionaFiltro('filcgc',$aCamposChave['filcgc']);
      $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
       
      $oDados = $this->Persistencia->consultarWhere();
      $sSit = $oDados->getSituaca();
      if($sSit=='Liberado'){
         $oMensagem = new Modal('Atenção','A entrada de projeto nº'.$aCamposChave['nr'].' já está liberada!', Modal::TIPO_AVISO,false,true,true); 
      }else{
         $oMensagem = new Modal('Liberação','Deseja liberar a reclamação nº'.$aCamposChave['nr'].' para a Metalbo?', Modal::TIPO_AVISO,true,true,true);
         $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","liberaRc","'.$sDados.'");');
      }
      
     
       echo $oMensagem->getRender();
      }
      
      public function liberaRc($sDados){
       $aDados = explode(',', $sDados);
       $sChave = htmlspecialchars_decode($aDados[2]);
       $aCamposChave = array();
       parse_str($sChave,$aCamposChave);
       $sClasse= $this->getNomeClasse();
         
       $aRetorno = $this->Persistencia->liberaRc($aCamposChave);
       
       if($aRetorno[0]){
           $oMensagem = new Modal('Sucesso', 'Sua reclamação foi liberada com sucesso, você receberá um e-mail informando de sua rc!', Modal::TIPO_SUCESSO,false,true,true);
           $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","envrc","'.$sDados.'");');
           echo $oMensagem->getRender();
           echo"$('#".$aDados[1]."-pesq').click();";
       }
          $oMensagem = new Modal('Problemas', 'Verifique sua rc!', Modal::TIPO_ERRO,false,true,true);
          $oMensagem->getRender();
      }
      
      public function envrc($sDados){
         $aDados = explode(',', $sDados);
         $sChave = htmlspecialchars_decode($aDados[2]);
         $aCamposChave = array();
         parse_str($sChave,$aCamposChave);
         $sClasse= $this->getNomeClasse(); 
         
          $oEmail = new Email();
      $oEmail->setMailer();
    
      $oEmail->setEnvioSMTP();
      //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
      $oEmail->setServidor('smtp.terra.com.br');
      $oEmail->setPorta(587);
      $oEmail->setAutentica(true);
      $oEmail->setUsuario('metalboweb@metalbo.com.br');
      $oEmail->setSenha('filialwe');
      $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'),utf8_decode('Relatórios Web Metalbo'));
      
       $this->Persistencia->adicionaFiltro('filcgc',$aCamposChave['filcgc']);
      $this->Persistencia->adicionaFiltro('nr',$aCamposChave['nr']);
       
      $oDados = $this->Persistencia->consultarWhere();
      
      
      $oEmail->setAssunto(utf8_decode('Nova reclamação de cliente nº'.$oDados->getNr().''));
      $oEmail->setMensagem(utf8_decode('RECLAMAÇÃO DE CLIENTE Nº '.$oDados->getNr().' FOI LIBERADO PELO REPRESENTANTE '.$oDados->getOfficedes().'<hr><br/>'
              .'<b>Cliente:</b> '.$oDados->getEmpdes().'<br/>'
              .'<b>Produto:</b> '.$oDados->getProcod().' '.$oDados->getProdes().'<br />' 
              .'<b>Data Implantação:  '.$oDados->getData().'<br/>'
              .'<b>Nota fiscal:  '.$oDados->getNf().'<br/>'
              .'<b>Ordem compra:  '.$oDados->getOdcompra().'<br/>'
              .'<b>Pedido:  '.$oDados->getPedido().'<br/>'
              .'<b>Escritório:  '.$oDados->getOfficedes().'<br/>'
              .'<br/><br/> '
              .'<a href="sistema.metalbo.com.br">Clique aqui para acessar a entrada de projeto!</a>'
              .'<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));
      
      $oEmail->limpaDestinatariosAll();
        
        // Para
      $aEmails = array();
      $aEmails[] = $_SESSION['email'];
      foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }
     
      //enviar e-mail projetos
      $aEmail = array();
      $aEmail[] = $this->Persistencia->emailRep($aCamposChave['filcgc'],$aCamposChave['nr']);
        
         foreach ($aEmail as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }
        //provisório para ir cópia para avanei
        $oEmail->addDestinatario('avanei@rexmaquinas.com.br');
        
       // $oEmail->addAnexo('app/relatorio/qualidade/Aq'.$aDados[1].'_empresa_'.$aDados[0].'.pdf', utf8_decode('Aq nº'.$aDados[1].'_empresa_'.$aDados[0]));
        $aRetorno = $oEmail->sendEmail();
        if($aRetorno[0]){
           $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
           echo $oMensagem->getRender();
        }else{
          $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - '.$aRetorno[1], Modal::TIPO_ERRO,false,true,true);
          echo $oMensagem->getRender();  
        }
        
      }
      
     
    
}