<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_PORT_Transito extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_PORT_Transito');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('placa', 'placa');
        $this->adicionaRelacionamento('placacarr1', 'placacarr1');
        $this->adicionaRelacionamento('placacarr2', 'placacarr2');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('datachegou', 'datachegou');
        $this->adicionaRelacionamento('horachegou', 'horachegou');
        $this->adicionaRelacionamento('dataentrou', 'dataentrou');
        $this->adicionaRelacionamento('horaentrou', 'horaentrou');
        $this->adicionaRelacionamento('datasaiu', 'datasaiu');
        $this->adicionaRelacionamento('horasaiu', 'horasaiu');
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('motorista', 'motorista');
        $this->adicionaRelacionamento('cpf', 'cpf');
        $this->adicionaRelacionamento('fone', 'fone');
        $this->adicionaRelacionamento('motivo', 'motivo');
        $this->adicionaRelacionamento('descmotivo', 'descmotivo');
        $this->adicionaRelacionamento('tipo', 'tipo');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop(75);
    }

    public function consultaPlaca($sNrPlaca) {
        $sSql = "select empcod,empdes from MET_CAD_Placas where placa ='" . $sNrPlaca . "'";
        $oRow = $this->consultaSql($sSql);

        return $oRow;
    }

    public function cadPlaca($oDados) {
        $aPlacas = array();

        $aPlacas[0] = $oDados->getPlaca();
        if ($oDados->getPlacacarr1() != '') {
            array_push($aPlacas, strtoupper($oDados->getPlacacarr1()));
        }
        if ($oDados->getPlacacarr2() != '') {
            array_push($aPlacas, strtoupper($oDados->getPlacacarr2()));
        }

        foreach ($aPlacas as $key => $sPlaca) {

            $sSql = "select COUNT(*) as total "
                    . "from MET_CAD_Placas "
                    . "where placa = '" . $sPlaca . "' and empcod <>'' and empdes <>''";
            $sRetPlaca = $this->consultaSql($sSql);

            switch ($sRetPlaca) {
                case $sRetPlaca->total >= '1':
                    break;
                default:

                    $sSqlCadPlaca = "insert into MET_CAD_Placas("
                            . "filcgc,placa,empcod,empdes) "
                            . "values("
                            . "'" . $oDados->getFilcgc() . "',"
                            . "'" . $sPlaca . "',"
                            . "'" . $oDados->getEmpcod() . "',"
                            . "'" . $oDados->getEmpdes() . "')";
                    $this->executaSql($sSqlCadPlaca);
                    break;
            }
        }
    }

    public function consultaCpf($aDados) {
        $sSql = "select fone"
                . " from MET_CAD_Cpf"
                . " where cpf = '" . $aDados['cpf'] . "'"
                . " and filcgc = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);

        return $oRetorno;
    }

    public function cadCPF($oDados) {
        $sSql = "select COUNT(*) as total "
                . "from MET_CAD_Cpf "
                . "where cpf = '" . $oDados->getCpf() . "' and empfant <>'' and fone <>'' and nome <>''";
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
                    . "'" . $oDados->getMotorista() . "')";
            $this->executaSql($sSqlCadCpf);
        }
    }

    public function geraCadastro($oDados) {
        $sMotorista = Util::removeAcentos($oDados->getMotorista());
        $sMotorista = strtoupper($sMotorista);

        $sSql = "insert into MetExp_Carga("
                . "empcod,transp,dataent,horaent,placa,motorista,motcod,sitcod,pesotara,pesobruto,pesocarregado,pesodiver)"
                . "values('" . $oDados->getEmpcod() . "',"
                . "'" . $oDados->getEmpdes() . "',"
                . "'" . $oDados->getDatachegou() . "',"
                . "'" . $oDados->getHorachegou() . "',"
                . "'" . $oDados->getPlaca() . "',"
                . "'" . $sMotorista . "',"
                . "'" . $oDados->getMotivo() . "',"
                . "'1',"
                . "'0,00',"
                . "'0,00',"
                . "'0,00',"
                . "'0,00'"
                . ")";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function updateCadastro($oDados) {

        $sSqlDados = "select * from MET_PORT_Transito"
                . " where filcgc = '" . $oDados->getFilcgc() . "' and nr = '" . $oDados->getNr() . "'";
        $oDadosConsulta = $this->consultaSql($sSqlDados);

        $sSqlIdCarga = "select idcarga from MetExp_Carga where empcod = '" . $oDadosConsulta->empcod . "'
                and transp ='" . $oDadosConsulta->empdes . "' 
                and dataent = '" . $oDadosConsulta->datachegou . "'
                and horaent = '" . $oDadosConsulta->horachegou . "'
                and placa = '" . $oDadosConsulta->placa . "'
                and pesotara  = '0,00'
                and pesobruto  = '0,00' 
                and pesocarregado = '0,00'";
        $oIdCarga = $this->consultaSql($sSqlIdCarga);

        $sMotorista = Util::removeAcentos($oDados->getMotorista());
        $sMotorista = strtoupper($sMotorista);

        if ($oIdCarga == false) {
            $aRetorno = $this->geraCadastro($oDados);
            return $aRetorno;
        } else {
            $sSqlSit = "select sitcod from MetExp_Carga "
                    . "where idcarga = '" . $oIdCarga->idcarga . "' ";
            $oSit = $this->consultaSql($sSqlSit);

            if ($oSit->sitcod == '1') {

                $sSql = "update MetExp_Carga set "
                        . "empcod ='" . $oDados->getEmpcod() . "', "
                        . "transp ='" . $oDados->getEmpdes() . "', "
                        . "placa ='" . $oDados->getPlaca() . "', "
                        . "motorista ='" . $sMotorista . "', "
                        . "motcod ='" . $oDados->getMotivo() . "' "
                        . "where idcarga = '" . $oIdCarga->idcarga . "'";
                $aRetorno = $this->executaSql($sSql);
            } else {
                return true;
            }
            return $aRetorno;
        }
    }

    public function apontaEntrada($aDados) {
        $sSql = "update MET_PORT_Transito set "
                . "horaentrou = '" . $aDados['horaentrou'] . "', "
                . "dataentrou = '" . $aDados['dataentrou'] . "', "
                . "situaca = 'Entrada' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' and placa ='" . $aDados['placa'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        if ($aRetorno[0] == true && $aDados['motivo'] == 1) {
            $aRetorno = $this->updateLiberaBalanca($aDados);
            if ($aRetorno) {
                $aRetorno = true;
            } else {
                $aRetorno = false;
            }
        }
        return $aRetorno;
    }

    public function updateLiberaBalanca($aDados) {
        $sSqlDados = "select * from MET_PORT_Transito"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'and placa ='" . $aDados['placa'] . "'";
        $oDados = $this->consultaSql($sSqlDados);

        $sSqlIdCarga = "select idcarga from MetExp_Carga where empcod = '" . $oDados->empcod . "'
                and transp ='" . $oDados->empdes . "' 
                and dataent = '" . $oDados->datachegou . "'
                and horaent = '" . $oDados->horachegou . "'
                and placa = '" . $oDados->placa . "'
                and pesotara  = '0,00'
                and pesobruto  = '0,00' 
                and pesocarregado = '0,00'";
        $oIdCarga = $this->consultaSql($sSqlIdCarga);

        $sSqlUpdateEntrada = "update MetExp_Carga set "
                . "sitcod = '2' "
                . "where idcarga = '" . $oIdCarga->idcarga . "'";
        $aRetornaUpdate = $this->executaSql($sSqlUpdateEntrada);

        return $aRetornaUpdate;
    }

    public function apontaSaida($aDados) {
        $sSql = "update MET_PORT_Transito set "
                . "horasaiu = '" . $aDados['horasaiu'] . "', "
                . "datasaiu = '" . $aDados['datasaiu'] . "', "
                . "situaca = 'Saída' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'and placa ='" . $aDados['placa'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function buscaHora($aDados) {
        $sSql = "select horachegou from MET_PORT_Transito where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $sRetorno = $this->consultaSql($sSql);

        return $sRetorno->horachegou;
    }

    public function alteraHora($sValor, $aCamposChave) {
        $dHoje = date('Y-m-d');

        $sSqlDados = "select * from MET_PORT_Transito"
                . " where nr = '" . $aCamposChave['nr'] . "'";
        $oDados = $this->consultaSql($sSqlDados);

        if ($oDados->datachegou == $dHoje) {
            $sIdCarga = $this->buscaIdcarga($aCamposChave);

            if ($sIdCarga != null && $sIdCarga != '') {
                $sSql = "update MET_PORT_Transito set horachegou ='" . $sValor . "' where nr='" . $aCamposChave['nr'] . "'";
                $aRetorno = $this->executaSql($sSql);
                if ($aRetorno) {
                    $sSqlHoraCarga = "update MetExp_Carga set horaent ='" . $sValor . "' where idcarga='" . $sIdCarga . "'";
                    $this->executaSql($sSqlHoraCarga);
                }
            } else {
                $sSql = "update MET_PORT_Transito set horachegou ='" . $sValor . "' where nr='" . $aCamposChave['nr'] . "'";
                $aRetorno = $this->executaSql($sSql);
            }
        } else {
            $aRetorno = false;
        }
        return $aRetorno;
    }

    public function excluirRegistro($aDados) {
        $sIdCarga = $this->buscaIdcarga($aDados);

        $sSql = "select sitcod from MetExp_Carga "
                . "where idcarga = '" . $sIdCarga . "'";
        $oDadosCarga = $this->consultaSql($sSql);

        if ($sIdCarga == false) {
            $sSqlDel = "delete from MET_PORT_Transito"
                    . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
            $aRetornaDel = $this->executaSql($sSqlDel);
            return $aRetornaDel;
        } else {
            if ($oDadosCarga->sitcod == '1') {
                $sSqlDeletaBalanca = "delete from MetExp_Carga "
                        . "where idcarga = '" . $sIdCarga . "'";
                $aRetornaDeletaBalanca = $this->executaSql($sSqlDeletaBalanca);

                if ($aRetornaDeletaBalanca[0] == true) {
                    $sSqlDel = "delete from MET_PORT_Transito"
                            . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
                    $aRetornaDel = $this->executaSql($sSqlDel);
                    return $aRetornaDel;
                } else {
                    return $aRetornaDeletaBalanca;
                }
            } else {
                $sSqlDel = "delete from MET_PORT_Transito"
                        . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
                $aRetornaDel = $this->executaSql($sSqlDel);
                return $aRetornaDel;
            }
        }
    }

    public function buscaIdcarga($aDados) {
        $sSqlDados = "select * from MET_PORT_Transito"
                . " where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'";
        $oDados = $this->consultaSql($sSqlDados);

        $sSqlIdCarga = "select idcarga from MetExp_Carga where empcod = '" . $oDados->empcod . "'
                and transp ='" . $oDados->empdes . "' 
                and dataent = '" . $oDados->datachegou . "'
                and horaent = '" . $oDados->horachegou . "'
                and placa = '" . $oDados->placa . "'
                and pesotara  = '0,00'
                and pesobruto  = '0,00' 
                and pesocarregado = '0,00'";
        $oIdCarga = $this->consultaSql($sSqlIdCarga);

        return $oIdCarga->idcarga;
    }

    public
            function buscaSituaca($aDados) {
        $sSql = "select situaca from MET_PORT_Transito where nr = '" . $aDados['nr'] . "' and filcgc = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno->situaca;
    }

}
