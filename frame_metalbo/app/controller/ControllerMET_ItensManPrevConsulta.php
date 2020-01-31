<?php

/*
 * Implementa a classe controler MET_ItensManPrevConsulta
 * 
 * @author Cleverton Hoffmann
 * @since 18/02/2019
 */

class ControllerMET_ItensManPrevConsulta extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ItensManPrevConsulta');
    }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        
        $this->buscaCelulas();   
        
    }
    public function buscaCelulas(){
        
        $oControllerMaquina = Fabrica::FabricarController('MET_Maquinas');
        $aParame = $oControllerMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
    
    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);
        $sCodSet = $_SESSION['codsetor']; 
        if($sCodSet=='12'){
            $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'MANUTENCAO');    
        }else if($sCodSet=='29'){     
            $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'MECANICA');    
        }else if($sCodSet=='14') {
            $this->Persistencia->adicionaFiltro('MET_ServicoMaquina.resp', 'OPERADOR');  
        }   
        $this->Persistencia->adicionaFiltro('sitmp', 'ABERTO');
    }
}


