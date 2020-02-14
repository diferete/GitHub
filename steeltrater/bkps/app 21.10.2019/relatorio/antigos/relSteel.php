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
       
        $this->Image('../../biblioteca/assets/images/metalbo-preta.png',180,286,20);
       
    }
}
//trata os filtros da tela
if(isset($_REQUEST['forno'])){
    $forno = $_REQUEST['forno'];
}

    $dataini = $_REQUEST['dataini'];
    $datafim = $_REQUEST['datafim'];

    if(isset($_REQUEST['sit'])){
        $sit = $_REQUEST['sit'];
    }




$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2,10,2); 
  
$pdf->Image('../../biblioteca/assets/images/steel.png',3,15,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial','B',16);
      
$pdf->Cell(190,18,'Fornos SteelTrater',0,1,'C');
$pdf->Ln(5);

$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
 //adiciona cabeçalho
$pdf->SetFont('arial','',9);
$pdf->Cell(20,5,'Op. Steel',1);
$pdf->Cell(20,5,'Código',1);
$pdf->Cell(130,5,'Produto',1);
$pdf->Cell(37,5,'Op. Cliente',1,1);
$pdf->Ln(2);

 $sSql = "select ofsteel,procodCod,prodes,empcod,empdes,ofcliente,
convert(varchar,dtent,103)as dtent,
dtent as dtent1,
convert (time(2),horaent) as horaent,
forno,
sit,
convert(varchar,dtsaida,103)as dsaida,
dtsaida as dtsaida1,
convert (time(2),horasaida) as horasaida
from steelmov_forno where dtent between '".$dataini."' and '".$datafim."' ";
 if($forno!=='Todos'){
     $sSql.=" and forno ='".$forno."'  ";
 }
 if ($sit!=='Todos'){
     $sSql .=" and sit ='".$sit."' ";
 }
 
$sSql.=" order by forno,dtent1 desc";
 $dadosItens = $PDO->query($sSql);
 
 while ($row = $dadosItens->fetch(PDO::FETCH_OBJ)){
    $pdf->SetFont('arial','',9);
    $pdf->Cell(20,5,$row->ofsteel,0,0); 
    $pdf->Cell(20,5,$row->procodCod,0,0);
    $pdf->Cell(130,5,$row->prodes,0,0);
    $pdf->Cell(37,5,$row->ofcliente,0,1);
    //detalhes
    $pdf->SetFont('arial','',7);
    $pdf->Cell(20,5,'Forno: '.$row->forno,0);
    $pdf->Cell(30,5,'Data ent.: '.$row->dtent,0);
    $pdf->Cell(30,5,'Hora ent.: '.$row->horaent,0);
    $pdf->Cell(30,5,'Situação: '.$row->sit,0);
    $pdf->Cell(30,5,'Data saída: '.$row->dsaida,0);
    $pdf->Cell(30,5,'Hora saída: '.$row->horasaida,0,1);
    $pdf->Cell(0,5,"","B",1,'C');
    
    
    $pdf->Ln(2);
 }

 $pdf->Output('I','fornosSteel.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
