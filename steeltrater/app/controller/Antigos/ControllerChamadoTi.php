<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ControllerChamadoTi extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('ChamadoTi');
    }
    
    public function carregaProb($sDados){
        $aDados = explode(',',$sDados);
        $aChamado = explode('=', $aDados[1]);
        
        $this->Persistencia->adicionaFiltro($aChamado[0],$aChamado[1]);
        $oDados = $this->Persistencia->consultarWhere();
        
        $oDados->setProbl(str_replace("\n", " ",$oDados->getProbl()));
        $oDados->setProbl(str_replace("'","\'",$oDados->getProbl()));   
        $oDados->setProbl(str_replace("\r", "",$oDados->getProbl()));
        
        $sProblema = $oDados->getProbl(); 
        echo '$("#'.$aDados[2].'").val("'.$sProblema.'");';  

    }
}
