<?php

/*
 * Classe que implementa a persistencia de estado
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class PersistenciaDELX_CID_Estado extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CID_ESTADO');

        $this->adicionaRelacionamento('cid_paiscodigo', 'cid_paiscodigo', true, true);
        $this->adicionaRelacionamento('cid_estadocodigo', 'cid_estadocodigo', true, true);
        $this->adicionaRelacionamento('cid_estadodescricao', 'cid_estadodescricao');
        $this->adicionaRelacionamento('cid_estadoibge', 'cid_estadoibge');
        $this->adicionaRelacionamento('cid_estadoaliquotaintra', 'cid_estadoaliquotaintra');
        $this->adicionaRelacionamento('cid_estadoaliquotainter', 'cid_estadoaliquotainter');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('cid_paiscodigo', 0);
    }

}
