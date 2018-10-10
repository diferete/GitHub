<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class PersistenciaDELX_PRO_Produtocaracte extends Persistencia {

    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_PRODUTOCARACTE');
        
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true,true);
        $this->adicionaRelacionamento('pro_produtocaractecodigo', 'pro_produtocaractecodigo',true,true);
        $this->adicionaRelacionamento('pro_produtocaractevalor', 'pro_produtocaractevalor');
        $this->adicionaRelacionamento('pro_produtocaractedensidade', 'pro_produtocaractedensidade');
        
        $this->setSTop(50);
        
        
    }

}
