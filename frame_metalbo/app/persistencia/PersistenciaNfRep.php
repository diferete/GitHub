<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaNfRep extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.NFC001');
        $this->adicionaRelacionamento('nfsnfnro', 'nfsnfnro', true, true, true);
        $this->adicionaRelacionamento('nfsclicod', 'nfsclicod');
        $this->adicionaRelacionamento('nfsclinome', 'nfsclinome');
        $this->adicionaRelacionamento('nfsvlripi', 'nfsvlripi');
        $this->adicionaRelacionamento('nfsvlricm', 'nfsvlricm');
        $this->adicionaRelacionamento('nfsvlrpis', 'nfsvlrpis');
        $this->adicionaRelacionamento('nfsvlrcofi', 'nfsvlrcofi');
        $this->adicionaRelacionamento('nfsvlrsub', 'nfsvlrsub');
        $this->adicionaRelacionamento('nfspesobr', 'nfspesobr');
        $this->adicionaRelacionamento('nfsvlrtoti', 'nfsvlrtoti');
        $this->adicionaRelacionamento('nfsvlrtot', 'nfsvlrtot');
        $this->adicionaRelacionamento('nfsrepcod', 'nfsrepcod');
        $this->adicionaRelacionamento('nfsdtemiss', 'nfsdtemiss');
        $this->adicionaRelacionamento('pedido', 'pedido');
        $this->adicionaRelacionamento('nfstranome', 'nfstranome');
        $this->adicionaRelacionamento('nfshrsaida', 'nfshrsaida');
        $this->adicionaRelacionamento('nfscancela', 'nfscancela');
        $this->adicionaRelacionamento('nfsnfesit', 'nfsnfesit');
        $this->adicionaRelacionamento('nfsemailen', 'nfsemailen');

        $this->setBConsultaManual(true);
        $this->setSTop(10);
        $this->adicionaOrderBy('nfsnfnro', 1);
        $this->adicionaFiltro('nfscancela', '*', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);

        if (isset($_SESSION['repsoffice'])) {
            $aValor = explode(',', $_SESSION['repsoffice']);


            $this->adicionaFiltro('nfsrepcod', $aValor, 0, 9);
        }
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select top(20) widl.NFC001.nfsnfnro as 'widl.NFC001.nfsnfnro',
         widl.NFC001.nfsclicod as 'widl.NFC001.nfsclicod',
         widl.NFC001.nfsclinome as 'widl.NFC001.nfsclinome',
         widl.NFC001.nfsvlripi  as 'widl.NFC001.nfsvlripi',
         widl.NFC001.nfsvlricm as 'widl.NFC001.nfsvlricm',
         widl.NFC001.nfsvlrpis as 'widl.NFC001.nfsvlrpis', 
         widl.NFC001.nfsvlrcofi as 'widl.NFC001.nfsvlrcofi',
         widl.NFC001.nfsvlrsub as 'widl.NFC001.nfsvlrsub',
         widl.NFC001.nfspesobr as 'widl.NFC001.nfspesobr',
         widl.NFC001.nfsvlrtoti as 'widl.NFC001.nfsvlrtoti',
         widl.NFC001.nfsvlrtot as 'widl.NFC001.nfsvlrtot',
         widl.NFC001.nfsrepcod as 'widl.NFC001.nfsrepcod',
         widl.NFC001.nfsdtemiss as 'widl.NFC001.nfsdtemiss', 
        LTRIM((nfslei3 +''+nfslei2 +''+nfslei1))as 'widl.NFC001.pedido',
        widl.NFC001.nfstranome as 'widl.NFC001.nfstranome',
        widl.NFC001.nfshrsaida as 'widl.NFC001.nfshrsaida', 
        widl.NFC001.nfsnfesit as 'widl.NFC001.nfsnfesit',
        widl.NFC001.nfsemailen as 'widl.NFC001.nfsemailen'

        from widl.NFC001,widl.mov01 ";


        $sSqlWhere = " and widl.nfc001.nfsmovcod = widl.MOV01.movcod  
        and nfsfilcgc = '75483040000211'
        and widl.NFC001.nfsnfser = 2 ";
        $this->setSWhereManual($sSqlWhere);

        return $sSql;
    }

    public function buscaPed($sNf) {
        $sSql = "select RTRIM(nfsitpdvnr) as nfsitpdvnr from widl.NFC003 
        where nfsfilcgc = '75483040000211'
        and widl.NFC003.nfsnfser = 2 
        and widl.NFC003.nfsnfnro =" . $sNf . "
        group by nfsitpdvnr";

        $result = $this->getObjetoSql($sSql);
        $sPed = "";
        while ($oRow = $result->fetch(PDO::FETCH_OBJ)) {
            if (strlen($oRow->nfsitpdvnr) > 0) {
                $sPed = $sPed . ltrim($oRow->nfsitpdvnr) . ', ';
            }
        }
        $sRetorno = substr($sPed, 0, -2);
        return $sRetorno;
    }

    public function buscaTodasOd($sNf) {
        $sSql = "select RTRIM(pdvordcomp) as pdvordcomp "
                . "from widl.PEV01 "
                . "where pdvnro in("
                . "select distinct nfsitpdvnr "
                . "from widl.NFC003 "
                . "where nfsnfnro =" . $sNf . " "
                . "and nfsnfser = 2)";
        $result = $this->getObjetoSql($sSql);
        $sOd = "";
        while ($oRow = $result->fetch(PDO::FETCH_OBJ)) {
            if (strlen($oRow->pdvordcomp) > 0) {
                $sOd = $sOd . ltrim($oRow->pdvordcomp) . ', ';
            }
        }
        $sRetorno = substr($sOd, 0, -2);
        return $sRetorno;
    }

    public function buscaDadosNfRep($aCamposChave) {
        $sSql = 'select nfsnfesit, nfsnfechv, nfsdtemiss, nfsfilcgc from widl.NFC001 where nfsnfnro = ' . $aCamposChave['nfsnfnro'] . ' and nfsnfser = 2';
        $oDadosNF = $this->consultaSql($sSql);

        return $oDadosNF;
    }

}
