<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php"); 

class PDF extends FPDF {
    function Footer(){ // Cria rodapé
        $this->SetXY(15,283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial','',7); // seta fonte no rodape
        $this->Cell(190,7,'Página '.$this->PageNo().' de {nb}',0,0,'C'); // paginação
    }
}
//pega os dados para parametro
$sOrdena = 'asc';
if(isset($_REQUEST['orddata1'])){
    $sOrdena = $_REQUEST['orddata1']; 
}



$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2,10,2); 
  
$pdf->Image('../../biblioteca/assets/images/logojpg.jpg',3,10,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial','B',16);
      
$pdf->Cell(190,18,'Cadastro de máquinas',0,1,'C');
$pdf->Ln(5);
 //seta o cabeçalho dos pedidos
//define a altura inicial dos dados
$pdf->SetFont('arial','',9);
$pdf->SetY(30);
$iAlturaRet = 122; // Y (altura) INICIAL DOS DADOS 
$l=5; // ALTURA DA LINHA
//seta o cabeçalho
$pdf->Cell(0,5,"Código     Máquina                                                                                          "
        . "                                                Responsável                       Data             ",1,1,'L');

//traz os dados 
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
 
 $sSql = "select codmaq,maquina,responsavel,convert(varchar,datacad,103) as datacad from tbpolimaq order by codmaq ".$sOrdena;
 $dadosItens = $PDO->query($sSql);
 
 while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)){
     $pdf->SetFont('arial','',9);
     //adiciona nova página se necessário
     if($iAlturaRet + $l >= 275){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $iAlturaRet = 10;  // Altura na segunda página
        $pdf->Rect(2,$iAlturaRet,206,5); 
        $pdf->Cell(0,5,"Código     Máquina                                                                                          "
        . "                                                Responsável                       Data             ",1,1,'L');
        $iAlturaRet = $iAlturaRet+5; 
    } 
    //adiciona primeira linha
   
    $pdf->Cell(14,5,$row['codmaq'],1,0,'L');
    $pdf->Cell(135,5,$row['maquina'],1,0,'L');
    $pdf->Cell(37,5,$row['responsavel'],1,0,'L');
    $pdf->Cell(20,5,$row['datacad'],1,1,'L');
  
   }







$pdf->Output('','RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
