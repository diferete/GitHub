<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_TEC_Chamados extends Persistencia {

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


        $this->setSTop('50');
        $this->adicionaOrderBy('nr', 1);
    }

    public function buscaDadosChamado($aDados) {
        $sSql = "select * from MET_TEC_Chamados where filcgc = '" . $aDados['filcgc'] . "' and usucod = '" . $aDados['usucod'] . "' and setor = '" . $aDados['setor'] . "' and datacad = '" . $aDados['datacad'] . "' and horacad = '" . $aDados['horacad'] . "' and tipo = '" . $aDados['tipo'] . "' and subtipo = '" . $aDados['subtipo'] . "' and problema = '" . $aDados['problema'] . "'";
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function buscaDadosEmailChamado($aDados) {
        $sSql = "select * from MET_TEC_Chamados where nr = '" . $aDados['nr'] . "' and filcgc = '" . $aDados['filcgc'] . "'";
        $oDados = $this->consultaSql($sSql);

        $sSqlEmail = "select usuemail from MET_TEC_usuario where usucodigo = " . $oDados->usucod;
        $oConsulta = $this->consultaSql($sSqlEmail);
        $oDados->email = $oConsulta->usuemail;

        return $oDados;
    }

    public function buscaProblema($aDados) {
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

    public function somaSit() {
        $sSql = "select COUNT(*) as cont from MET_TEC_Chamados where situaca = 'AGUARDANDO'";
        $oRow = $this->consultaSql($sSql);
        $sTotalAg = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_TEC_Chamados where situaca = 'INICIADO'";
        $oRow = $this->consultaSql($sSql);
        $sTotalIni = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_TEC_Chamados where situaca = 'FINALIZADO'";
        $oRow = $this->consultaSql($sSql);
        $sTotalFim = $oRow->cont;

        $sSql = "select COUNT(*) as cont from MET_TEC_Chamados where situaca = 'CANCELADO'";
        $oRow = $this->consultaSql($sSql);
        $sTotalCanc = $oRow->cont;

        $aTotal['AGUARDANDO'] = $sTotalAg;
        $aTotal['INICIADO'] = $sTotalIni;
        $aTotal['FINALIZADO'] = $sTotalFim;
        $aTotal['CANCELADO'] = $sTotalCanc;

        return $aTotal;
    }

    public function buscaDadosRep() {

        $sSql = "select repoffice from  MET_TEC_Chamados where repoffice is not null  group by repoffice";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

    public function buscaDadosUsuario() {

        $sSql = "select usucod, usunome from MET_TEC_Chamados where usunome is not null  group by usucod, usunome";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

    public function buscaDadosEmp() {

        $sSql = "select filcgc, empdes from MET_TEC_Chamados left outer join widl.emp01 on MET_TEC_Chamados.filcgc = widl.emp01.empcod group by filcgc, empdes";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

    public function buscaDadosSubTipo() {

        $sSql = "select subtipo_nome from MET_TEC_Chamados where subtipo_nome is not null  group by subtipo_nome";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

}
