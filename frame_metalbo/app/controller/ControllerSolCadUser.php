<?php

/**
 * Classe que controla as operações do objeto SolCadUser
 * 
 * @author Avanei Martendal
 * @since 14/07/2017
 */

class ControllerSolCadUser extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('SolCadUser');
    }
    
    public function insereSolCad($sDados){
       $aCamposChave = array();
       $sChave = htmlspecialchars_decode($_REQUEST['campos']);
       parse_str($sChave,$aCamposChave);
       
       if($aCamposChave['nomeSol']=='' || $aCamposChave['sobrenomeSol']=='' || $aCamposChave['loginSol']=='' || $aCamposChave['emailSol']==''){
           $oModal = new Modal('Atenção', 'Preencha todos os campos!', Modal::TIPO_ERRO, false, true,true);
           echo $oModal->getRender(); 
       }else{
       
       $aRetorno = $this->Persistencia->insereSol();
       if($aRetorno[0]){
       
        $oModal = new Modal('Sucesso', 'Sua solicitação foi enviado com sucesso, sua solicitação será analisada e entraremos em contato pelo e-mail informado!', Modal::TIPO_SUCESSO, false, true,true);
        echo $oModal->getRender();
        echo"$('#closeSol').click();";
        
       }else{
         $oModal = new Modal('Solicitação não enviada', 'Sua solicitação não foi enviada, tente novamente mais tarde!', Modal::TIPO_ERRO, false, true,true);
        echo $oModal->getRender(); 
       }
       }
       
    }
    
   public function envMaill($aCamposChave){
      
      
      $oEmail = new Email();
      $oEmail->setMailer();
      /*testes*/
      $oEmail->setEnvioSMTP();
      //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
      $oEmail->setServidor('smtp.terra.com.br');
      $oEmail->setPorta(587);
      $oEmail->setAutentica(true);
      $oEmail->setUsuario('metalboweb@metalbo.com.br');
      $oEmail->setSenha('filialwe');
      $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'),utf8_decode('Relatórios Web Metalbo'));
      
      $oEmail->setAssunto(utf8_decode('Nova solicitação de usuário do sistema'));
       $oEmail->setMensagem(utf8_decode('Nova solicitação de usuário '.$aCamposChave['nomeSol'].'<br/>'
              . '<table border=1 cellspacing=0 cellpadding=2 width="100%"><tr><td><b>Nome:</b></td><td>'.$aCamposChave['nomeSol'].'</td></tr>'
              . '<tr><td><b>Sobrenome:</b></td><td>'.$aCamposChave['sobrenomeSol'].'</td></tr>'
              . '<tr><td><b>Login:</b></td><td>'.$aCamposChave['loginSol'].'</td></tr> '
              . '<tr><td><b>E-mail:</b></td><td>'.$aCamposChave['emailSol'].'</td></tr> ' 
               . '</table>'));
      $oEmail->limpaDestinatariosAll();
        
        // Para
      $aEmails = array();
      $aEmails[] = $_SESSION['email'];
      foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        // Cópia
      $aCopia = array();
      $aCopia[] = 'avaneim@gmail.com';
      $aCopia[] = 'avanei@rexmaquinas.com.br';
      $aCopia[] = 'jose@rexmaquinas.com.br';
      $aCopia[] = 'carlos@metalbo.com.br';
      
        foreach ($aCopia as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }
        
        
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