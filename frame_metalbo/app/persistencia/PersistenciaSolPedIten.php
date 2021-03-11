<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSolPedIten extends Persistencia {

    public function __construct() {
        parent::__construct();

        if ($_SESSION['officecabsoliten']) {
            $this->setTabela($_SESSION['officecabsoliten']);
        } else {
            $this->setTabela('pdfitenvenda');
        }

        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true, true);
        $this->adicionaRelacionamento('codigo', 'codigo');
        $this->adicionaRelacionamento('descricao', 'descricao');
        $this->adicionaRelacionamento('quant', 'quant');
        $this->adicionaRelacionamento('vlrunit', 'vlrunit');
        $this->adicionaRelacionamento('desconto', 'desconto');
        $this->adicionaRelacionamento('vlrtot', 'vlrtot');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('desctrat', 'desctrat');
        $this->adicionaRelacionamento('descextra1', 'descextra1');
        $this->adicionaRelacionamento('descextra2', 'descextra2');
        $this->adicionaRelacionamento('prcbruto', 'prcbruto');
        $this->adicionaRelacionamento('obsprod', 'obsprod');
        $this->adicionaRelacionamento('odprod', 'odprod');
        $this->adicionaRelacionamento('seqod', 'seqod');
        $this->adicionaRelacionamento('qtcaixa', 'qtcaixa');
        $this->adicionaRelacionamento('diver', 'diver');
        $this->adicionaRelacionamento('qtsug', 'qtsug');
        $this->adicionaRelacionamento('pdfdisp', 'pdfdisp');

        $this->adicionaOrderBy('seq', 1);
        $this->setSTop(10);

    }

    /**
     * retorna um array para calculo do valor da st
     */
    public function itensCalcSt($sNr) {
        $sSql = 'select codigo,vlrtot,seq from ' . $this->getTabela() . ' where nr=' . $sNr . ' order by seq';
        $result = $this->getObjetoSql($sSql);

        $aDados = array();
        $i = 0;
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados[$i][] = $row->codigo;
            $aDados[$i][] = $row->vlrtot;
            $aDados[$i][] = $row->seq;
            $i++;
        }
        return $aDados;
    }

    /**
     * Marca item como disponível para venda
     */
    public function dispVenda($sNr, $sSeq) {
        $sTabIten = $_SESSION['officecabsoliten'];

        $sSql = "update " . $sTabIten . " set pdfdisp ='Disp.' where nr ='" . $sNr . "' and seq ='" . $sSeq . "'  ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function limpaDispVenda($sNr, $sSeq) {
        $sTabIten = $_SESSION['officecabsoliten'];

        $sSql = "update " . $sTabIten . " set pdfdisp ='' where nr ='" . $sNr . "' and seq ='" . $sSeq . "'  ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

}
