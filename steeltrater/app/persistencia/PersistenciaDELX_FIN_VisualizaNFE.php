<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaDELX_FIN_VisualizaNFE extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.NFC001');
        $this->adicionaRelacionamento('nfsfilcgc', 'nfsfilcgc', true, true);
        $this->adicionaRelacionamento('nfsnfser', 'nfsnfser', true);
        $this->adicionaRelacionamento('nfsnfnro', 'nfsnfnro', true, true);
        $this->adicionaRelacionamento('nfsnfechv', 'nfsnfechv');
        $this->adicionaRelacionamento('nfsdtemiss', 'nfsdtemiss');
        $this->adicionaRelacionamento('nfsclicgc', 'nfsclicgc');
        $this->adicionaRelacionamento('nfsclinome', 'nfsclinome');
        $this->adicionaRelacionamento('nfsemailen', 'nfsemailen');
        $this->adicionaRelacionamento('nfsnfesit', 'nfsnfesit');
        $this->adicionaRelacionamento('nfsmovcod', 'nfsmovcod');
        $this->adicionaRelacionamento('nfshrsaida', 'nfshrsaida');


        $this->adicionaFiltro('nfsfilcgc', '75483040000211');
        $this->adicionaFiltro('nfsclicgc', '8993358000174');
        $aTipoMov = array();
        $aTipoMov[0] = '5';
        $aTipoMov[1] = '13';
        $aTipoMov[2] = '138';
        $this->adicionaFiltro('nfsmovcod', $aTipoMov, 0, 9);
        $this->adicionaFiltro('nfsnfesit', 'A');
        $this->adicionaOrderBy('nfsdtemiss', 1);
        $this->adicionaOrderBy('nfsnfnro', 1);
        $this->setSTop(75);
        $this->setBNoLock(true);
    }

    public function buscaDadosNf($aCamposChave) {
        $sSql = 'select nfsnfesit, nfsnfechv, nfsdtemiss from rex_maquinas.widl.NFC001 where  nfsnfnro = ' . $aCamposChave['nfsnfnro'];
        $oDadosNF = $this->consultaSql($sSql);

        return $oDadosNF;
    }

    public function somaSit() {
        $sSql = "select COUNT(*) as cont from WIDL.NFC001 where nfsemailen <> 'S' and nfsdtemiss between '" . date('d/m/Y') . "' and '" . date('d/m/Y') . "' and nfsfilcgc = '" . $_SESSION['filcgc'] . "'";
        $oRow = $this->consultaSql($sSql);
        $sNEnvi = $oRow->cont;

        $sSql = "select COUNT(*) as cont from WIDL.NFC001 where nfsemailen = 'S' and nfsdtemiss between '" . date('d/m/Y') . "' and '" . date('d/m/Y') . "' and nfsfilcgc = '" . $_SESSION['filcgc'] . "'";
        $oRow = $this->consultaSql($sSql);
        $sEnv = $oRow->cont;

        $sSql = "select COUNT(*) as cont from WIDL.NFC001 where nfsnfesit <> 'A' and nfsdtemiss between '" . date('d/m/Y') . "' and '" . date('d/m/Y') . "' and nfsfilcgc = '" . $_SESSION['filcgc'] . "'";
        $oRow = $this->consultaSql($sSql);
        $sNAut = $oRow->cont;

        $aTotal['enviado'] = $sEnv;
        $aTotal['nenviado'] = $sNEnvi - $sNAut;
        $aTotal['nautorizada'] = $sNAut;

        return $aTotal;
    }

}
