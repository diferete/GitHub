<?php

/**
 * Classe responsável pelas operações de persistência do objeto
 * Sistema
 * 
 * @author Fernando Salla
 * @since 19/06/2012 
 */
class PersistenciaSistema extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela("tbsistema");

        $this->adicionaRelacionamento('siscodigo', 'codigo', true, true, true);
        $this->adicionaRelacionamento('sisnome', 'nome');
        $this->adicionaRelacionamento('sislogo', 'logo');
    }
   

}

?>