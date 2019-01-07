<?php
require('fpdf.php');

class myPDF extends FPDF {
    function myCell($w,$h,$x,$t){
        $height=$h/3;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $len=strlen($t);
        if($len>15){
            $txt=str_split($t,15);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }
        else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }
    }
}
$pdf = new myPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',16);
$pdf->Ln();

$w=45;
$h=15;

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'udiuash iaushd aiusdh aisduha sidhasiduhaidhasidh asi haidh asid haisu uha');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'1.2 satu titik dua');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'1.3 satu titik tiga');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'1.4 satu titik empat');
$pdf->Ln();

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'2.1 dua titik satu');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'2.2 dua titik dua');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'2.3 dua titik tiga');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'2.4 dua titik empat');
$pdf->Ln();

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'3.1 tiga titik satu');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'3.2 tiga titik dua');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'3.3 tiga titik tiga');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'3.4 tiga titik empat');
$pdf->Ln();

$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'4.1 empat titik satu');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'4.2 empat titik dua');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'4.3 empat titik tiga');
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'4.4 empat titik empat');

$pdf->Output();
?>