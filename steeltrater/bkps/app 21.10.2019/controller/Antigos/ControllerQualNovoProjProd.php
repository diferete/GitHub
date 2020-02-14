<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualNovoProjProd extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjProd');
    }
    
    public function TelaCadProd($sDados){
      
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
        //cria a tela
        $this->View->criaTelaProd();
        
        //adiciona onde será renderizado
        $this->View->getTela()->setSRender($aDados[0]);
        //adiciona tela que será dado um show 
        $this->View->getTela()->setSRenderHide($aDados[1]);
        //carregar campos tela
        $this->carregaCamposTela($sChave);
        //adiciona botoes padrão
        if(!$this->getBDesativaBotaoPadrao()){
            $this->View->addBotaoPadraoTela('');
            };
        //renderiza a tela
        $this->View->getTela()->getRender();
       }
       
       
       public function beforeInsert() {
        parent::beforeInsert();
        
        $this->Model->setChavemin($this->ValorSql($this->Model->getChavemin()));
        $this->Model->setChavemax($this->ValorSql($this->Model->getChavemax()));
        $this->Model->setAltmin($this->ValorSql($this->Model->getAltmin()));//Altmax()
        $this->Model->setAltmax($this->ValorSql($this->Model->getAltmax()));
        $this->Model->setDiamfmin($this->ValorSql($this->Model->getDiamfmin()));
        $this->Model->setDiamfmax($this->ValorSql($this->Model->getDiamfmax()));
        
        $this->Model->setCompmin($this->ValorSql($this->Model->getCompmin()));//Compmax
        $this->Model->setCompmax($this->ValorSql($this->Model->getCompmax()));
        
        $this->Model->setDiampmin($this->ValorSql($this->Model->getDiampmin()));
        $this->Model->setDiampmax($this->ValorSql($this->Model->getDiampmax()));
        
        $this->Model->setDiamexmin($this->ValorSql($this->Model->getDiamexmin()));
        $this->Model->setDiamexmax($this->ValorSql($this->Model->getDiamexmax()));
        
        $this->Model->setComprmin($this->ValorSql($this->Model->getComprmin()));
        $this->Model->setComprmax($this->ValorSql($this->Model->getComprmax()));
        
        $this->Model->setComphmin($this->ValorSql($this->Model->getComphmin()));
        $this->Model->setComphmax($this->ValorSql($this->Model->getComphmax()));
        
        $this->Model->setDiamhmin($this->ValorSql($this->Model->getDiamhmin()));
        $this->Model->setDiamhmax($this->ValorSql($this->Model->getDiamhmax()));//Anghelice
        
        $this->Model->setAnghelice($this->ValorSql($this->Model->getAnghelice()));
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    public function beforeUpdate() {
        parent::beforeUpdate();
        
        $this->Model->setChavemin($this->ValorSql($this->Model->getChavemin()));
        $this->Model->setChavemax($this->ValorSql($this->Model->getChavemax()));
        $this->Model->setAltmin($this->ValorSql($this->Model->getAltmin()));//Altmax()
        $this->Model->setAltmax($this->ValorSql($this->Model->getAltmax()));
        $this->Model->setDiamfmin($this->ValorSql($this->Model->getDiamfmin()));
        $this->Model->setDiamfmax($this->ValorSql($this->Model->getDiamfmax()));
        
        $this->Model->setCompmin($this->ValorSql($this->Model->getCompmin()));//Compmax
        $this->Model->setCompmax($this->ValorSql($this->Model->getCompmax()));
        
        $this->Model->setDiampmin($this->ValorSql($this->Model->getDiampmin()));
        $this->Model->setDiampmax($this->ValorSql($this->Model->getDiampmax()));
        
        $this->Model->setDiamexmin($this->ValorSql($this->Model->getDiamexmin()));
        $this->Model->setDiamexmax($this->ValorSql($this->Model->getDiamexmax()));
        
        $this->Model->setComprmin($this->ValorSql($this->Model->getComprmin()));
        $this->Model->setComprmax($this->ValorSql($this->Model->getComprmax()));
        
        $this->Model->setComphmin($this->ValorSql($this->Model->getComphmin()));
        $this->Model->setComphmax($this->ValorSql($this->Model->getComphmax()));
        
        $this->Model->setDiamhmin($this->ValorSql($this->Model->getDiamhmin()));
        $this->Model->setDiamhmax($this->ValorSql($this->Model->getDiamhmax()));//Anghelice
        
        $this->Model->setAnghelice($this->ValorSql($this->Model->getAnghelice()));
        
        $aRetorno = array();
        $aRetorno[0]=true;
        $aRetorno[1]='';
        return $aRetorno;
    }
    
    /**
     * Mensagem para finalizar projeto
     */
    
    public function msgFinalizar($sDados){
         $aDados = explode(',', $sDados);
         $sChave = htmlspecialchars_decode($aDados[2]);
         $aCamposChave = array();
         parse_str($sChave,$aCamposChave);
         $sClasse= $this->getNomeClasse();
       
         $oMensagem = new Modal('Finalizar projeto','Deseja finalizar o projeto nº'.$aCamposChave['nr'].'?', Modal::TIPO_AVISO,true,true,true);
         $oMensagem->setSBtnConfirmarFunction('requestAjax("","'.$sClasse.'","finalizaProj","'.$sDados.'");');
       
       
       echo $oMensagem->getRender(); 
    }
    
    /**
     * Finaliza projeto
     */
    public function finalizaProj($sDados){
        $aDados = explode(',', $sDados);
         $sChave = htmlspecialchars_decode($aDados[2]);
         $aCamposChave = array();
         parse_str($sChave,$aCamposChave);
         $sClasse= $this->getNomeClasse();
         
         
         $aRetorno = $this->Persistencia->finaProjeto($aCamposChave);
         
         if($aRetorno[0]==true){
          $oMensagem = new Mensagem('Atenção','O projeto nº'.$aRetorno[1].' foi finalizado com sucesso!', Modal::TIPO_SUCESSO);
          echo $oMensagem->getRender();
          echo"$('#".$aDados[1]."-pesq').click();"; 
          
        }else
        {
            $oMensagem = new Modal('Atenção','O projeto nº'.$aCamposChave['nr'].' não foi finalizado!', Modal::TIPO_ERRO,false,true,true);
            echo $oMensagem->getRender();  
        }
    }
}