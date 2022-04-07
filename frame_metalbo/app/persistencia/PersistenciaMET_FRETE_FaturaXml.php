<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaMET_FRETE_FaturaXml
 *
 * @author Alexandre
 */
class PersistenciaMET_FRETE_FaturaXml extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_FRETE_FaturaXml');
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('cnpj', 'cnpj', true, true);
        $this->adicionaRelacionamento('nfsfilcgc', 'Pessoa.empcod', false, false);
        $this->adicionaRelacionamento('fatura', 'fatura', true, true);
        $this->adicionaRelacionamento('dataEmit', 'dataEmit');
        $this->adicionaRelacionamento('dataVenc', 'dataVenc');
        $this->adicionaRelacionamento('usuario', 'usuario');
        $this->adicionaRelacionamento('dataUpload', 'dataUpload');
        $this->adicionaRelacionamento('horaUpload', 'horaUpload');
        $this->adicionaRelacionamento('arquivo', 'arquivo');
        $this->adicionaRelacionamento('extraido', 'extraido');


        $this->adicionaJoin('Pessoa', null, 1, 'cnpj', 'empcod');
        $this->setSTop(75);
        $this->adicionaOrderBy('dataUpload', 1);
    }

    public function buscaEmpresas() {
        $sSql = "select distinct cnpj,empdes from tbfrete left outer join widl.emp01
	         on tbfrete.cnpj =  widl.emp01.empcod ";
        $sth = $this->getObjetoSql($sSql);
        $iI = 0;
        $aRow = Array();
        while ($key = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRow[$iI] = $key;
            $iI++;
        }
        return $aRow;
    }

    public function getArquivos() {
        $sData = date('d/m/Y');
        $sSql = "select "
                . "cnpj,"
                . "fatura,"
                . "convert(varchar, dataemit, 103) as dataemit,"
                . "convert(varchar, datavenc, 103) as datavenc "
                . "from MET_FRETE_FaturaXml "
                . "where extraido = 'N' and "
                . "dataUpload between '" . $sData . "' "
                . "and '" . $sData . "'";
        $result = $this->getObjetoSql($sSql);
        while ($oRowBD = $result->fetch(PDO::FETCH_OBJ)) {
//adiciona o objeto atual ao array de retorno
            $aDados['cnpj'] = $oRowBD->cnpj;
            $aDados['fatura'] = $oRowBD->fatura;
            $aDados['dataEmit'] = $oRowBD->dataemit;
            $aDados['dataVenc'] = $oRowBD->datavenc;
            $aRetorno[] = $aDados;
        }

        return $aRetorno;
    }

    public function gerenciaXML($aDados) {

        $oNfsNfNro1 = '';
        $oTotalnf = 0;
        $oTotalKg = 0;
        $sObsFinal = null;
        $sSit = 'A';
        $sNfNfNroOBS = '';

        /* VALIDAÇÃO DO TIPO DE CTE - COMPRA OU VENDA - */
        /* seleciona na tabela do faturamento os dados da NFE referente ao CTE */
        $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
        $sSql = " select "
                . "nfsnfnro,"
                . "nfsvlrtot,"
                . "Ceiling(nfspesobr) as pesoNota,"
                . "'" . $aDados['cnpj'] . "' as cnpj ,"
                . "'' as totalfrete,"
                . "'' as freteminimo "
                . "from widl.NFC001 "
                . "left outer join widl.EMP01 "
                . "on widl.NFC001.nfsclicod = widl.EMP01.empcod "
                . "where nfsnfnro in(" . $aDados['sNFE'] . ") "
                . "and widl.EMP01.empcl = 'C' "
                . "and nfsfilcgc = 75483040000211 "
                . "and nfsclicgc = " . $aDados['sCNPJCliente'] . "";
        $dadosSql = $PDO->query($sSql);
        $aDadosNF1 = $dadosSql->fetch(PDO::FETCH_ASSOC);

        /* se nao existe na NFC001 retorna false e busca na NFE01 */

        if (!$aDadosNF1 || $aDadosNF1 == null) {
            /* compra */
            $sSql2 = "select nfenro as nfsnfnro,"
                    . "nfevlrnota as nfsvlrtot,"
                    . "nfetransp as cnpj "
                    . "from widl.NFE01 "
                    . "where nfetransp ='" . $aDados['cnpj'] . "' "
                    . "and empcod= '" . $aDados['sCNPJCliente'] . "' "
                    . "and nfenro in(" . $aDados['sNFE'] . ") ";
            $dadosSql2 = $PDO->query($sSql2);
            $oRow1 = $dadosSql2->fetch(PDO::FETCH_ASSOC);
            /* validação caso não tenha nota de compra */
            /* caso não ache na NFE01 carrega valores direto do XML */
            if (!$oRow1 || $oRow1 == null) {
                $iCodTipo = 2;
                $oTotalnf = $aDados['sValorCarga'];
                $oTotalKg = $aDados['sPeso'];
                $sSit = 'E';
                if ($aDados['iTotal'] > 1) {
                    $aNFE = explode(',', $aDados['sNFE']);
                    $oNfsNfNro1 = str_replace("'", "", $aNFE[0]);
                } else {
                    $oNfsNfNro1 = str_replace("'", "", $aDados['sNFE']);
                }
            } else {
                $iCodTipo = 2;
                $dadosSql2 = $PDO->query($sSql2);
                while ($oRow2 = $dadosSql2->fetch(PDO::FETCH_ASSOC)) {
                    if ($oNfsNfNro1 == '') {
                        $oNfsNfNro1 = "'" . $oRow2 ['nfsnfnro'] . "'";
                    } else {
                        $oNfsNfNro2 = $oNfsNfNro1 . ",'" . $oRow2 ['nfsnfnro'] . "'";
                    }
                    if ($oTotalnf == 0) {
                        $oTotalnf = $oRow2 ['nfsvlrtot'];
                    } else {
                        $oTotalnf = $oTotalnf + $oRow2 ['nfsvlrtot'];
                    }
                    $oTotalKg = $aDados['sPeso'];
                }
            }
        } else {
            /* VENDA */
            $iCodTipo = 1;
            $dadosSql = $PDO->query($sSql);
            while ($aDadosNF2 = $dadosSql->fetch(PDO::FETCH_ASSOC)) {
                if ($oNfsNfNro1 == '') {
                    $oNfsNfNro1 = "'" . $aDadosNF2 ['nfsnfnro'] . "'";
                } else {
                    $oNfsNfNro2 = $oNfsNfNro1 . ",'" . $aDadosNF2 ['nfsnfnro'] . "'";
                }
                if ($oTotalnf == 0) {
                    $oTotalnf = $aDadosNF2 ['nfsvlrtot'];
                } else {
                    $oTotalnf = $oTotalnf + $aDadosNF2 ['nfsvlrtot'];
                }
                if ($oTotalKg == 0) {
                    $oTotalKg = $aDadosNF2 ['pesoNota'];
                } else {
                    $oTotalKg = $oTotalKg + $aDadosNF2 ['pesoNota'];
                }
            }
        }


        /* calcula fração do frete */
        $oFracaoFrete = ceil($oTotalKg / 100);

        /* verifica se exitem mais de uma nota/chave e adiciona essas notas no campo observação */
        if ($aDados['iTotal'] > 1) {
            $obsfinal = str_replace("'", "", $oNfsNfNro2);
        }

        /* calculos por transportadora */
        $aRet1 = $PDO->exec("BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
                . "BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH ");

        if (stristr($oTotalnf, ',')) {
            $oTotalnf = Util::ValorSql($oTotalnf);
        }
        if (stristr($oTotalKg, ',')) {
            $oTotalKg = Util::ValorSql($oTotalKg);
        }
        if (($aDados['cnpj'] == '3565095000260') || ($aDados['cnpj'] == '428307001593') || ($aDados['cnpj'] == '2633583000385') || ($aDados['cnpj'] == '4353469003504') || ($aDados['cnpj'] == '89317697001880') || ($aDados['cnpj'] == '32241003000375')) {

            $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
                    . " BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
                    . "select " . $aDados['cnpj'] . " as cnpj,"
                    . "" . $oNfsNfNro1 . " as nota,"
                    . "" . $oTotalnf . " as nfsvlrtot,"
                    . "" . $oTotalKg . " as pesoNota,"
                    . "" . $oFracaoFrete . " as FracaoFrete,"
                    . "'' as totalfrete,"
                    . "'' as freteminimo "
                    . "into tbnt#";
            $aRetorno = $PDO->exec($sSqlAux);
        }

        //MIRIN - Compra e Venda
        /*
         * VENDA SEQ
         * 1,2,3,4,5,17,18 = Fórmula completa
         * 16 = Fórmula de 2%
         * 11,12,13,14,15 = Fórmula parcial 
         * COMPRA SEQ
         * TODOS
         */
        if ($aDados['cnpj'] == '3565095000260') {

            if ($aRetorno == 1) {
                $sSql1 = " 
                create table tbnt2# (
                    seq integer,
                    ref varchar(100),
                    totalfrete money,
                    freteminimo money)    
                insert into tbnt2#   
                /*vendas = 1,2,3,4,5,6,17,18*/
                select seq, ref, ROUND(
                    ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris) + 
                    ROUND(ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2)* taxaEmergencial ,2),2) * imposto/100 
                    +ROUND(ROUND( fretevalor  * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio *FracaoFrete,2)+taxa2 +tas +(nfsvlrtot *gris)  ,2),2 ) +
                    ROUND(ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2)* taxaEmergencial ,2) 
                    as totalfrete,
                    ROUND(ROUND(ROUND( fretevalor * nfsvlrtot ,2)  +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris) +
                    ROUND(ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2)* taxaEmergencial ,2) ,2) *imposto/100  
                    +ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+ (nfsvlrtot *gris)  ,2),2 )+
                    ROUND(ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2)* taxaEmergencial ,2)
                    as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $aDados['cnpj'] . " and SEQ not in(11,12,13,14,15,16) and codtipo = 1
                insert into tbnt2#
                /*vendas = 16*/
                select seq, ref, ROUND(
                    ROUND(ROUND( (fretevalor * nfsvlrtot) ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2) ,2 ) as totalfrete,
                    ROUND(
                    ROUND(ROUND( (fretevalor * nfsvlrtot) ,2)  +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $aDados['cnpj'] . " and SEQ in(16) and codtipo = 1
                insert into tbnt2#
                /*vendas = 11,12,13,14,15*/
                select seq, ref, ROUND(
                    ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2)* imposto/100  
                    + ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2) ,2) as totalfrete,
                    ROUND(
                    ROUND(ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2)* imposto/100  
                    + ROUND(ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $aDados['cnpj'] . " and SEQ in(11,12,13,14,15) and codtipo = 1 
                insert into tbnt2#   
                /*compras = TODOS*/
                select seq, ref, 
                CASE WHEN ROUND( pesoNota * fretepeso,2)<taxamin THEN (ROUND(
                   ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2)* imposto/100  
                   + ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2))
                   ELSE (ROUND(
                   ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot * gris)  ,2) * imposto/100 
                   +ROUND(ROUND( fretevalor  * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas +(nfsvlrtot * gris)  ,2),2 ))
                        end as totalfrete,
                   ROUND(
                   ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2)* imposto/100  
                   + ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2) as freteminimo
                   from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $aDados['cnpj'] . " and codtipo = 2";

                $result1 = $PDO->exec($sSql1);
            }

            $fp = fopen("bloco1.txt", "w");
            fwrite($fp, $sSql1);
            fclose($fp);

            if ($result1) {
                $sSql2 = "select * from  tbnt2#";
                $result = $PDO->query($sSql2);
            }


            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //* EXPRESSO SÃO MIGUEL LTDA */ - COMPRA OK
        /*
         * Campos
         * Pedagio sempre colocado o mínimo por região
         * Taxa = mínimo - gris minimo
         */
        if ($aDados['cnpj'] == '428307001593') {

            if ($aRetorno == 1) {
                $sSql1 = "select seq, ref,
                            CASE    WHEN ((pedagio *FracaoFrete)<=pedagio AND (nfsvlrtot * gris)<=taxa) THEN (
					ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce(pedagio,0)+
                                        COALESCE(taxa, 0),2)/imposto,2))
                                    WHEN ((pedagio *FracaoFrete)<=pedagio AND (nfsvlrtot * gris)>taxa) THEN(
                                        ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce(pedagio,0)+
                                        COALESCE(nfsvlrtot * gris, 0),2)/imposto,2)
                                        )
                                    WHEN (pedagio *FracaoFrete)>pedagio AND (nfsvlrtot * gris)<=taxa THEN(
                                        ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce(pedagio *FracaoFrete,0)+
                                        COALESCE(taxa, 0),2)/imposto,2)
                                        )
                                    ELSE 
                                        (ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+
                                        COALESCE( nfsvlrtot * gris, 0),2)/imposto,2))
                                        END AS totalfrete,
					ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce(pedagio,0)+
					coalesce( taxa,0),2)/imposto,2)  as freteminimo
					from tbfrete left outer join tbnt#
                on tbfrete.cnpj = tbnt#.cnpj
                where  tbfrete.cnpj = " . $aDados['cnpj'] . " ";
                $result = $PDO->query($sSql1);
            }

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*leomar*/ - Venda OK
        if ($aDados['cnpj'] == '2633583000385') {

            if ($aRetorno == 1) {

                $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( (pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+ TAXA2 + tas +
                    coalesce(nfsvlrtot  *gris,0) ,2)/imposto  AS totalfrete
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $aDados['cnpj'] . " ";
                $result = $PDO->query($sSql1);
            }
            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*bauer*/ - Venda OK
        if ($aDados['cnpj'] == '4353469003504') {

            if ($aRetorno == 1) {
                $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) as totalfrete, 
                    ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $aDados['cnpj'] . " ";
                $result = $PDO->query($sSql1);
            }

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*TW TRANSPORTES E LOGISTICA */ - Venda OK
        if ($aDados['cnpj'] == '89317697001880') {

            if ($aRetorno == 1) {
                $sSql1 = "select 'tw'as cliente, ref, seq ,ROUND((ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota * fretepeso)+taxamin),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)+ ROUND (coalesce( fretevalor * nfsvlrtot ,0)+ coalesce( pedagio *FracaoFrete,0)+ coalesce(  nfsvlrtot  *gris,0),2)*taxaEmergencial) / imposto ,2)
                    as totalfrete, '' as freteminimo 
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $aDados['cnpj'] . "";
                $result = $PDO->query($sSql1);
            }

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*SNM TRANSPORTES LTDA*/ - Venda OK
        if ($aDados['cnpj'] == '10618249000119') {


            $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH"
                    . " BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
                    . "select " . $aDados['cnpj'] . " as cnpj, " . $oNfsNfNro1 . " as nota, "
                    . $oTotalnf . " as nfsvlrtot, " . $oTotalKg . " as pesoNota, "
                    . $oFracaoFrete . " as FracaoFrete,'' as totalfrete, '' as freteminimo, '' as seq into tbnt2#"
                    . " create table tbnt# (
                        seq integer,
                        ref varchar(100),
                        totalfrete money,
                        freteminimo money)";

            $aRetorno = $PDO->exec($sSqlAux);

            if ($aRetorno == 1) {

                $sSql3 = "/*26,27,28,29*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce((pesoNota * fretepeso),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Totalfrete,ROUND(ROUND (coalesce( taxamin ,0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq  in(26,27,28,29)
                    /*30,31*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref, ROUND(ROUND (coalesce( 0.001 * nfsvlrtot ,0) + coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Totalfrete,ROUND(ROUND (coalesce( 0.001 * nfsvlrtot ,0) + coalesce( taxamin ,0)+  coalesce(((pesoNota -taxa) * (fretepeso)+taxa2),0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(30,31)
                    /*32*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref,ROUND(ROUND(coalesce( 0.001 * nfsvlrtot ,0) + fretevalor * nfsvlrtot ,2)+ ROUND(((pesoNota -taxa) * (fretepeso)+taxa2),2)+ ROUND( pedagio *FracaoFrete,2)+ROUND(  nfsvlrtot  *gris,2),2)
                    as Totalfrete,
                    ROUND(ROUND(coalesce( 0.001 * nfsvlrtot ,0) + ROUND( fretevalor * nfsvlrtot ,2)+ ROUND(((pesoNota -taxa) * (fretepeso)+taxa2),2)+ROUND(nfsvlrtot  *gris,2),2)/imposto ,2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(32)
                    /*33*/
                    insert into tbnt#
                    select tbfrete.seq, tbfrete.ref,ROUND(((ROUND ( coalesce( 0.001 * nfsvlrtot ,0) + (fretevalor * nfsvlrtot),2)  + ROUND ((((pesoNota -taxa)*fretepeso) +taxa2),2) 
                    + ROUND ((nfsvlrtot * gris),2) + ROUND ((pedagio * FracaoFrete),2))/imposto),2) as Totalfrete,
                    ROUND(((ROUND (coalesce( 0.001 * nfsvlrtot ,0) + (fretevalor * nfsvlrtot),2)  + ROUND ((((pesoNota -taxa)*fretepeso) +taxa2),2) 
                    + ROUND ((nfsvlrtot  *gris),2))/imposto),2) as Freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10618249000119 and tbfrete.seq in(33)";
                $aRetorno1 = $PDO->exec($sSql3);
            }
            $sSql1 = "select * from  tbnt#";
            $result = $PDO->query($sSql1);

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*VENTOLOG*/ - Compra OK
        if ($aDados['cnpj'] == '10882366000195') {

            $sSqlAux = "select " . $aDados['cnpj'] . " as cnpj, " . $oNfsNfNro1 . " as nota, "
                    . $oTotalnf . " as nfsvlrtot, " . $oTotalKg . " as pesoNota, "
                    . $oFracaoFrete . " as FracaoFrete,'' as totalfrete, '' as freteminimo into tbnt2#"
                    . " create table tbnt# (
                        seq integer,
                        ref varchar(100),
                        totalfrete money,
                        freteminimo money) ";

            $aRetorno = $PDO->exec($sSqlAux);

            if ($aRetorno == 1) {

                $sSql3 = "insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce((pesoNota * fretepeso),0),2)) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 34.50),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 41.40),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 48.30),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 55.20),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 69.00),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 83.95),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 109.25),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 125.35),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 
                    /*-*/
                    insert into tbnt#
                    select tbfrete.seq , tbfrete.ref,(ROUND ( coalesce(((fretevalor * nfsvlrtot)+ 138),0),2) ) as Totalfrete ,0 as  freteminimo
                    from tbfrete left outer join tbnt2#
                    on tbfrete.cnpj = tbnt2#.cnpj
                    where  tbfrete.cnpj =10882366000195 ";

                $aRetorno1 = $PDO->exec($sSql3);
            }
            $sSql1 = "select * from  tbnt#";
            $result = $PDO->query($sSql1);

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }

        //*vonderlog*/ - Venda
        if ($aDados['cnpj'] == '32241003000375') {

            $sSql1 = "select seq, ref, ROUND (coalesce( (taxamin/100) * nfsvlrtot ,0),2)  AS totalfrete, ROUND (coalesce( (taxamin/100) * nfsvlrtot ,0),2) as  freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $aDados['cnpj'] . " ";
            $result = $PDO->query($sSql1);

            $iI = 0;
            while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
                $aRow1[$iI] = $key;
                $iI++;
            }
        }


        /* verifica regra da tabela de valores */
        $sTotalFrete = '';
        $sFreteMin = '';
        $SeqRegra = '';
        $i = 0;

        foreach ($aRow1 as $value) {
            if ($i == 0) {
                $sTotalFrete = $value['totalfrete'];
                $sFreteMin = $value['freteminimo'];
                $SeqRegra = $value['seq'];
                $i++;
            } else {
                if (abs(number_format(str_replace(',', '.', $aDados['sValorServico']), 0) - number_format($value['totalfrete'])) < abs(number_format(str_replace(',', '.', $aDados['sValorServico']), 0) - number_format($sTotalFrete, 0))) {
                    $sTotalFrete = $value['totalfrete'];
                    $sFreteMin = $value['freteminimo'];
                    $SeqRegra = $value['seq'];
                }
            }
        }

        /* pega o ultimo valor da sequencia da tabela */
        $sSqlMax = "select MAX(nr) + 1 as nr  from tbgerecfrete";
        $dadosSqlMax = $PDO->query($sSqlMax);
        $aMax = $dadosSqlMax->fetch(PDO::FETCH_ASSOC);

        if ($oTotalKg != $aDados['sPeso']) {
            $oTotalKg = $aDados['sPeso'];
        }

        $sSqlNFE = "select count(nrnotaoc) as total,nrconhe from tbgerecfrete where nrnotaoc = " . $oNfsNfNro1 . " "
                . "and cnpj = " . $aDados['cnpj'] . " "
                . "group by nrconhe";
        $dadosSqlNFE = $PDO->query($sSqlNFE);
        $aNFE = $dadosSqlNFE->fetch(PDO::FETCH_ASSOC);
        $aNConhecimento = array();
        if ($aNFE['total'] >= 1) {
            $sSit = 'E';
            $dadosSqlNFE = $PDO->query($sSqlNFE);
            while ($aNFE = $dadosSqlNFE->fetch(PDO::FETCH_ASSOC)) {
                array_push($aNConhecimento, $aNFE['nrconhe']);
            }
            $sConhecimentos = implode(',', $aNConhecimento);
            $obsfinal = 'NFE ' . str_replace("'", "", $oNfsNfNro1) . ' TAMBÉM ESTÁ VINCULADA AO CTE(s) ' . $sConhecimentos;
        }

        /* insere valores nos campos da tabela */
        date_default_timezone_set('America/Sao_Paulo');
        $dados = [
            'nr' => $aMax['nr'],
            'cnpj' => $aDados['cnpj'],
            'nrconhe' => $aDados['sNCTe'],
            'nrfat' => $aDados['fatura'],
            'nrnotaoc' => str_replace("'", "", $oNfsNfNro1),
            'totakg' => $oTotalKg,
            'totalnf' => $oTotalnf,
            'valorserv' => $aDados['sValorServico'],
            'fracaofrete' => $oFracaoFrete,
            'seqregra' => $SeqRegra,
            'codtipo' => $iCodTipo,
            'sit' => $sSit,
            'data' => $aDados['data'],
            'hora' => $aDados['hora'],
            'usuario' => $aDados['usuario'],
            'obsfinal' => $obsfinal,
            'dataem' => $aDados['dataem'],
            'datafn' => $aDados['datafn'],
            'valorserv2' => $sTotalFrete,
            'valorserv3' => $sFreteMin,
        ];
        $sSqlInsert = "INSERT "
                . "INTO tbgerecfrete  ("
                . "nr,"
                . "cnpj,"
                . "nrconhe,"
                . "nrfat,"
                . "nrnotaoc,"
                . "totakg,"
                . "totalnf,"
                . "valorserv,"
                . "fracaofrete,"
                . "seqregra,  "
                . "codtipo,"
                . "sit,"
                . "data,"
                . "hora,"
                . "usuario,"
                . "obsfinal,"
                . "dataem,"
                . "datafn,"
                . "valorserv2,"
                . "valorserv3)"
                . "VALUES("
                . ":nr,"
                . ":cnpj,"
                . ":nrconhe,"
                . ":nrfat,"
                . ":nrnotaoc,"
                . ":totakg,"
                . ":totalnf,"
                . ":valorserv,"
                . ":fracaofrete,"
                . ":seqregra,"
                . ":codtipo,"
                . ":sit,"
                . ":data,"
                . ":hora,"
                . ":usuario,"
                . ":obsfinal,"
                . ":dataem,"
                . ":datafn,"
                . ":valorserv2,"
                . ":valorserv3)";
        $stmt = $PDO->prepare($sSqlInsert);
        $debug = $stmt->execute($dados);
    }

    public function setTagOpen($aDados) {
        $sSql = "update MET_FRETE_FaturaXml set extraido = 'S' where cnpj = " . $aDados['cnpj'] . " and fatura = " . $aDados['fatura'] . "";
        $this->executaSql($sSql);
    }

}
