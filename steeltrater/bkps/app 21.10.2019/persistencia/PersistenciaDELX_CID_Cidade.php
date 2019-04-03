<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class PersistenciaDELX_CID_Cidade extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CID_CIDADE');

        $this->adicionaRelacionamento('cid_paiscodigo', 'cid_paiscodigo', true, true);
        $this->adicionaRelacionamento('cid_codigo', 'cid_codigo', true, true);
        $this->adicionaRelacionamento('cid_estadocodigo', 'cid_estadocodigo');
        $this->adicionaRelacionamento('cid_descricao', 'cid_descricao');
        $this->adicionaRelacionamento('cid_cidadecodibge', 'cid_cidadecodibge');

        $this->setSTop('1000');
        $this->adicionaOrderBy('cid_codigo', 0);
    }

}
