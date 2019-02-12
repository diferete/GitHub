<?php

/*
 * Classe que implementa a persistencia de STEEL_PCP_CargaInsumoServ
 * 
 * @author Avanei Martendal
 * @since 10/01/2019
 */

class PersistenciaSTEEL_PCP_CargaInsumoServ extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_CargaInsumoServ');
        
        $this->adicionaRelacionamento('pdv_pedidofilial', 'pdv_pedidofilial',true,true);
        $this->adicionaRelacionamento('pdv_pedidocodigo', 'pdv_pedidocodigo',true,true);
        $this->adicionaRelacionamento('pdv_pedidoitemseq', 'pdv_pedidoitemseq',true,true);
        $this->adicionaRelacionamento('pdv_insserv', 'pdv_insserv');
        $this->adicionaRelacionamento('op','op');
        
       
    }
    
    
    
}