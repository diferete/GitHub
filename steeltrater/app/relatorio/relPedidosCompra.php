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

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA

$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);
$icont = 0;
$iQnt = 0;

$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 33.78), 1, 0, 'L');


$pdf->SetFont('Arial', '', 15);

$pdf->Cell(110, 10, 'Relatório de Pedidos de Compras', 1, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(53, 5, 'Usuário: ' . $useRel, 'T,R', 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(53, 5, 'Data: ' . $data .
        '  Hora: ' . $hora, 'B, R', 'L');

$pdf->Ln(2);

//busca os dados do banco pegando a op do foreach
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

/* bsuca pdcs baseado nos filtros */
$sSql = "select "
        . "convert(varchar, sup_pedidodata, 103) as sup_pedidodata, "
        . "sup_pedido.sup_pedidoseq "
        . "from sup_pedido "
        . "left outer join sup_pedidoitem "
        . "on sup_pedidoitem.fil_codigo = sup_pedido.fil_codigo "
        . "and sup_pedidoitem.sup_pedidoseq = sup_pedido.sup_pedidoseq "
        . "left outer join cct_centrocusto "
        . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
        . "where "
        . "sup_pedido.sup_pedidosituacao not in('C') "
        . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
        . "and sup_pedido.fil_codigo = 8993358000174 ";
if ($sCCT_Codigos != '') {
    $sSql = $sSql . " and sup_pedidoitemcentrocustocodig in(" . $sCCT_Codigos . ") ";
}
if ($sPedIni !== '') {
    $sSql = $sSql . "and sup_pedido.sup_pedidoseq between '" . $sPedIni . "' and '" . $sPedFim . "' ";
}
$sSql = $sSql . "group by "
        . "sup_pedido.sup_pedidoseq,"
        . "sup_pedidodata "
        . "order by "
        . "sup_pedido.sup_pedidoseq desc";
$dados = $PDO->query($sSql);

/* buscado dados dos itens do pdc baseado nos filtros */
while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
    $sSqlItens = "select sup_pedidoitemseq,"
            . "sup_pedidoitemcentrocustocodig, "
            . "cct_descricao, "
            . "pro_codigo, "
            . "sup_pedidoitemdescricao, "
            . "sup_pedidoitemunidade, "
            . "sup_pedidoitemcomqtd, "
            . "sup_pedidoitemcomvalor, "
            . "sup_pedidoitemvalortotal "
            . "from sup_pedidoitem "
            . "left outer join cct_centrocusto "
            . "on cct_centrocusto.cct_codigo = sup_pedidoitem.sup_pedidoitemcentrocustocodig "
            . "where "
            . "sup_pedidoseq = " . $row['sup_pedidoseq'] . " "
            . "and fil_codigo = 8993358000174 ";
    if ($sCCT_Codigos != '' && $sCCT_Codigos != "''") {
        $sSqlItens = $sSqlItens . " and sup_pedidoitemcentrocustocodig in(" . $sCCT_Codigos . ") ";
    }
    $sSqlItens = $sSqlItens . "order by SUP_PedidoItemCentroCustoCodig desc";
    $dadosItens = $PDO->query($sSqlItens);

    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(125, 5, 'Pedido de compra nrº ' . $row['sup_pedidoseq'], 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, 'Data do pedido: ' . $row['sup_pedidodata'], 0, 1, 'L');
    $pdf->Cell(220, 1, '', 'B', 1, 'L');
    $pdf->Ln(2);
    while ($rowItens = $dadosItens->fetch(PDO::FETCH_ASSOC)) {

        if (!in_array($rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao'], $aCCTs)) {
            array_push($aCCTs, $rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao']);
        }

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(130, 5, trim($rowItens['pro_codigo']) . ' - ' . trim($rowItens['sup_pedidoitemdescricao']), 0, 0, 'L');
        $pdf->Cell(0, 5, 'Centro de custo: ' . $rowItens['sup_pedidoitemcentrocustocodig'] . ' - ' . $rowItens['cct_descricao'], 0, 1, 'L');
        $pdf->Cell(50, 5, 'Qtd. ' . number_format($rowItens['sup_pedidoitemcomqtd'], 4, ',', '.') . ' ' . $rowItens['sup_pedidoitemunidade'], 0, 0, 'L');
        $pdf->Cell(50, 5, 'Vlr unitário R$ ' . number_format($rowItens['sup_pedidoitemcomvalor'], 2, ',', '.'), 0, 0, 'L');
        $pdf->Cell(0, 5, 'Vlr total R$ ' . number_format($rowItens['sup_pedidoitemvalortotal'], 2, ',', '.'), 0, 1, 'L');
        $pdf->Ln(2);
    }
    $pdf->Ln(3);
}
$pdf->Ln(5);
$pdf->Cell(55, 1, '', 'B', 1, 'L');
$pdf->Ln(2);

/* totalizadores por centro de custo baseado nos filtros e itens do pedido */

if ($sCCT_Codigos != '') {
    foreach ($aCCT_CodDesc as $sValue) {
        $aCCT_Dados = explode('-', $sValue);
        $sSqlSum = "select "
                . "SUM(sup_pedidoitemvalortotal) as total "
                . "from SUP_PEDIDOITEM "
                . "left outer join sup_pedido "
                . "on sup_pedido.sup_pedidoseq = sup_pedidoitem.sup_pedidoseq "
                . "and sup_pedido.fil_codigo = sup_pedidoitem.fil_codigo "
                . "where "
                . "sup_pedidoitem.fil_codigo = 8993358000174"
                . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
                . "and sup_pedidoitemcentrocustocodig =  " . $aCCT_Dados[0];
        $dadosSum = $PDO->query($sSqlSum);
        $rowSum = $dadosSum->fetch(PDO::FETCH_ASSOC);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 5, 'Totalizador CCT' . $aCCT_Dados[1] . ': R$' . number_format($rowSum['total'], 2, ',', '.'), 0, 1, 'L');
    }
} else {
    /* totalizadores por centro de custo baseado nos itens do pedido porém sem filtro de centro de custo */

    foreach ($aCCTs as $sValue) {
        $aCCT_Dados = explode('-', $sValue);
        $sSqlSum = "select "
                . "SUM(sup_pedidoitemvalortotal) as total "
                . "from SUP_PEDIDOITEM "
                . "left outer join sup_pedido "
                . "on sup_pedido.sup_pedidoseq = sup_pedidoitem.sup_pedidoseq "
                . "and sup_pedido.fil_codigo = sup_pedidoitem.fil_codigo "
                . "where "
                . "sup_pedidoitem.fil_codigo = 8993358000174"
                . "and sup_pedidodata between '" . $sDataIni . "' and '" . $sDataFim . "' "
                . "and sup_pedidoitemcentrocustocodig =  " . $aCCT_Dados[0];
        $dadosSum = $PDO->query($sSqlSum);
        $rowSum = $dadosSum->fetch(PDO::FETCH_ASSOC);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(18, 5, 'Totalizador CCT' . $aCCT_Dados[1] . ': R$ ' . number_format($rowSum['total'], 2, ',', '.'), 0, 1, 'L');
    }
}


$pdf->Output('I', 'relPedidosCompra.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  


