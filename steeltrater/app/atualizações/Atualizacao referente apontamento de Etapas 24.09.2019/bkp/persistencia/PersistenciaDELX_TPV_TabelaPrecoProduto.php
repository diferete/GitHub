<?php

/* 
 * Classe que implementa a persistencia das tabelas de preços
 * 
 * @author Avanei Martendal
 * @since 23/01/2019
 */

class PersistenciaDELX_TPV_TabelaPrecoProduto extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('TPV_TABELAPRECOPRODUTO');
        
        $this->adicionaRelacionamento('tpv_codigo','tpv_codigo',true,true);
        $this->adicionaRelacionamento('tpv_produtocodigo','tpv_produtocodigo',true,true);
        $this->adicionaRelacionamento('tpv_produtopreco','tpv_produtopreco');
        
        $this->setSTop('10');
    }
}