<?php

/*
 * Implementa classe controller
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * * */

class PersistenciaDELX_FIS_Generoitem extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIS_GENEROITEM');

        $this->adicionaRelacionamento('fis_generoitemcodigo', 'fis_generoitemcodigo',true,true);
        $this->adicionaRelacionamento('fis_generoitemdescricao', 'fis_generoitemdescricao');

        $this->setSTop(50);
    }

}
