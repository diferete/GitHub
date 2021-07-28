<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');

$dataIni = $_REQUEST['dataini'];
$dataFim = $_REQUEST['datafim'];
$repOfficeCod = $_REQUEST['repcodoffice'];
$repOfficeDes = $_REQUEST['repoffice'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
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
$pdf->Cell(50);
// Title
$pdf->Cell(95, 0, 'Solicitações e cadastros', 0, 1, 'C');
$pdf->Cell(200, 10, 'de clientes novos', 0, 1, 'C');

$pdf->Cell(150, 1);

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');
$pdf->SetXY($x, $y + 5);

$pdf->Ln(5);

$pdf->SetY(26);

$pdf->Ln(8);

//Filtros
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(25, 5, "FILTROS - ", 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(21, 5, 'Data Inicial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(25, 5, $dataIni, 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(19, 5, 'Data Final: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(25, 5, $dataFim, 0, 1, 'L');

$pdf->Cell(205, 6, '', 'T', 1, 'C');

$pdf->SetFont('arial', '', 8);


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "select empcod,empdes,convert(varchar,empdtcad,103) as empdtcad "
        . "from widl.emp01 "
        . "where repcod in (" . $_REQUEST['rep'] . ") "
        . "and empdtcad between ('" . $dataIni . "') and ('" . $dataFim . "') "
        . "order by empdtcad asc";
$sth = $PDO->query($sql);
$contador = 0;


while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(10, 5, 'CNPJ:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['empcod'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(15, 5, 'Empresa:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(115, 5, $row['empdes'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Data cad.:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['empdtcad'], 0, 1);

    $pdf->Cell(205, 6, '', 'T', 1, 'C');
    $contador++;
}

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(30, 5, "Total de cadastros: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(120, 5, $contador, 0, 1, 'L');

$pdf->Output('I', 'Cad_Clientes.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

/**
 * Função que quebra página em uma dada altura do PDF
 * @param type $i
 * @param type $pdf
 * @return type
 */
function quebraPagina($i, $pdf) {
    if ($i >= 187) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
