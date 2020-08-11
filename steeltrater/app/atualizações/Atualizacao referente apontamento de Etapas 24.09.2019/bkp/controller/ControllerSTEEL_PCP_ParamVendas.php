<?php

/* 
 * Implementa a classe controler STEEL_PCP_Parametros
 * 
 * @author Cleverton Hoffmann
 * @since 23/11/2018
 */


class ControllerSTEEL_PCP_ParamVendas extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ParamVendas');
    }
}
