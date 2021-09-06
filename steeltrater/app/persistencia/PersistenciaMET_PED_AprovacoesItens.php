<?php

/*
 * Implementa a classe persistencia MET_PED_AprovacoesItens
 * @author Alexandre de Souza
 * @since 19/08/2021
 */

class PersistenciaMET_PED_AprovacoesItens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.PEDC01');
        
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('pdcnro', 'pdcnro', true, true);
        $this->adicionaRelacionamento('pdcproseq', 'pdcproseq', true, true, true);
        $this->adicionaRelacionamento('pdcproqtdp', 'pdcproqtdp');
        $this->adicionaRelacionamento('pdcprovlru', 'pdcprovlru');
        
        
        $this->adicionaRelacionamento('procod', 'procod', true);
        $this->adicionaRelacionamento('procod', 'Produto.procod');

        $this->adicionaOrderBy('pdcproseq', 1);
        $this->adicionaJoin('Produto');
    }

}
