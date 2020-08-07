<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaCot extends Persistencia {

    public function __construct() {
        parent::__construct();
        
        
        if (isset($_SESSION['officecabcot'])) {
            $this->setTabela($_SESSION['officecabcot']);
        } else {
            $oControllerUser = Fabrica::FabricarController('Usuario');
            $oControllerUser->msgSessaoInvalida();
        }

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
        $this->adicionaRelacionamento('emailcot', 'emailcot');
        $this->adicionaRelacionamento('venda', 'venda');
        $this->adicionaRelacionamento('nrvenda', 'nrvenda');
        $this->adicionaRelacionamento('consemail', 'consemail');
        $this->adicionaRelacionamento('frete', 'frete');
        $this->adicionaRelacionamento('situaca', 'situaca');
        $this->adicionaRelacionamento('dtent', 'dtent');
        $this->adicionaRelacionamento('contato', 'contato');
        $this->adicionaRelacionamento('diver', 'diver');
        $this->adicionaRelacionamento('qtexata', 'qtexata');
        $this->adicionaRelacionamento('userins', 'userins');


        $this->setSTop('100');
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

    public function copiaCot($sChave) {
        $aDados = explode('=', $sChave);
        $iNrNew = $this->getIncremento('nr', false);

        /*  $sSql = "insert into ".$this->getTabela()." (NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
          REP,TRANSCNPJ,TRANSP,DATA,HORA,OBS,EMAIL,NRCOT,IMP,
          consemail,FRETE,GERAPED,situaca,DTENT,contato,diver,datalib,horalib,qtexata)
          select ".$iNrNew." AS NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
          REP,TRANSCNPJ,TRANSP,
          CONVERT (date, SYSDATETIME())as DATA,
          CONVERT (time, SYSDATETIME())as HORA,
          OBS,'NV' AS EMAIL,NRCOT,'' as IMP,
          consemail,FRETE,'' as GERAPED,situaca,DTENT,contato,diver,datalib,horalib,qtexata
          from ".$this->getTabela()." where NR =".$aDados[1];
          $aRetorno = $this->executaSql($sSql); */

        $sSql = "insert into " . $this->getTabela() . "(NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
                REP,TRANSCNPJ,TRANSP,DATA,HORA,OBS,EMAIL,EMAILCOT,VENDA,NRVENDA,CONSEMAIL,FRETE,SITUACA,DTENT,
                CONTATO,DIVER,QTEXATA,userins) 
                select " . $iNrNew . " AS NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP, 
                REP,TRANSCNPJ,TRANSP,
                CONVERT (date, SYSDATETIME())as DATA,
                CONVERT (time, SYSDATETIME())as HORA, 
                OBS, 
                'NV' AS EMAIL,'NV' AS EMAILCOT, 
                 VENDA,NRVENDA, 
                consemail,FRETE,situaca,DTENT,contato,diver,qtexata,userins
                from " . $this->getTabela() . " where NR =" . $aDados[1];
        $aRetorno = $this->executaSql($sSql);
        /**
         * insert into '+cabcot+'(NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
          REP,TRANSCNPJ,TRANSP,DATA,HORA,OBS,EMAIL,EMAILCOT,VENDA,NRVENDA,CONSEMAIL,FRETE,SITUACA,DTENT,
          CONTATO,DIVER,QTEXATA)
          select '+inttostr(nrpednew)+' AS NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,
          REP,TRANSCNPJ,TRANSP,
          CONVERT (date, SYSDATETIME())as DATA,
          CONVERT (time, SYSDATETIME())as HORA,
          OBS,
          'NV' AS EMAIL,'NV' AS EMAILCOT,
          VENDA,NRVENDA,
          consemail,FRETE,situaca,DTENT,contato,diver,qtexata
          from '+cabcot+' where NR =:NR
         */
        //instancia classe de itens da solicitacao
        $oItenSol = Fabrica::FabricarPersistencia('CotIten');

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
     * Gera uma solicitação
     */
    public function geraSol($sChave) {
        //pega o número da solicitacao
        $oSol = Fabrica::FabricarPersistencia('SolPed');
        $oSolIten = Fabrica::FabricarPersistencia('SolPedIten');
        $oCotIten = Fabrica::FabricarPersistencia('CotIten');
        $iNr = $oSol->getIncremento('nr', false);
        $sSql = "INSERT INTO " . $oSol->getTabela() . " (NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA, 
         CODREP,REP,TRANSCNPJ,TRANSP,DATA,HORA,OBS,EMAIL,NRCOT,consemail,frete,dtent,SITUACA,contato,diver,qtexata,userins)
	 SELECT (" . $iNr . ") AS NR,CNPJ,CLIENTE,CODPGT,CPGT,ODCOMPRA,CODREP,REP,TRANSCNPJ,TRANSP, 
	 (select CONVERT(date,getdate()))AS DATA,(select CONVERT(time,getdate()))AS HORA,OBS,
         EMAIL,NR,consemail,frete,dtent, 'A' as SITUACA,contato,diver,qtexata,userins 
	 FROM " . $this->getTabela() . " WHERE NR =" . $sChave;

        $aRetorno1 = $this->executaSql($sSql);

        $sSql = " INSERT INTO " . $oSolIten->getTabela() . " (NR,SEq,CODIGO,DESCRICAO,QUANT,
            VLRUNIT,DESCONTO,VLRTOT,DATA,HORA,desctrat, 
	          descextra1,descextra2,prcbruto,obsprod,odprod,seqod,qtcaixa,diver,qtsug,pdfdisp) 
	          select (" . $iNr . ") AS NR,SEq,CODIGO,DESCRICAO,QUANT,VLRUNIT,DESCONTO,VLRTOT,
	          (select CONVERT(date,getdate()))AS DATA,(select CONVERT(time,getdate()))AS HORA, 
            desctrat,descextra1,descextra2,prcbruto,obsprod,odprod,seqod,qtcaixa,
            diver,qtsug,pdfdisp from " . $oCotIten->getTabela() . " where NR =" . $sChave;

        $aRetorno2 = $this->executaSql($sSql);

        $sSql = "update " . $this->getTabela() . " set venda = 'S', NRVENDA ='" . $iNr . "' where NR =" . $sChave;

        $aRetorno3 = $this->executaSql($sSql);


        if ($aRetorno1[0] == false || $aRetorno2[0] == false || $aRetorno3 == false) {
            $aRetorno[0] = false;
            return $aRetorno;
        } else {
            $aRetorno[0] = true;
            $aRetorno[1] = $iNr;
            return $aRetorno;
        }
    }

    public function confirmaEnvioEmail($sNr) {
        $sSql = "update " . $_SESSION['officecabcot'] . " set email = 'EV' where nr = " . $sNr . "";
        $this->executaSql($sSql);
    }

}
