<?php

/* 
 * Persistencia destinada a informar empresas que não vão participar dos indicadores da expedição
 * 
 */

class PersistenciaNotEmpQual extends Persistencia{
    public function __construct() {
        parent::__construct();

        $this->setTabela('tbnotempqual');
        
        $this->adicionaRelacionamento('empcod', 'empcod',true,true);
        $this->adicionaRelacionamento('empdes','empdes');
        
        $this->adicionaOrderBy('empcod', 1);
        
    }
    
    
}
