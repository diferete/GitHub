<?php

/* 
 * Cria a classe que implementa cadastro de tratamentos da produção steel trater
 * 
 * @author Avanei Martendal
 * @since 31/05/2018
 */

class PersistenciaSTEEL_PCP_Tratamentos extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('STEEL_PCP_tratamentos');
        
        $this->adicionaRelacionamento('tratcod','tratcod', true, true, true);
        $this->adicionaRelacionamento('tratdes','tratdes');
        $this->adicionaRelacionamento('tratrevencomp','tratrevencomp');
        
        $this->setSTop(20);
        $this->adicionaOrderBy('tratcod',1);
    }
}

