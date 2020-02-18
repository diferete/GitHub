<?php

/* 
 *Classe que implementa o controller da produção steeltrater
 * 
 * @author Avanei Martendal
 * @since 31/05/2018
 */

class ControllerSTEEL_CAD_tratamentos extends Controller{
    public function __construct() {
        $this->carregaClassesMvc('STEEL_CAD_tratamentos');
    }
}

