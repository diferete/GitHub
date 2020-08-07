<?php 
 /*
 * Implementa a classe controler MET_ServicoOrdemCompra
 * @author Cleverton Hoffmann
 * @since 22/07/2020
 */ 
class ControllerMET_ServicoOrdemCompra extends Controller { 
    public function __construct() {
        $this->carregaClassesMvc('MET_ServicoOrdemCompra');
    }  
}