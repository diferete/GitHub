<?php

/*
 * Classe que implementa a persistencia de cidade
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class PersistenciaDELX_NFS_TipoMovimento extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('NFS_TIPOMOVIMENTO');

        $this->adicionaRelacionamento('nfs_tipomovimentocodigo', 'nfs_tipomovimentocodigo', true, true);
        $this->adicionaRelacionamento('nfs_tipomovimentodescricao', 'nfs_tipomovimentodescricao');

        $this->setSTop('1000');
        $this->adicionaOrderBy('nfs_tipomovimentocodigo', 0);
    }

}
