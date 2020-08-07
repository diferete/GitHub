<?php

/* 
 * Classe que implementa o controle de usuários que logam no sistema com erro de senha
 * @author Avanei Martendal
 * @date 25/08/2017
 */

class ControllerLoginErro extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('LoginErro');
    }
    
    /**
     * Class que gera os dados para inserir no controle de login incorreto
     */
    public function geraLoginErro(){
        $aCamposChave = array();
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        parse_str($sChave,$aCamposChave);
        
        $sIp = $_SERVER["REMOTE_ADDR"];
        
        date_default_timezone_set('America/Sao_Paulo');
        $sHora = date('H:i');
        $sData = date('d/m/Y');
        
        $this->Persistencia->setChaveIncremento(false);
        $iInc = $this->Persistencia->getIncremento('codigo',true);  
        
        $this->Model->setCodigo($iInc);
        $this->Model->setData($sData);
        $this->Model->setHora($sHora);
        $this->Model->setIp($sIp);
        $this->Model->setNome($aCamposChave['login']);
        $this->Model->setSenha($aCamposChave['loginsenha']);
        
        $aRetorno = $this->Persistencia->inserir();
        
    }
    
    
    
}
