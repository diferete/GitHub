<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/06/2018
 */


class ControllerDELX_CPG_CondicaoPagamento extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('DELX_CPG_CONDICAOPAGAMENTO');
    }
}