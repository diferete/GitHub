<?php

/**
 *  
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 **/
class PersistenciaDELX_FIS_Ncm extends Persistencia {

    public function __construct() {
        parent::__construct();
              
        $this->setTabela('FIS_NCM');
        
        $this->adicionaRelacionamento('fis_ncmcodigo', 'fis_ncmcodigo',true,true);
        $this->adicionaRelacionamento('fis_ncmdescricao', 'fis_ncmdescricao');
        
        $this->setSTop(50);
    }

}
