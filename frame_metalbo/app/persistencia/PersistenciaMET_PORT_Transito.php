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
        $this->adicionaRelacionamento('modelo', 'modelo');
        $this->adicionaRelacionamento('cor', 'cor');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('emptranscod', 'emptranscod');
        $this->adicionaRelacionamento('emptransdes', 'emptransdes');
        $this->adicionaRelacionamento('datachegou', 'datachegou');
        $this->adicionaRelacionamento('horachegou', 'horachegou');
        $this->adicionaRelacionamento('dataentrou', 'dataentrou');
        $this->adicionaRelacionamento('horaentrou', 'horaentrou');
        $this->adicionaRelacionamento('datasaiu', 'datasaiu');
        $this->adicionaRelacionamento('horasaiu', 'horasaiu');
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('motorista', 'motorista');
        $this->adicionaRelacionamento('documento', 'documento');
        $this->adicionaRelacionamento('fone', 'fone');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('motivo', 'motivo');
        $this->adicionaRelacionamento('descmotivo', 'descmotivo');
        $this->adicionaRelacionamento('tipo', 'tipo');

        $this->adicionaFiltro('tipo', 'V');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop(50);
    }

    public function consultaPlaca($sNrPlaca) {
        $sSql = "select emptranscod,emptransdes,codsetor,descsetor,modelo,cor 
                from MET_PORT_CadVeiculos where placa ='" . $sNrPlaca . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    public function geraCadastro($oDados) {
        
        $sMotorista = Util::removeAcentos($oDados->getMotorista());
        $sMotorista = strtoupper($sMotorista);

        $sSql = "insert into MetExp_Carga("
                . "empcod,transp,dataent,horaent,placa,motorista,motcod,sitcod,pesotara,pesobruto,pesocarregado,pesodiver)"
                . "values('" . $oDados->getEmptranscod() . "',"
                . "'" . $oDados->getEmptransdes() . "',"
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

    public function apontaEntrada($aDados) {
        $sSql = "update MET_PORT_Transito set "
                . "horaentrou = '" . $aDados['horaentrou'] . "', "
                . "dataentrou = '" . $aDados['dataentrou'] . "', "
                . "situaca = 'Entrada' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "' and placa ='" . $aDados['placa'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        if ($aRetorno[0] == true && ($aDados['motivo'] == 1 || $aDados['motivo'] == 2)) {
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

        $sSqlIdCarga = "select idcarga from MetExp_Carga where empcod = '" . $oDados->emptranscod . "'
                and transp ='" . $oDados->emptransdes . "' 
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

}
