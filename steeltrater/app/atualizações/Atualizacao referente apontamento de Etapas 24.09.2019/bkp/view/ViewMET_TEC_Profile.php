<?php

/* 
 *Classe que implementa o view da classe usuário
 * @author Avanei Martendal
 * @since 25/12/2015
 */
class ViewMET_TEC_Profile extends View{
    function __construct() {
        parent::__construct();
      }
    
   
 public function criaTela() {
        parent::criaTela();
        
        $this->setBTela(true); 
       
        $this->setTituloTela($this->addIcone("icon wb-user"). 'Meu Perfil');
        
        $oUsucodigo = new Campo('','usucodigo', Campo::TIPO_TEXTO,1);
        $oUsucodigo->setBCampoBloqueado(true);
        $oUsucodigo->setBOculto(true);
        
        $oUsuCracha = new Campo('Crachá', 'usucracha', Campo::TIPO_TEXTO,1);
        $oUsuCracha->setBCampoBloqueado(true);
        
        $oUserNome = new Campo('','usunome',  Campo::TIPO_TEXTO,3);
        $oUserNome->setBCampoBloqueado(true);
        $oUserNome->setBOculto(true);
        
        $oUserImagem = new Campo('Imagem', 'usuimagem', Campo::TIPO_UPLOAD);
        
        $oUsuLogin = new Campo('Login', 'usulogin',  Campo::TIPO_TEXTO,3);
        $oUsuLogin->addValidacao(true, Validacao::TIPO_EMAIL);
        $oUsuLogin->setBCampoBloqueado(true);
        //fazer senha
        $UsusenhaAtual = new Campo('Digite sua senha atual','ususenhaatual', Campo::TIPO_SENHA,3);
        $UsusenhaAtual->setApenasTela(true);
        $oBadgeAtual = new Campo('Aguardando','b0', Campo::TIPO_BADGE,2);
        $oBadgeAtual->setApenasTela(true);
        
        
        
       
        
        $oNovaSenha = new Campo('Nova senha', 'ususenha', Campo::TIPO_SENHA,3);
        $oNovaSenha->setBCampoBloqueado(true);
        $oBadge = new campo('Aguardando','b1', Campo::TIPO_BADGE,2);
        $oBadge->setApenasTela(true);
        
        $oNovaSenhaConfirma = new Campo('Confirme a nova senha', 'ususenhaconfirma', Campo::TIPO_SENHA,3);
        $oNovaSenhaConfirma->addValidacao(false, Validacao::TIPO_IGUAL, '$Mensagem', '6', '20', 'ususenha');
        $oNovaSenhaConfirma->setApenasTela(true);
        $oNovaSenhaConfirma->setBCampoBloqueado(true);
        $oBadge2 = new campo('Aguardando','b1', Campo::TIPO_BADGE,2);
        $oBadge2->setApenasTela(true);
        
        //verificação da senha digitada
        $sCallback = 'if (requestJSON(true, "MET_TEC_Profile", "validaLogin", $("#'.$this->getTela()->getId().'-form").serialize(), "'.$UsusenhaAtual->getNome().'").retorno == "true"){'
                .'$("#'.$oBadgeAtual->getId().'").removeClass( "label-danger label-warning label-success" );'
                .'$("#'.$UsusenhaAtual->getId().'-group").removeClass("has-success has-error");'
                .'$("#'.$UsusenhaAtual->getId().'-group").addClass("has-success");'
                .'$("#'.$oBadgeAtual->getId().'").addClass("label-success");'
                .'$("#'.$oBadgeAtual->getId().'").text("Sucesso digite sua senha!");'
                .'$("#'.$oNovaSenha->getId().',#'.$oNovaSenhaConfirma->getId().'").prop("readonly", false);'
                .'}else{'
                .'$("#'.$oBadgeAtual->getId().'").removeClass( "label-warning label-error label-success" );'
                .'$("#'.$UsusenhaAtual->getId().'-group").addClass("has-error");'
                .'$("#'.$oBadgeAtual->getId().'").addClass("label-danger");'
                .'$("#'.$oBadgeAtual->getId().'").text("Atenção sua senha não está correta!");'
                .'$("#'.$oNovaSenha->getId().',#'.$oNovaSenhaConfirma->getId().'").prop("readonly", true);'
                . '};';
        $UsusenhaAtual->addEvento(Campo::EVENTO_SAIR, $sCallback);
        //botao alterar
        $oBotaoAlterar = new Campo('Alterar senha','', Campo::TIPO_BOTAOSMALL_SUB,2);
        //verificacao se senha é forte
        $sCallback1 ='strongPassSistema("'.$oNovaSenha->getId().'","'.$oNovaSenhaConfirma->getId().'","'.$oBadge->getId().'","'.$oBadge2->getId().'","'.$oBotaoAlterar->getOBotao()->getId().'");'; 
        $oNovaSenha->addEvento(Campo::EVENTO_SAIR, $sCallback1);
        $oNovaSenhaConfirma->addEvento(Campo::EVENTO_SAIR, $sCallback1);
        
        
        $sAcaoAlterar ='requestAjax("'.$this->getTela()->getId().'-form","MET_TEC_Profile","alteraSenha","'.$this->getTela()->getId().'-form");'; 
        $oBotaoAlterar->addAcaoBotao($sAcaoAlterar);
        $oBotaoAlterar->setApenasTela(true);
        $oBotaoAlterar->setBDesativado(true);
        
        $oBotaoAlterarImg = new Campo('Alterar imagem','', Campo::TIPO_BOTAOSMALL_SUB,2);
        $sAcaoAlterarImg ='requestAjax("'.$this->getTela()->getId().'-form","MET_TEC_Profile","alteraImagem","'.$this->getTela()->getId().'-form");'; 
        $oBotaoAlterarImg->addAcaoBotao($sAcaoAlterarImg);
        $oBotaoAlterarImg->setApenasTela(true);
        
      


        
        $this->addCampos($oUsuLogin, array($UsusenhaAtual,$oBadgeAtual),array($oNovaSenha,$oBadge),array($oNovaSenhaConfirma,$oBadge2),$oBotaoAlterar,
                array($oUsucodigo,$oUserNome), $oUserImagem,$oBotaoAlterarImg);
    }
}
