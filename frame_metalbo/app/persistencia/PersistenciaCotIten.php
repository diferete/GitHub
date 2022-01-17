<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaCotIten extends Persistencia {

    public function __construct() {
        parent::__construct();

        if ($_SESSION['officecabcotiten']) {
            $this->setTabela($_SESSION['officecabcotiten']);
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
    }

    /**
     * retorna um array para calculo do valor da st
     */
    public function itensCalcSt($sNr) {
        $sSql = 'select codigo,vlrtot,seq '
                . 'from ' . $this->getTabela() . '(nolock) '
                . 'where nr=' . $sNr . ' '
                . 'order by seq';
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
        $sTabIten = $_SESSION['officecabcotiten'];

        $sSql = "update " . $sTabIten . " "
                . "set pdfdisp ='Disp.' "
                . "where nr ='" . $sNr . "' "
                . "and seq ='" . $sSeq . "'  ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function limpaDispVenda($sNr, $sSeq) {
        $sTabIten = $_SESSION['officecabcotiten'];

        $sSql = "update " . $sTabIten . " "
                . "set pdfdisp ='' "
                . "where nr ='" . $sNr . "' "
                . "and seq ='" . $sSeq . "'  ";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

}


//guilherme.sanchez@belenus.com.br;compras01@crvindustrial.com;sider@sider.com.br;augusto.mattos@saetowers.com.br;jeferson@fusopar.com.br;carlos@hard.com.br;roffer@roffer.com.br;suprimentos4@page.ind.br;viemar@viemar.com.br;thiago@allenfix.com.br;marcos.simon@macrosul.com.br;lcfernandes@gsl.com.br;ester.vendas@metalurgicacaninde.com.br;tadeu.fiorentin@agcocorp.com;antonio@arsparafusos.com.br;gilmar@vencetudo.ind.br;ezequiel@jhonrob.com.br;jfeijo@carlosbecker.com.br;vendas@parafusosrudgeramos.com.br;rosi@fusopar.com.br;nfe.grc@kepler.com.br;roni@brametal.com.br;compras.wan@mascarello.com.br;phe@phe.ind.br;rsimioni@rsimioni.com.br;brandalisejr@hotmail.com;brafer@brafer.com;piva@konesul.ind.br;janaina@fusopar.com.br;compras@nathor.com.br;metalrvb@terra.com.br;forjafix@forjafix.com.br;contato@fortefixadores.com.br;cristiano@mgparafusos.com.br;gringa@stara.com.br;marcoaurelio@ovd.com.br;rafael.dutra@aguiasistemas.com.br;mario.klann@coremma.com.br;financeiro@plaxmetal.com.br;fiscal@planticenter.com.br;nfe@reiparparafusos.com.br;brasil_rudi@terra.com.br;paramar@paramar.com.br;compras2@krebs.com.br;administrativo@alfafix.com.br;elias@imperialferramentas.com.br;cezar@w3.ind.br;adm@msmindustria.com.br;vendas@metalparafusos.com.br;andre@commersul.com.br;leandro@macripar.com.br;compras01@metalurgicaamapa.com.br;neyrocha@fpparafusos.com.br;gomes@ovd.com.br;victor.moreno@indufix.com.br;tedesco@tedesco.eng.br;