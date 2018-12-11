<?php

/*
 * Classe que implementa a persistencia de DELX_FIS_Cnae
 * 
 * @author Cleverton Hoffmann
 * @since 26/10/2018
 */

class PersistenciaDELX_FIS_Cnae extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIS_CNAE');

        $this->adicionaRelacionamento('FIS_CNAECodigo', 'FIS_CNAECodigo', true, true);
        $this->adicionaRelacionamento('FIS_CNAEDescricao', 'FIS_CNAEDescricao');
        $this->adicionaRelacionamento('FIS_CNAERetencao', 'FIS_CNAERetencao');

        $this->setSTop('1000');
       // $this->adicionaOrderBy('FIS_CNAECodigo', 0);
    }

}

