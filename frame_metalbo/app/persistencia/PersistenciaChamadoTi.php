<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaChamadoTi extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_TEC_Chamados');


        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome ', 'usunome');
        $this->adicionaRelacionamento('datacad', 'datacad');
        $this->adicionaRelacionamento('horacad', 'horacad');
        $this->adicionaRelacionamento('repoffice', 'repoffice');
        $this->adicionaRelacionamento('setor', 'setor');
        $this->adicionaRelacionamento('tipo', 'tipo');
        $this->adicionaRelacionamento('subtipo ', 'subtipo');
        $this->adicionaRelacionamento('subtipo_nome', 'subtipo_nome');
        $this->adicionaRelacionamento('problema', 'problema');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('usunomeinicio', 'usunomeinicio');
        $this->adicionaRelacionamento('usunomefim', 'usunomefim');
        $this->adicionaRelacionamento('datainicio', 'datainicio');
        $this->adicionaRelacionamento('horainicio', 'horainicio');
        $this->adicionaRelacionamento('datafim', 'datafim');
        $this->adicionaRelacionamento('horafim', 'horafim');
        $this->adicionaRelacionamento('obsfim', 'obsfim');
        $this->adicionaRelacionamento('anexo1', 'anexo1');
        $this->adicionaRelacionamento('anexo2', 'anexo2');
        $this->adicionaRelacionamento('anexo3', 'anexo3');


        if ($_SESSION['codsetor'] != 2 || $_SESSION['filcgc'] != '75483040000211' || $_SESSION['repoffice'] != '') {
            $this->adicionaFiltro('setor', $_SESSION['codsetor']);
            $this->adicionaFiltro('filcgc', $_SESSION['filcgc']);
            $this->adicionaFiltro('repoffice', $_SESSION['repofficedes']);
        }

        $this->setSTop('50');
        $this->adicionaOrderBy('nr', 1);
    }

    public function buscaDadosChamado($aDados) {
        $sSql = 'select * from MET_TEC_Chamados where nr = ' . $aDados['nr'] . ' and filcgc = ' . $aDados['filcgc'];
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function iniciaChamado($aDados) {
        $sSql = "update MET_TEC_Chamados set situaca = 'INICIADO',"
                . " datainicio = '" . $aDados['datainicio'] . "',"
                . " horainicio = '" . $aDados['horainicio'] . "',"
                . " usunomeinicio = '" . $aDados['usunomeinicio'] . "'"
                . " where nr = " . $aDados['nr'] . " and filcgc = " . $aDados['filcgc'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function finalizaChamado($aDados) {
        $sSql = "update MET_TEC_Chamados set situaca = 'FINALIZADO',"
                . " datafim = '" . $aDados['datafim'] . "',"
                . " horafim = '" . $aDados['horafim'] . "',"
                . " obsfim = '" . $aDados['obsfim'] . "',"
                . " usunomefim = '" . $aDados['usunomefim'] . "'"
                . " where nr = " . $aDados['nr'] . " and filcgc = " . $aDados['filcgc'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function cancelaChamado($aDados) {
        $sSql = "update MET_TEC_Chamados set situaca = 'CANCELADO',"
                . " datafim = '" . $aDados['datafim'] . "',"
                . " horafim = '" . $aDados['horafim'] . "',"
                . " obsfim = '" . $aDados['obsfim'] . "',"
                . " usunomefim = '" . $aDados['usunomefim'] . "'"
                . " where nr = " . $aDados['nr'] . " and filcgc = " . $aDados['filcgc'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
