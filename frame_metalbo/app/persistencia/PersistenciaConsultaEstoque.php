<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaConsultaEstoque extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('widl.prod01');
        $this->adicionaRelacionamento('procod', 'procod', true, true);
        $this->adicionaRelacionamento('grucod', 'grucod');
        $this->adicionaRelacionamento('subcod', 'subcod');
        $this->adicionaRelacionamento('famcod', 'famcod');
        $this->adicionaRelacionamento('famsub', 'famsub');
        $this->adicionaRelacionamento('prodes', 'prodes');
        $this->adicionaRelacionamento('pround', 'pround');
        $this->adicionaRelacionamento('propesprat', 'propesprat');
        $this->adicionaRelacionamento('probloqpro', 'probloqpro');


        $this->adicionaJoin('TabVenda', null, Persistencia::LEFT_JOIN, 'procod', 'codigo');

        $this->adicionaFiltro('probloqpro', 'S', Persistencia::LIGACAO_AND, Persistencia::DIFERENTE);

        if (isset($_SESSION['grupoprod'])) {
            $aGrupo = explode(',', $_SESSION['grupoprod']);

            $this->adicionaFiltro('grucod', $aGrupo[0], Persistencia::LIGACAO_AND, Persistencia::ENTRE, $aGrupo[1]);
        }
        $this->setSTop('350');
        $this->adicionaOrderBy('procod', 1);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select widl.prod01.procod as 'widl.prod01.procod',"
                . "widl.prod01.prodes as 'widl.prod01.prodes',"
                . "widl.prod01.pround as 'widl.prod01.pround',"
                . "widl.prod01.propesprat as 'widl.prod01.propesprat' "
                . "from widl.prod01(nolock) ";
        return $sSql;
    }

    public function dataFechamento() {
        $sSql = "select distinct convert(varchar,widl.ESTI01.encdata,103) as encdata "
                . "from widl.ESTI01(nolock) "
                . "where encdata = (select MAX(encdata) from widl.esti01(nolock) where filcgc = 75483040000211) "
                . "and filcgc = 75483040000211  ";

        $row = $this->consultaSql($sSql);
        $sData = $row->encdata;

        return $sData;
    }

    /**
     * Monta o estoque
     */
    public function carregaEstoque($sProcod) {
        $sDataEnc = $this->dataFechamento();

        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        $aRet1 = $PDOnew->exec("drop table #EstLiveMetalbo");

        $sSql = "create table #EstLiveMetalbo( "
                . "procod integer not null, "
                . "mov varchar (1), "
                . "quantEnt money, "
                . "quantSaid money, "
                . "alm varchar (10)) ";
        $aRet2 = $PDOnew->exec($sSql);

        // estoque inicial
        $sSql = "insert into  #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.esti04.procod,('E') as mov,(widl.ESTI04.encqtdest)as Entrada,('0')as Saida,encestalm "
                . "from widl.ESTI04(nolock) "
                . "where widl.ESTI04.procod in (select widl.prod01.procod from widl.prod01(nolock) "
                . "where  WIDL.ESTI04.encdata = "
                . "(select MAX(WIDL.ESTI04.encdata) from widl.ESTI04(nolock) where filcgc = 75483040000211 )) "
                . "and filcgc = '75483040000211' "
                . "and encestpos = '' "
                . "and procod in('" . $sProcod . "')";
        $aRet3 = $PDOnew->exec($sSql);

        //entrada de nota fiscal
        $sSql = "insert into #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "select procod,('E') as mov,(nfeproqtd) as Entrada,('0')as Saida,nfeproalm "
                . "from widl.nfe01(nolock),widl.NFEENT2(nolock),widl.MOV01(nolock) "
                . "where widl.NFE01.nfenro = widl.NFEENT2.nfenro "
                . "and widl.NFE01.nfeserie = widl.NFEENT2.nfeserie "
                . "and widl.NFE01.movcod = widl.MOV01.movcod "
                . "and widl.NFE01.empcod = widl.NFEENT2.empcod "
                . "and movest = 'S' "
                . "and nfeflag <> 4 "
                . "and nfepromove = 'S' "
                . "and nfeprodtch >'" . $sDataEnc . "' "
                . "and procod in('" . $sProcod . "')";
        $aRet4 = $PDOnew->exec($sSql);

        //entrada de produção
        $sSql = "insert into #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "Select widl.lctprod1.procod,('E') as mov,sum(lcpproqtd)as Entrada,('0')as Saida,lctproalmo "
                . "from widl.LCTPROD1 (NOLOCK),widl.prod01 (NOLOCK) "
                . "where widl.prod01.procod = widl.LCTPROD1.procod "
                . "and lcpprodata >'" . $sDataEnc . "' and filcgc = 75483040000211 "
                . "and  widl.lctprod1.procod in( '" . $sProcod . "') "
                . "GROUP by widl.LCTPROD1.procod,lctproalmo "
                . "order by widl.lctprod1.procod";
        $aRet5 = $PDOnew->exec($sSql);

        //entrada de transferencia
        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "SELECT procod, ('E') as mov, SUM (traiteqtde)as Entrada, ('0')as Saida,traitealm "
                . "FROM widl.TRANSF1(nolock),widl.prod01(nolock) "
                . "WHERE widl.prod01.procod = widl.transf1.traitepro "
                . "AND traitedata >'" . $sDataEnc . "' "
                . "and procod in('" . $sProcod . "') "
                . "and filcgc = '75483040000211' "
                . "group by procod,traitealm";
        $aRet6 = $PDOnew->exec($sSql);

        //saida de transferencia
        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "SELECT procod,('S') as mov,('0')as Entrada,SUM (traqtdtot)AS Saida,traalmcod "
                . "FROM widl.TRANSF(nolock),widl.prod01(nolock) "
                . "WHERE widl.TRANSF.traprocod = widl.prod01.procod "
                . "and tradata >'" . $sDataEnc . "' "
                . "and procod in('" . $sProcod . "') "
                . "and filcgc = '75483040000211'"
                . "group by widl.prod01.procod,traalmcod";
        $aRet7 = $PDOnew->exec($sSql);

        //requisição
        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.requis.procod, ('S') as mov, ('0') as Entrada, "
                . "sum(widl.requis.reqproqtat)as Saida, reqproalm "
                . "from widl.requis(nolock) left outer join widl.REQ01(nolock) "
                . "on widl.REQUIS.reqnro = widl.REQ01.reqnro "
                . "and widl.REQ01.filcgc = widl.REQUIS.filcgc "
                . "where "
                . "widl.req01.filcgc ='75483040000211' "
                . "and reqprodtat >'" . $sDataEnc . "' "
                . "and reqprosit IN ( 'I','E','N','') "
                . "and widl.requis.procod in('" . $sProcod . "') "
                . "group by widl.requis.procod,reqproalm";
        $aRet8 = $PDOnew->exec($sSql);

        //faturamento
        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.nfc003.nfsitcod,('S') as mov,"
                . "case "
                . "when nfssaida = '' then sum(widl.NFC003.nfsitqtd) end as Entrada,"
                . "case "
                . "when nfssaida = 'XXX' then sum(widl.NFC003.nfsitqtd) end as Saida, "
                . "nfsitalm "
                . "FROM widl.NFC003(nolock),widl.NFC001(nolock),widl.prod01(nolock),widl.mov01(nolock) "
                . "WHERE widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro "
                . "and widl.NFC003.nfsitcod = widl.prod01.procod  "
                . "and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc "
                . "and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser  "
                . "and widl.NFC001.nfsmovcod = widl.MOV01.movcod and movest = 'S' "
                . "and widl.nfc003.nfsfilcgc = '75483040000211' "
                . "and widl.nfc001.nfscancela <> '*' "
                . "AND nfsitdtemi >'" . $sDataEnc . "' "
                . "and nfsitcod in('" . $sProcod . "') "
                . "and widl.NFC003.nfsnfser = 2 "
                . "group by procod,nfsitcod,nfsitalm,nfssaida "
                . "order by widl.prod01.procod";
        $aRet9 = $PDOnew->exec($sSql);

        //gera o total
        $sSql = "select "
                . "(SUM(quantEnt)) - (SUM(quantSaid)) as estoque "
                . "from #EstLiveMetalbo "
                . "where alm in('1','224','57','69') ";
        $result = $PDOnew->query($sSql);
        $row = $result->fetchObject();
        $iTotal = $row->estoque;

        //gera array do total
        $sSql = "select alm,almdes,SUM(quantEnt)as totent,SUM(quantSaid)as tottaid, "
                . "(SUM(quantEnt)) - (SUM(quantSaid)) as estoque "
                . "from #EstLiveMetalbo,widl.ALM01(nolock) "
                . "where #EstLiveMetalbo.alm = widl.ALM01.almcod "
                . "and alm in('1','224','57','69') "
                . "group by alm,almdes ";
        $result = $PDOnew->query($sSql);
        $aEstoque = array();
        while ($row = $result->fetchObject()) {
            $aEstoque[trim($row->almdes)] = $row->estoque;
        }
        $aEstoque['Total'] = $iTotal;
        return $aEstoque;
    }

    //carrega os pedidos em aberto
    public function carregaSomaPedidos($sProcod) {
        $sSql = "select SUM (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) as totalped "
                . "from widl.PEDV01(nolock),widl.PEV01(nolock) "
                . "where "
                . "widl.PEV01.pdvnro = widl.PEDV01.pdvnro "
                . "and widl.pev01.filcgc =  75483040000211 "
                . "and empcod <> 75483040000211 "
                . "and pdvsituaca = 'O' "
                . "and pdvaprova = 'A' "
                . "and widl.PEDV01.procod =" . $sProcod . " "
                . "and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)> =0 ";
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sTotal = $row->totalped;
        return $sTotal;
    }

    //carrega o total em ordens de serviço
    public function carregaOf($sProcod) {
        $sSql = "select SUM(quant-quantprod)as op "
                . "from metop(nolock),metitenop(nolock) "
                . "where metop.op = metitenop.op "
                . "and codsituaca in (1,2,3,4) "
                . "and cod = " . $sProcod;
        $result = $this->getObjetoSql($sSql);
        $row = $result->fetch(PDO::FETCH_OBJ);
        $sOf = $row->op;
        return $sOf;
    }

}
