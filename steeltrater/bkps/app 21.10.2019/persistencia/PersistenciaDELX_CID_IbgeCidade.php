<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class PersistenciaDELX_CID_IbgeCidade extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CID_IBGECIDADE');

        $this->adicionaRelacionamento('cid_ibgecidadecodigo', 'cid_ibgecidadecodigo', true, true);
        $this->adicionaRelacionamento('cid_ibgecidadedescricao', 'cid_ibgecidadedescricao');

        $this->setSTop('1000');
        $this->adicionaOrderBy('cid_ibgecidadecodigo', 0);
    }

}
