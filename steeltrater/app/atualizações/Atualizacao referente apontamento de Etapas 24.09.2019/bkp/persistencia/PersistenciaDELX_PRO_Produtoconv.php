<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018 
 */

class PersistenciaDELX_PRO_Produtoconv extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTOCONV');

        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true,true);
        $this->adicionaRelacionamento('pro_convcodigo', 'pro_convcodigo',true,true);
        $this->adicionaRelacionamento('pro_convunidade', 'pro_convunidade');
        $this->adicionaRelacionamento('pro_convfator', 'pro_convfator');
        $this->adicionaRelacionamento('pro_convpadrao', 'pro_convpadrao');
        $this->adicionaRelacionamento('pro_convdimensao', 'pro_convdimensao');
        $this->adicionaRelacionamento('pro_convproduto', 'pro_convproduto');
        $this->adicionaRelacionamento('pro_produtoconvpesobruto', 'pro_produtoconvpesobruto');
        $this->adicionaRelacionamento('pro_produtoconvpesoliq', 'pro_produtoconvpesoliq');

        $this->setSTop(50);
    }

}
