<?php

/**
 * Implementa Persistencia da classe FIS_Lc11603secundario
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class PersistenciaDELX_FIS_Lc11603secundario extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIS_LC11603SECUNDARIO');

        $this->adicionaRelacionamento('fis_lc11603principalcodigo', 'fis_lc11603principalcodigo',true,true);        
        $this->adicionaRelacionamento('fis_lc11603secundariocodigo', 'fis_lc11603secundariocodigo',true,true);
        $this->adicionaRelacionamento('fis_lc11603secundariodescricao', 'fis_lc11603secundariodescricao');
        $this->adicionaRelacionamento('fis_lc11603codigoservico', 'fis_lc11603codigoservico');
        $this->adicionaRelacionamento('fis_lc11603secundariopercentua', 'fis_lc11603secundariopercentua');
        

        $this->setSTop(50);
    }

}
