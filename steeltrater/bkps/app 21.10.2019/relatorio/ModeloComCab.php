<?php


// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

//captura o número da op
$aOps = $_REQUEST['ops'];
$nrOp ='108966'; 
//monta paginação de 2 em dois




class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,1,'C'); // paginação
        }
}
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10,5); // DEFINE O X E O Y NA PAGINA



//cabeçalho da op
 $pdf->SetMargins(3,0,3);
 $pdf->Rect(2,5,38,10);
 // Logo
 $pdf->Image('../../biblioteca/assets/images/steelrel.png',4,8,30);
    
 $pdf->SetFont('Arial','',15);
    
 $pdf->Cell(30);
    // Title
 $pdf->Cell(120,10,'                  ORDEM DE PRODUÇÃO ',1,0,'L');
 $pdf->SetFont('Arial','',9);
   
 $pdf->Rect(160,5,48,5);
 $pdf->Rect(160,10,48,5);
 
 $pdf->SetFont('Arial','B',9);
 $pdf->MultiCell(45,5,'            Número:    '.$nrOp.'                 Data:'
         . '                        ',0,'J');
 
 
 
 
 

 
 $pdf->Output('I','solvenda.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
