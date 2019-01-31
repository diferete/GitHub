<?php

/* 
 * Implementa a classe persistência
 * 
 * @author Cleverton Hoffmann
 * @since 24/08/2018
 */

class PersistenciaMET_Setores extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MetCad_Setores');
        
        $this->adicionaRelacionamento('codsetor','codsetor',true,true, true);
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        
        $this->adicionaOrderBy('codsetor',0);
        
    }
}
