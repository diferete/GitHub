<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php'; 
include("../../includes/Config.php");



//monta o início da ficha de manutenção

$pdf= new FPDF("P","pt","A4");
 
 
$pdf->AddPage();
$pdf->Image('../../biblioteca/assets/images/logopoli.gif',null,null,100);
 
$pdf->SetFont('arial','B',16);
$pdf->Cell(0,5,"Ordem de manutenção nº".$_REQUEST['nr'],0,1,'C');
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(8);

/*
 * Conexão com banco de dados 
 */
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    
//grupo=1&grupo1=2&subgrupo=1&subgrupo1=2&familia=1&familia1=2&subfamilia=1&subfamilia1=2&codigo=10110101
$sNr = $_REQUEST['nr'];
$sql = "select convert(varchar,data,103)as data,hora,usuario,tbpolimanut.codmaq,maquina,
problema,solucao,situaca,mecanico,consumo,userenc,dataenc,horaenc,convert(varchar,previsao,103)as previsao
from tbpolimanut left outer join tbpolimaq
on tbpolimaq.codmaq = tbpolimanut.codmaq where nr =".$sNr."";//. $sFiltro; 
$sth = $PDO->query($sql);

while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    
// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA
    $codigo = $row["codmaq"];
    $data = $row["data"];
    $maquina = $row['maquina'];
    $hora = $row['hora'];
    $usuario = $row['usuario'];
    $situaca = $row['situaca'];
    $problema = $row['problema'];
    $mecanico = $row['mecanico'];
    $previsao = $row['previsao'];
    
    
//código máquina   
$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Código:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$codigo,0,1,'L');

//código máquina   
$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Máquina:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$maquina,0,1,'L');
  
//data  
$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Data:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(80,20,$data,0,0,'L');

$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Hora:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$hora,0,1,'L');

$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Usuário:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$usuario,0,1,'L');

$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Situação:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$situaca,0,1,'L');


$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Mecânico:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(120,20,$mecanico,0,0,'L');

$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Previsão:",0,0,'L');
$pdf->setFont('arial','',12);
$pdf->Cell(0,20,$previsao,0,1,'L');
$pdf->Ln(20);



$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Problema apresentado",0,1,'L');
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(5);



$pdf->setFont('arial','',9);
//$pdf->SetXY(61,92);
$pdf->MultiCell(600, 15,$problema,0,'J');

$pdf->Ln(20);
$pdf->SetFont('arial','B',12);
$pdf->Cell(60,20,"Listar consumo",0,1,'L');

$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);
$pdf->Cell(0,5,"","B",1,'C');
$pdf->Ln(10);





}



$pdf->Output('','RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE