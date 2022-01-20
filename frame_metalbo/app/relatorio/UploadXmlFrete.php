<?php

include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

/* variáveis em geral */
date_default_timezone_set('America/Sao_Paulo');
$fatura = $_REQUEST['fatura'];
$cnpj = $_REQUEST['cnpj'];
$arquivo = $_REQUEST['xml'];
$dataem = $_REQUEST['dataEmit'];
$datafn = $_REQUEST['dataVenc'];
$data = date('d/m/Y');
$hora = date('H:i:s');
$usuario = $_REQUEST['usuario'];
$oNfsNfNro1 = '';
$oTotalnf = 0;
$oTotalKg = 0;
$obsfinal = null;
$sNFE = '';
$sSit = 'A';

/* carrega os dados do XML em variaveis para uso geral */
$oXml = simplexml_load_file($arquivo);
$sNCTe = (string) $oXml->CTe->infCte->ide->nCT;
$sValorServico = (string) $oXml->CTe->infCte->vPrest->vTPrest;
$sCNPJCliente = (string) $oXml->CTe->infCte->dest->CNPJ;
$aObjetoChaves = (array) $oXml->CTe->infCte->infCTeNorm->infDoc;
$sValorCarga = (string) $oXml->CTe->infCte->infCTeNorm->infCarga->vCarga;
if ($cnpj == '428307001593') {
    $aPeso = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[1]; //->qCarga;
} else {
    $aPeso = (array) $oXml->CTe->infCte->infCTeNorm->infCarga->infQ[4]; //->qCarga;
}
$sPeso = $aPeso['qCarga'];

/* veriica se existem mais de uma nota/chave referente ao CTE e concatena ambas */
foreach ($aObjetoChaves as $key => $chaves) {
    $total = count($chaves); //número de elementos
    if ($total > 1) {
        foreach ($chaves as $chave) {
            if ($sNFE == '') {
                $sNFE = "'" . substr((string) $chave->chave, 25, 9) . "'";
            } else {
                $sNFE = $sNFE . ",'" . substr((string) $chave->chave, 25, 9) . "'";
            }
        }
    } else {
        $sNFE = "'" . substr((string) $chaves->chave, 25, 9) . "'";
    }
}

/* VALIDAÇÃO DO TIPO DE CTE - COMPRA OU VENDA - */
/* seleciona na tabela do faturamento os dados da NFE referente ao CTE */
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = " select "
        . "nfsnfnro,"
        . "nfsvlrtot,"
        . "Ceiling(nfspesobr) as pesoNota,"
        . "'" . $cnpj . "' as cnpj ,"
        . "'' as totalfrete,"
        . "'' as freteminimo "
        . "from widl.NFC001 "
        . "left outer join widl.EMP01 "
        . "on widl.NFC001.nfsclicod = widl.EMP01.empcod "
        . "where nfsnfnro in(" . $sNFE . ") "
        . "and widl.EMP01.empcl = 'C' "
        . "and nfsfilcgc = 75483040000211 "
        . "and nfsclicgc = " . $sCNPJCliente . "";
$dadosSql = $PDO->query($sSql);
$aDadosNF1 = $dadosSql->fetch(PDO::FETCH_ASSOC);
/* se nao existe na NFC001 retorna false e busca na NFE01 */
if (!$aDadosNF1 || $aDadosNF1 == null) {
    /* compra */
    $sSql2 = "select nfenro as nfsnfnro,"
            . "nfevlrnota as nfsvlrtot,"
            . "nfetransp as cnpj "
            . "from widl.NFE01 "
            . "where nfetransp ='" . $cnpj . "' "
            . "and  nfenro in(" . $sNFE . ") ";
    $dadosSql2 = $PDO->query($sSql2);
    $oRow1 = $dadosSql2->fetch(PDO::FETCH_ASSOC);
    /* validação caso não tenha nota de compra */
    /* caso não ache na NFE01 carrega valores direto do XML */
    if (!$oRow1 || $oRow1 == null) {
        $iCodTipo = 2;
        $oTotalnf = $sValorCarga;
        $oTotalKg = $sPeso;
        $sSit = 'E';
        if ($total > 1) {
            $aNFE = explode(',', $sNFE);
            $oNfsNfNro1 = str_replace("'", "", $aNFE[0]);
        } else {
            $oNfsNfNro1 = str_replace("'", "", $sNFE);
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
            $oTotalKg = $sPeso;
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
if ($total > 1) {
    $obsfinal = $oNfsNfNro2;
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
if (($cnpj == '3565095000260') || ($cnpj == '428307001593') || ($cnpj == '2633583000385') || ($cnpj == '4353469003504') || ($cnpj == '89317697001880') || ($cnpj == '32241003000375')) {

    $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH "
            . " BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
            . "select " . $cnpj . " as cnpj, " . $oNfsNfNro1 . " as nota, "
            . $oTotalnf . " as nfsvlrtot, " . $oTotalKg . " as pesoNota, "
            . $oFracaoFrete . " as FracaoFrete,'' as totalfrete, '' as freteminimo into tbnt#";
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
if ($cnpj == '3565095000260') {

    if ($aRetorno == 1) {
        $sSql1 = "create table tbnt2# (
                    seq integer,
                    ref varchar(100),
                    totalfrete money,
                    freteminimo money)    
                insert into tbnt2#   
                /*vendas = 1,2,3,4,5,6,17,18*/
                select seq, ref, ROUND(
                    ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2) * imposto/100 
                    +ROUND(ROUND( fretevalor  * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio *FracaoFrete,2)+taxa2 +tas +(nfsvlrtot *gris)  ,2),2 ) as totalfrete,
                    ROUND(
                    ROUND(ROUND( fretevalor * nfsvlrtot ,2)  +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) *imposto/100 
                    +ROUND(ROUND( fretevalor * nfsvlrtot ,2)+ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+ (nfsvlrtot *gris)  ,2),2 ) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $cnpj . " and SEQ not in(11,12,13,14,15,16) and codtipo = 1
                insert into tbnt2#
                /*vendas = 16*/
                select seq, ref, ROUND(
                    ROUND(ROUND( (fretevalor * nfsvlrtot) ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2) ,2 ) as totalfrete,
                    ROUND(
                    ROUND(ROUND( (fretevalor * nfsvlrtot) ,2)  +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $cnpj . " and SEQ in(16) and codtipo = 1
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
                    where tbfrete.cnpj =" . $cnpj . " and SEQ in(11,12,13,14,15) and codtipo = 1 
                insert into tbnt2#   
                /*compras = TODOS*/
                select seq, ref, ROUND(
                    ROUND(ROUND( fretevalor * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+(nfsvlrtot *gris)  ,2) * imposto/100 
                    +ROUND(ROUND( fretevalor  * nfsvlrtot ,2) +ROUND( pesoNota * fretepeso,2) +ROUND( pedagio *FracaoFrete,2)+taxa2 +tas +(nfsvlrtot *gris)  ,2),2 ) as totalfrete,
                    ROUND(
                    ROUND(ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2)* imposto/100  
                    + ROUND(ROUND( pedagio * FracaoFrete,2)+taxa2 +tas+taxa+(nfsvlrtot *gris)   ,2) ,2) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where tbfrete.cnpj =" . $cnpj . " and codtipo = 2";

        $result1 = $PDO->exec($sSql1);
    }
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
if ($cnpj == '428307001593') {

    if ($aRetorno == 1) {
        $sSql1 = "select seq, ref, ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+
                coalesce(  nfsvlrtot * gris, 0),2)/imposto,2)  as totalfrete,
                ROUND(ROUND(coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( taxamin +(pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+
                coalesce( taxa,0),2)/imposto,2)  as freteminimo
                from tbfrete left outer join tbnt#
                on tbfrete.cnpj = tbnt#.cnpj
                where  tbfrete.cnpj = " . $cnpj . " ";

        $result = $PDO->query($sSql1);
    }

    $iI = 0;
    while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
        $aRow1[$iI] = $key;
        $iI++;
    }
}

//*leomar*/ - Venda OK
if ($cnpj == '2633583000385') {

    if ($aRetorno == 1) {

        $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce( (pesoNota * fretepeso),0)+coalesce( pedagio *FracaoFrete,0)+ TAXA2 + tas +
                    coalesce(nfsvlrtot  *gris,0) ,2)/imposto  AS totalfrete
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $cnpj . " ";
        $result = $PDO->query($sSql1);
    }
    $iI = 0;
    while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
        $aRow1[$iI] = $key;
        $iI++;
    }
}

//*bauer*/ - Venda OK
if ($cnpj == '4353469003504') {

    if ($aRetorno == 1) {
        $sSql1 = "select seq, ref, ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  nfsvlrtot  *gris,0) as totalfrete, 
                    ROUND (coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) ,2)*imposto + coalesce( fretevalor * nfsvlrtot ,0)  + coalesce((pesoNota * fretepeso),0) + coalesce( pedagio *FracaoFrete,0)+ 
                    coalesce(  taxa2,0) as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $cnpj . " ";
        $result = $PDO->query($sSql1);
    }

    $iI = 0;
    while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
        $aRow1[$iI] = $key;
        $iI++;
    }
}

//*TW TRANSPORTES E LOGISTICA */ - Venda OK
if ($cnpj == '89317697001880') {

    if ($aRetorno == 1) {
        $sSql1 = "select 'tw'as cliente, ref, seq ,ROUND(ROUND (coalesce( fretevalor * nfsvlrtot ,0)+  coalesce(((pesoNota * fretepeso)+taxamin),0)+ coalesce( pedagio *FracaoFrete,0)+
                    coalesce(  nfsvlrtot  *gris,0),2)/ imposto ,2) as totalfrete, '' as freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $cnpj . "";
        $result = $PDO->query($sSql1);
    }

    $iI = 0;
    while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
        $aRow1[$iI] = $key;
        $iI++;
    }
}

//*SNM TRANSPORTES LTDA*/ - Venda OK
if ($cnpj == '10618249000119') {


    $sSqlAux = "BEGIN TRY DROP TABLE tbnt# END TRY BEGIN CATCH END CATCH"
            . " BEGIN TRY DROP TABLE tbnt2# END TRY BEGIN CATCH END CATCH "
            . "select " . $cnpj . " as cnpj, " . $oNfsNfNro1 . " as nota, "
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
if ($cnpj == '10882366000195') {

    $sSqlAux = "select " . $cnpj . " as cnpj, " . $oNfsNfNro1 . " as nota, "
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
if ($cnpj == '32241003000375') {

    $sSql1 = "select seq, ref, ROUND (coalesce( (taxamin/100) * nfsvlrtot ,0),2)  AS totalfrete, ROUND (coalesce( (taxamin/100) * nfsvlrtot ,0),2) as  freteminimo
                    from tbfrete left outer join tbnt#
                    on tbfrete.cnpj = tbnt#.cnpj
                    where  tbfrete.cnpj = " . $cnpj . " ";
    $result = $PDO->query($sSql1);

    $iI = 0;
    while ($key = $result->fetch($PDO::FETCH_ASSOC)) {
        $aRow1[$iI] = $key;
        $iI++;
    }
}


/* verifica regra da tabela de valores */
foreach ($aRow1 as $value) {
    if ((number_format($value['totalfrete'], 0) == number_format(str_replace(',', '.', $sValorServico), 0)) ||
            number_format($value['freteminimo'], 0) == number_format(str_replace(',', '.', $sValorServico), 0)) {
        $SeqRegra = $value['seq'];
    }
}

/* pega o ultimo valor da sequencia da tabela */
$sSqlMax = "select MAX(nr) + 1 as nr  from tbgerecfrete";
$dadosSqlMax = $PDO->query($sSqlMax);
$aMax = $dadosSqlMax->fetch(PDO::FETCH_ASSOC);

if ($oTotalKg != $sPeso) {
    $oTotalKg = $sPeso;
}

/* insere valores nos campos da tabela */
date_default_timezone_set('America/Sao_Paulo');
$dados = [
    'nr' => $aMax['nr'],
    'cnpj' => $cnpj,
    'nrconhe' => $sNCTe,
    'nrfat' => $fatura,
    'nrnotaoc' => str_replace("'", "", $oNfsNfNro1),
    'totakg' => $oTotalKg,
    'totalnf' => $oTotalnf,
    'valorserv' => $sValorServico,
    'fracaofrete' => $oFracaoFrete,
    'seqregra' => $SeqRegra,
    'codtipo' => $iCodTipo,
    'sit' => $sSit,
    'data' => $data,
    'hora' => $hora,
    'usuario' => $usuario,
    'obsfinal' => $obsfinal,
    'dataem' => $dataem,
    'datafn' => $datafn,
    'valorserv2' => $value['totalfrete'],
    'valorserv3' => $value['freteminimo'],
];
$sSqlInsert = "INSERT INTO tbgerecfrete 
 (nr, cnpj, nrconhe, nrfat, nrnotaoc, totakg, totalnf, valorserv, fracaofrete, seqregra, 
 codtipo, sit, data, hora, usuario, obsfinal, dataem, datafn, valorserv2, valorserv3)
 VALUES
 (:nr, :cnpj, :nrconhe, :nrfat, :nrnotaoc, :totakg, :totalnf, :valorserv, :fracaofrete, :seqregra,
 :codtipo, :sit, :data, :hora, :usuario, :obsfinal, :dataem, :datafn, :valorserv2, :valorserv3)";
$stmt = $PDO->prepare($sSqlInsert);
$debug = $stmt->execute($dados);


return;
