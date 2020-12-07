<?php

/* 
 * Implementa a classe controler STEEL_PCP_ParFornoMaster
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2020
 */


class ControllerSTEEL_PCP_ParFornoMaster extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_ParFornoMaster');
       // $this->setControllerDetalhe('STEEL_PCP_ParForno');
       // $this->setSMetodoDetalhe('acaoTelaDetalhe');
    }
    
//    //NOVO ----------------------------------------------------------------------------------
//    public function adicionaFiltrosExtras() {
//        parent::adicionaFiltrosExtras();
//          $this->Persistencia->adicionaFiltro('fornocod', $this->Model->getFilcgc());
//    }
//
//    function montaProxEtapa() {
//        parent::montaProxEtapa();
//        $aRetorno[0] = $this->Model->getFornocod();
//        return $aRetorno;
//    }

}