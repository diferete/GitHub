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


        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('datacad', 'datacad');
        $this->adicionaRelacionamento('horacad', 'horacad');
        $this->adicionaRelacionamento('repoffice', 'repoffice');
        $this->adicionaRelacionamento('setor', 'setor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
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
        $this->adicionaRelacionamento('anexofim', 'anexofim');
        $this->adicionaRelacionamento('previsao', 'previsao');
        $this->adicionaRelacionamento('dias', 'dias');


        $this->setSTop(50);
        if ($_SESSION['codsetor'] != 2) {
            $this->adicionaFiltro('setor', $_SESSION['codsetor']);
        }
        if ($_SESSION['filcgc'] != '75483040000211') {
            $this->adicionaFiltro('filcgc', $_SESSION['filcgc']);
        }
        if ($_SESSION['repoffice'] != '') {
            $this->adicionaFiltro('repoffice', $_SESSION['repofficedes']);
        }
        $this->adicionaOrderBy('nr', 1);
        $this->adicionaOrderBy('datacad', 1);
    }

    public function updateTempoRestante() {

        $sSql = "select filcgc, nr, datainicio, previsao from MET_TEC_Chamados where situaca = 'INICIADO' ";
        $sth = $this->getObjetoSql($sSql);
        while ($aChamado = $sth->fetch(PDO::FETCH_ASSOC)) {
            date_default_timezone_set('America/Sao_Paulo');
            
            $hoje = date_create(date('Y-m-d'));
            $inicio = date_create($aChamado['datainicio']);
            $previsao = date_create($aChamado['previsao']);
            
            $intervaloPrevisao = date_diff($inicio, $previsao);
            $intervaloAtual = date_diff($hoje, $previsao);
            $diasPrevisao = $intervaloPrevisao->format('%a');
            $diasAtual = $intervaloAtual->format('%a');

            if ($diasAtual > $diasPrevisao) {
                $dias = '-' . $diasAtual;
            } else {
                $dias = $diasAtual;
            }

            $sSqlUpdate = "update MET_TEC_Chamados set dias = " . $dias . " where nr = " . $aChamado['nr'] . " and filcgc = " . $aChamado['filcgc'] . "";
            $debug = $this->executaSql($sSqlUpdate);
        }
    }

    public function buscaDadosChamado($aDados) {
        $sSql = "select * from MET_TEC_Chamados where filcgc = '" . $aDados['filcgc'] . "' and usucod = '" . $aDados['usucod'] . "' and setor = '" . $aDados['setor'] . "' and datacad = '" . $aDados['datacad'] . "' and horacad = '" . $aDados['horacad'] . "' and tipo = '" . $aDados['tipo'] . "' and subtipo = '" . $aDados['subtipo'] . "' and problema = '" . $aDados['problema'] . "'";
        $oDados = $this->consultaSql($sSql);
        return $oDados;
    }

    public function buscaDadosEmailChamado($aDados) {
        $sSql = "select * from MET_TEC_Chamados where nr = '" . $aDados['nr'] . "' and filcgc = '" . $aDados['filcgc'] . "'";
        $oDados = $this->consultaSql($sSql);

        if ($oDados->repoffice == 'METALBOF') {
            return false;
        } else {
            $sSqlEmail = "select usuemail from tbusuario where usucodigo = " . $oDados->usucod;
            $oConsulta = $this->consultaSql($sSqlEmail);
            $oDados->email = $oConsulta->usuemail;
        }

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
                . " previsao = '" . $aDados['previsao'] . "',"
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
                . " anexofim = '" . $aDados['anexofim'] . "',"
                . " tempo = '" . $aDados['tempo'] . "',"
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
                . " anexofim = '" . $aDados['anexofim'] . "',"
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

    public function buscaDadosSetores() {

        $sSql = "select codsetor,descsetor from MetCad_Setores order by codsetor";
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

        $sSql = "select filcgc, empdes from MET_TEC_Chamados "
                . "left outer join widl.emp01 "
                . "on MET_TEC_Chamados.filcgc = widl.emp01.empcod "
                . "group by filcgc, empdes";
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
