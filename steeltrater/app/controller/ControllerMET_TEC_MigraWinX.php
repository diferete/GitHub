<?php

/**
 * Implementa controller da classe MET_TEC_MigraWinX
 * 
 * @author Alexandre W de Souza
 * @since 01/10/2018
 * ** */
class ControllerMET_TEC_MigraWinX extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_MigraWinX');
    }

    public function migraProd($sDados) {
        $this->Persistencia->migraProd($sDados);
    }

    public function migraProdGeral($sDados) {
        $this->Persistencia->migraProdGeral($sDados);
    }

}
