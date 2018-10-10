<?php

/* 
 * Classe que gerencia a busca de representantes por estado
 * @author: Alexandre
 * @since: 19/01/2018
 * 
 */

class ControllerBuscaRepSite extends Controller{
    
    public function __construct() {
        $this->carregaClassesMvc('BuscaRepSite');
    }
    
    public function buscaRep($sDados){
        $sDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $aRetorno = $this->Persistencia->getRep('');
        
        
        echo json_encode($aRetorno);

    }
}

