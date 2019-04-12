<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,1,'C'); // paginação
        }
}
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$text=str_repeat('this is a word wrap test mais um teste alexandre, vamos analisar quebras de linhas se está ok! ',5);
$text2=str_repeat('this is a word wrap test mais um teste alexandre, vamos analisar quebras de linhas se está ok! ',3);

$x=$pdf->GetX(); $y=$pdf->GetY();

$pdf->MultiCell(60, 5, $text,1);
$pdf->SetXY($x+61,$y); 

$pdf->MultiCell(60, 5, $text2,1);
$pdf->SetXY($x+123,$y); 

$pdf->MultiCell(60, 5, $text2,1);

$pdf->Output();

