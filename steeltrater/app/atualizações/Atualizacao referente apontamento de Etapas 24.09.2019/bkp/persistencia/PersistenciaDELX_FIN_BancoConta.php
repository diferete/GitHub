<?php

/*
 * Classe que implementa a persistencia de Banco Conta
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class PersistenciaDELX_FIN_BancoConta extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('FIN_BANCOCONTA');

        $this->adicionaRelacionamento('fin_bancocodigo', 'fin_bancocodigo', true, true);
        $this->adicionaRelacionamento('fin_bancocontanumero', 'fin_bancocontanumero', true, true);
        $this->adicionaRelacionamento('fin_bancocontaagencia', 'fin_bancocontaagencia');
        $this->adicionaRelacionamento('fin_bancocontageraremessa', 'fin_bancocontageraremessa');
        $this->adicionaRelacionamento('fin_bancocontacobrancaseq', 'fin_bancocontacobrancaseq');
        $this->adicionaRelacionamento('fin_bancocontapagamentoseq', 'fin_bancocontapagamentoseq');
        $this->adicionaRelacionamento('fin_bancocontaemitecheque', 'fin_bancocontaemitecheque');
        $this->adicionaRelacionamento('fin_bancocontaultimocheque', 'fin_bancocontaultimocheque');
        $this->adicionaRelacionamento('fin_bancocontalaycheque', 'fin_bancocontalaycheque');
        $this->adicionaRelacionamento('fin_bancocontafilial', 'fin_bancocontafilial');
        
        $this->setSTop('1000');
        $this->adicionaOrderBy('fin_bancocodigo', 0);
    }

}
