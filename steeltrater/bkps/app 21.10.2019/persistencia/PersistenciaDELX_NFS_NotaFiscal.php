<?php

/*
 * Classe que implementa a persistencia de NotaFiscal de entrada
 * 
 * @author Cleverton Hoffmann
 * @since 20/06/2018
 */

class PersistenciaDELX_NFS_NotaFiscal extends Persistencia {

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

        $this->setSTop('1000');
        $this->adicionaOrderBy('nfs_notafiscalfilial', 1);
    }

}
