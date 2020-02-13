<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerNfRep extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('NfRep');
    }
    
    /**
     * Método que alimenta os campos abaixo do grid
     */
    
    public function camposGrid($sDados){
        $aDados = explode(',',$sDados);
        $aNfs = explode('=', $aDados[1]);
        $sNf = $aNfs[1];
        
        //busca os pedidos e as observações da nota fiscal
        $sObsPed = $this->Persistencia->buscaPed($sNf);
        //buca todas as od
        $sOds = $this->Persistencia->buscaTodasOd($sNf);
        echo '$("#'.$aDados[2].'").val("'.$sObsPed.'");';
        echo '$("#'.$aDados[3].'").val("'.$sOds.'");';
    }
    
     public function mostraTelaRelFat($renderTo, $sMetodo = '') {
        parent::mostraTelaRelatorio($renderTo, 'RelRepFat');
    }  
    
    public function getSget() {
        parent::getSget();
        
        $sGet ='&codrep='.$_SESSION['repsoffice'];
        
       
        return $sGet;
    }
    
}