<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_PORT_CadVeiculos extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_PORT_CadVeiculos');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('placa', 'placa');
        $this->adicionaRelacionamento('datacad', 'datacad');
        $this->adicionaRelacionamento('usucod', 'usucod');
        $this->adicionaRelacionamento('usunome', 'usunome');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('modelo', 'modelo');
        $this->adicionaRelacionamento('cor', 'cor');
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');

        $this->adicionaOrderBy('nr', 1);
        $this->setSTop('50');
    }

    public function buscaPlaca($sPlaca) {

        $sPlaca = strtoupper($sPlaca);
        
        $sSql = "select placa from MET_PORT_CadVeiculos where placa = '" . $sPlaca . "'";
        $oPlacaCad = $this->consultaSql($sSql);

        if($oPlacaCad->placa == $sPlaca){
            return true;
        }else{
            return false;
        }
    }

}
