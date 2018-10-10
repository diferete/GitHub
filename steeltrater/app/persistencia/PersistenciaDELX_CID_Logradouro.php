<?php

/*
 * Classe que implementa a persistencia de logradouro
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class PersistenciaDELX_CID_Logradouro extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CID_LOGRADOURO');

        $this->adicionaRelacionamento('cid_paiscodigo', 'cid_paiscodigo', true, true);
        $this->adicionaRelacionamento('cid_logradourocep', 'cid_logradourocep', true, true);
        $this->adicionaRelacionamento('cid_logradourorua', 'cid_logradourorua');
        $this->adicionaRelacionamento('cid_logradourobairro', 'cid_logradourobairro');
        $this->adicionaRelacionamento('cid_logradourocidadecodigo', 'cid_logradourocidadecodigo');

        $this->setSTop('1000');
        $this->adicionaOrderBy('cid_paiscodigo', 0);
    }

}
