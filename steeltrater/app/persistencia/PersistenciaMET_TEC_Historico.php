<?php

/**
 * Implementa persistencia da classe MET_TEC_Historico
 * @author Alexandre W de Souza
 * @since 09/10/2018
 * ** */
class PersistenciaMET_TEC_Historico extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_HISTORICO');

        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('classe', 'classe');
        $this->adicionaRelacionamento('historico', 'historico');

        $this->setSTop('50');
    }

    public function gravaHistorico($aDados) {
        $sSql = "";
        $this->executaSql($sSql);
    }

}
