<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_PORT_Colaboradores extends Persistencia {

    public function __construct() {
        parent::__construct();


        $this->setTabela('MET_PORT_Colaboradores');


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
        $this->adicionaRelacionamento('cracha', 'cracha');
        $this->adicionaRelacionamento('respcracha', 'respcracha');
        $this->adicionaRelacionamento('respnome', 'respnome');
        $this->adicionaRelacionamento('placa', 'placa');

        $this->adicionaOrderBy('nr', 1);

        $this->setSTop(50);
    }

    public function consultaCracha($aDados) {
        $sSql = "select nome,sobrenome"
                . " from MetCad_User"
                . " where cracha = '" . $aDados['cracha'] . "'"
                . " and empcnpj = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);

        $aDadosUser = array();
        $aDadosUser[0] = $oRetorno->nome . ' ' . $oRetorno->sobrenome;

        return $aDadosUser;
    }

    public function apontaEntrada($aDados) {
        $sSql = "update MET_PORT_Colaboradores set "
                . "horaentrou = '" . $aDados['horaentrou'] . "', "
                . "dataentrou = '" . $aDados['dataentrou'] . "', "
                . "situaca = 'Entrada' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' and cracha ='" . $aDados['cracha'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function apontaSaida($aDados) {
        $sSql = "update MET_PORT_Colaboradores set "
                . "horasaiu = '" . $aDados['horasaiu'] . "', "
                . "datasaiu = '" . $aDados['datasaiu'] . "', "
                . "situaca = 'Saída' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' and cracha ='" . $aDados['cracha'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaDadosUpdate($sDados) {
        $aChave = array();
        parse_str($sDados, $aChave);
        $sSql = "select datachegou,horachegou "
                . "from MET_PORT_Colaboradores "
                . "where nr = '" . $aChave['nr'] . "' and filcgc ='" . $aChave['filcgc'] . "' ";
        $aDadosRegistro = $this->consultaSql($sSql);
        return $aDadosRegistro;
    }

    public function cadPlaca($oDados) {
        $sSql = "select COUNT(*) as total "
                . "from MET_CAD_Placas "
                . "where placa = '" . $oDados->getPlaca() . "'";
        $sRetPlaca = $this->consultaSql($sSql);

        if ($sRetPlaca->total >= 1) {
            return;
        } else {
            $sPlaca = strtoupper($oDados->getPlaca());
            $sSqlCadPlaca = "insert into MET_CAD_Placas("
                    . "filcgc,placa,nome,cracha,empcod,empdes) "
                    . "values("
                    . "'" . $oDados->getFilcgc() . "',"
                    . "'" . $sPlaca . "',"
                    . "'" . $oDados->getPessoa() . "',"
                    . "'" . $oDados->getCracha() . "',"
                    . "'" . $oDados->getFilcgc() . "',"
                    . "'" . $oDados->getEmpdes() . "')";
            $this->executaSql($sSqlCadPlaca);
        }
    }

}
