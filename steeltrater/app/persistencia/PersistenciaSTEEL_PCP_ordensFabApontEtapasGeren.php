<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class PersistenciaSTEEL_PCP_ordensFabApontEtapasGeren extends Persistencia{
    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_ordensFabApont');

        $this->adicionaRelacionamento('op', 'op', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true,true);
        $this->adicionaRelacionamento('fornocod', 'fornocod');
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('procod', 'procod');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('dataent_forno', 'dataent_forno');
        $this->adicionaRelacionamento('horaent_forno', 'horaent_forno');
        $this->adicionaRelacionamento('datasaida_forno', 'datasaida_forno');
        $this->adicionaRelacionamento('horasaida_forno', 'horasaida_forno');
        $this->adicionaRelacionamento('situacao','situacao');
        $this->adicionaRelacionamento('coduser','coduser');
        $this->adicionaRelacionamento('usernome','usernome');
        $this->adicionaRelacionamento('codusersaida','codusersaida');
        $this->adicionaRelacionamento('usernomesaida','usernomesaida');
        $this->adicionaRelacionamento('turnoSteel', 'turnoSteel');
        $this->adicionaRelacionamento('turnoSteelSaida','turnoSteelSaida');
        $this->adicionaRelacionamento('corrida', 'corrida');
        $this->adicionaRelacionamento('processoativo', 'processoativo');
        
        

        $this->setSTop('500');
        $this->adicionaOrderBy('seq', 1);
    }
}