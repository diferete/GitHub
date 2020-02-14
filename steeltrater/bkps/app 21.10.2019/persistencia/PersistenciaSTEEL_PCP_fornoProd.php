<?php

/* 
 * Class que implementa a persitencia da classe STEEL_PCP_fornoProd
 * 
 * @author Avanei Martendal
 * @since 28/08/2018
 */

class PersistenciaSTEEL_PCP_fornoProd extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_fornoProd');
        
        $this->adicionaRelacionamento('prod', 'prod',true,true);
        $this->adicionaRelacionamento('fornocod', 'STEEL_PCP_Forno.fornocod',true,true);
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        
        $this->setSTop('500');
        $this->adicionaOrderBy('prod',1);
        $this->adicionaJoin('STEEL_PCP_Forno');
    }
}
