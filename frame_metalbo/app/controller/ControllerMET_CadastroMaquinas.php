<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class ControllerMET_CadastroMaquinas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_CadastroMaquinas');
    }

    public function buscaDados() {
        $aParame = array();
        $aParame1 = $this->Persistencia->buscaDadosTipMaq();
        $aParame[0] = $aParame1;
        $oControllerMaquina = Fabrica::FabricarController('MET_Maquinas');
        $aParame[1] = $oControllerMaquina->Persistencia->buscaDadosSetor();
        return $aParame;
    }

}
