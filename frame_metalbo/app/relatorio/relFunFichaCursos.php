<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");
date_default_timezone_set('America/Sao_Paulo');

$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sTip = $_REQUEST['tipo'];
$aSeq = explode('|', $_REQUEST['seq']);
$sSeq = '';
$iCont = 0;
foreach ($aSeq as $sKey){
    if($iCont == 0){
    $sSeq = explode('=',$sKey)[1];
    $iCont++;
    }else{
    $sSeq = $sSeq.','.explode('=',$sKey)[1];
    }
}

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
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

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(120, 10, 'Ficha Contratual de Funcionário', 0, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->Ln(15);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

$sql = "select * from tbrhpessoas where seq in (".$sSeq.")";

$sth = $PDO->query($sql);

if($sTip=='FICHA'){

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    
    if($iCont>1){
        
        $pdf->AddPage(); // ADICIONA UMA PAGINA
        $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
        $pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
        //seta as margens
        $pdf->SetMargins(2, 10, 2);

        $pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetMargins(3, 0, 3);
        $pdf->SetFont('Arial', 'B', 15);
        // Move to the right
        $pdf->Cell(45);
        // Title
        $pdf->Cell(120, 10, 'Ficha Contratual de Funcionário', 0, 0, 'C');
        $pdf->Ln(15);
        $pdf->Cell(0, 0, "", "B", 1, 'C');
        $pdf->Ln(3);
    }
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(63, 7, 'FUNCIONÁRIO', "L,T", 0, 'L');
    $pdf->Cell(140, 7,$row['nome'] , "T,R", 1, 'L');

    $pdf->Cell(63, 7, 'DATA ADMISSÃO', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['datadm'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'FUNÇÃO À EXERCER', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['funcao'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'SETOR', "L", 0, 'L');
    $pdf->Cell(140, 7,'Cod. '.$row['setor'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'HORÁRIO DE TRABALHO', "L", 0, 'L');
    $pdf->Cell(140, 7,'escala '.$row['escala'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'CONTRATO DE EXPERIÊNCIA', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['contexp'].' DIAS' , "R", 1, 'L');
   
    $pdf->Cell(63, 7, 'REMUNERAÇÃO', "L", 0, 'L');
    $pdf->Cell(140, 7, 'R$ '.(number_format($row['salini'],2)).'/hora' , "R", 1, 'L');    

    $pdf->Cell(63, 7, 'NOME DO BANCO', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['banco'] , "R", 1, 'L');    

    $pdf->Cell(63, 7, 'AGÊNCIA', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['agb'] , "R", 1, 'L');    

    $pdf->Cell(63, 7, 'CONTA CORRENTE', "B,L", 0, 'L');
    $pdf->Cell(140, 7,$row['contac'] , "B,R", 1, 'L'); 
    
    $pdf->Ln(20);
    $pdf->Cell(120, 7, '', 0, 0, 'L');
    $pdf->Cell(63, 7, 'HERMES BOEWING', "T", 1, 'C');
    
    $iCont++;
    
    }

    
}ELSE{
    
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    
    if($iCont>1){
        
        $pdf->AddPage(); // ADICIONA UMA PAGINA
        $pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
        $pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
        //seta as margens
        $pdf->SetMargins(2, 10, 2);

        $pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetMargins(3, 0, 3);
        $pdf->SetFont('Arial', 'B', 15);
        // Move to the right
        $pdf->Cell(45);
        // Title
        $pdf->Cell(120, 10, 'Ficha Contratual de Funcionário', 0, 0, 'C');
        $pdf->Ln(15);
        $pdf->Cell(0, 0, "", "B", 1, 'C');
        $pdf->Ln(3);
    }
    
    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(63, 7, 'FUNCIONÁRIO', "L,T", 0, 'L');
    $pdf->Cell(140, 7,$row['nome'] , "T,R", 1, 'L');

    $pdf->Cell(63, 7, 'DATA ADMISSÃO', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['datadm'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'FUNÇÃO À EXERCER', "L", 0, 'L');
    $pdf->Cell(140, 7,$row['funcao'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'SETOR', "L", 0, 'L');
    $pdf->Cell(140, 7,'Cod. '.$row['setor'] , "R", 1, 'L');

    $pdf->Cell(63, 7, 'HORÁRIO DE TRABALHO', "L,B", 0, 'L');
    $pdf->Cell(140, 7,'escala '.$row['escala'] , "R,B", 1, 'L');

    $pdf->Ln(10);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(203, 7, 'CURSOS', "B,L,T,R", 1, 'C');
    
    $pdf->SetFont('Arial', '', 10);
    foreach (explode(';',$row['cursos']) as $sCursos){
        $pdf->Cell(203, 7, $sCursos , "R,L", 1, 'L');            
    }
    
    $iCont++;
    
    $pdf->Cell(203, 7, '' , "T", 1, 'L'); 
    
   
    if (strstr($row['anexo'], 'png') || strstr($row['anexo'], 'jpg')) {
    if (isset($row['anexo'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo = $row['anexo'];
        $pdf->Image('../../Uploads/' . $sAnexo, null, null, 190, 250);
    }
    }
    
    }
    
}


$pdf->Output('I', 'relFunFichaCursos.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
