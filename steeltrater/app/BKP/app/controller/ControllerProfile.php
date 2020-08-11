<?php
/* 
 * Classe que implementa o controller da classe User
 * @author Avanei Martendal
 * @since 24/05/2016
 */

class ControllerProfile extends Controller {
    function __construct() {
        $this->carregaClassesMvc('Profile');
    }

/**
 * Adiciona o código do usuário como filtro
 */    
public function antesDeCriarConsulta($sParametros = null) {
    parent::antesDeCriarConsulta($sParametros);
    
    $sCodigo = $_SESSION['codUser'];
    $this->Persistencia->adicionaFiltro('usucodigo',$sCodigo);  
}
 /**
     * Antes de inserir/atualizar no banco carrega as informações do model a partir 
     * do nome do arquivo temporário
     * 
     * @return array
     */
    public function beforeInsert() {
        $aRetorno = array();
        
        //criptografia da senha
        $this->Model->setUsusenha(sha1($this->Model->getUsusenha()));
            
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }  
    /**
     * Antes de inserir/atualizar no banco carrega as informações do model a partir 
     * do nome do arquivo temporário
     * 
     * @return array
     */
    public function beforeUpdate() {
        $aRetorno = array();
        
        //criptografia da senha
        $this->Model->setUsusenha(sha1($this->Model->getUsusenha()));
            
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }    
    
    
    public function validaLogin($UserLogin = '', $UserSenha = ''){
        if(empty($UserLogin) && empty($UserSenha)){
            
            $Login = $_SESSION['loginUser'];
            
            $CampoSenha = $_REQUEST['parametros'];
            
            $aCampos = array();
            parse_str($_REQUEST['campos'],$aCampos);
            
            $Senha = $aCampos[$CampoSenha];
        }
        
        if($this->Persistencia->validaSenha($Login,$Senha)){   
             $sRetorno = json_encode(['retorno' => 'true']);
        }else{
            $sRetorno = json_encode(['retorno' => 'false']);
        }
        
        echo $sRetorno;
   }
   
   /**
    * Cria a tela do perfil
    */
    public function acaoMostraTelaPerfil($sDados){
      
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[0]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
        //cria a tela
        $this->View->criaTela();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[1]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[2]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
       
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
    /**
     * Gera alteração da senha atual
     */
    public function alteraSenha($sDados){
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
      
       $aRetorno = $this->Persistencia->redefineSenha($aCamposChave['usucodigo'], sha1($aCamposChave['ususenha']));
       if($aRetorno[0]){
           $oModal = new Modal('Sucesso','Sua senha foi alterada com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
           echo $oModal->getRender();
       }
    }
    
    /**
     * Alterar imagem de perfil
     */
    public function alteraImagem($sDados){
         $aDados = explode(',',$sDados);
         $sChave =htmlspecialchars_decode($_REQUEST['campos']);
         $aCamposChave = array();
         parse_str($sChave,$aCamposChave);
        
        $aAlterar = $this->Persistencia->alteraImagem($aCamposChave['usucodigo'],$aCamposChave['usuimagem']);
        $sImagem = $aCamposChave['usuimagem'];
        $sCodMode = $aCamposChave['usucodigo'];
        
        if($_SESSION['codUser']==$sCodMode){
           echo "$('#img-perfil1').attr('src','Uploads/".$sImagem."');";
           echo "$('#on-line').attr('src','Uploads/".$sImagem."');";
           }
        
        
        
        
         if($aAlterar[0]){
           $oModal = new Modal('Sucesso','Sua imagem foi alterado com sucesso!', Modal::TIPO_SUCESSO, false, true, true);
           echo $oModal->getRender();
       }
    }
}

