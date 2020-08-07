<?php


require('../../biblioteca/fpdf/ean13.php');

$pdf=new PDF_EAN13();
$pdf->AddPage();
$pdf->EAN13(20,20,'23789');
$pdf->SetY(100);
//$pdf->Cell(100, 5,'7899371741086');
$pdf->Output();

 