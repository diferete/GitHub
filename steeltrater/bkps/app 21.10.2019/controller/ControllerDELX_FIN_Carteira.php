<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */


class ControllerDELX_FIN_Carteira extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('DELX_FIN_CARTEIRA');
    }
}