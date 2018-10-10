<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class PersistenciaDELX_PRO_Caracteristica extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_CARACTERISTICA');

        $this->adicionaRelacionamento('pro_caracteristicacodigo', 'pro_caracteristicacodigo',true,true);
        $this->adicionaRelacionamento('pro_caracteristicadescricao', 'pro_caracteristicadescricao');
        $this->adicionaRelacionamento('pro_caracteristicavlrdefinidos', 'pro_caracteristicavlrdefinidos');
        
        $this->setSTop(50);
    }

}
