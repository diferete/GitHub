<?php

/**
 *  
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 **/
class PersistenciaDELX_FIS_Cnae extends Persistencia{
    
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('FIS_CNAE');
        
        $this->adicionaRelacionamento('fis_cnaecodigo', 'fis_cnaecodigo',true,true);
        $this->adicionaRelacionamento('fis_cnaedescricao', 'fis_cnaedescricao');
        
        $this->setSTop(50);
        
    }
}

