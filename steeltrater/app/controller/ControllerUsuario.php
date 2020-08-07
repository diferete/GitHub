<?php
/**
 * Classe que controla as operações do objeto Usuario
 * 
 * @author Fernando Salla
 * @since 04/06/2012
 */
 class ControllerUsuario extends Controller{
     function __construct(){
        $this->View = Fabrica::FabricarView('Usuario');
        $this->Model = Fabrica::FabricarModel('Usuario');
        
        $this->Persistencia = Fabrica::FabricarPersistencia('Usuario');
        $this->Persistencia->setModel($this->Model);
        
        $this->ControllerDetalhe = Fabrica::FabricarController('UsuarioEmpresa');
    }    
    
    /**
     * Realiza a operação de login validando se as informações
     * digitadas estão de acordo com o que está armazenado na 
     * base de dados
     * 
     * @return string String JSON com o conteúdo a ser renderizado
     */
    public function acaoLogin(){
        $this->carregaModel($aCamposTela);
        
        if ($this->Persistencia->validaLogin()){
            if(!$this->Model->getBloqueado()){
                $oControllerEmpresa = Fabrica::FabricarController('Empresa');
                
                $_SESSION["codUser"] = $this->Model->getCodigo();
                $_SESSION["loginUser"] = $this->Model->getLogin();
                $_SESSION["tipoUser"] = $this->Model->getTipo();
                $_SESSION["nome"] = $this->Model->getNome();
                $_SESSION['sessao'] = session_id();
                $_SESSION['data'] = date('d/m/Y');
                $_SESSION['hora'] = $this->getHoraAtual();
                //passa por parametro o codigo e traz a empresa principal, codigo alimentado pelo carregamodel()
               // $_SESSION["empresa"] = 2;//$oControllerEmpresa->getEmpresaPrincipal($this->Model->getCodigo());
                $_SESSION["empresa"] = $oControllerEmpresa->getEmpresaPrincipal($this->Model->getCodigo());

                $_SESSION["pescodigousuario"] = $oControllerEmpresa->getPessoaUsuario($this->Model->getCodigo(),$_SESSION["empresa"]);
                $_SESSION["pescodigousuarioAdm"] = $oControllerEmpresa->getPessoaUsuario($this->Model->getCodigo(),$_SESSION["empresa"]);
                $_SESSION["logoEmpresa"] = $oControllerEmpresa->getCodigoLogoEmpresa($_SESSION["empresa"]);
                $_SESSION["filial"] = null;
                $_SESSION["nomeEmpresa"] = $oControllerEmpresa->getNomeEmpresa($_SESSION["empresa"]);
                //cria um cookie para armazenar o login do usuário e carregar no próximo acesso
                setcookie("loginUser", $_SESSION['loginUser'], time()+60*60*24*100, "/");
                
                //$iFirstSistema =2;
                $iFirstSistema =$oControllerEmpresa->getFirstSistema( $oControllerEmpresa->getEmpresaPrincipal($this->Model->getCodigo()));
                if ($this->Model->getTipo()!=PersistenciaUsuario::USUARIO_ADMINISTRADOR){
                    $iFirstSistema = $oControllerEmpresa->getFirstSistema($_SESSION["empresa"]);
                }
                 
                //cria o controller do sistema e chama o método para criar a tela
                $oControllerSistema = Fabrica::FabricarController('Sistema');
                $this->adicionaJSON($oControllerSistema->getTelaSistema($iFirstSistema));
                
                //adiciona o listener que realiza o controle do tempo de inatividade da sessão
                $this->adicionaJSON('Ext.src.SessionMonitor.start();');
            } else{
                $this->adicionaJSON($this->View->mensagemErro("Usuário bloqueado!<br>Entre em contato com o administrador do sistema"));
            }
        } else {
            $this->adicionaJSON($this->View->mensagemErro("Login inválido!"));
        }
        $this->confirmaJSON();
    }
    
    /**
     * Método que encerra a sessão atual
     * 
     */
    public function acaoLogout(){
        $sid = session_id();
        $this->Persistencia->deltaSessaoDb($_SESSION['codUser'],$_SESSION['nome'],$sid);
        session_set_cookie_params(99999999); 
        session_start();
        session_unset();
        session_destroy();
        echo 'window.location = "index.php";';
       
    }  
    
    /**
     * Método que realiza a validação da sessão do usuário 
     * Caso a sessão esteja correta a hora é atualizada
     * 
     * @return boolean
     */
    public function validaSessao(){
        session_cache_limiter('private');
        $cache_limiter = session_cache_limiter();

        /* define o prazo do cache em 10000 minutos */
        session_cache_expire(100000);
        $cache_expire = session_cache_expire();  
        session_set_cookie_params(99999999); 
        session_start();
        $sid = session_id();
        if(isset($_SESSION['codUser'])){
            $sessao_Id =$this->Persistencia->getIdSessao($_SESSION['codUser'],$_SESSION['nome'],$sid);
        }
		
		//verifica e grava sessao
        if(isset($_SESSION['sessao'])){
            $fp = fopen("bloco1.txt", "w");
            fwrite($fp, 'Sessão:'.$_SESSION['sessao'].' sessao do banco:'.$sessao_Id);
            fclose($fp);
        }else{
            $fp = fopen("bloco1.txt", "w");
            fwrite($fp, 'Sem sessão!!!!');
            fclose($fp);
        }
        
        if(isset($_SESSION['sessao']) && $_SESSION['sessao'] === $sessao_Id){
        //vamos verificar o tempo discorrido
         date_default_timezone_set('America/Sao_Paulo');
         $dataSalva = $_SESSION["ultimoAcesso"]; 
         $agora = date("Y-n-j H:i:s"); 
         
         $tempo_transcorrido = (strtotime($agora)-strtotime($dataSalva)); 
         //tempo em segundos
          if($tempo_transcorrido >=10576000) {
              if(isset($_SESSION["ultimoAcesso"])){
              $this->msgSessaoInvalida($tempo_transcorrido);
              }
          }
            
        $_SESSION['hora'] = $this->getHoraAtual();
        $_SESSION["ultimoAcesso"]= date("Y-n-j H:i:s"); 
          return true;
        } else{
            
            return false;
        }
    }
     /**
     * Método que retorna a mensagem de erro para os casos em que a sessão
     * não for validada
     * 
     * @return string String contendo o conteúdo que será renderizado para formar
     *                a mensagem de erro
     */
    public function msgSessaoInvalida($tempo) {
        //$sMsg = "Sua sessão não é mais válida, talvez ficou muito tempo osciosa ou foi desconectada, você será direcionado para efetuar novo login!";
            $oMensagem = new Modal('Sessão Expirada!', 'Sua sessão não é mais válida, talvez ficou muito tempo osciosa ou foi desconectada, você será direcionado para efetuar novo login!'.$tempo, Modal::TIPO_ERRO, false, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","Usuario","acaoLogout","");');
            echo $oMensagem->getRender();
        }

    /**
     * Método que retorna a mensagem de erro para os casos em que a sessão
     * não for validada
     * 
     * @return string String contendo o conteúdo que será renderizado para formar
     *                a mensagem de erro
     *
	public function msgSessaoInvalida() {

        if (isset($_SESSION['sessao'])) {
            $oMensagem = new Modal('Sessão Expirada!', 'Sua sessão não é mais válida, talvez ficou muito tempo osciosa ou foi desconectada, você será direcionado para efetuar novo login!', Modal::TIPO_ERRO, false, true, true);
            $oMensagem->setSBtnConfirmarFunction('requestAjax("","Usuario","acaoLogout","");');
            echo $oMensagem->getRender();
        } else {
            $this->msgHtmlSessaoInvalida();
        }
    }

    public function msgHtmlSessaoInvalida() {

        $cssStyleBtn = 'padding: 6px 15px;'
                . 'font-size: 14px;'
                . 'line-height: 1.57142857;'
                . 'border-radius: 3px;'
                . 'cursor: pointer;'
                . 'display: block;'
                . 'color: #fff;'
                . 'background-color: #46be8a;'
                . 'border: 1px solid transparent;'
                . 'position: absolute;'
                . 'margin-top: 50px;'
                . 'left: 50%;'
                . 'transform: translateX(-50%) translateY(-50%);';

       $cssStyleDiv = 'padding: 50px 40px 100px 50px;'
                . 'position: relative;'
                . 'text-align: center!important;';

        $cssBody = 'background-image: url(https://drive.google.com/uc?export=view=&id=1Tfk4MwDDl1jPEhw2K8D2mWPDbDQqelD8");';

        $htmlReLog = '<body style="' . $cssBody . '">'
                . '<div style="' . $cssStyleDiv . '">'
                . '<h2 style="margin:10px;font-family: Roboto, sans-serif;"> Sessão Expirada!</h2>'
                . '<p style="margin:10px;font-family: Roboto, sans-serif;"> Sua sessão não é mais válida, talvez ficou muito tempo osciosa ou foi desconectada, você será direcionado para efetuar novo login!'
                . '<a href="https://sistema.metalbo.com.br/"><input style="' . $cssStyleBtn . '"  type="button" value="Clique aqui!" /></a>'
                . '</div>'
                . '</body>';

        echo $htmlReLog;
    }
	*/
    
    
    /**
     * Método que captura e retorna o horário atual para que possa ser atrubuído
     * a variável de sessão correspondente
     * 
     */
    public function getHoraAtual(){
        $h = (float)(date('H') * 3600);
        $m = (float)(date('i') * 60);
        $s = (float)(date('s') * 1);
        $horaAtual = ($h + $m + $s);
        
        return $horaAtual;
    }
    
    /**
     * Método que retorna a string contendo o botão que permite ao usuário
     * realizar algumas ações
     */
    public function getAcoesUsuario(){
        $oControllerEmpresa = Fabrica::FabricarController('Empresa');
        $aListaSistemas = $oControllerEmpresa->getListaEmpresaSistema();
        
        return $this->View->getAcoesUsuario($aListaSistemas);
    }

    /**
     * se o tipo do usuário do sistema não for administrador, não irá visualizar os administradores
     */
    public function adicionaFiltrosExtras(){
        parent::adicionaFiltrosExtras();
        if ($_SESSION["tipoUser"]==PersistenciaUsuario::USUARIO_NORMAL){
            $this->Persistencia->adicionaFiltro('usutipo',PersistenciaUsuario::USUARIO_ADMINISTRADOR,0,Persistencia::DIFERENTE);       
            $this->Persistencia->setSqlWhere('usucodigo in (select usucodigo from tbusuarioempresa where empcodigo in (select empcodigo from tbusuarioempresa where usucodigo = '.$_SESSION["codUser"].' ))');
        }
        if ($_SESSION["tipoUser"]==PersistenciaUsuario::USUARIO_ADMINISTRADOR && $_SESSION["sistema"]!=3){
            $this->Persistencia->setSqlWhere('usucodigo in (select usucodigo from tbusuarioempresa where empcodigo = '.$_SESSION["empresa"].') ');
        }
        //Vendedor poderá ver apenas seu próprio usuário
        if ($_SESSION["tipoUser"]==PersistenciaUsuario::USUARIO_VENDEDOR){
            $this->Persistencia->adicionaFiltro('usucodigo',$_SESSION["codUser"]);       
        }
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
        $this->Model->setSenha(sha1($this->Model->getSenha()));
            
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }
    
    /**
     * Antes de atualizar chama a função beforeUpdate
     * 
     * @return array
     */
    public function beforeUpdate() {
        $aRetorno = array();
        
        //verifica se veio da tela de alteração de senha
        $aCampos = json_decode($_REQUEST['campos'],true);
        
        if(isset($aCampos['novaSenha'])){
            $this->setProcessaDetalhe(false);
            $this->Model->setSenha(sha1($aCampos['novaSenha']));
        }
            
        $aRetorno[0]=true;
        $aRetorno[1]='';

        return $aRetorno;
    }
    
    /**
     * Método que abre a tela de alteração de senha do usuário
     */
    public function acaoMostraTelaManutencaoSenha($renderTo = 'Ext.getBody()', $sChave = null, $sParametrosCriaTela = ""){
        $aCodUser = explode('=',$sParametrosCriaTela);
        if($_SESSION["tipoUser"] != PersistenciaUsuario::USUARIO_ADMINISTRADOR && $_SESSION["codUser"] != $aCodUser[1]){
            $sMsg  = "Apenas o administrador do sistema pode alterar a senha de outro usuário.";
            $this->adicionaMensagem($this->View->mensagemErro($sMsg));
            $this->confirmaJSON();
        } else{
            $this->setMetodoCriaTela('criaTelaAlteraSenha');
            parent::acaoMostraTelaManutencao($renderTo,$sParametrosCriaTela);
        }
    } 
    
    /**
     * Método que realiza a validação da senha atual na rotina de alteração
     * de senha do usuário
     * 
     * @param string $sLogin login do usuário
     * @param string $sSenhaAtual senha atual informada pelo usuário
     * @param string $sIdSenhaAtual id do campo senha atual
     */
    public function validaSenhaLogin($sLogin,$sSenhaAtual,$sIdSenhaAtual){
        $this->Persistencia->Model->setLogin($sLogin);
        $this->Persistencia->Model->setSenha($sSenhaAtual);
        
        $bValidaSenha = $sLogin != "" && $sSenhaAtual != "" ? $this->Persistencia->validaSenhaLogin() : false;
        
        $sReturn = "";
        if(!$bValidaSenha){
            $sReturn = "var oSenhaAtual = Ext.ComponentQuery.query('#".$sIdSenhaAtual."')[0];"
                      ."if(oSenhaAtual){"
                         ."oSenhaAtual.setValue();"
                         ."oSenhaAtual.markInvalid('Senha informada difere da senha armazenada no sistema.');"
                      ."}";
        }
        $this->adicionaJSON($sReturn);
        $this->confirmaJSON();
    }

    public function acaoMostraTelaRelatorioUsuario($renderTo,$sParametro){
        parent::mostraTelaRelatorio($renderTo,'relatorioUsuario');
    }
    
    
}
?>