<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");
include("../../biblioteca/Utilidades/Util.php");

$sCod = $_REQUEST['procod'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sUser = $_REQUEST['userRel'];

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

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Dimensionais', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUser, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select prodes,promatcod,ProClasseG ,ProAngHel,"
        . " prodchamin,prodchamax,prodaltmin,prodaltmax,proddiamin,proddiamax,procommin,procommax,prodiapmin,prodiapmax,"
        . "prodiaemin,prodiaemax,procomrmin,procomrmax,comphastma,comphastmi,DiamHastMi,DiamHastMa ,pfcmin, pfcmax"
        . " from widl.prod01 where procod = '" . $sCod . "' and grucod in(12,13) and probloqpro <> 'S'";
$sth = $PDO->query($sSql);
$row = $sth->fetch(PDO::FETCH_ASSOC);

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(8, 5, 'Cód:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $sCod, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(10, 5, 'Desc.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $row['prodes'], 0, 1);

$pdf->Ln(1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Material:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5,$row['promatcod'], 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Classe.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['ProClasseG']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Ângulo Helice:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['ProAngHel']) . ' mm', 0, 1);

$pdf->Ln(1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Chave Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodchamin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Chave Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodchamax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Altura Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodaltmin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Altura Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodaltmax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Furo Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['proddiamin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Furo Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['proddiamax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Prim. Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Prim. Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Externo Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Externo Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommax']) . ' mm', 0, 1);


$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Haste Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Haste Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Rosca Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Comp. Rosca Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommax']) . ' mm', 0, 1);


$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Haste Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Diâm. Haste Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['prodiapmax']) . ' mm', 0, 1);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Profu. Caneco Mín.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommin']) . ' mm', 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(32, 5, 'Profu. Caneco Máx.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, Util::formataSqlDecimal($row['procommax']) . ' mm', 0, 1);

$pdf->Output('I', 'Dimensional - Cod ' . $sCod . '.pdf');
Header('Pragma: public');
