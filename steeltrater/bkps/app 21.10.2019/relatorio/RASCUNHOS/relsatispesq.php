<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$Empcod = $_REQUEST['filcgc'];
$nr = $_REQUEST['nr'];
$usuario = $_REQUEST['usuario'];


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
$pdf->Cell(120, 10, 'Pesquisa de satisfação de clientes   ' . $nr, 0, 1, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, 'Empresa:' . $Empcod, 0, 1, 'L');
$pdf->Cell(40, 5, 'Usuário:' . $usuario, 0, 1, 'L');
//$pdf->Cell(0,5,"","B",1,'C');  linha em branco 

$pdf->SetFont('Arial', '', 9);

//define a altura inicial dos dados
$pdf->SetFont('arial', '', 8);
$pdf->SetY(45);
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sql = "select empcod,empdes,comercial,prodrequisito,
prodembalagem,prodprazo,geralexpectativa,geralindica,obs,contato,seqrel 
from tbsatisclientepesq
where filcgc = '" . $Empcod . "' and nr ='" . $nr . "' order by seqrel";
$sth = $PDO->query($sql);
//cabeçalho
$pdf->Cell(25, 5, 'Cnpj', 1, 0);
        $pdf->Cell(80, 5, 'Empresa', 1, 0);
        $pdf->Cell(16, 5, 'Comercial', 1, 0);
        $pdf->Cell(20, 5, 'Requisito Prod.', 1, 0);
        $pdf->Cell(16, 5, 'Embalagem', 1, 0);
        $pdf->Cell(16, 5, 'Prazo', 1, 0);
        $pdf->Cell(16, 5, 'Expectativa', 1, 0);
        $pdf->Cell(16, 5, 'Indicação', 1, 1);


$iContaAltura = $pdf->GetY();

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    if ($iContaAltura >= 270) {    // 275 tamanho máximo da página
        $pdf->AddPage();   // nova pagina 
        $pdf->SetY(10);
        $iContaAltura = 10;

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
        $pdf->Cell(120, 10, 'Pesquisa de satisfação de clientes   ' . $nr, 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 5, 'Empresa:' . $Empcod, 0, 1, 'L');
        $pdf->Cell(40, 5, 'Usuário:' . $usuario, 0, 1, 'L');
        //$pdf->Cell(0,5,"","B",1,'C');  linha em branco 

        $pdf->SetFont('Arial', '', 9);

        //define a altura inicial dos dados
        $pdf->SetFont('arial', '', 8);
        $pdf->SetY(45);
        $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

        //cabeçalho
        $pdf->Cell(25, 5, 'Cnpj', 1, 0);
        $pdf->Cell(80, 5, 'Empresa', 1, 0);
        $pdf->Cell(16, 5, 'Comercial', 1, 0);
        $pdf->Cell(20, 5, 'Requisito Prod.', 1, 0);
        $pdf->Cell(16, 5, 'Embalagem', 1, 0);
        $pdf->Cell(16, 5, 'Prazo', 1, 0);
        $pdf->Cell(16, 5, 'Expectativa', 1, 0);
        $pdf->Cell(16, 5, 'Indicação', 1, 1);
    }

    $pdf->Cell(25, 5, $row['empcod'], 0, 0);
    $pdf->Cell(80, 5, $row['empdes'], 0, 0);
    $pdf->Cell(16, 5, $row['comercial'], 0, 0);
    $pdf->Cell(20, 5, $row['prodrequisito'], 0, 0);
    $pdf->Cell(16, 5, $row['prodembalagem'], 0, 0);
    $pdf->Cell(16, 5, $row['prodprazo'], 0, 0);
    $pdf->Cell(16, 5, $row['geralexpectativa'], 0, 0);
    $pdf->Cell(16, 5, $row['geralindica'], 0, 1);
    $pdf->MultiCell(205, 5, $row['obs'], 1, 1);

    $pdf->Ln(2);
    $iContaAltura = $pdf->GetY() + 5;
}



$pdf->Output('I', 'solvenda' . $_REQUEST['nr'] . '.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  