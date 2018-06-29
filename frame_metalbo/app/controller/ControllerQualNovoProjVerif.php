<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualNovoProjVerif extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('QualNovoProjVerif');
    }
    
    public function TelaCadVerif($sDados){
      
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',',$sDados);
        $sChave =htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        //procedimentos antes de criar a tela
        $this->antesAlterar($aDados);
        //cria a tela
        $this->View->criaTela();
        
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
}