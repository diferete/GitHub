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

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5,5); // DEFINE O X E O Y NA PAGINA

//Caminho da logo
$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel=$_REQUEST['userRel'];
$sPPAP =$_REQUEST['ppap']; 
        
/////////////////////////////////////////////////////////        
        
 $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select seqmat, prod, matcod, cod, 
            durezaNucMin,
            durezaNucMax,
            NucEscala,
            durezaSuperfMin ,
            durezaSuperfMax ,
            superEscala,
            expCamadaMin,
            expCamadaMax
            from STEEL_PCP_prodmatreceita 
            where ppap= '".$sPPAP."'";

   $dadosRela = $PDO->query($sSql);       


/////////////////////////////////////////////////////////////////        
if ($sPPAP == 'S'){
    $sTipo = "COM";
}else{
    $sTipo = "SEM";
}
//Inserção do cabeçalho
$pdf->Cell(37,15,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY()+4, 40),0,0,'C');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'RELATÓRIO DE ITENS '.$sTipo.' PPAP', '',0, 'C',0);

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0);
$pdf->Cell(0,5,'','',1,'L');
$pdf->Cell(0,6,'','T',1,'L');



 while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   
   $sSqlPro = "select pro_descricao from pro_produto where pro_codigo = '".$row['prod']."'";

   $dados1 = $PDO->query($sSqlPro);   
     
   $rowPro = $dados1->fetch(PDO::FETCH_ASSOC);
   //////////////////////////////////////////////////////////////////////////////////////  
   $sSqlMat = "select matdes from steel_pcp_material where matcod = '".$row['matcod']."'";

   $dados2 = $PDO->query($sSqlMat);   
     
   $rowMat = $dados2->fetch(PDO::FETCH_ASSOC);
   //////////////////////////////////////////////////////////////////////////////////////
   $sSqlRec = "select peca from steel_pcp_receitas where cod = '".$row['cod']."'";

   $dados3 = $PDO->query($sSqlRec);   
     
   $rowRec = $dados3->fetch(PDO::FETCH_ASSOC);
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(78, 6,"SEQUENCIA PRODUTO/MATERIAL/RECEITA: ",'',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(30, 6,$row['seqmat'],'',1,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(30, 6,"PRODUTO:",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(39, 6,$row['prod'],'T',0,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(10, 6,"",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(120, 6,$rowPro['pro_descricao'],'T',1,'L');
  
   $pdf->Cell(199, 1,"",'',1,'');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(30, 6,"MATERIAL:",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(39, 6,$row['matcod'],'T',0,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(10, 6,"",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(120, 6,$rowMat['matdes'],'T',1,'L');
   
   $pdf->Cell(199, 1,"",'',1,'');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(30, 6,"RECEITA:",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(39, 6,$row['cod'],'T',0,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(10, 6,"",'T',0,'L');
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(120, 6,$rowRec['peca'],'T',1,'L');
   
   $pdf->Cell(199, 5,"",'',1,'');
   
 }

$pdf->Output('I','RelItensPPAP.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 