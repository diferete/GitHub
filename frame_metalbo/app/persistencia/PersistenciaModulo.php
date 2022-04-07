<?php

class PersistenciaModulo extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('tbmodulo');

        $this->adicionaRelacionamento('modcod', 'modcod', true, true, true);
        $this->adicionaRelacionamento('modescricao', 'modescricao');

        $this->adicionaOrderBy('modcod', 1);
    }

    public function teste() {
        $sSql = 'select distinct codsetor,setor,cargo from tbfunc where cnpj = 75483040000211';
        $iNr = 1;
        $iCodFunc = 1;
        $iFilcgc = 75483040000211;

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $sSqlInsert = "insert into MET_RH_FuncaoSetor (nr,filcgc,codsetor,codfuncao,descfuncao,descsetor)"
                    . "values"
                    . "(" . $iNr . "," . $iFilcgc . "," . $row->codsetor . "," . $iCodFunc . ",'" . $row->cargo . "','" . $row->setor . "')";
            $aRetorno = $this->executaSql($sSqlInsert);
            $iNr++;
            $iCodFunc++;
        }
        return;
    }

    public function populaTabelaPrecoNovo() {
        /* seleciona todos os códgios com # no código de acabamento */
        $sSql = "select * from tempoProdPrecoAtualizado";
        $sth = $this->getObjetoSql($sSql);
        while ($aDados = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aAcab = array();
            $aAcab[0] = '1';
            $aAcab[1] = '2';
            $aAcab[2] = '3';
            $aAcab[3] = '4';
            $aAcab[4] = '5';
            $aAcab[5] = '6';
            $aAcab[6] = '7';
            $aAcab[7] = '8';
            $aAcab[8] = '9';

            foreach ($aAcab as $key => $value) {
                /* substitui o # por um valor entre 1-9 sequencial conforme array acima */
                $iCod = str_replace('#', $value, $aDados['procod']);
                $iCod = str_replace('.', '', $iCod);
                /* arredonda o valor do preço atualizado para duas casas decimais */
                $fPreco = round($aDados['preco'], 2);
                /* verifica se o código existe na tabela original de itens de vendas que não são itens especiais */
                $sSqlSelectPdfTabVendas = "select COUNT(*) as total from pdftabvendas where codigo = " . $iCod . " and prcmin <> 'S'";
                $oTotal = $this->consultaSql($sSqlSelectPdfTabVendas);
                if ($oTotal->total > 0) {
                    /* se o código do produto existe na tabela de vendas, insere código e preço em outra tabela */
                    $sSql = "insert into tempoPDFTabVendaPrecos(procod,preco)values(" . $iCod . "," . $fPreco . ")";
                    $debug = $this->executaSql($sSql);
                }
            }
        }
    }

    public function verificaMovProduto() {
        /* verifica se existem códigos na tabela de vendas que não terão seus preços atualizados */
        $sSql = "select pdftabvendas.codigo as codigo,"
                . "widl.prod01.prodes as descricao,"
                . "pdftabvendas.preco as preco,"
                . "widl.prod01.probloqpro as bloqueado "
                . "from pdftabvendas "
                . "left outer join widl.prod01 "
                . "on widl.prod01.procod = pdftabvendas.codigo "
                . "where pdftabvendas.codigo not in (select procod from tempoPDFTabVendaPrecos) "
                . "and prcmin <> 'S' order by codigo asc";
        $sth = $this->getObjetoSql($sSql);
        while ($aDados = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aEstoque = $this->carregaEstoque($aDados['codigo']);
            $iSomaPedidos = $this->carregaSomaPedidos($aDados['codigo']);
            if ($aEstoque['Total'] == '' || $aEstoque['Total'] == null) {
                $aEstoque['Total'] = 0;
            }
            if ($iSomaPedidos == '' || $iSomaPedidos == null) {
                $iSomaPedidos = 0;
            }

            $sSql = "insert into tempoTabMovItem(procod,estoque,pedidos,bloqueado)"
                    . "values(" . $aDados['codigo'] . ",'" . $aEstoque['Total'] . "','" . $iSomaPedidos . "','" . $aDados['bloqueado'] . "')";
            $debug = $this->executaSql($sSql);
        }
    }

    //carrega os pedidos em aberto
    public function carregaSomaPedidos($sProcod) {
        $sSql = "select SUM (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf) "
                . "as totalped from widl.PEDV01,widl.PEV01 where widl.PEV01.pdvnro = widl.PEDV01.pdvnro "
                . "and widl.pev01.filcgc =  75483040000211 and empcod <> 75483040000211 and pdvsituaca = 'O' "
                . "and pdvaprova = 'A' and widl.PEDV01.procod =" . $sProcod . " and (widl.pedv01.pdvproqtdp - widl.pedv01.pdvproqtdf)>=0 ";
        $row = $this->consultaSql($sSql);
        $sTotal = $row->totalped;
        return $sTotal;
    }

    public function carregaEstoque($sProcod) {
        $sDataEnc = $this->dataFechamento();

        $PDOnew = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        $aRet1 = $PDOnew->exec('drop table #EstLiveMetalbo');

        $sSql = 'create table #EstLiveMetalbo( '
                . 'procod integer not null, '
                . 'mov varchar (1), '
                . 'quantEnt money, '
                . 'quantSaid money, '
                . 'alm varchar (10)) ';
        $aRet2 = $PDOnew->exec($sSql);

        $sSql = "insert into  #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.esti04.procod,('E') as mov,(widl.ESTI04.encqtdest)as Entrada,('0')as Saida,encestalm "
                . "from widl.ESTI04 "
                . "where widl.ESTI04.procod in "
                . "(select widl.prod01.procod "
                . "from widl.prod01 "
                . "where  WIDL.ESTI04.encdata = (select MAX(WIDL.ESTI04.encdata) from widl.ESTI04 where filcgc = 75483040000211 )) "
                . "and filcgc = '75483040000211' "
                . "and encestpos ='' "
                . "and procod =" . $sProcod . " ";
        $aRet3 = $PDOnew->exec($sSql);

        $sSql = " insert into  #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "select procod,('E') as mov,(nfeproqtd) as Entrada,('0')as Saida,nfeproalm "
                . "from widl.nfe01,widl.NFEENT2,widl.MOV01 "
                . "where widl.NFE01.nfenro = widl.NFEENT2.nfenro "
                . "and widl.NFE01.nfeserie = widl.NFEENT2.nfeserie "
                . "and widl.NFE01.movcod = widl.MOV01.movcod "
                . "and widl.NFE01.empcod = widl.NFEENT2.empcod "
                . "and movest = 'S' "
                . "and nfeprodtch >'" . $sDataEnc . "' "
                . "and procod =" . $sProcod . "";
        $aRet4 = $PDOnew->exec($sSql);

        $sSql = " insert into #EstLiveMetalbo (procod,mov,quantEnt,quantSaid,alm) "
                . "Select widl.lctprod1.procod,('E') as mov,sum(lcpproqtd)as Entrada,('0')as Saida,lctproalmo "
                . "from widl.LCTPROD1 (NOLOCK),widl.prod01 (NOLOCK) "
                . "where widl.prod01.procod = widl.LCTPROD1.procod "
                . "and lcpprodata >'" . $sDataEnc . "' and filcgc = 75483040000211 "
                . "and  widl.lctprod1.procod =" . $sProcod . " "
                . "GROUP by widl.LCTPROD1.procod,lctproalmo order by widl.lctprod1.procod ";
        $aRet5 = $PDOnew->exec($sSql);

        $sSql = " insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "SELECT procod,('E') as mov,SUM (traiteqtde)as Entrada,('0')as Saida,traitealm "
                . "FROM widl.TRANSF1(nolock),widl.prod01 "
                . "WHERE widl.prod01.procod = widl.transf1.traitepro "
                . "AND traitedata >'" . $sDataEnc . "' "
                . "and procod =" . $sProcod . " "
                . "group by procod,traitealm ";
        $aRet6 = $PDOnew->exec($sSql);

        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "SELECT procod,('S') as mov,('0')as Entrada,SUM (traqtdtot)AS Saida,traalmcod "
                . "FROM widl.TRANSF(nolock),widl.prod01 "
                . "WHERE widl.TRANSF.traprocod = widl.prod01.procod "
                . "and tradata >'" . $sDataEnc . "' "
                . "and procod =" . $sProcod . " "
                . "group by widl.prod01.procod,traalmcod ";
        $aRet7 = $PDOnew->exec($sSql);

        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.requis.procod,('S') as mov,('0')as Entrada, "
                . "sum(widl.requis.reqproqtat)as Saida,reqproalm "
                . "from widl.requis left outer join "
                . "widl.REQ01 on widl.REQUIS.reqnro = widl.REQ01.reqnro "
                . "and widl.REQ01.filcgc = widl.REQUIS.filcgc "
                . "where "
                . "widl.req01.filcgc ='75483040000211' "
                . "and reqprodtat >'" . $sDataEnc . "' "
                . "and reqprosit IN ( 'I','E','N','') "
                . "and widl.requis.procod =" . $sProcod . " "
                . "group by widl.requis.procod,reqproalm ";
        $aRet8 = $PDOnew->exec($sSql);

        $sSql = "insert into #EstLiveMetalbo(procod,mov,quantEnt,quantSaid,alm) "
                . "select widl.nfc003.nfsitcod,('S') as mov, "
                . "case "
                . "when nfssaida = '' then sum(widl.NFC003.nfsitqtd) end as Entrada, "
                . "case "
                . "when nfssaida = 'XXX' then sum(widl.NFC003.nfsitqtd) end as Saida, "
                . "nfsitalm "
                . "FROM widl.NFC003,widl.NFC001,widl.prod01,widl.mov01 "
                . "WHERE widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro "
                . "and widl.NFC003.nfsitcod = widl.prod01.procod  "
                . "and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc "
                . "and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser  "
                . "and widl.NFC001.nfsmovcod = widl.MOV01.movcod and movest = 'S' "
                . "and widl.nfc003.nfsfilcgc = '75483040000211' "
                . "and widl.nfc001.nfscancela <> '*' "
                . "AND nfsitdtemi >'" . $sDataEnc . "' "
                . "and nfsitcod =" . $sProcod . " "
                . "and widl.NFC003.nfsnfser = 2 "
                . "group by procod,nfsitcod,nfsitalm,nfssaida "
                . "order by widl.prod01.procod ";
        $aRet9 = $PDOnew->exec($sSql);

        //gera o total
        $sSql = "select "
                . "(SUM(quantEnt)) - (SUM(quantSaid)) as estoque "
                . "from #EstLiveMetalbo where alm <> 60 and alm <> 62 and alm <> 63 ";
        $result = $PDOnew->query($sSql);
        $row = $result->fetchObject();
        $iTotal = $row->estoque;

        //gera array do total
        $sSql = "select alm,almdes,SUM(quantEnt)as totent,SUM(quantSaid)as tottaid, "
                . "(SUM(quantEnt)) - (SUM(quantSaid)) as estoque "
                . "from #EstLiveMetalbo,widl.ALM01 "
                . "where #EstLiveMetalbo.alm = widl.ALM01.almcod "
                . "and alm <> 60 and alm <> 62 and alm <> 63 group by alm,almdes ";
        $result = $PDOnew->query($sSql);
        $aEstoque = array();
        while ($row = $result->fetchObject()) {
            $aEstoque[trim($row->almdes)] = $row->estoque;
        }
        $aEstoque['Total'] = $iTotal;
        return $aEstoque;
    }

    public function dataFechamento() {
        $sSql = 'select distinct convert(varchar,widl.ESTI01.encdata,103) as encdata '
                . 'from widl.ESTI01 '
                . 'where encdata = (select MAX(encdata) '
                . 'from widl.esti01 where filcgc = 75483040000211 ) '
                . 'and filcgc = 75483040000211  ';
        $row = $this->consultaSql($sSql);

        $sData = $row->encdata;

        return $sData;
    }

    public function exportaFunc() {
        $sSql = 'select numpis,nomfun,numcad '
                . 'from vetorh.dbo.r034fun '
                . 'where sitafa = 1 '
                . 'and codfil = 1 '
                . 'and numemp = 3 '
                . 'order by nomfun';
        $result = $this->getObjetoSql($sSql);
        //14138320721;ALEXANDRE W DE SOUZA;0;1824;0;0;;000000182400;
        $sHeader = 'pis;nome;administrador;matricula;rfid;codigo;senha;barras;digitais';
        $sDados = '';
        $fp = fopen("bloco2.txt", "w");
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
            $pis = $oRowBD->numpis;
            $nome = $oRowBD->nomfun;
            $matricula = $oRowBD->numcad;
            if (strlen(trim($oRowBD->numcad)) <= 3) {
                //000000012300
                $barras = '0000000' . trim($oRowBD->numcad) . '00';
            } else {
                //000000123400
                $barras = '000000' . trim($oRowBD->numcad) . '00';
            }
            $sDados = $pis . ';' . $nome . ';' . '0' . ';' . $matricula . ';' . '0' . ';' . '0' . ';;' . $barras . ';';
            fwrite($fp, $sDados . "\n");
        }
        fclose($fp);
    }

}
