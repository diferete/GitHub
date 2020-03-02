<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_LogXml extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_LogXml');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true);
        $this->adicionaRelacionamento('nf', 'nf', true);
        $this->adicionaRelacionamento('datalog', 'datalog');
        $this->adicionaRelacionamento('horalog', 'horalog');
        $this->adicionaRelacionamento('logxml', 'logxml');
        $this->adicionaRelacionamento('tipolog', 'tipolog');
    }

    public function carregaLogXml($aDados) {
        $sSql = "select logxml from MET_TEC_LogXml where filcgc =" . $aDados['filcgc'] . " and nf = " . $aDados['nf'];
        $oLogXml = $this->consultaSql($sSql);
        return $oLogXml->logxml;
    }

}
