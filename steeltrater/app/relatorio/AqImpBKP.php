<?php

include '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

// Diretórios
//require '../../biblioteca/fpdf/fpdf.php';
//include("../../includes/Config.php");

class PDF extends FPDF {

    function myCell($w, $h, $x, $t) {
        $height = $h / 3;
        $first = $height + 2;
        $second = $height + $height + $height + 3;
        $len = strlen($t);
        if ($len > 15) {
            $txt = str_split($t, 15);
            $this->SetX($x);
            $this->Cell($w, $first, $txt[0], '', 1, '');
            $this->SetX($x);
            $this->Cell($w, $second, $txt[1], '', 1, '');
            $this->SetX($x);
            $this->Cell($w, $second, $txt[2], '', 1, '');
            $this->SetX($x);
            $this->Cell($w, $second, $txt[3], '', 1, '');
            $this->SetX($x);
            $this->Cell($w, $second, $txt[4], '', 1, '');
            $this->SetX($x);
            $this->Cell($w, $h, '', 'LTRB', 0, 'L', 0);
        } else {
            $this->SetX($x);
            $this->Cell($w, $h, $t, 'LTRB', 0, 'L', 0);
        }
    }

//    function Footer() { // Cria rodapé
//        $this->SetXY(15, 283);
//        $this->Ln(); //quebra de linha
//        $this->SetFont('Arial', '', 7); // seta fonte no rodape
//        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
//    }
}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->Ln();


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//############################### Conteção/Abrangência #######################################

$sSqlDadosContencao = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,situaca "
        . "from MET_QUAL_Contencao "
        . "where filcgc = '8993358000174' and nr ='3'";
$dadosContencao = $PDO->query($sSqlDadosContencao);
$rowContencao = $dadosContencao->fetch(PDO::FETCH_ASSOC);

$pdf->SetFillColor(213, 213, 213);


$w=45;
$h=15;

//$x=$pdf->getx();
//$pdf->myCell($w,$h,$x, $rowContencao['usunome']);
//$x=$pdf->getx();
///$pdf->myCell($w,$h,$x,$rowContencao['dataprev']);
$x=$pdf->getx();
$pdf->myCell($w,$h,$x,'Primeiro texto do multicell para fazermos um teste real de como funciona ');
$pdf->Ln();

$pdf->Output();
