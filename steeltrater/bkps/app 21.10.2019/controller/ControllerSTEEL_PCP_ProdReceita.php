<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */


class ControllerSTEEL_PCP_ProdReceita extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_PRODRECEITA');
    }
    
    public function receitaPadrao($sDados){
        $this->Persistencia->adicionaFiltro('pro_codigo',$sDados);
        $oDados = $this->Persistencia->consultarWhere();
        return $oDados;
    }
}