<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 30/07/2018
 */

class ControllerSTEEL_PCP_ordensFabListaPesq extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ordensFabListaPesq');
    }
    
    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        
    }
    
}
