<?php

/*
 * Classe que implementa a persistencia de tipo frete
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class PersistenciaDELX_FRE_TipoFrete extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FRE_TIPOFRETE');

        $this->adicionaRelacionamento('fre_tipofretecodigo', 'fre_tipofretecodigo', true, true);
        $this->adicionaRelacionamento('fre_tipofretedescricao', 'fre_tipofretedescricao');
        $this->adicionaRelacionamento('fre_tipofreteresponsavel', 'fre_tipofreteresponsavel');
        $this->adicionaRelacionamento('fre_tipofretepagamento', 'fre_tipofretepagamento');
      

        $this->setSTop('1000');
        $this->adicionaOrderBy('fre_tipofretecodigo', 0);
    }

}
