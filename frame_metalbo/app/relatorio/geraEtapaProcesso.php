<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$aCampos = explode('&', $_REQUEST['campos']);
$aDados = array();

foreach ($aCampos as $key => $value) {
    $array = explode('=', $value);
    $aDados[$array[0]] = str_replace('+',' ',$array[1]);
}

require 'biblioteca/fpdf/fpdf.php';
include '../../includes/Config.php';
include '../../includes/Fabrica.php';

function Footer() { // Cria rodapé
    $this->SetXY(15, 278);
    $this->Ln(); //quebra de linha
    $this->SetFont('Arial', '', 7); // seta fonte no rodape
    $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

    $this->Image('biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Itens do carrinho', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$sTeste = 'teste';

$nr = rand();
$pdf->Output('I', 'catalogo/PDF/Itens-carrinho-metalbo' . $nr . '.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  