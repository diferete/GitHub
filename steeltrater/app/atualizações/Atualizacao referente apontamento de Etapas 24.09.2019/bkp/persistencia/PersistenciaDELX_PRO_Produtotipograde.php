<?php

/*
 * 
 * @author Alexandre W de Souza
 * @sice 25/09/2018 
 */

class PersistenciaDELX_PRO_Produtotipograde extends Persistencia {

    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_PRODUTOTIPOGRADE');
        
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true,true);
        $this->adicionaRelacionamento('pro_tipogradecodigo', 'pro_tipogradecodigo',true,true);
        $this->adicionaRelacionamento('pro_produtotipogradedtbloq', 'pro_produtotipogradedtbloq');
        $this->adicionaRelacionamento('pro_produtotipogradeobrigatori', 'pro_produtotipogradeobrigatori');
        
        $this->setSTop(50);
    }

}
