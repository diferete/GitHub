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
        $this->adicionaRelacionamento('emptranscod', 'emptranscod');
        $this->adicionaRelacionamento('emptransdes', 'emptransdes');
        $this->adicionaRelacionamento('codsetor', 'codsetor');
        $this->adicionaRelacionamento('descsetor', 'descsetor');
        $this->adicionaRelacionamento('cracha', 'cracha');
        $this->adicionaRelacionamento('pessoa', 'pessoa');

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
    
    public function consultaCracha($aDados) {
        $sSql = "select nome,sobrenome,codsetor"
                . " from MetCad_User"
                . " where cracha = '" . $aDados['cracha'] . "'"
                . " and empcnpj = '" . $aDados['filcgc'] . "'";
        $oRetorno = $this->consultaSql($sSql);

        $aDadosUser = array();
        $aDadosUser[0] = $oRetorno->nome . ' ' . $oRetorno->sobrenome;
        $aDadosUser[1] = $oRetorno->codsetor;

        $sSqlSetor = "select descsetor from MetCad_Setores"
                . " where codsetor = '" . $aDadosUser[1] . "'";
        $oRetornoSetor = $this->consultaSql($sSqlSetor);

        $aDadosUser[2] = $oRetornoSetor->descsetor;
        return $aDadosUser;
    }

}
