<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");


//Pega os dados do Request
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora local
$useRel = $_REQUEST['userRel'];
$sPedIni = $_REQUEST['pedini'];
$sPedFim = $_REQUEST['pedfim'];
$sDataIni = $_REQUEST['dataini'];
$sDataFim = $_REQUEST['datafinal'];
$sCCT_Codigos = ''; // usado para fazer filtro IN no sql caso seja passado 1 ou mais ccts (centros de custo)
$aCCTs = array(); // usado para totalizador caso não seja passado nenhum filtro de cct (centro de custo)
if ($_REQUEST['cct_codigos'] != '') {
    $aCCT_CodDesc = explode(';', $_REQUEST['cct_codigos']);
    foreach ($aCCT_CodDesc as $sValue) {
        $aCCT_Dados = explode('-', $sValue);
        if ($sCCT_Codigos == '') {
            $sCCT_Codigos = "'" . rtrim($aCCT_Dados[0]) . "'";
        } else {
            $sCCT_Codigos = $sCCT_Codigos . ",'" . rtrim($aCCT_Dados[0]) . "'";
        }
    }
}
$iFornec = $_REQUEST['SUP_PedidoFornecedor'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('L', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA

$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);
$icont = 0;
$iQnt = 0;

$pdf->Cell(50, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 1, 0, 'L');


$pdf->SetFont('Arial', '', 15);

$pdf->Cell(180, 10, 'Relatório de Pedidos de Compras - Centro de Custos', 1, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(55, 5, 'Usuário: ' . $useRel, 'T,R', 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(55, 5, 'Data: ' . $data .
        '  Hora: ' . $hora, 'B, R', 'L');

$pdf->Ln(4);

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(30, 10, 'Filtros escolhidos:', '', 1, 'L', 0);

$pdf->SetFont('Arial', '', 9);
if ($sPedIni != 0 && $sPedIni != null && $sPedIni != "" && $sPedFim != 0 && $sPedFim != null && $sPedFim != "") {
    $pdf->Cell(70, 10, 'Pedido: ' . $sPedIni . ' até ' . $sPedFim .
            ' ', '', 0, 'L', 0);
}else{
    $pdf->Cell(70, 10, 'Pedido: TODOS ', '', 0, 'L', 0);
}

if ($iFornec != 0 && $iFornec != null && $iFornec != "") {
    $pdf->Cell(70, 10, '   CNPJ fornecedor: ' . $iFornec , '', 0, 'L', 0);
}else{
    $pdf->Cell(70, 10, '   CNPJ fornecedor: TODOS' , '', 0, 'L', 0);
}

if ($sCCT_Codigos != 0 && $sCCT_Codigos != null && $sCCT_Codigos != '') {
    $pdf->Cell(60, 10, 'Centro de custo: ' . $sCCT_Codigos , '', 0, 'L', 0);
}else{
    $pdf->Cell(60, 10, 'Centro de custo: TODOS' , '', 0, 'L', 0);
}

$pdf->Cell(50, 10,
        '              Data inicial: ' . $sDataIni .
        '   Data final: ' . $sDataFim .
        ' ', '', 1, 'L', 0);

$pdf->Ln(4);

//busca os dados do banco pegando a op do foreach
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
//
///* bsuca pdcs baseado nos filtros */
//$sSql = "select "
//        . "convert(varchar, sup_pedidodata, 103) as sup_pedidodata, "
//        . "sup_pedido.sup_pedidoseq "
//        . "from sup_pedido "
//        . "left outer join sup_pedidoitem "
//        . "on sup_pedidoitem.fil_codigo = sup_pedido.fil_codigo "
//        . "and sup_pedidoitem.sup_pedidoseq = sup_pedido.sup_pedidoseq "
//        . "left outer join cct_centrocusto "
//        . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
//        . "where "
//        . "sup_pedido.sup_pedidosituacao not in('C') "
//        . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
//        . "and sup_pedido.fil_codigo = 8993358000174 ";
//if ($sCCT_Codigos != '') {
//    $sSql = $sSql . " and sup_pedidoitemcentrocustocodig in(" . $sCCT_Codigos . ") ";
//}
//if ($sPedIni !== '') {
//    $sSql = $sSql . "and sup_pedido.sup_pedidoseq between '" . $sPedIni . "' and '" . $sPedFim . "' ";
//}
//$sSql = $sSql . "group by "
//        . "sup_pedido.sup_pedidoseq,"
//        . "sup_pedidodata "
//        . "order by "
//        . "sup_pedido.sup_pedidoseq desc";
//$dados = $PDO->query($sSql);
//
///* buscado dados dos itens do pdc baseado nos filtros */
//while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
//    $sSqlItens = "select sup_pedidoitemseq,"
//            . "sup_pedidoitemcentrocustocodig, "
//            . "cct_descricao, "
//            . "pro_codigo, "
//            . "sup_pedidoitemdescricao, "
//            . "sup_pedidoitemunidade, "
//            . "sup_pedidoitemcomqtd, "
//            . "sup_pedidoitemcomvalor, "
//            . "sup_pedidoitemvalortotal "
//            . "from sup_pedidoitem "
//            . "left outer join cct_centrocusto "
//            . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
//            . "where "
//            . "sup_pedidoseq = " . $row['sup_pedidoseq'] . " "
//            . "and fil_codigo = 8993358000174 ";
//    if ($sCCT_Codigos != '' && $sCCT_Codigos != "''") {
//        $sSqlItens = $sSqlItens . " and sup_pedidoitemcentrocustocodig in(" . $sCCT_Codigos . ") ";
//    }
//    $sSqlItens = $sSqlItens . "order by SUP_PedidoItemCentroCustoCodig desc";
//    $dadosItens = $PDO->query($sSqlItens);
//
//    $pdf->SetFont('Arial', 'B', 11);
//    $pdf->Cell(125, 5, 'Pedido de compra nrº ' . $row['sup_pedidoseq'], 0, 0, 'L');
//    $pdf->SetFont('Arial', 'B', 10);
//    $pdf->Cell(18, 5, 'Data do pedido: ' . $row['sup_pedidodata'], 0, 1, 'L');
//    $pdf->Cell(200, 1, '', 'B', 1, 'L');
//    $pdf->Ln(2);
//    while ($rowItens = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
//
//        if (!in_array($rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao'], $aCCTs)) {
//            array_push($aCCTs, $rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao']);
//        }
//
//        $pdf->SetFont('Arial', 'B', 8);
//        $pdf->Cell(125, 5, trim($rowItens['pro_codigo']) . ' - ' . trim($rowItens['sup_pedidoitemdescricao']), 0, 0, 'L');
//        $pdf->Cell(0, 5, 'Centro de custo: ' . $rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao'], 0, 1, 'L');
//        $pdf->SetFont('Arial', '', 9);
//        $pdf->Cell(66, 5, 'Qtd. ' . number_format($rowItens['sup_pedidoitemcomqtd'], 4, ',', '.') . ' ' . $rowItens['sup_pedidoitemunidade'], 0, 0, 'L');
//        $pdf->Cell(60, 5, 'Vlr unitário R$ ' . number_format($rowItens['sup_pedidoitemcomvalor'], 2, ',', '.'), 0, 0, 'L');
//        $pdf->Cell(66, 5, 'Vlr total R$ ' . number_format($rowItens['sup_pedidoitemvalortotal'], 2, ',', '.'), '', 1, 'L');
//        $pdf->SetFont('Arial', '', 8);
//        $pdf->Cell(199, 1, '- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -', '', 1, 'R');
//        $pdf->Ln(3);
//    }
//    $pdf->Ln(3);
//}
//$pdf->Ln(5);
//$pdf->Cell(55, 1, '', 'B', 1, 'L');
//$pdf->Ln(2);
//
///* totalizadores por centro de custo baseado nos filtros e itens do pedido */
//$pdf->SetFont('Arial', 'B', 10);
//$pdf->Cell(18, 5, 'Totalizador CCT (Vlr Total):', 0, 1, 'L');
//$pdf->Ln(2);
//if ($sCCT_Codigos != '') {
//    foreach ($aCCT_CodDesc as $sValue) {
//        $aCCT_Dados = explode('-', $sValue);
//        $sSqlSum = "select "
//                . "SUM(sup_pedidoitemvalortotal) as total "
//                . "from SUP_PEDIDOITEM "
//                . "left outer join sup_pedido "
//                . "on sup_pedido.sup_pedidoseq = sup_pedidoitem.sup_pedidoseq "
//                . "and sup_pedido.fil_codigo = sup_pedidoitem.fil_codigo "
//                . "where "
//                . "sup_pedidoitem.fil_codigo = 8993358000174"
//                . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
//                . "and sup_pedidoitemcentrocustocodig =  " . $aCCT_Dados[0];
//        $dadosSum = $PDO->query($sSqlSum);
//        $rowSum = $dadosSum->fetch(PDO::FETCH_ASSOC);
//        $pdf->SetFont('Arial', '', 10);
//        $pdf->Cell(50, 5, $aCCT_Dados[1], 0, 0, 'L');
//        $pdf->Cell(10, 5, 'R$', 0, 0, 'L');
//        $pdf->Cell(18, 5, number_format($rowSum['total'], 2, ',', '.'), 0, 1, 'R');
//        $pdf->Ln(2);
//    }
//} else {
//    /* totalizadores por centro de custo baseado nos itens do pedido porém sem filtro de centro de custo */
//
//    foreach ($aCCTs as $sValue) {
//        $aCCT_Dados = explode('-', $sValue);
//        $sSqlSum = "select "
//                . "SUM(sup_pedidoitemvalortotal) as total "
//                . "from SUP_PEDIDOITEM "
//                . "left outer join sup_pedido "
//                . "on sup_pedido.sup_pedidoseq = sup_pedidoitem.sup_pedidoseq "
//                . "and sup_pedido.fil_codigo = sup_pedidoitem.fil_codigo "
//                . "where "
//                . "sup_pedidoitem.fil_codigo = 8993358000174"
//                . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
//                . "and sup_pedidoitemcentrocustocodig =  " . $aCCT_Dados[0];
//        $dadosSum = $PDO->query($sSqlSum);
//        $rowSum = $dadosSum->fetch(PDO::FETCH_ASSOC);
//        $pdf->SetFont('Arial', '', 10);
//        $pdf->Cell(50, 5, $aCCT_Dados[1], 0, 0, 'L');
//        $pdf->Cell(10, 5, 'R$ ', 0, 0, 'L');
//        $pdf->Cell(18, 5, number_format($rowSum['total'], 2, ',', '.'), 0, 1, 'R');
//        $pdf->Ln(2);
//    }
//}

/* busca pdcs baseado nos filtros */
$sSql = "select "
        . "sup_pedidoitem.sup_pedidoitemcentrocustocodig "
        . "from sup_pedido "
        . "left outer join sup_pedidoitem "
        . "on sup_pedidoitem.fil_codigo = sup_pedido.fil_codigo "
        . "and sup_pedidoitem.sup_pedidoseq = sup_pedido.sup_pedidoseq "
        . "left outer join cct_centrocusto "
        . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
        . "where "
        . "sup_pedido.sup_pedidosituacao not in('C') "
        . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
        . "and sup_pedido.fil_codigo = 8993358000174 "
        . "and sup_pedidoitemcentrocustocodig <> 0"; //$iFornec
if ($sCCT_Codigos != '') {
    $sSql = $sSql . " and sup_pedidoitemcentrocustocodig in(" . $sCCT_Codigos . ") ";
}
if ($iFornec !== null && $iFornec !== 0 && $iFornec !== '') {
    $sSql = $sSql . " and SUP_PedidoFornecedor = " . $iFornec . " ";
}
if ($sPedIni !== '') {
    $sSql = $sSql . "and sup_pedido.sup_pedidoseq between '" . $sPedIni . "' and '" . $sPedFim . "' ";
}
$sSql = $sSql . "group by "
        . "sup_pedidoitem.sup_pedidoitemcentrocustocodig "
        . "order by "
        . "sup_pedidoitem.sup_pedidoitemcentrocustocodig desc";
$dados = $PDO->query($sSql);


//------------------------------------------------------------------
//* buscado dados dos itens do pdc baseado nos filtros */
while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
    $sSqlItens = "select sup_pedidoitem.sup_pedidoseq, "
            . "sup_pedidoitemseq,"
            . "sup_pedidoitemcentrocustocodig, "
            . "cct_descricao, "
            . "pro_codigo, "
            . "sup_pedidoitemdescricao, "
            . "sup_pedidoitemunidade, "
            . "sup_pedidoitemcomqtd, "
            . "sup_pedidoitemcomvalor, "
            . "sup_pedidoitemvalortotal, "
            . "convert(varchar, sup_pedidoitemdataentrega, 103) as sup_pedidoitemdataentrega "
            . "from sup_pedidoitem "
            . "left outer join sup_pedido "
            . "on sup_pedido.fil_codigo = sup_pedidoitem.fil_codigo "
            . "and sup_pedido.sup_pedidoseq = sup_pedidoitem.sup_pedidoseq "
            . "left outer join cct_centrocusto "
            . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
            . "where "
            . "sup_pedido.fil_codigo = 8993358000174 ";
    if ($iFornec !== null && $iFornec !== 0 && $iFornec !== '') {
        $sSqlItens = $sSqlItens . " and SUP_PedidoFornecedor = " . $iFornec . " ";
    }
    $sSqlItens = $sSqlItens . " and sup_pedidoitemcentrocustocodig in(" . $row['sup_pedidoitemcentrocustocodig'] . ") ";

    $sSqlItens = $sSqlItens . "order by sup_pedidoitemcentrocustocodig desc";
    $dadosItens = $PDO->query($sSqlItens);
    $ik = 0;
    $iValorTotal = 0;
    $sDesc = '';
    while ($rowItens = $dadosItens->fetch(PDO::FETCH_ASSOC)) {

        if (!in_array($rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao'], $aCCTs)) {
            array_push($aCCTs, $rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao']);
        }
        //CABEÇALHO
        if ($ik == 0) {
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(200, 5, $rowItens['cct_descricao'], 0, 1, 'L'); //$rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' .
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(16, 5, 'EMISSÃO', 1, 0, 'C');
            $pdf->Cell(12, 5, 'PEDIDO', 1, 0, 'C');
            $pdf->Cell(67, 5, 'FORNECEDOR', 1, 0, 'C');
            $pdf->Cell(93, 5, 'PRODUTO', 1, 0, 'C');
            $pdf->Cell(19, 5, 'QUANTIDADE', 1, 0, 'C');
            $pdf->Cell(20, 5, 'VLR. UNITÁR.', 1, 0, 'C');
            $pdf->Cell(22, 5, 'VALOR TOTAL', 1, 0, 'C');
            $pdf->Cell(13, 5, 'IPI', 1, 0, 'C');
            $pdf->Cell(13, 5, 'ICMS', 1, 0, 'C');
            $pdf->Cell(12, 5, 'FRETE', 1, 1, 'C');
            $ik++;
        }

        $sSqlAux = "select "
                . "convert(varchar,SUP_PedidoData,103)as SUP_PedidoData,"
                . "SUP_PEDIDO.SUP_PedidoFornecedor as CNPJFornecedor,"
                . "emp_pessoa.EMP_RazaoSocial as Fornecedor, "
                . "SUP_PedidoVlrFrete "
                . "from SUP_PEDIDO "
                . "left outer join EMP_PESSOA "
                . "on SUP_PEDIDO.SUP_PedidoFornecedor = emp_pessoa.EMP_Codigo "
                . "where SUP_PEDIDO.SUP_PedidoSeq = " . $rowItens['sup_pedidoseq'] . " ";
        $dadosRela = $PDO->query($sSqlAux);
        $rowDados = $dadosRela->fetch(PDO::FETCH_ASSOC);

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(16, 5, $rowItens['sup_pedidoitemdataentrega'], 1, 0, 'L');
        $pdf->Cell(12, 5, $rowItens['sup_pedidoseq'], 1, 0, 'R');
        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(67, 5, $rowDados['Fornecedor'], 1, 0, 'L');
        $pdf->Cell(93, 5, substr(trim($rowItens['sup_pedidoitemdescricao']), 0, 72), 1, 0, 'L'); //trim($rowItens['pro_codigo']) . ' - ' .
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(19, 5, number_format($rowItens['sup_pedidoitemcomqtd'], 2, ',', '.') . ' ' . trim($rowItens['sup_pedidoitemunidade']), 1, 0, 'R');
        $pdf->Cell(5, 5, '   R$', 'B,T', 0, 'R');
        $pdf->Cell(15, 5, number_format($rowItens['sup_pedidoitemcomvalor'], 2, ',', '.'), 'R, B, T', 0, 'R');
        $pdf->Cell(5, 5, '   R$', 'B,T', 0, 'R');
        $pdf->Cell(17, 5, number_format($rowItens['sup_pedidoitemvalortotal'], 2, ',', '.'), 'R, B, T', 0, 'R');

        /* IMPOSTOS POR ITEM */
        $sSqlImpostosItem = "select "
                . "SUP_PedidoItemIImposto,"
                . "SUP_PedidoItemIValor,"
                . "SUP_PedidoItemIAliquota "
                . "from SUP_PEDIDOITEMI "
                . "where SUP_PedidoSeq = " . $rowItens['sup_pedidoseq'] . " "
                . "and SUP_PedidoItemSeq =" . $rowItens['sup_pedidoitemseq'] . " "
                . "and FIL_Codigo = 8993358000174 ";
        $sSqlImpostosItem = $sSqlImpostosItem . "order by SUP_PedidoItemIImposto desc";
        $dadosImpostosItem = $PDO->query($sSqlImpostosItem);
        /* Tabela com os tipos de impostos para comparação
          FIS_ImpostoCodigo	FIS_ImpostoDescricao
          1	ICMS
          3	IPI */

        $bIpi = false;
        $bIcms = false;
        while ($rowImpostosItem = $dadosImpostosItem->fetch(PDO::FETCH_ASSOC)) {
            //%IPI
            if ($rowImpostosItem['SUP_PedidoItemIImposto'] == '3') {
                $pdf->Cell(13, 5, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'R');
                $bIpi = true;
            }
            //%ICMS
            if ($rowImpostosItem['SUP_PedidoItemIImposto'] == '1' && $bIpi == false) {
                $pdf->Cell(13, 5, '0,000', 'L,B,T', 0, 'L');
                $pdf->Cell(13, 5, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'R');
                $bIcms = true;
            } elseif ($rowImpostosItem['SUP_PedidoItemIImposto'] == '1' && $bIpi == true) {
                $pdf->Cell(13, 5, number_format($rowImpostosItem['SUP_PedidoItemIAliquota'], 3, ',', '.'), 'L,B,T', 0, 'R');
                $bIcms = true;
            }
        }
        if ($bIpi == true && $bIcms == false) {
            $pdf->Cell(13, 5, '0,00000', 'L,B,T', 0, 'R');
        } elseif ($bIpi == false && $bIcms == false) {
            $pdf->Cell(13, 5, '0,000', 'L,B,T', 0, 'R');
            $pdf->Cell(13, 5, '0,00000', 'L,B,T', 0, 'R');
        }

        $pdf->Cell(12, 5, number_format($rowDados['SUP_PedidoVlrFrete'], 3, ',', '.'), 1, 1, 'R');
        $iValorTotal = $iValorTotal + $rowItens['sup_pedidoitemvalortotal'];
        $sDesc = $rowItens['cct_descricao'];
    }
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(227, 5, 'TOTAL ' . $sDesc, 1, 0, 'L');
    $pdf->Cell(6, 5, 'R$', 'B,T', 0, 'R');
    $pdf->Cell(54, 5, number_format($iValorTotal, 2, ',', '.'), 'R, B, T', 1, 'L');
    $iValorTotal = 0;
    $sDesc = '';
    $pdf->Ln(3);
}

$pdf->Output('I', 'relPedidosCompra.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  


