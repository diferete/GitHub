<?php

/**
 * Implementa persistencia da classe DELX_PRO_Principioativo
 * 
 * @author Alexandre W de Souza
 * @since 08/10/2018
 * ** */
class PersistenciaDELX_PRO_Principioativo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRINCIPIOATIVO');

        $this->adicionaRelacionamento('pro_principioativoseq', 'pro_principioativoseq', true, true, true);
        $this->adicionaRelacionamento('pro_principioativodescricao', 'pro_principioativodescricao');

        $this->setSTop(50);
    }

}
