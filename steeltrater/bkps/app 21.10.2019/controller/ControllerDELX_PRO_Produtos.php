<?php

/*
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ControllerDELX_PRO_Produtos extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('DELX_PRO_Produtos');
    }

    
    public function retornaPeso($sProduto) {
        $this->Persistencia->adicionaFiltro('pro_codigo', $sProduto);
        $oProduto = $this->Persistencia->consultarWhere();
        return $oProduto->getPro_pesoliquido();
    }

}
