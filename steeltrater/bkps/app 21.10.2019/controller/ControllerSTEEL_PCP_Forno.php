<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 05/07/2018
 */


class ControllerSTEEL_PCP_Forno extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_FORNO');
    }
    /**
     * Busca forno
     * @param type $iForno
     * @return type
     */
    public function buscaForno($iForno){
        $this->Persistencia->adicionaFiltro('fornocod',$iForno);
        $oForno = $this->Persistencia->consultarWhere();
        return $oForno;
    }
}