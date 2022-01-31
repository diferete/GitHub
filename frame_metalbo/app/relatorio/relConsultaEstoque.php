<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");
include("../../biblioteca/Utilidades/Util.php");


date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sUser = $_REQUEST['userRel'];
$iGrucod = $_REQUEST['grucod'];
$iGrucodFin = $_REQUEST['grucodfin'];
$iSubcod = $_REQUEST['subcod'];
$iSubcodFin = $_REQUEST['subcodfin'];
$iFamcod = $_REQUEST['famcod'];
$iFamcodFin = $_REQUEST['famcodfin'];
$iFamsub = $_REQUEST['famsub'];
$iFamsubFin = $_REQUEST['famsubfin'];

$sGrudes = $_REQUEST['grudes'];
$sSubGrudes = $_REQUEST['subdes'];
$sFamdes = $_REQUEST['famdes'];
$sSubFamdes = $_REQUEST['famsdes'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 20); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(95, 10, 'Estoque de produto acabado', 0, 0, 'L');


$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(100, 5, 'Usuário: ' . $sUser, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sSql = "SELECT "
        . "tbestWeb.procod,tbestWeb.prodes,estoque,unm,estoquePeso,DataEst "
        . "FROM tbestWeb "
        . "LEFT JOIN widl.prod01 "
        . "ON tbestWeb.procod = widl.prod01.procod "
        . "WHERE grucod BETWEEN '" . $iGrucod . "' AND '" . $iGrucodFin . "' "
        . "AND subcod BETWEEN '" . $iSubcod . "' AND '" . $iSubcodFin . "' "
        . "AND famcod BETWEEN '" . $iFamcod . "' AND '" . $iFamcodFin . "' "
        . "AND famsub BETWEEN '" . $iFamsub . "' AND '" . $iFamsubFin . "' "
        . "and widl.prod01.procod not in('54264') "
        . "and tbestWeb.procod is not null "
        . "ORDER BY  widl.prod01.procod asc ";
$dadosSql = $PDO->query($sSql);

$pdf->Ln(8);

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(150, 5, 'Filtros:', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);

$pdf->Ln(2);

if ($iGrucod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(150, 5, $iGrucod . ' - ' . $sGrudes, 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
}
if ($iSubcod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(150, 5, $iSubcod . ' - ' . $sSubGrudes, 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
}
if ($iFamcod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(150, 5, $iFamcod . ' - ' . $sFamdes, 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
}
if ($iFamsub == 0) {
    
} else {
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(150, 5, $iFamsub . ' - ' . $sSubFamdes, 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
}

$pdf->Ln(8);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(150, 5, 'Item', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(28, 5, 'Estoque', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, 'Peso(Kg)', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);


while ($aRow = $dadosSql->fetch(PDO::FETCH_ASSOC)) {

    $sProcod = ltrim(rtrim($aRow['procod']));
    $fEstoque = number_format($aRow['estoque'], 2, ',', '.');
    /* montar linhas a partir daqui para cada item */

    if ($fEstoque != '0,00') {

        $pdf->Cell(150, 5, $sProcod . ' - ' . $aRow['prodes'], 0, 0);

        $pdf->Cell(28, 5, $fEstoque . ' ' . $aRow['unm'] . '', 0, 0);

        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(18, 5, number_format($aRow['estoquePeso'], 2, ',', '.'), 0, 1);
        $pdf->Cell(200, 1, '', 'T', 1, 'C', 0);
    }
}

$pdf->Output('I', 'Consulta de Estoque - ' . $sData . ' - ' . $sHora . '.pdf');
Header('Pragma: public');
