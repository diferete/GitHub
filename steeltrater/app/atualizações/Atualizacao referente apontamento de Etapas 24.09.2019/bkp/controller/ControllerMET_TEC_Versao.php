<?php

/*
 * Classe que gerencia a Controller da VersaoSistema
 * @author: Alexandre W. de Souza
 * @since: 15/09/2017
 * 
 */

class ControllerMET_TEC_Versao extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Versao');
    }

}
