<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

//Requests do relatório
$sUserRel = $_REQUEST['userRel'];
$sDtEmiInic = $_REQUEST['dtemiInic'];
$sDtEmiFin = $_REQUEST['dtemiFinal'];
$sDtEntInic = $_REQUEST['dteEntInic'];
$SDtEntFin = $_REQUEST['dtEntFinal'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');

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
$pdf->SetMargins(3, 10, 3);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 10, 35); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);
// Move to the right
$pdf->Cell(30);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial','',15);
$pdf->Cell(115,15,'SALDOS DE PEDIDOS POR ÍTEM', '',0, 'C',0);


$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$sData
        .'        Hora:'.$sHora
        .' Usuário:'.$sUserRel 
        .' ','','L',0);
$pdf->Cell(0,2,'','',1,'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(70, 4, 'Emissão de '.$sDtEmiInic.' até '.$sDtEmiFin , '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(70, 4, 'Data de entrega '.$sDtEntInic.' até '.$SDtEntFin, '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(70, 4, 'Data de geração: '.$sData, '', 1, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(70, 4, 'Todos os clientes!' , '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(70, 4, 'Todos os pedidos!', '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(0,4,'','',1,'L');
        
    $pdf->SetFont('arial', 'B', 7);
    $pdf->MultiCell(198, 4, 'Informação do relatório: Esse relatório irá listar todos os pedidos emitidos no período que'
            . 'geram saldo e vai percorrer as notas fiscais dos pedidos subtraindo a quantidade e valores da primeira '
            . 'nota fiscal, o restante configura saldo de pedidos, o sistema irá trazer o código, a quantidade de saldo '
            . 'que foi gerado no período o valor desse saldo e também a quantidade de pedidos desse item que geraram saldo '
            . 'O relatório vai ordenar pela quantidade de pedidos que geraram saldos de forma decrescente',0,'J');
   
    $pdf->Cell(0,4,'','',1,'L');
        
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(15, 5, 'Código', '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(75, 5, 'Descrição', '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(25, 5, 'Qt. Saldo', '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(35, 5, 'R$ Total de Saldo.', '', 0, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(40, 5, 'Nº Pedidos que geraram saldo', '', 0, 'L');

       

//number_format($quant, 2, ',', '.')
$pdf->Output('I', 'relSaldoPedNrSaldosPorItem.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
