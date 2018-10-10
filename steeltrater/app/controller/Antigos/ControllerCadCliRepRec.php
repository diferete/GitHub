<?php

/*
 * Classe que implementa a controller CadCliRep
 * @author Avanei Martendal
 * @since 18/09/2017
 */

class ControllerCadCliRepRec extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('CadCliRepRec');
    }
    
    /**
     * Mensagem para gerar cadastro 
     */
    public function msgCadastro($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        
        $this->Persistencia->adicionafiltro('nr',$aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();
        
        if($oRow->getSituaca()!=='Liberado'){
            $oMensagem = new Modal('Atenção', 'O cadastro nº' . $aCamposChave['nr'] . ' não está liberado para cadastro!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }else{
            //verifica se há um cnpj já cadastrado no sistema
            $aRetono = $this->Persistencia->buscaVerificaCnpj($oRow->getEmpcod());//$oRow->getEmpcod()
            if($aRetono[0]){
              $oMensagem = new Modal('Gerar cadastro', 'Deseja gerar cadastro nº' . $aCamposChave['nr'] . '?', Modal::TIPO_AVISO, true, true, true);
              $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","geraCadastro","' . $sDados . '");');
              echo $oMensagem->getRender();  
            }else{
              $oMensagem = new Modal('Atenção', $aRetono[1], Modal::TIPO_ERRO, false, true, true);
              echo $oMensagem->getRender();   
            }
            
            
            
            
            
        }
    }
    
    public function geraCadastro($sDados){
       $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse(); 
        
      
        
        $this->Persistencia->adicionafiltro('nr',$aCamposChave['nr']);
        $oRow = $this->Persistencia->consultarWhere();
        
        $aRetorno = $this->Persistencia->geraCadastro($oRow);
        
        if($aRetorno[0]){
            //insere email de nfe
            $aRetorno = $this->Persistencia->insereEmailNfe($oRow);
            //insere endereços
            
            $aRetorno = $this->Persistencia->insereEnderecos($oRow);
            if($aRetorno[0]){
                $this->Persistencia->sitCadastrado($oRow);
                $oMensagem = new Modal('Sucesso!', 'Cadastro realizado com sucesso!', Modal::TIPO_SUCESSO, false, true);
            echo $oMensagem->getRender();
             echo"$('#" . $aDados[1] . "-pesq').click();";
            }else{
              $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!', Modal::TIPO_ERRO, false, true);
              echo $oMensagem->getRender();  
            }
            
        }else{
            $oMensagem = new Modal('Erro ao inserir cadastro', 'Relate o problema para o setor de Tecnologia da Informação!', Modal::TIPO_ERRO, false, true);
            echo $oMensagem->getRender();
        }
        
        
    }







    /**
     * Método para liberar cadastro para a Metalbo
     */
/*    public function msgLiberaCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $oMensagem = new Modal('Liberação de cadastro', 'Deseja liberar o cadastro nº' . $aCamposChave['nr'] . ' para a Metalbo?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","liberaCadastro","' . $sDados . '");');
        echo $oMensagem->getRender();
    }*/

 /*   public function liberaCadastro($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();

        $aRetorno = $this->Persistencia->liberaMetalbo($aCamposChave);

        if ($aRetorno[0]) {
            $oMensagem2 = new Mensagem('Sucesso!', 'Seu cadastro foi liberado com sucesso...', Mensagem::TIPO_SUCESSO);
            echo"$('#" . $aDados[1] . "-pesq').click();";
            $this->enviaEmailMetalbo($aCamposChave['nr']);
        } else {
            $oMensagem2 = new Mensagem('Atenção!', $aRetorno[1], Mensagem::TIPO_ERROR);
        }
        echo $oMensagem2->getRender();
    }*/

   
  /*  public function enviaEmailMetalbo($sNr) {
        $oEmail = new Email();
        $oEmail->setMailer();

        $oEmail->setEnvioSMTP();
        //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
        $oEmail->setServidor('smtp.terra.com.br');
        $oEmail->setPorta(587);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario('metalboweb@metalbo.com.br');
        $oEmail->setSenha('filialwe');
        $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

        $this->Persistencia->adicionafiltro('nr', $sNr);
        $oRow = $this->Persistencia->consultarWhere();

        $oEmail->setAssunto(utf8_decode('Cadastro de Cliente Nº' . $oRow->getNr() . ''));
        $oEmail->setMensagem(utf8_decode('CLIENTE Nº ' . $oRow->getNr() . ' FOI LIBERADO PELO REPRESENTANTE ' . $oRow->getUsucodigo() . '<hr><br/>'
                        . '<b>Representante:  ' . $_SESSION['nome'] . '<br/>'
                        . '<b>Escritório:  ' . $oRow->getOfficedes() . '<br/>'
                        . '<b>Hora:  ' . $oRow->getHoralib() . '<br/>'
                        . '<b>Data do Cadastro:  ' . $oRow->getEmpdtcad() . '<br/><br/><br/>'
                        . '<table border=1 cellspacing=0 cellpadding=2 width="100%"> '
                        . '<tr><td><b>Cnpj:</b></td><td>' . $oRow->getEmpcod() . '</td></tr>'
                        . '<tr><td><b>Razão Social:</b></td><td>' . $oRow->getEmpdes() . '</td></tr>'
                        . '<tr><td><b>Nome Fantasia:</b></td><td>' . $oRow->getEmpfant() . '</td></tr>'
                        . '<tr><td><b>Observação:</b></td><td>' . $oRow->getEmpobs() . '</td></tr> '
                        . '</table><br/><br/> '
                        . '<a href="sistema.metalbo.com.br">Clique aqui para acessar o cadastro!</a>'
                        . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

        $oEmail->limpaDestinatariosAll();

        // Para
        $aEmails = array();
        $aEmails[] = $_SESSION['email'];
        foreach ($aEmails as $sEmail) {
            $oEmail->addDestinatario($sEmail);
        }

        //enviar e-mail vendas
        $aUserPlano = $this->Persistencia->buscaEmailVenda($sNr);

        foreach ($aUserPlano as $sCopia) {
            $oEmail->addDestinatarioCopia($sCopia);
        }
        //provisório para ir cópia para avanei
        $oEmail->addDestinatario('avanei@rexmaquinas.com.br');


        $aRetorno = $oEmail->sendEmail();
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
        } else {
            $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }*/
 /* Mensagem para gerar cadastro 
     */
    public function msgRet($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        
            
        $oMensagem = new Modal('Retornar para o representante', 'Deseja retornar o cadastro para o representante?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","RetRep","' . $sDados . '");');
         echo $oMensagem->getRender();  
            
    }
    
    /**
     * retorna para o representante
     */
    public function RetRep($sDados){
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);
        $sClasse = $this->getNomeClasse();
        
         $aRetorno = $this->Persistencia->retRep($aCamposChave);   
         
         if($aRetorno[0]==true){
             $oMensagem = new Modal('Retornado com sucesso', '', Modal::TIPO_SUCESSO, false, true, true);
             echo $oMensagem->getRender();
             echo"$('#" . $aDados[1] . "-pesq').click();";
         }else{
             $oMensagem = new Modal('Não foi possível retornar o cadastro', '', Modal::TIPO_ERRO, false, true, true);
             echo $oMensagem->getRender();
         }
         
         
      /*  $oMensagem = new Modal('Retornar para o representante', 'Deseja retornar o cadastro para o representante?', Modal::TIPO_AVISO, true, true, true);
        $oMensagem->setSBtnConfirmarFunction('requestAjax("","' . $sClasse . '","geraCadastro","' . $sDados . '");');
         echo $oMensagem->getRender();  */
            
    }
}
