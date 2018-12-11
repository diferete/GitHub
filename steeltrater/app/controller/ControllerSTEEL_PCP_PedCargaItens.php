<?php

/* 
 * Implementa a classe controler
 * 
 * @author Cleverton Hoffmann
 * @since 21/11/2018
 */


class ControllerSTEEL_PCP_PedCargaItens extends Controller {
    public function __construct() {
        $this->carregaClassesMvc('STEEL_PCP_PedCargaItens');
    }
    
     public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $this->View->setAParametrosExtras($aChave);
        
        }
        
     public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if(count($aparam)>0){
          
          $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aparam[0]);
          $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aparam[1]);
          
            }  else {
          $this->Persistencia->adicionaFiltro('pdv_pedidofilial',$aparam1[0]);
          $this->Persistencia->adicionaFiltro('pdv_pedidocodigo',$aparam1[1]);
          $this->Persistencia->setChaveIncremento(false); 
        }
        
    }
}