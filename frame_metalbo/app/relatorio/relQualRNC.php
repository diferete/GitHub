<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
//require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");
date_default_timezone_set('America/Sao_Paulo');

/*
 * Preenche as variáveis com os dados escolhidos nos filtros na tela
 */
$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSit = $_REQUEST['sitmp'];
$sDataIni = $_REQUEST['dataini'];
$sDataFin = $_REQUEST['datafinal'];
$sTipRnc = $_REQUEST['tipornc'];
$sTipFix = $_REQUEST['tipfix'];
//Empresa
$iCnpj = $_REQUEST['Pessoa_empcod'];
$sEmpresa = $_REQUEST['Pessoa_empdes'];
//Problema
$iCodProb = $_REQUEST['codprobl'];
$sDesProb = $_REQUEST['MET_QUAL_Prob_Rnc_descprobl'];
//Setor
$iCodSet = $_REQUEST['cod_set02'];
$sDesSet = $_REQUEST['descset02'];
//Produto
$iCodProd = $_REQUEST['codprod'];
$sDesProd = $_REQUEST['descprod'];
//Tipo de relatório
$iTipo = $_REQUEST['tiprel'];
//Usuário que causou
$sUsuCausa = $_REQUEST['nomfun'];

///////////////////////////////////////////////////////////////////

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Relatório de Não Conformidade', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(5);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(1);

//Filtros
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(15, 5, 'Filtros:', 0, 0, 'L');
//Empresa
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Empresa: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
if ($iCnpj == '75483040000211') {
    $pdf->Cell(87, 5, 'METALBO FILIAL', 0, 0, 'L');
} else {
    if ($iCnpj == '') {
        $pdf->Cell(87, 5, 'Todos', 0, 0, 'L');
    } else {
        $pdf->Cell(87, 5, $sEmpresa, 0, 0, 'L');
    }
}
//Setor
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(12, 5, 'Setor: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(75, 5, $sDesSet, 0, 1, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Ln(1);
//Produto
$pdf->Cell(18, 5, 'Produto: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
if ($sDesProd == '') {
    $pdf->Cell(75, 5, 'Todos', 0, 0, 'L');
} else {
    $pdf->Cell(75, 5, $sDesProd, 0, 0, 'L');
}
//Problema
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(18, 5, 'Problema: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
if ($sDesProb == '') {
    $pdf->Cell(80, 5, 'Todos', 0, 1, 'L');
} else {
    $pdf->Cell(80, 5, $sDesProb, 0, 1, 'L');
}
$pdf->Ln(1);
$pdf->Cell(15, 5, 'Tipo: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sTipRnc, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Tipo Fixador: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sTipFix, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(20, 5, 'Situação: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sSit, 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data Inicial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sDataIni, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data Final: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sDataFin, 0, 1, 'L');

$pdf->Cell(203, 2, '', 'B', 1, 'L');
$pdf->Cell(203, 1, '', 'B', 1, 'L');
$pdf->Ln(2);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

if ($iTipo == '1' || $iTipo == '2') {

//1 - Quantidade de RNC
    $sql = "select count(nr) as TotalRnc from Met_Qual_rnc "
            . "left outer join widl.PROD01 
           on Met_Qual_rnc.codprod = widl.PROD01.procod";

    $sql .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql .= " and usercausa like '%" . $sUsuCausa . "%'";
    }


    $sth = $PDO->query($sql);

    $row = $sth->fetch(PDO::FETCH_ASSOC);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(50, 5, 'QUANTIDADE DE RNCs:', 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->Cell(15, 5, 'Total:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(9, 5, $row['TotalRnc'], 0, 1, 'L');

    $pdf->Cell(203, 2, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(3);

//2 - Quantidade de RNC aberta e fechada mensalmente 
    $sql1 = " select count(nr) as totalrnc,sit   from Met_Qual_rnc left outer join widl.PROD01 
           on Met_Qual_rnc.codprod = widl.PROD01.procod ";

    $sql1 .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql1 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql1 .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql1 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql1 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql1 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql1 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql1 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql1 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql1 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }

    $sql1 .= " group by sit ";

    $sth1 = $PDO->query($sql1);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'QUANTIDADE DE RNCs DE ACORDO COM A SITUAÇÃO:', '', 1, 'L');
    $pdf->Ln(2);

    while ($row1 = $sth1->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Situação:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row1['sit'], 'B', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row1['totalrnc'], 'B', 1, 'L');
    }

    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(3);

//3 - Número de RNC gerada em porcas - Número de RNC gerada em Parafusos
    $sql2 = " select count(nr) as totalrnc,case grucod when 12  then ' 12-Porca '
        when 13 then  '13-Parafuso ' END grucod from  Met_Qual_rnc  
        left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod ";

    if ($sTipFix == "Porca") {
        $sql2 .= " where grucod in(12) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
    } else if ($sTipFix == "Parafuso") {
        $sql2 .= " where grucod in(13) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
    } else {
        $sql2 .= " where grucod in(12,13) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
    }
    if ($iCodProd != '') {
        $sql2 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql2 .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql2 .= " and sit = '" . $sSit . "'";
    }
    if ($iCnpj != '') {
        $sql2 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql2 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql2 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql2 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }

    $sql2 .= " group by grucod";

    $sth2 = $PDO->query($sql2);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'NÚMERO DE RNCs GERADAS EM PORCAS E PARAFUSOS:', '', 1, 'L');
    $pdf->Ln(2);

    while ($row2 = $sth2->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Tipo:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row2['grucod'], 'B', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row2['totalrnc'], 'B', 1, 'L');
    }

    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(3);
}

if ($iTipo == '1' || $iTipo == '3') {
    /* 3.1.1 - Quando for do PROCESSO considerar o peso da peça X quantidade de peças não conformes.
      Assim tenho a informação do montante de peças não conformes geradas no processo.
      Se possivel conseguir o peso separado por setor causador e correção. */

    $sql3 = "select tipornc ,sum  (qtloternc/100 * propesprat ) as PesoNconforme ,decisaornc
from Met_Qual_rnc left outer join widl.PROD01 
on Met_Qual_rnc.codprod = widl.PROD01.procod  
where tipornc ='Processo'  and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql3 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sSit != 'Todos') {
        $sql3 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql3 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql3 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql3 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql3 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql3 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql3 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }

    $sql3 .= " group by tipornc,decisaornc";

    $sth3 = $PDO->query($sql3);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DAS PEÇAS NÃO CONFORMES GERADAS DE ACORDO COM A DECISÃO DAS RNCs:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(57, 5, 'Tipo', 'B', 0, 'L');
    $pdf->Cell(77, 5, 'Peso não Conforme', 'B', 0, 'L');
    $pdf->Cell(67, 5, 'Decisão RNC', 'B', 1, 'L');

    while ($row3 = $sth3->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(57, 5, $row3['tipornc'], 'B', 0, 'L');
        $pdf->Cell(77, 5, number_format($row3['PesoNconforme'], 2, ',', '.'), 'B', 0, 'L');
        $pdf->Cell(67, 5, $row3['decisaornc'], 'B', 1, 'L');
    }

    $pdf->Ln(5);
}

if ($iTipo == '1' || $iTipo == '4') {
    /* 3.1.2 - Quando for do PROCESSO considerar o peso da peça X quantidade de peças não conformes.
      Assim tenho a informação do montante de peças não conformes geradas no processo.
      Se possivel conseguir o peso separado por setor causador e correção. */

    $sql4 = "select  descset02,sum  (qtloternc/100 * propesprat ) as PesoNconforme ,decisaornc  
from Met_Qual_rnc left outer join widl.PROD01 
on Met_Qual_rnc.codprod = widl.PROD01.procod  
where tipornc <> 'Fornecedor' and descset02 is not null and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql4 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sSit != 'Todos') {
        $sql4 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql4 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql4 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql4 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql4 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql4 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql4 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }

    $sql4 .= " group by descset02,decisaornc";

    $sth4 = $PDO->query($sql4);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DAS PEÇAS NÃO CONFORMES GERADAS DE ACORDO COM A DECISÃO DAS RNCs POR SETOR:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(81, 5, 'Descrição setor', 'B', 0, 'L');
    $pdf->Cell(60, 5, 'Peso não Conforme', 'B', 0, 'L');
    $pdf->Cell(60, 5, 'Decisão RNC', 'B', 1, 'L');

    while ($row4 = $sth4->fetch(PDO::FETCH_ASSOC)) {


        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(81, 5, $row4['descset02'], 'B', 0, 'L');
        $pdf->Cell(60, 5, number_format($row4['PesoNconforme'], 2, ',', '.'), 'B', 0, 'L');
        $pdf->Cell(60, 5, $row4['decisaornc'], 'B', 1, 'L');
        $pdf = quebraPagina($pdf->GetY(), $pdf);
    }

    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(5);
}
if ($iTipo == '1' || $iTipo == '5') {
    /* 3.2 - Quando for FORNECEDOR preciso das duas informações: peso da peça X quantidade de peças não conformes 
      Assim tenho a informação do montante de peças não conformes geradas no processo.
      Peso da peça X quantidade do lote, para ter a informação do peso do lote devolvido. Se possivel conseguir o peso separado por setor causador e correção. */

    $sql5 = "select tipornc , fornec,decisaornc,
        sum  (qtloternc/100 * propesprat ) as PesoNconforme , sum  (qtlote/100 * propesprat ) as PesoLote  
        from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod  
        where tipornc ='Fornecedor' and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql5 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sSit != 'Todos') {
        $sql5 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql5 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql5 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql5 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql5 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql5 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql5 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }
    $sql5 .= " group by tipornc,fornec,decisaornc";

    $sth5 = $PDO->query($sql5);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DE PEÇAS NÃO CONFORMES NO PROCESSO E LOTE DEVOLVIDO:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(25, 5, 'Tipo RNC', 'B', 0, 'L');
    $pdf->Cell(85, 5, 'Fornecedor', 'B', 0, 'L');
    $pdf->Cell(40, 5, 'Decisao RNC', 'B', 0, 'L');
    $pdf->Cell(30, 5, 'Peso não Conforme', 'B', 0, 'L');
    $pdf->Cell(25, 5, 'Peso Lote', 'B', 1, 'L');

    while ($row5 = $sth5->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(25, 5, $row5['tipornc'], 'B', 0, 'L');
        $pdf->Cell(85, 5, $row5['fornec'], 'B', 0, 'L');
        $pdf->Cell(40, 5, $row5['decisaornc'], 'B', 0, 'L');
        $pdf->Cell(30, 5, number_format($row5['PesoNconforme'], 2, ',', '.'), 'B', 0, 'L');
        $pdf->Cell(25, 5, number_format($row5['PesoLote'], 2, ',', '.'), 'B', 1, 'L');
        $pdf = quebraPagina($pdf->GetY(), $pdf);
    }

    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(5);
}
if ($iTipo == '1' || $iTipo == '2') {
    /* 4 - Quantidades baseadas na origem da RNC */
    $sql6 = " select tipornc,count(nr) as TotalRnc from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod   ";

    $sql6 .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql6 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql6 .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql6 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql6 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql6 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql6 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql6 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql6 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql6 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }

    $sql6 .= " group by tipornc ";

    $sth6 = $PDO->query($sql6);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'QUANTIDADES BASEADAS NA ORIGEM DA RNC:', '', 1, 'L');
    $pdf->Ln(2);

    while ($row6 = $sth6->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Tipo RNC:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row6['tipornc'], 'B', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(50, 5, $row6['TotalRnc'], 'B', 1, 'L');
    }

    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(3);

    /* 5 - Quantidades baseadas no setor causador da RNC */
    $sql7 = " select descset02,count(nr) as TotalRnc from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod   ";

    $sql7 .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql7 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sSit != 'Todos') {
        $sql7 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql7 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql7 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql7 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql7 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql7 .= " and codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql7 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }
    $sql7 .= " and tipornc <> 'Fornecedor' and descset02 is not null group by descset02 ";

    $sth7 = $PDO->query($sql7);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'QUANTIDADES BASEADAS NO SETOR CAUSADOR DA RNC:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(100, 5, 'Descrição Setor:', 'B', 0, 'L');
    $pdf->Cell(100, 5, 'Total RNC:', 'B', 1, 'L');

    while ($row7 = $sth7->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(100, 5, $row7['descset02'], 'B', 0, 'L');
        $pdf->Cell(100, 5, $row7['TotalRnc'], 'B', 1, 'L');
        $pdf = quebraPagina($pdf->GetY(), $pdf);
    }
}
if ($iTipo == '1') {
    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(5);
}
/*
 * TIPO DE PROBLEMA-FILTRO DE DATA 
 */
if ($iTipo == '1' || $iTipo == '6') {
    $sql8 = " select MET_QUAL_Rnc.codprobl, descprobl,
          case when SUM ((qtloternc/100) * propesprat) is null then 0
          else SUM ((qtloternc/100) * propesprat) end as  PESODEFEITO2 
          from MET_QUAL_Rnc left outer join 
          widl.prod01 on  widl.prod01.procod = MET_QUAL_Rnc.codprod 
           left outer join MET_QUAL_Prob_Rnc on MET_QUAL_Rnc.codprobl = MET_QUAL_Prob_Rnc.codprobl ";

    $sql8 .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql8 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql8 .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql8 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql8 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql8 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql8 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql8 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql8 .= " and MET_QUAL_Rnc.codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql8 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }
    $sql8 .= " GROUP BY MET_QUAL_Rnc.codprobl,descprobl ORDER BY MET_QUAL_Rnc.codprobl ";

    $sth8 = $PDO->query($sql8);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DEFEITO CONFORME O PROBLEMA DAS RNCs', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(60, 5, 'Código Problema:', 'B', 0, 'L');
    $pdf->Cell(80, 5, 'Descrição Problema:', 'B', 0, 'L');
    $pdf->Cell(80, 5, 'Peso com Defeito:', 'B', 1, 'L');

    while ($row8 = $sth8->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(60, 5, $row8['codprobl'], 'B', 0, 'L');
        $pdf->Cell(80, 5, $row8['descprobl'], 'B', 0, 'L');
        $pdf->Cell(80, 5, number_format($row8['PESODEFEITO2'], 2, ',', '.'), 'B', 1, 'L');
        $pdf = quebraPagina($pdf->GetY(), $pdf);
    }

    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(5);
}
if ($iTipo == '1' || $iTipo == '7') {
    /*
     * TIPO DE PROBLEMA POR SETOR-FILTRO DE SETOR 
     */

    $sql9 = " select  descset02, descprobl,
          case when SUM ((qtloternc/100) * propesprat) is null then  0
          else SUM ((qtloternc/100) * propesprat) end as  PESODEFEITO2  
          from MET_QUAL_Rnc left outer join 
          widl.prod01 on  widl.prod01.procod = MET_QUAL_Rnc.codprod 
          left outer join MET_QUAL_Prob_Rnc on MET_QUAL_Rnc.codprobl = MET_QUAL_Prob_Rnc.codprobl ";

    $sql9 .= " where databert between '" . $sDataIni . "' and '" . $sDataFin . "' and descset02 is not null ";
    if ($iCodProd != '') {
        $sql9 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sTipRnc != 'Todos') {
        $sql9 .= " and tipornc = '" . $sTipRnc . "'";
    }
    if ($sSit != 'Todos') {
        $sql9 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql9 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql9 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql9 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql9 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql9 .= " and MET_QUAL_Rnc.codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql9 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }
    $sql9 .= " GROUP BY MET_QUAL_Rnc.codprobl,descprobl,descset02 
           ORDER BY  descset02,descprobl  ";

    $sth9 = $PDO->query($sql9);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DEFEITO CONFORME O PROBLEMA DAS RNCs POR SETOR:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(80, 5, 'Descrição Setor:', 'B', 0, 'L');
    $pdf->Cell(80, 5, 'Descrição Problema:', 'B', 0, 'L');
    $pdf->Cell(40, 5, 'Peso com Defeito:', 'B', 1, 'L');

    while ($row9 = $sth9->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(80, 5, $row9['descset02'], 'B', 0, 'L');
        $pdf->Cell(80, 5, $row9['descprobl'], 'B', 0, 'L');
        $pdf->Cell(40, 5, number_format($row9['PESODEFEITO2'], 2, ',', '.'), 'B', 1, 'L');
        $pdf = quebraPagina($pdf->GetY(), $pdf);
    }


    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    $pdf->Cell(203, 5, '', 'B', 1, 'L');
    $pdf->Cell(203, 1, '', 'B', 1, 'L');
    $pdf->Ln(5);
}
if ($iTipo == '1' || $iTipo == '8') {
    /*
     * TIPO DE PROBLEMA- problema//FILTRO DE DATA 
     */

    $sql11 = " select cnpj,empdes as fornec,MET_QUAL_Rnc.codprobl, descprobl,SUM ((qtloternc/100) * propesprat) AS PESODEFEITO  , 
           case when SUM ((qtloternc/100) * propesprat) is null then 0
           else SUM ((qtloternc/100) * propesprat) end as  PESODEFEITO2
           from MET_QUAL_Rnc left outer join 
           widl.prod01 on  widl.prod01.procod = MET_QUAL_Rnc.codprod 
           left outer join MET_QUAL_Prob_Rnc on MET_QUAL_Rnc.codprobl = MET_QUAL_Prob_Rnc.codprobl
           left outer join widl.emp01 on MET_QUAL_Rnc.cnpj = widl.emp01.empcod
           where tipornc ='Fornecedor'";

    $sql11 .= " and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($iCodProd != '') {
        $sql11 .= " and codprod = '" . $iCodProd . "'";
    }
    if ($sSit != 'Todos') {
        $sql11 .= " and sit = '" . $sSit . "'";
    }
    if ($sTipFix == "Porca") {
        $sql11 .= " and grucod in(12)";
    } else if ($sTipFix == "Parafuso") {
        $sql11 .= " and grucod in(13)";
    }
    if ($iCnpj != '') {
        $sql11 .= " and cnpj = '" . $iCnpj . "'";
    }
    if ($iCodSet != '') {
        $sql11 .= " and cod_set02 = '" . $iCodSet . "'";
    }
    if ($iCodProb != '') {
        $sql11 .= " and MET_QUAL_Rnc.codprobl = '" . $iCodProb . "'";
    }
    if ($sUsuCausa) {
        $sql11 .= " and usercausa like '%" . $sUsuCausa . "%'";
    }
    $sql11 .= " GROUP BY cnpj,fornec,MET_QUAL_Rnc.codprobl,descprobl, empdes
            ORDER BY cnpj, MET_QUAL_Rnc.codprobl";

    $sth11 = $PDO->query($sql11);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(203, 5, 'PESO DEFEITO CONFORME O PROBLEMA DAS RNCs POR FORNECEDOR:', '', 1, 'L');
    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(30, 5, 'CNPJ', 'B', 0, 'L');
    $pdf->Cell(85, 5, 'Fornecedor', 'B', 0, 'L');
    $pdf->Cell(18, 5, 'Codigo', 'B', 0, 'L');
    $pdf->Cell(43, 5, 'Descrição Problema', 'B', 0, 'L');
    $pdf->Cell(25, 5, 'Peso Defeito', 'B', 1, 'L');
    $iQuantPeso = 0;
    $iQuantPEmpresa = 0;
    $sEmp = '';
    while ($row11 = $sth11->fetch(PDO::FETCH_ASSOC)) {
        $sAux = $row11['cnpj'];
        if ($sEmp == '' || $sEmp == $sAux) {
            $sEmp = $sAux;
            $iQuantPEmpresa = $iQuantPEmpresa + $row11['PESODEFEITO2'];
        } else {
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(156, 5, '', '', 0, 'L');
            $pdf->Cell(20, 5, 'TOTAL:', 'B', 0, 'L');
            $pdf->SetFont('arial', '', 8);
            $pdf->Cell(25, 5, number_format($iQuantPEmpresa, 2, ',', '.'), 'B', 1, 'L');
            $iQuantPEmpresa = $row11['PESODEFEITO2'];
            $sEmp = $sAux;
            $pdf->Ln(5);
        }
        $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(30, 5, $row11['cnpj'], 'B', 0, 'L');
        $pdf->Cell(85, 5, $row11['fornec'], 'B', 0, 'L');
        $pdf->Cell(18, 5, $row11['codprobl'], 'B', 0, 'L');
        $pdf->Cell(43, 5, $row11['descprobl'], 'B', 0, 'L');
        $pdf->Cell(25, 5, number_format($row11['PESODEFEITO2'], 2, ',', '.'), 'B', 1, 'L');
        $iQuantPeso = $iQuantPeso + $row11['PESODEFEITO2'];
    }
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(156, 5, '', '', 0, 'L');
    $pdf->Cell(20, 5, 'TOTAL:', 'B', 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(25, 5, number_format($iQuantPEmpresa, 2, ',', '.'), 'B', 1, 'L');

    $pdf->Ln(5);
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(136, 5, '', '', 0, 'L');
    $pdf->Cell(40, 5, 'SOMA PESO TOTAL:', 'B', 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(25, 5, number_format($iQuantPeso, 2, ',', '.'), 'B', 0, 'L');
}
$pdf->Output('I', 'relQualRNC.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
