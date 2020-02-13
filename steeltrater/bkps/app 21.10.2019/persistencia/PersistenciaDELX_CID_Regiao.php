<?php

/*
 * Classe que implementa a persistencia de regiao
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class PersistenciaDELX_CID_Regiao extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CID_REGIAO');

        $this->adicionaRelacionamento('cid_regiaocodigo', 'cid_regiaocodigo', true, true);
        $this->adicionaRelacionamento('cid_regiaodescricao', 'cid_regiaodescricao');
        $this->adicionaRelacionamento('cid_regiaotipo', 'cid_regiaotipo');
        $this->adicionaRelacionamento('cid_regiaodataultimofaturament', 'cid_regiaodataultimofaturament');
        $this->adicionaRelacionamento('cid_regiaonumerodiasfaturament', 'cid_regiaonumerodiasfaturament');
        $this->adicionaRelacionamento('cid_regiaodiasfinanceiro', 'cid_regiaodiasfinanceiro');
        $this->adicionaRelacionamento('cid_regiaodiasentrega', 'cid_regiaodiasentrega');

        $this->setSTop('1000');
        $this->adicionaOrderBy('cid_regiaocodigo', 0);
    }

}
