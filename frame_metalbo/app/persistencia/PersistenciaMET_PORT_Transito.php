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
        $this->adicionaRelacionamento('datacad', 'datacad');
        $this->adicionaRelacionamento('horaentra', 'horaentra');
        $this->adicionaRelacionamento('datasaida', 'datasaida');
        $this->adicionaRelacionamento('horasaida', 'horasaida');
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('motorista', 'motorista');
        $this->adicionaRelacionamento('documento', 'documento');
        $this->adicionaRelacionamento('fone', 'fone');
        $this->adicionaRelacionamento('setor', 'setor');
        $this->adicionaRelacionamento('motivo', 'motivo');
        $this->adicionaRelacionamento('descmotivo', 'descmotivo');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop(50);
    }

    public function consultaPlaca($sNrPlaca) {
        $sSql = "select empcod,empdes,descsetor,modelo,cor 
                from MET_PORT_CadVeiculos where placa ='" . $sNrPlaca . "'";
        $result = $this->getObjetoSql($sSql);
        $oRow = $result->fetch(PDO::FETCH_OBJ);

        return $oRow;
    }

    public function apontaSaida($aDados) {
        $sSql = "update MET_PORT_Transito set "
                . "horasaida = '" . $aDados['horasaida'] . "', "
                . "datasaida = '" . $aDados['datasaida'] . "', "
                . "situaca = 'Saída' "
                . "where filcgc = '" . $aDados['filcgc'] . "' and nr = '" . $aDados['nr'] . "'and placa ='" . $aDados['placa'] . "' ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
