<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 03/09/2018
 */

class ControllerSTEEL_PCP_Material extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Material');
    }
}