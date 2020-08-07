<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaMET_VENDA_ExpSol extends Persistencia {

    public function __construct() {
        parent::__construct();


        $this->setTabela('PDFVENDA_EX');


        $this->adicionaRelacionamento('nr', 'nr', true, true, true);
        $this->adicionaRelacionamento('cnpj', 'cnpj');
        $this->adicionaRelacionamento('cliente', 'cliente');
        $this->adicionaRelacionamento('codpgt', 'codpgt');
        $this->adicionaRelacionamento('cpgt', 'cpgt');
        $this->adicionaRelacionamento('odcompra', 'odcompra');
        $this->adicionaRelacionamento('codrep', 'codrep');
        $this->adicionaRelacionamento('rep', 'rep');
        $this->adicionaRelacionamento('transcnpj', 'transcnpj');
        $this->adicionaRelacionamento('transp', 'transp');
        $this->adicionaRelacionamento('data', 'data');
        $this->adicionaRelacionamento('hora', 'hora');
        $this->adicionaRelacionamento('obs', 'obs');
        $this->adicionaRelacionamento('email', 'email');
        $this->adicionaRelacionamento('nrcot', 'nrcot');
        $this->adicionaRelacionamento('imp', 'imp');
        $this->adicionaRelacionamento('consemail', 'consemail');
        $this->adicionaRelacionamento('frete', 'frete');
        $this->adicionaRelacionamento('geraped', 'geraped');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('dtent', 'dtent');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('diver', 'diver');
        $this->adicionaRelacionamento('datalib', 'datalib');
        $this->adicionaRelacionamento('horalib', 'horalib');
        $this->adicionaRelacionamento('qtexata', 'qtexata');
        $this->adicionaRelacionamento('userlib', 'userlib');
        $this->adicionaRelacionamento('userins', 'userins');


        $this->setSTop('50');
        $this->adicionaOrderBy('nr', 1);
    }

    /* Método temporário para busca de representante de cliente */

    public function buscaRep($sCnpj) {
        $sSql = "select widl.emp01.repcod,repdes 
                from widl.EMP01 left outer join 
                widl.rep01 on widl.emp01.repcod = widl.rep01.repcod
                where empcod =" . $sCnpj;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $aRetorno[0] = $row->repcod;
        $aRetorno[1] = $row->repdes;

        return $aRetorno;
    }

    public function libMetalbo($aDados) {
        $dataLib = date('Y-m-d');
        date_default_timezone_set('America/Sao_Paulo');
        $horaLib = (date('H:i'));

        $sSql = "update " . $this->getTabela() . " set EMAIL = 'EV',datalib='" . $dataLib . "',horalib='" . $horaLib . "',userlib='" . $_SESSION['nome'] . "' where NR =" . $aDados['nr'];
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function copiaSol($sChave) {
        $aDados = explode('=', $sChave);
        $iNrNew = $this->getIncremento('nr', false);

        $sSql = "insert into " . $this->getTabela() . " (NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
                REP,TRANSCNPJ,TRANSP,DATA,HORA,OBS,EMAIL,NRCOT,IMP,
                consemail,FRETE,GERAPED,situaca,DTENT,contato,diver,datalib,horalib,qtexata,userins)
                select " . $iNrNew . " AS NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
                REP,TRANSCNPJ,TRANSP,
                CONVERT (date, SYSDATETIME())as DATA, 
                CONVERT (time, SYSDATETIME())as HORA, 
                OBS,'NV' AS EMAIL,NRCOT,'' as IMP,
                consemail,FRETE,'' as GERAPED,situaca,DTENT,contato,diver,datalib,horalib,qtexata,userins 
                from " . $this->getTabela() . " where NR =" . $aDados[1];
        $aRetorno = $this->executaSql($sSql);

        //instancia classe de itens da solicitacao
        $oItenSol = Fabrica::FabricarPersistencia('SolPedIten');

        $sSql = " insert into " . $oItenSol->getTabela() . " (NR,SEQ,CODIGO,DESCRICAO,QUANT,VLRUNIT,DESCONTO,
                VLRTOT,DATA,HORA,DESCTRAT,DESCEXTRA1,DESCEXTRA2,PRCBRUTO,OBSPROD,ODPROD,SEQOD,QTCAIXA,DIVER,
                QTSUG,pdfdisp) 
                select " . $iNrNew . " as nr,SEq,CODIGO,DESCRICAO,
                QUANT,VLRUNIT,DESCONTO,VLRTOT,
                CONVERT (date, SYSDATETIME())as DATA, 
                CONVERT (time, SYSDATETIME())as HORA, 
                desctrat, 
                descextra1,descextra2,prcbruto,obsprod,odprod,seqod,qtcaixa,diver,qtsug,pdfdisp 
                from " . $oItenSol->getTabela() . "   where NR =" . $aDados[1];
        $aRetorno = $this->executaSql($sSql);

        if ($aRetorno[0] == true) {
            $aRetorno[0] = true;
            $aRetorno[1] = $iNrNew;
            return $aRetorno;
        } else {
            return $aRetorno;
        }
    }

    /**
     * Retorna cliente a partir de uma solicitacao
     */
    public function retCli($sNr) {
        $sSql = 'select cnpj from ' . $this->getTabela() . ' where nr = ' . $sNr;
        $resul = $this->getObjetoSql($sSql);
        $row = $resul->fetch(PDO::FETCH_OBJ);

        $sCnpj = $row->cnpj;

        return $sCnpj;
    }

    /**
     * retorna se o cliente é bloqueado
     */
    public function retBloq($sEmpcod) {
        $sSql = "select empblocred from widl.emp01 where empcod ='" . $sEmpcod . "' ";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sBloq = $row->empblocred;

        return $sBloq;
    }

}
