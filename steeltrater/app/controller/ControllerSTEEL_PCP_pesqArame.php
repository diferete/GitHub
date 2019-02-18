<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 19/10/2018
 */

class ControllerSTEEL_PCP_pesqArame extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_pesqArame');
    }

    
    public function retornaPeso($sProduto) {
        $this->Persistencia->adicionaFiltro('pro_codigo', $sProduto);
        $oProduto = $this->Persistencia->consultarWhere();
        return $oProduto->getPro_pesoliquido();
    }

}
