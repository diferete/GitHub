<?php

/**
 * Implementa Persistencia da classe
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class PersistenciaDELX_PRO_Produtocoproduto extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTOCOPRODUTO');

        $this->adicionaRelacionamento('pro_coprodutoseq', 'pro_coprodutoseq', true, true, true);
        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo', true, true);
        $this->adicionaRelacionamento('pro_coprodutocodigo', 'pro_coprodutocodigo', true, true);
        $this->adicionaRelacionamento('pro_coprodutograde', 'pro_coprodutograde');
        $this->adicionaRelacionamento('pro_coprodutoquantidade', 'pro_coprodutoquantidade');
        $this->adicionaRelacionamento('pro_coprodutomotivo', 'pro_coprodutomotivo');

        $this->setSTop(50);
    }

}
