<?php

/*
 * Classe que implementa os models da DELX_NFS_TipoMovimento
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ModelDELX_NFS_TipoMovimento {

    private $nfs_tipomovimentocodigo;
    private $nfs_tipomovimentodescricao;

    function getNfs_tipomovimentocodigo() {
        return $this->nfs_tipomovimentocodigo;
    }

    function getNfs_tipomovimentodescricao() {
        return $this->nfs_tipomovimentodescricao;
    }

    function setNfs_tipomovimentocodigo($nfs_tipomovimentocodigo) {
        $this->nfs_tipomovimentocodigo = $nfs_tipomovimentocodigo;
    }

    function setNfs_tipomovimentodescricao($nfs_tipomovimentodescricao) {
        $this->nfs_tipomovimentodescricao = $nfs_tipomovimentodescricao;
    }

}
