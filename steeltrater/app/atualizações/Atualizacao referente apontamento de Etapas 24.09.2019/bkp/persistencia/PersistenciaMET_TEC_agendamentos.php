<?php

/* 
 * Classe para cadastrar os agendamentos 
 * 
 * @data 16/07/2019
 * @Usuário Avanei Martendal 
 */

class PersistenciaMET_TEC_agendamentos extends Persistencia{
    public function __construct() {
        parent::__construct();
        
        $this->setTabela('MET_TEC_agendamentos');
        
        $this->adicionaRelacionamento('nr','nr',true,true,true);
        $this->adicionaRelacionamento('titulo','titulo');
        $this->adicionaRelacionamento('classe','classe');
        $this->adicionaRelacionamento('metodo','metodo');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora','hora');
        $this->adicionaRelacionamento('parametros','parametros');
        $this->adicionaRelacionamento('obs','obs');
        $this->adicionaRelacionamento('agendamento','agendamento');
        $this->adicionaRelacionamento('intervalominuto','intervalominuto');
        
        $this->adicionaOrderBy('nr',1);
        $this->setSTop('200');
    }
}
