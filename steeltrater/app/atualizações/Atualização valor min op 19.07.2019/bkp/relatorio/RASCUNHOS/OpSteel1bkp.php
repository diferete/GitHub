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

$pdf->SetXY(5,5); // DEFINE O X E O Y NA PAGINA

$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);

foreach ($aOps as $key => $aOp) {
    
    $pdf->Cell(37,10,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 33.78),1,0,'L');
    
    $pdf->SetFont('Arial','',15);

   
    $pdf->Cell(110,10,'                  ORDEM DE PRODUÇÃO ',1,0,'L');
    //$pdf->SetFont('Arial','',9);

 

    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(52,5,'Número:        '.$nrOp.'              '
            . '  Data:                24/10/2018 '
            . ' ',1,'J');
    //dados da ordem de produção
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(132, 5, 'Cliente TESTE','B,R',0,'L');
    //nota fiscal do cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(22, 5, 'NF do cliente:','B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '242424','B,R',1,'L');
    //produto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Produto:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(184, 5, 'Produto teste ','B,R',1,'L');
    //material
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(15, 5, 'Material:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '10B22','B,R',0,'L');
    //op do cliente
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(21, 5, 'Op do cliente:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(35, 5, '242424','B,R',0,'L');
    //dureza solicitada
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(27, 5, 'Dureza solicitada:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(71, 5, '242424','B,R',1,'L');
    //inspeção recebimento
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 5, 'Inspeção de recebimento:','L,B',0,'L');
    $pdf->Cell(159, 5, '     Oxidação superficial (    )              Empenamento (    )   '
            . '     Trincas (    )                  Material / Classe (    )','B,R',1,'L');
    //forno previsto
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(25, 10, 'Forno previsto:','L,B',0,'L');
    $pdf->Cell(20, 10, 'FC 1 (    )','B',0,'L');
    $pdf->Cell(20, 10, 'FC 2 (    )','B',0,'L');
    $pdf->Cell(20, 10, 'FC 3 (    )','B',0,'L');
    $pdf->Cell(20, 10, 'FC 4 (    )','B',0,'L');
    $pdf->Cell(20, 10, 'FC 5 (    )','B',0,'L');
    $pdf->Cell(20, 10, 'FC 6 (    )','B',0,'L');
    $pdf->Cell(18, 10, 'FC 8 (    )','B',0,'L');
    $pdf->Cell(18, 10, 'FA (    )','B',0,'L');
    $pdf->Cell(18, 10, 'FAR (    )','B,R',1,'L');
    
    //quantidade de peças
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(40, 5, 'Quantidade de peças:','L,B',0,'L');
    $pdf->SetFont('Arial','B',9);
    $pdf->Cell(30, 5, '242424','B,R',1,'L');
    
}

 
 
 
 
 

 
 $pdf->Output('I','solvenda.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
