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
$sGrudesFin = $_REQUEST['grudesfin'];
$sSubGrudes = $_REQUEST['subdes'];
$sSubGrudesFin = $_REQUEST['subdesfin'];
$sFamdes = $_REQUEST['famdes'];
$sFamdesFin = $_REQUEST['famdesfin'];
$sSubFamdes = $_REQUEST['famsdes'];
$sSubFamdesFin = $_REQUEST['famsdesfin'];

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
        . "and subcod not in('2','9','114','116','125','128','129','150','151','152','153','201','202','203','204','205','206','207','208',"
        . "'209','210','211','212','213','214','215','216','217','218','219','220','221','222','223','224','225','226','260','301','302','303',"
        . "'304','306','308','309','310','311','314','317','318','319','321','328','329','401','404','409','410','419','514','516','517','518',"
        . "'521','529','542','543','544','545','546','547','548','549','550','551','552','554','555','590','629','633','700','710','800','802',"
        . "'803','804','805','807','808','809') "
        . "and tbestWeb.procod is not null "
        . "and estoque > 0.00 "
        . "ORDER BY  widl.prod01.procod asc ";
$dadosSql = $PDO->query($sSql);
$aRow = $dadosSql->fetch(PDO::FETCH_ASSOC);




$pdf->Ln(8);
$pdf->SetFont('arial', '', 10);
$pdf->SetTextColor(255, 0, 0);
$pdf->Cell(150, 5, 'Última atualização do estoque: ' . Util::converteData($aRow['DataEst']), 0, 1, 'L');
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(150, 5, 'Filtros:', 0, 1, 'L');
$pdf->SetFont('arial', '', 9);

$pdf->Ln(2);

if ($iGrucod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(150, 5, 'Grupo:             ' . $iGrucod . ' - ' . $sGrudes, 0, 1, 'L');
}
if ($iSubcod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(150, 5, 'Sub. Grupo:    ' . $iSubcod . ' - ' . $sSubGrudes, 0, 1, 'L');
}
if ($iFamcod == 0) {
    
} else {
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(150, 5, 'Familia:            ' . $iFamcod . ' - ' . $sFamdes, 0, 1, 'L');
}
if ($iFamsub == 0) {
    
} else {
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(150, 5, 'Sub Familia:    ' . $iFamsub . ' - ' . $sSubFamdes, 0, 1, 'L');
}

$pdf->Ln(8);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(150, 5, 'Item', 0, 0, 'L');
$pdf->Cell(28, 5, 'Estoque', 0, 0, 'L');
$pdf->Cell(18, 5, 'Peso(Kg)', 0, 1, 'L');

$iTotalPeso = 0;
$iToralEstoque = 0;

$dadosSql = $PDO->query($sSql);
while ($aRow = $dadosSql->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Ln(1);
    $sProcod = ltrim(rtrim($aRow['procod']));
    $fEstoque = number_format($aRow['estoque'], 2, ',', '.');
    /* montar linhas a partir daqui para cada item */

    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(150, 5, $sProcod . ' - ' . $aRow['prodes'], 0, 0);

    $pdf->Cell(28, 5, $fEstoque . ' ' . $aRow['unm'] . '', 0, 0);

    $pdf->Cell(18, 5, number_format($aRow['estoquePeso'], 2, ',', '.'), 0, 1);
    //$pdf->Cell(200, 1, '', 'T', 1, 'C', 0);

    $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
    /*
      $iTotalPeso = $iTotalPeso + $aRow['estoquePeso'];
      $iToralEstoque = $iToralEstoque + $aRow['estoque']; */
}
/*
  $pdf->SetFont('arial', 'B', 9);
  $pdf->Cell(150, 5, 'Totais', 0, 0);
  $pdf->SetFont('arial', '', 9);
  $pdf->Cell(28, 5, number_format($iToralEstoque, 2, ',', '.'), 0, 0);
  $pdf->Cell(18, 5, number_format($iTotalPeso, 2, ',', '.'), 0, 1);
 * 
 */

$pdf->Output('I', 'Consulta de Estoque - ' . $sData . ' - ' . $sHora . '.pdf');
Header('Pragma: public');

function quebraPagina($i, $pdf) {
    if ($i >= 278) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
