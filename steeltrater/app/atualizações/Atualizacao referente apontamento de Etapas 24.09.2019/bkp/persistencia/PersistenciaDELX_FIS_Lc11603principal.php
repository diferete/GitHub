<?php

/**
 *  
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * */
class PersistenciaDELX_FIS_Lc11603principal extends Persistencia {

    public function __construct() {
        parent::__construct();
        
        $this->setTabela('FIS_LC11603PRINCIPAL');
        
        $this->adicionaRelacionamento('fis_lc11603principalcodigo', 'fis_lc11603principalcodigo',true,true);
        $this->adicionaRelacionamento('fis_lc11603principaldescricao', 'fis_lc11603principaldescricao');
        
        $this->setSTop(50);
        
        
    }

}
