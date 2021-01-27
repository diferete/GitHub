<?php

/*
 * classe responsáveis somente por consultas das empresas que compoem o grupo
 */

class PersistenciaDELX_FIL_Empresa extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIL_EMPRESA');

        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', TRUE, TRUE, true);
        $this->adicionaRelacionamento('fil_fantasia', 'fil_fantasia');

        $this->adicionaOrderBy('fil_codigo');
    }

}
