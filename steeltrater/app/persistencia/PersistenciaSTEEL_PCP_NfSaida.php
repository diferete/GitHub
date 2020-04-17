<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_PCP_NfSaida extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('NFS_NOTAFISCAL');
        $this->adicionaRelacionamento('NFS_NotaFiscalFilial', 'NFS_NotaFiscalFilial', true, true);
        $this->adicionaRelacionamento('NFS_NotaFiscalSeq', 'NFS_NotaFiscalSeq', true, true, true);
        $this->adicionaRelacionamento('NFS_NotaFiscalNumero', 'NFS_NotaFiscalNumero');
        $this->adicionaRelacionamento('NFS_NotaFiscalEmpEntDescricao', 'NFS_NotaFiscalEmpEntDescricao');
        $this->adicionaRelacionamento('NFS_NotaFiscalNfeSituacao', 'NFS_NotaFiscalNfeSituacao');
        $this->adicionaRelacionamento('NFS_NotaFiscalDataEmissao', 'NFS_NotaFiscalDataEmissao');

        $this->setSTop(75);
        $this->adicionaFiltro('NFS_NotaFiscalFilial', '8993358000174');


        $this->adicionaOrderBy('NFS_NotaFiscalDataEmissao', 1);
        $this->adicionaOrderBy('NFS_NotaFiscalSeq', 1);
    }

    public function buscaDadosNf($aCamposChave) {
        $sSql = 'select nfs_notafiscalnfesituacao, nfs_notafiscalnfechave, nfs_notafiscaldataemissao, nfs_notafiscalnumero from nfs_notafiscal where nfs_notafiscalfilial = ' . $aCamposChave['NFS_NotaFiscalFilial'] . ' and nfs_notafiscalseq = ' . $aCamposChave['NFS_NotaFiscalSeq'];
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
