<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_Maquinas extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('metmaq');
        
        $this->adicionaRelacionamento('cod','cod',true,true, true);
        $this->adicionaRelacionamento('maquina', 'maquina');
        $this->adicionaRelacionamento('maqtip', 'maqtip');
        $this->adicionaRelacionamento('nomeclatura', 'nomeclatura');
        
        $this->adicionaOrderBy('cod',0);
        
    }
}
