<?php

/*
 * Classe que implementa a persistencia de Carteira
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class PersistenciaDELX_FIN_Carteira extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIN_CARTEIRA');

        $this->adicionaRelacionamento('fin_carteiracodigo', 'fin_carteiracodigo', true, true);
        $this->adicionaRelacionamento('fin_carteiradescricao', 'fin_carteiradescricao');

        $this->setSTop('1000');
        $this->adicionaOrderBy('fin_carteiracodigo', 0);
    }

}
