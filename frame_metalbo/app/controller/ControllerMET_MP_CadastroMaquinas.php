<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 22/08/2018
 */

class ControllerMET_MP_CadastroMaquinas extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_MP_CadastroMaquinas');
    }

    /**
     * Função que retorna array com o tipo de máquina e os setores
     * @return type
     */
    public function buscaDados() {
        $aParame = array();
        $aParame1 = $this->Persistencia->buscaDadosTipMaq();
        $aParame[0] = $aParame1;
        $oControllerMaquina = Fabrica::FabricarController('MET_MP_Maquinas');
        $aParame[1] = $oControllerMaquina->Persistencia->buscaDadosSetor();
        return $aParame;
    }

}
