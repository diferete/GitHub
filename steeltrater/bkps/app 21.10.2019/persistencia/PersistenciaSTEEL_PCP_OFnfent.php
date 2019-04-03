<?php

/* 
 * Classe que implementa a geração de ordens de fabricação a partir de uma nota de entrada
 * 
 * @author Avanei Martendal
 * 
 * @since 21/06/2018
 */

class PersistenciaSTEEL_PCP_OFnfent extends Persistencia {
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('NFS_NOTAFISCAL');

        $this->adicionaRelacionamento('nfs_notafiscalfilial', 'nfs_notafiscalfilial', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalseq', 'nfs_notafiscalseq', true, true);
        $this->adicionaRelacionamento('nfs_notafiscalnumero', 'nfs_notafiscalnumero');
        $this->adicionaRelacionamento('nfs_notafiscalserie', 'nfs_notafiscalserie');
        $this->adicionaRelacionamento('nfs_notafiscaldatachegada', 'nfs_notafiscaldatachegada');
        $this->adicionaRelacionamento('nfs_notafiscalnfechave', 'nfs_notafiscalnfechave');
        $this->adicionaRelacionamento('nfs_notafiscalpessoanome', 'nfs_notafiscalpessoanome');

        $this->setSTop('100');
        $this->adicionaOrderBy('nfs_notafiscalseq', 1);
        
        $this->adicionaFiltro('nfs_notafiscalfilial','8993358000174');
    }
}

