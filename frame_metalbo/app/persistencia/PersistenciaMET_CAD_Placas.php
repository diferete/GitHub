<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_CAD_Placas extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_CAD_Placas');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('placa', 'placa', true, true);
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('cracha', 'cracha');
        $this->adicionaRelacionamento('nome', 'nome');
        $this->adicionaRelacionamento('dataCad', 'dataCad');
        $this->adicionaRelacionamento('horaCad', 'horaCad');
        $this->adicionaRelacionamento('nomeCad', 'nomeCad');
        $this->adicionaRelacionamento('codNomeCad', 'codNomeCad');

        $this->adicionaOrderBy('placa');
        
        $this->setSTop(100);
    }

    public function buscaPlaca($sPlaca) {

        $sPlaca = strtoupper($sPlaca);

        $sSql = "select placa from MET_CAD_Placas where placa = '" . $sPlaca . "'";
        $oPlacaCad = $this->consultaSql($sSql);

        if ($oPlacaCad->placa == $sPlaca) {
            return true;
        } else {
            return false;
        }
    }

    public function consultaCracha($aDados) {
        $sSql = "select nomfun"
                . " from tbfunc"
                . " where numcad = '" . $aDados['cracha'] . "'";
        $oRetorno = $this->consultaSql($sSql);

        return $oRetorno;
    }

}
