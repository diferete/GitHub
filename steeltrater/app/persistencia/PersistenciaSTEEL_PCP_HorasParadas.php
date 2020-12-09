<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_HorasParadas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('STEEL_PCP_HorasParadas');

        $this->adicionaRelacionamento('fornocod', 'fornocod', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('fornodes', 'fornodes');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('dataini', 'dataini');
        $this->adicionaRelacionamento('horaini', 'horaini');
        $this->adicionaRelacionamento('datafim', 'datafim');
        $this->adicionaRelacionamento('horafim', 'horafim');        
        $this->adicionaRelacionamento('codmotivo', 'codmotivo');
        $this->adicionaRelacionamento('motivo', 'motivo');
        $this->adicionaRelacionamento('tempoparada', 'tempoparada');
        $this->adicionaRelacionamento('horasparadas', 'horasparadas');

        $this->adicionaOrderBy('seq', 1);
    }

    public function buscaForno($aChave) {
        $sSql = "select fornodes from steel_pcp_forno where fornocod = " . $aChave[0];
        $oDados = $this->consultaSql($sSql);
        return $oDados->fornodes;
    }

}
