<?php

/*
 * * Implementa classe persistencia
 * 
 * @author Otávio V. Prada
 * @since 09/03/2022
 *  */

class PersistenciaMET_MP_ManutHistorico extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmanuthistorico');

        $this->adicionaRelacionamento('id', 'id', true);
        $this->adicionaRelacionamento('usersistcod', 'usersistcod');
        $this->adicionaRelacionamento('usersistdes', 'usersistdes');
        $this->adicionaRelacionamento('codmaquina', 'codmaquina');
        $this->adicionaRelacionamento('codmaquina', 'MET_MP_Maquinas.cod', false, false, false);
        $this->adicionaRelacionamento('maquina', 'MET_MP_Maquinas.maquina', false, false, false);
        $this->adicionaRelacionamento('horasmaq', 'horasmaq');
        $this->adicionaRelacionamento('horasmaqant', 'horasmaqant');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('datahora', 'datahora');

        $this->adicionaOrderBy('id', 1);
        $this->adicionaOrderBy('codmaquina', 1);
        
        $this->adicionaJoin('MET_MP_Maquinas', null, 1, 'codmaquina', 'cod');

        $this->setSTop('50');
    }

}
