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
    
}


