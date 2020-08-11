<?php
/**
 * Classe que implementa as operações de tela referentes ao 
 * objeto USUARIO
 * 
 * @author Fernando Salla
 * @since 09/05/2012
 * 
 */
class ViewUsuario extends View{
    
    function __construct() {
        parent::__construct();
        
        $this->setController('Usuario');
        $this->setTitulo('Usuários');
    }
    
    /**
     * Método que realiza a criação dos campos da tela de manutenção (inclusão/alteração) 
     */
    function criaTela(){
        parent::criaTela();
        
        $oCodigo = new Campo('Código','codigo',Campo::TIPO_TEXTO);
        
        $oNome = new Campo('Nome','nome',Campo::TIPO_TEXTO,350,false);
        $oLogin = new Campo('Login','login',Campo::TIPO_EMAIL,350,false);
        
        $oBloqueado = new Campo('Bloqueado','bloqueado',Campo::TIPO_SELECT,60,false);
        $oBloqueado->addItem(0,'Não');
        $oBloqueado->addItem(1,'Sim');
        $oBloqueado->setValor('Não');
        
        $oTipo = new Campo('Tipo','tipo',Campo::TIPO_SELECT,120,false);
        $oTipo->addItemFrom('Usuario','getListaTipoUsuario');
        
        $oEmpresaNome = new Campo('Empresa','Empresa.nome',Campo::TIPO_TEXTO,300);
        $oEmpresaNome->setTipoVisualiza(Campo::VISUALIZA_GRID);
        
        $oEmpresa = new Campo('Empresa','Empresa.codigo',Campo::TIPO_TEXTO);
        $oEmpresa->setTipoVisualiza(Campo::VISUALIZA_FORM);
        $oEmpresa->setClasseBusca('Empresa');
        $oEmpresa->addCampoBusca('Empresa.nome');
        $oEmpresa->addCampoBusca('Empresa.nome',$oEmpresaNome);
        
        $oPrincipal = new Campo('Principal','principal',Campo::TIPO_SELECT,80,false);
        $oPrincipal->addItem(0,'Não');
        $oPrincipal->addItem(1,'Sim');
        $oPrincipal->setValor(1);

        $oNomePessoa = new Campo('Pessoa','Pessoa.nome',Campo::TIPO_TEXTO,300);
        $oNomePessoa->setTipoVisualiza(Campo::VISUALIZA_GRID);
        
        $oPessoa = new Campo('Pessoa','Pessoa.codigo',Campo::TIPO_TEXTO);
        $oPessoa->setTipoVisualiza(Campo::VISUALIZA_FORM);
        $oPessoa->setClasseBusca('Pessoa');
        $oPessoa->addCampoBusca('Pessoa.nome');
        $oPessoa->addCampoBusca('Pessoa.nome',$oNomePessoa);
        
        $oGridEmpresa = new FormGrid('Empresas',170,'100%');
        $oGridEmpresa->addCampos($oEmpresa,$oEmpresaNome,
                                 array($oPessoa,$oNomePessoa,$oPrincipal));
        $oGridEmpresa->getFieldSet()->addLarguraLabel(55);
        $oGridEmpresa->getFieldSet()->addLarguraLabel(0);
        $oGridEmpresa->getFieldSet()->addLarguraLabel(0);
        
        //campos apenas da tela de inclusão
        if($this->getRotina() === parent::ROTINA_INCLUIR){
            $oSenha = new Campo('Senha','senha',Campo::TIPO_SENHA,250,false);
            $oConfirmaSenha = new Campo('Confirma Senha','confirmaSenha',Campo::TIPO_SENHA,250,false);
            $oConfirmaSenha->setApenasTela(true);
            $oConfirmaSenha->addValidacao($oConfirmaSenha,"''", Base::DIFERENTE);
            $oConfirmaSenha->addValidacao($oConfirmaSenha, $oSenha, Base::IGUAL);
            $oConfirmaSenha->setTextoValorInvalido("Campo SENHA e CONFIRMA SENHA devem ser preenchidos e iguais");
            
            $this->addCampos($oCodigo,$oNome,$oLogin,$oSenha,$oConfirmaSenha,$oBloqueado,$oTipo,$oGridEmpresa);
            $this->addLarguraLabel(100);
        } else{
            $this->addCampos($oCodigo,$oNome,$oLogin,$oBloqueado,$oTipo,$oGridEmpresa);
            $this->addLarguraLabel(65);
        }
    }
    
    /**
     * Método que realiza a criação da tela de alteração de senha
     */
    function criaTelaAlteraSenha(){
        parent::criaTela();
        
        $oCodigo = new Campo('Código','codigo',Campo::TIPO_TEXTO);
        
        $oNome = new Campo('Nome','nome',Campo::TIPO_TEXTO,350,false);
        $oNome->setSomenteLeitura(true);
        
        $oLogin = new Campo('Login','login',Campo::TIPO_EMAIL,350,false);
        $oLogin->setSomenteLeitura(true);
        
        $oNovaSenha = new Campo('Nova Senha','novaSenha',Campo::TIPO_SENHA,250,false);
        $oNovaSenha->setApenasTela(true);
        
        $oConfirmaSenha = new Campo('Confirma Nova Senha','confirmaNovaSenha',Campo::TIPO_SENHA,250,false);
        $oConfirmaSenha->setApenasTela(true);
        $oConfirmaSenha->addValidacao($oConfirmaSenha, "''", Base::DIFERENTE);
        $oConfirmaSenha->addValidacao($oConfirmaSenha, $oNovaSenha, Base::IGUAL);
        $oConfirmaSenha->setTextoValorInvalido("Campo NOVA SENHA e CONFIRMA NOVA SENHA devem ser preenchidos e iguais");
        $oConfirmaSenha->setApenasTela(true);

        if($_SESSION["tipoUser"] != PersistenciaUsuario::USUARIO_ADMINISTRADOR){
            $oSenhaAtual = new Campo('Senha Atual','senhaAtual',Campo::TIPO_SENHA,250,false);
            $oSenhaAtual->setApenasTela(true);
            $oSenhaAtual->addListener(Base::EVENTO_EXIT,$this->addAcao('Usuario','validaSenhaLogin',array($this->getValorCampo($oLogin),
                                                                                                          $this->getValorCampo($oSenhaAtual),
                                                                                                          $oSenhaAtual->getId())));
            $this->addCampos($oCodigo,$oNome,$oLogin,$oSenhaAtual,$oNovaSenha,$oConfirmaSenha);
        } else{
            $this->addCampos($oCodigo,$oNome,$oLogin,$oNovaSenha,$oConfirmaSenha);
        }       
        
        $this->addLarguraLabel(140);
    }
    
    
    /**
     * Método que realiza a criação dos campos da tela de consulta
     */
    function criaConsulta(){
        parent::criaConsulta();
        
        $oCodigo = new CampoConsulta('Código','codigo',CampoConsulta::TIPO_INTEIRO,80);
        $oNome = new CampoConsulta('Nome','nome',CampoConsulta::TIPO_TEXTO);
        $oLogin = new CampoConsulta('Login','login',CampoConsulta::TIPO_TEXTO);
        $oTipo = new CampoConsulta('Tipo','tipo',CampoConsulta::TIPO_LISTA);
        $oTipo->addListaFrom('Usuario','getListaTipoUsuario');
        
        $this->addCampos($oCodigo,$oNome,$oLogin,$oTipo);
        
        $this->addBotaoConsulta('Alterar Senha',10,6,Base::ICON_LOGIN,false,null,true);
    }
    /*
     *  function criaConsulta() {
          parent::criaConsulta();
          
          $oCodigo = new CampoConsulta('Modulo','modcod');
          $oUnidade = new CampoConsulta('Descrição','modescricao');
          
          $this->addCampos($oCodigo,$oUnidade);
      }
     */
    
    /**
     * Método que retorna a string contendo o botão que permite ao usuário
     * realizar algumas ações
     */
    public function getAcoesUsuario($aListaSistemas){
        $oBtnUser = new Botao($_SESSION["loginUser"]);
        $oBtnUser->setSplit(true);
        $oBtnUser->setIcone('icon-areaUser');
        $oBtnUser->setPosicaoIcone(Botao::$ESQUERDA);
        $oBtnUser->setTamanho(Botao::$MEDIO);
        
        foreach($aListaSistemas as $aLinha){
            $oBtnUser->addItem(utf8_decode($aLinha[0]),'requestAjax("","Menu","recarregaMenuSistema",['.$aLinha[1].','.$aLinha[2].'])','icon-favoritos');
        }
        
        $sAcaoLogout = "requestAjax('','".$this->getController()."','acaoLogout');";
        $oBtnUser->addItem('Logout',$sAcaoLogout,'icon-exit');
        
        return $oBtnUser->getRender();
    }
    /**
     * Método que cria a da tela de relatório de usuários
     */
    function relatorioUsuario(){
        parent::criaTelaRelatorio();
        
        $oUsuario = new Campo('Cód. Usuário','codigoUsuario',Campo::TIPO_NUMERICO);
        
        $this->addCampos($oUsuario);
    }    
    
}
?>