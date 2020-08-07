<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 03/09/2018
 */

class PersistenciaSTEEL_PCP_Material extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_material');

        $this->adicionaRelacionamento('matcod', 'matcod', true,true,true);
        $this->adicionaRelacionamento('matdes', 'matdes');

        $this->setSTop('30');
        $this->adicionaOrderBy('matcod', 1);
    }

}
