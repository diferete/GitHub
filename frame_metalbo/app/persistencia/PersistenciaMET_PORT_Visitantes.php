<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_PORT_Visitantes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_PORT_Visitantes');


        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('datachegou', 'datachegou');
        $this->adicionaRelacionamento('horachegou', 'horachegou');
        $this->adicionaRelacionamento('dataentrou', 'dataentrou');
        $this->adicionaRelacionamento('horaentrou', 'horaentrou');
        $this->adicionaRelacionamento('datasaiu', 'datasaiu');
        $this->adicionaRelacionamento('horasaiu', 'horasaiu');
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('pessoa', 'pessoa');
        $this->adicionaRelacionamento('fone', 'fone');
        $this->adicionaRelacionamento('motivo', 'motivo');
        $this->adicionaRelacionamento('descmotivo', 'descmotivo');
        $this->adicionaRelacionamento('tipopessoa', 'tipopessoa');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('cpf', 'cpf');
        $this->adicionaRelacionamento('placa', 'placa');
        $this->adicionaRelacionamento('cracha', 'cracha');

        $this->adicionaOrderBy('nr', 1);

        $this->setSTop(50);
    }

    public function consultaCpf($aDados) {
        $sSql = "select empfant,fone"
                . " from MET_CAD_Cpf"
                . " where cpf = '" . $aDados['cpf'] . "'"
                . " and filcgc = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);

        return $oRetorno;
    }

    public function apontaEntrada($aDados) {
        $sSql = "update MET_PORT_Visitantes set "
                . "horaentrou = '" . $aDados['horaentrou'] . "', "
                . "dataentrou = '" . $aDados['dataentrou'] . "', "
                . "situaca = 'Entrada' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function apontaSaida($aDados) {
        $sSql = "update MET_PORT_Visitantes set "
                . "horasaiu = '" . $aDados['horasaiu'] . "', "
                . "datasaiu = '" . $aDados['datasaiu'] . "', "
                . "situaca = 'Saída' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaDadosUpdate($sDados) {
        $aChave = array();
        parse_str($sDados, $aChave);
        $sSql = "select datachegou,horachegou "
                . "from MET_PORT_Visitantes "
                . "where nr = '" . $aChave['nr'] . "' and filcgc ='" . $aChave['filcgc'] . "' ";
        $aDadosRegistro = $this->consultaSql($sSql);
        return $aDadosRegistro;
    }

    public function cadPlaca($oDados) {
        if ($oDados->getPlaca() == '') {
            return;
        } else {
            $sSql = "select COUNT(*) as total "
                    . "from MET_CAD_Placas "
                    . "where placa = '" . $oDados->getPlaca() . "'";
            $oRetPlaca = $this->consultaSql($sSql);

            if ($oRetPlaca->total >= 1) {
                return;
            } else {
                $sPlaca = strtoupper($oDados->getPlaca());
                $sSqlCadPlaca = "insert into MET_CAD_Placas("
                        . "filcgc,placa,empdes) "
                        . "values("
                        . "'" . $oDados->getFilcgc() . "',"
                        . "'" . $sPlaca . "',"
                        . "'" . $oDados->getEmpdes() . "')";
                $this->executaSql($sSqlCadPlaca);
            }
        }
    }

    public function cadCPF($oDados) {
        if ($oDados->getCpf() == '') {
            return;
        } else {
            $sSql = "select COUNT(*) as total "
                    . "from MET_CAD_Cpf "
                    . "where cpf = '" . $oDados->getCpf() . "'";
            $oRetCpf = $this->consultaSql($sSql);

            if ($oRetCpf->total >= 1) {
                return;
            } else {
                $sSqlCadCpf = "insert into MET_CAD_Cpf("
                        . "filcgc,cpf,empfant,fone,nome) "
                        . "values("
                        . "'" . $oDados->getFilcgc() . "',"
                        . "'" . $oDados->getCpf() . "',"
                        . "'" . $oDados->getEmpdes() . "',"
                        . "'" . $oDados->getFone() . "',"
                        . "'" . $oDados->getPessoa() . "')";
                $this->executaSql($sSqlCadCpf);
            }
        }
    }

    public function alteraHora($sValor, $sChave) {
        $sSql = "update MET_PORT_Visitantes set horachegou ='" . $sValor . "' where nr='" . $sChave . "'   ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function buscaHora($aDados) {
        $sSql = "select horachegou from MET_PORT_Visitantes where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $sRetorno = $this->consultaSql($sSql);

        return $sRetorno->horachegou;
    }

    public function excluirRegistro($aDados) {
        $sSqlDel = "delete from MET_PORT_Visitantes"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $aRetornaDel = $this->executaSql($sSqlDel);
        return $aRetornaDel;
    }

    public function buscaSituaca($aDados) {
        $sSql = "select situaca from MET_PORT_Visitante where nr = '" . $aDados['nr'] . "' and filcgc = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno->situaca;
    }

}
