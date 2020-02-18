<?php

/* 
 *Classe que implementa o controller da produção steeltrater
 * 
 * @author Avanei Martendal
 * @since 31/05/2018
 */

class ControllerSTEEL_PCP_Tratamentos extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_Tratamentos');
    }
}

