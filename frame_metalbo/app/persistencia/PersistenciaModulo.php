<?php

class PersistenciaModulo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmodulo');

        $this->adicionaRelacionamento('modcod', 'modcod', true, true, true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');

        $this->adicionaOrderBy('modcod', 1);
    }

}
