<?php

/*
 * Classe que implementa os models da DELX_CAD_Pessoa
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class PersistenciaMET_PROD_Produtos extends Persistencia{
    public function __construct() {
        parent::__construct();

        $this->setTabela('PRO_PRODUTO');

        $this->adicionaRelacionamento('pro_codigo', 'pro_codigo',true,true);
        $this->adicionaRelacionamento('pro_descricao', 'pro_descricao');
        $this->adicionaRelacionamento('pro_unidademedida', 'pro_unidademedida');
       

        $this->setSTop('50');
        $this->adicionaOrderBy('pro_codigo', 1);
    }

}
