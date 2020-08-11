<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_CargaInsumoServ
 * 
 * @author Avanei Martendal
 * @since 10/01/2019
 */

class ViewSTEEL_PCP_CargaInsumoServ extends View{
    public function criaTela() {
        parent::criaTela();
    }
    
    public function criaConsulta() {
        parent::criaConsulta();
        
        $oPedidoFilial = new CampoConsulta('Pedido','pdv_pedidocodigo');
        
        $this->addCampos($oPedidoFilial);
    }
}

