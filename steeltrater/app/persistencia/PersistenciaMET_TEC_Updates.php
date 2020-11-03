<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Updates extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_Updates');

        $this->adicionaRelacionamento('seq', 'seq', true, true);
        $this->adicionaRelacionamento('sequpdates', 'sequpdates', true, true, true);
        $this->adicionaRelacionamento('updates', 'updates');
        $this->adicionaRelacionamento('versao', 'versao');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('todos', 'todos');
        $this->adicionaRelacionamento('anexo', 'anexo');
        $this->adicionaRelacionamento('data_updates', 'data_updates');
        $this->adicionaRelacionamento('hora_updates', 'hora_updates');

        $this->adicionaOrderBy('sequpdates', 1);
    }

    public function getDadosVersoes() {
        $sSql = "select top 5 * from MET_TEC_Updates where codsetor in ('00','" . $_SESSION['codsetor'] . "') order by versao desc";
        $result = $this->getObjetoSql($sSql);
        $aArrSql = array();
        while ($oRow = $result->fetch(PDO::FETCH_OBJ)) {
            array_push($aArrSql, $oRow);
        }
        return $aArrSql;
    }

    public function getDadosVersao($aChave) {
        $sSql = "select versao from MET_TEC_Versao where seq = " . $aChave[0];
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);
        $sVersao = $oRow->versao;

        return $sVersao;
    }

}
