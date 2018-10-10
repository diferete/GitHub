<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018 
 */

class PersistenciaDELX_PRO_Produtocodbarra extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('PRO_PRODUTOCODBARRA');
        
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true,true);
        $this->adicionaRelacionamento('pro_codigobarra', 'pro_codigobarra',true,true);
        $this->adicionaRelacionamento('pro_codigobarradescricao', 'pro_codigobarradescricao');
        $this->adicionaRelacionamento('pro_codigobarraunidade', 'pro_codigobarraunidade');
        $this->adicionaRelacionamento('pro_codigobarraquantidade', 'pro_codigobarraquantidade');
        $this->adicionaRelacionamento('pro_codigobarragrade', 'pro_codigobarragrade');
        $this->adicionaRelacionamento('pro_codigobarranaousa', 'pro_codigobarranaousa');
        $this->adicionaRelacionamento('pro_codigobarratipo', 'pro_codigobarratipo');
        
        $this->setSTop(50);
    }
}
