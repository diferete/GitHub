<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/08/2018
 */

class ControllerMET_ServicoMaquina extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('MET_ServicoMaquina');
    }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();

        $this->buscaCelulas();
        
    }
    
    public function buscaCelulas(){
        $oControllerCadastroMaquina = Fabrica::FabricarController('MET_CadastroMaquinas');
        $aParame = $oControllerCadastroMaquina->buscaDados();
        $this->View->setAParametrosExtras($aParame);
    }
}
