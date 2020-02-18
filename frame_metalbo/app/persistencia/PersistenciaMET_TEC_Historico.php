<?php

/**
 * Implementa persistencia da classe MET_TEC_Historico
 * @author Alexandre W de Souza
 * @since 09/10/2018
 * ** */
class PersistenciaMET_TEC_Historico extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_Historico');

        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc');
        $this->adicionaRelacionamento('usucodigo', 'usucodigo');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('classe', 'classe');
        $this->adicionaRelacionamento('historico', 'historico');
        $this->adicionaRelacionamento('acao', 'acao');
              
        $this->adicionaOrderBy('seq',1);

        $this->setSTop('50');
    }

}
