<?php
/* 
 * Classe que implementa o controller da classe User
 * @author Avanei Martendal
 * @since 25/12/2015
 */
class ControllerUser extends Controller{
    function __construct() {
        $this->carregaClassesMvc('User');
    }
    
  /**
     * Antes de inserir/atualizar no banco carrega as informações do model a partir 
     * do nome do arquivo temporário
     * 
     * @return array
     */
    public function beforeInsert() {
        $aRetorno = array();
        
         //se senha marcada como gravar cria um cookie
        //se tiver marcado para gravar mas sem senha para
        if($this->Model->getUsusalvasenha() == true){
            if($this->Model->getUsusenha()==''){
               $oModel = new Modal('Atenção','Para salvar a senha para acesso '
                       . 'posterior é necessário informar o campo senha.', Modal::TIPO_ERRO,false,true,true); 
               echo $oModel->getRender();
                $aRetorno[0]=false;
                $aRetorno[1]='';
                return $aRetorno;
            }else{
                if($this->Model->getUsusalvasenha() == true){
                   setcookie('pass', ''.$this->Model->getUsusenha().'');
               }else{
                   setcookie('pass');
               }
         }
        }else{
                   setcookie('pass');
               }
        
        //criptografia da senha
        $this->Model->setUsusenha(sha1($this->Model->getUsusenha()));
       
            
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }  
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $aRetorno = array();
        
         //se senha marcada como gravar cria um cookie
        //se tiver marcado para gravar mas sem senha para
        if($this->Model->getUsusalvasenha() == true){
            if($this->Model->getUsusenha()==''){
               $oModel = new Modal('Atenção','Para salvar a senha para acesso '
                       . 'posterior é necessário informar o campo senha.', Modal::TIPO_ERRO,false,true,true); 
               echo $oModel->getRender();
                $aRetorno[0]=false;
                $aRetorno[1]='';
                return $aRetorno;
            }else{
                if($this->Model->getUsusalvasenha() == true){
                   setcookie('pass', ''.$this->Model->getUsusenha().'');
               }else{
                   setcookie('pass');
               }
         }
        }else{
                   setcookie('pass');
               }
        
        $usuSenha = $this->Model->getUsusenha();
        if(!empty($usuSenha)){
             //criptografia da senha
             $this->Model->setUsusenha(sha1($usuSenha));
        }else{
            $oCampoSenha = $this->Persistencia->getCampoByNameBanco('ususenha');
            $oCampoSenha->setPersiste(false);
        }
       
           
        $UsuBloqueado = $this->Model->getUsubloqueado();                
        if($UsuBloqueado == 'TRUE' || $UsuBloqueado == 'true'){
            $this->Model->setUsubloqueado('TRUE');
        }else{
            $this->Model->setUsubloqueado('FALSE');
        }
        
       
        
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }
    
    public function afterCommitUpdate() {
        parent::afterCommitUpdate();
        $sImagem = $this->Model->getUsuimagem();
        $sCodMode = $this->Model->getUsucodigo();
        
        if($_SESSION['codUser']==$sCodMode){
        
        echo "$('#img-perfil1').attr('src','Uploads/".$sImagem."');";
        echo "$('#on-line').attr('src','Uploads/".$sImagem."');";
        //$(this).attr('src', caminho+index+'.jpg');
        }
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    
    /**
     * Método para atualizar dados do usuário através da interface mobile
     */
    public function mobileAtualizarDadosUsuario($Dados){
        if(empty($Dados->usucodigo)){
           $aRetorno['SUCESSO'] = FALSE;
           $aRetorno['ERRO'] = 'Código do Usuário em branco';
        }else{
            $aRetorno = $this->Persistencia->mobileAtualizarDadosUsuario($Dados);
        }
        
        return $aRetorno;
    }
	
    /**
     * Método para atualizar senha do usuário através da interface mobile
     */
    public function mobileAtualizarSenhaUsuario($Dados){
        if(!empty($Dados->usucodigo)|| !empty($Dados->senhaNova1) || !empty($Dados->senhaNova2)){
            if($Dados->senhaNova1 == $Dados->senhaNova2){
                $this->Persistencia->atualizarSenhaUsuario($Dados->usucodigo, $Dados->senhaNova2);
            }else{
                $aRetorno['SUCESSO'] = FALSE;
                $aRetorno['ERRO'] = 'As senhas não são iguais.';
            }
        }else{
           $aRetorno['SUCESSO'] = FALSE;
           $aRetorno['ERRO'] = 'Código do Usuário em branco';
        }
        
        return $aRetorno;
    }
    
   public function recuperaSenha($dados){
       $login = $dados->login;;
//       $login = 'carlos@metalbo.com.br';
       if(!empty($login)){
           $dadosUsuario = $this->Persistencia->buscaEmail($login);
           if($dadosUsuario['EXISTENTE']){
               if(!empty($dadosUsuario['USUEMAIL'])){
                   
                    $gerouCodigo = $this->geraCodigoRedefinicaoSenha($dadosUsuario['USUCODIGO'], $dadosUsuario['USUEMAIL']);
                    
                    if($gerouCodigo['SUCESSO']){
                        $emailEnviado = $this->enviaEmailComCodigo($dadosUsuario['USUEMAIL'], $gerouCodigo['CODIGO']);
                         
                        if($emailEnviado[0]){
                            $aRetorno = array("SUCESSO" => TRUE, "MSG" => "Foi enviado um código para seu email. Por favor verifique seu email e insira o código para prosseguir.");
                        }else{
                            $aRetorno = array("SUCESSO" => FALSE, "MSG" => "Falha ao enviar códido por email.", "ERRO" => $emailEnviado[1] );
                        }
                        
                    }else{
                        $aRetorno = array("SUCESSO" => FALSE, "MSG" => "Falha ao inserir código de redefinição.");
                    }
                    
               }else{
                   $aRetorno = array("SUCESSO" => FALSE, "MSG" => "Sem email cadastrado! Por favor entre em contato com o setor de Tecnologida da Informação.");
               }
           }else{
                $aRetorno = array("SUCESSO" => FALSE, "MSG" => "O email informado não foi localizado no banco de dados!");
           }
       }else{
           $aRetorno = array("SUCESSO" => FALSE, "MSG" => "O email informado está em branco!");
       }
       
       return $aRetorno;
   }
   
   
    public function geraCodigoRedefinicaoSenha($codigoUsuario, $emailUsuario){
        $codigoRedefinicao = Base::geraTokenNumerico(6);
        
        date_default_timezone_set('America/Sao_Paulo');
        $dataHora = date("d/m/Y H:i:s");
        
        $bInserido = $this->Persistencia->inserirCodigoRedefinicaoSenha($codigoUsuario, $emailUsuario, $codigoRedefinicao, $dataHora);
       if($bInserido){
           return array('SUCESSO' => TRUE, 'CODIGO' => $codigoRedefinicao);
       }else{
           return array('FALSE' => FALSE);
       }
    }  
   
   
    public function enviaEmailComCodigo($email, $codigoRedefinicao){
//       $codigo = $aDados['CODIGO']; //Codigo tipo código
     

        $sMsg = "Foi solicitado um código de redefinição de senha: ". $codigoRedefinicao;

        $oEmail = new Email();
        $oEmail->setMailer();
        /*testes*/
        $oEmail->setEnvioSMTP();
        $oEmail->setServidor(Config::SERVER_SMTP);
        $oEmail->setPorta(Config::PORT_SMTP);
        $oEmail->setAutentica(true);
        $oEmail->setUsuario(Config::EMAIL_SENDER);
        $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
        $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER),utf8_decode('Não responda | Metalbo '));

        $oEmail->setAssunto(utf8_decode('Solicitação de redefinição de senha'));
        $oEmail->setMensagem(utf8_decode($sMsg));
        $oEmail->limpaDestinatariosAll();
        $oEmail->addDestinatario($email);

        $aRetorno = $oEmail->sendEmail();

        return $aRetorno;
    }
    
    
    public function verficaCodigoRedefinicaoSenha($Dados){
        $loginUsuario = $Dados->login;
        $codigoRedefinicao = $Dados->codigo;
        
        date_default_timezone_set('America/Sao_Paulo');
        $dataHora = date("d/m/Y H:i:s");
        
        if(!empty($loginUsuario) && !empty($codigoRedefinicao)){
            
            $codigoValido = $this->Persistencia->verificaCodigoRedefinicaoSenha($loginUsuario, $codigoRedefinicao, $dataHora);
            
            if($codigoValido['VALIDADE']){
                $aRetorno = array('VALIDO' => TRUE, 'ID' => $codigoValido['ID'], 'USUCODIGO' => $codigoValido['USUCODIGO'], 'MSG'=> "Agora você deverá informar uma nova senha. Em seguida você será redirecionado a tela de login.");
            }else{
                $aRetorno = array('VALIDO' => FALSE, 'MSG' => 'Este não é código de redefinição válido para seu login. Por favor, tente novamente.');
            }  
            
        }else{
            $aRetorno = array('VALIDO' => FALSE, 'MSG' => 'Dados em branco.');
        }
        
        
        return $aRetorno;
    }
    
    /**
     * Método que permite alteração de senha para usuário, utilizando código do usuário juntamente com id da recuperação de senha
     * Obs: Utiliza id da tabela de recuperação de senha, e não o token numérico.
     */
    public function alteraSenhaUsuarioIdRecuperacaoSenha($Dados){
        $codigoUsuario = $Dados->usucodigo;
        $senhaUsuario = $Dados->senha;
        $idRecuperacao = $Dados->id;
  

        
        
        date_default_timezone_set('America/Sao_Paulo');
        $dataHora = date("d/m/Y H:i:s");
        
        if(!empty($codigoUsuario) || !empty($senhaUsuario) || !empty($idRecuperacao)){
            $validade = $this->Persistencia->verificaIdRecuperacaoSenha($idRecuperacao, $codigoUsuario, $dataHora);
           
            if($validade){
                $senhaAlterada = $this->Persistencia->atualizarSenhaUsuario($codigoUsuario, $senhaUsuario);
                
                if($senhaAlterada['SUCESSO']){
                    $this->Persistencia->alteraStatusIdRecuperacao($idRecuperacao, 'UTILIZADO');
                    $aRetorno = array('SUCESSO' => TRUE, 'MSG' => 'Sua senha foi alterada com sucesso! Você poderá fazer login com ela.');
                }else{
                    $aRetorno = array('SUCESSO' => FALSE, 'MSG' => 'Ocorreu algum problema na alteração de sua senha.');
                }
            }else{
                $aRetorno = array('SUCESSO' => FALSE, 'MSG' => 'Validade desta redefinição de senha já foi expirada');
            }
        }else{
            $aRetorno = array('SUCESSO' => FALSE);
        }
        

        return $aRetorno;
    }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        
       
        
    }
    
    /**
     * faz redefinição da senha no login qdo usuário está marcado para troca de senha
     */
    
    public function redefinePasswdLogin(){
       $aCamposChave = array();
       $sChave = htmlspecialchars_decode($_REQUEST['campos']);
       parse_str($sChave,$aCamposChave);
       
       $iCodUser = $_SESSION['codUser'];
       $sPasswd = $aCamposChave['Nova_senha'];
       
       $sPasswd = sha1($sPasswd);
       
       $aRetorno = $this->Persistencia->redefineSenha($iCodUser,$sPasswd);
       
       if($aRetorno[0]){
       echo "$('#exampleFormModal').modal('toggle');$('#resultado').empty();";
       $oModal = new Modal('Senha redefinida com sucesso','No próximo acesso use sua nova senha!', Modal::TIPO_SUCESSO,false,true,true); 
       $oModal->setSBtnConfirmarFunction('window.location = "index.php?classe=Sistema&metodo=getTelaInicial";');
       echo $oModal->getRender();
       
       
       
       }
       
      
       
       
    }
}


