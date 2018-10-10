<?php

class ControllerNoticiaSite extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('NoticiaSite');
    }
    
    public function getFeed($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $aRetorno = $this->Persistencia->liberaNoticia('');
        
        echo json_encode($aRetorno);
    }
    
    public function getNoticias($sDados){
        $sDados = explode(',',$sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave,$aCamposChave);
        
        $aRetorno = $this->Persistencia->buscaNoticia('');
        
        echo json_encode($aRetorno);
    }
    
}
