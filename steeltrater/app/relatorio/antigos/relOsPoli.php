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
if(isset($_REQUEST['PoliCadMaq_codmaq'])){
    $rCodMaq = $_REQUEST['PoliCadMaq_codmaq'];
    $rMaq = $_REQUEST['PoliCadMaq_maquina'];
    if($rCodMaq==''){
        $rCodMaq = 'Todas';
        $rMaq = '';
    }
}
if(isset($_REQUEST['dataini'])){
    $rData1 =$_REQUEST['dataini']; 
}
if(isset($_REQUEST['datafim'])){
    $rData2 =$_REQUEST['datafim']; 
}

if(isset($_REQUEST['sit'])){
    $rSit =$_REQUEST['sit']; 
}
//monta o início da ficha de manutenção

$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2,10,2); 

$pdf->Image('../../biblioteca/assets/images/logopoli.gif',3,10,40);


$pdf->SetFont('arial','B',16);
$pdf->Cell(0,5,"Relatório de controle de manutenção",0,1,'C');
$pdf->Ln(3);
$pdf->SetFont('arial','B',7);
$pdf->Cell(56,5,"",0,0,'L');
$pdf->Cell(18,5,"Máquina:",0,0,'L');
$pdf->Cell(20,5,$rCodMaq.' '.$rMaq,0,1,'L');
$pdf->Cell(56,5,"",0,0,'L');
$pdf->Cell(18,5,"Data:",0,0,'L');
$pdf->Cell(20,5,$rData1.' até '.$rData2,0,1,'L');
$pdf->Cell(56,5,"",0,0,'L');
$pdf->Cell(18,5,"Situação:",0,0,'L');
$pdf->Cell(20,5,$rSit,0,1,'L');
$pdf->Cell(0,5,"","B",1,'C');


$pdf->Ln(5);

/*
 * Conexão com banco de dados 
 */
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    


$sql = "select nr,convert(varchar,data,103)as data,hora,usuario,tbpolimanut.codmaq,maquina,
problema,solucao,situaca,mecanico,consumo,userenc,convert(varchar,dataenc,103)as dataenc,
horaenc,convert(varchar,previsao,103)as previsao,
solucao,consumo, data as data1
from tbpolimanut left outer join tbpolimaq
on tbpolimaq.codmaq = tbpolimanut.codmaq 
where data between '".$rData1."' and '".$rData2."' ";
if ($rCodMaq!== 'Todas'){
    $sql .=" and tbpolimanut.codmaq = '".$rCodMaq."' ";
}
if($rSit!=='Todas'){
  $sql .=" and situaca = '".$rSit."' ";  
}
$sql .=" order by data1 desc";//. $sFiltro; 
$sth = $PDO->query($sql);

$sAlturaInicial = $pdf->GetY() + 5;
$pdf->SetY($sAlturaInicial);
$iAlturaCausa = $sAlturaInicial;

while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    
// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA
    $codigoMaq = $row["codmaq"];
    $data = $row["data"];
    $maquina = $row['maquina'];
    $hora = $row['hora'];
    $sNrOs = $row['nr'];
    $sProblema = $row['problema'];
    $sSolucao = $row['solucao'];
    $sSit = $row['situaca'];
    $sDataEnc = $row['dataenc'];
    $sConsumo = $row['consumo'];
    
     if($iAlturaCausa >= 270){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaCausa = 10;
      
    } 
    
    
//código máquina   
$pdf->SetFont('arial','B',9);
$pdf->Cell(20,5,"Máquina:",0,0,'L');
$pdf->setFont('arial','',9);
$pdf->Cell(20,5,$codigoMaq,0,0,'L');

$pdf->Cell(160,5,$maquina,0,1,'L');

$pdf->SetFont('arial','B',9);
$pdf->Cell(20,5,"Os:",0,0,'L');
$pdf->SetFont('arial','',9);
$pdf->Cell(20,5,$sNrOs,0,0,'L');
$pdf->Cell(30, 5,$data,0,0,'L');
$pdf->Cell(30, 5,substr($hora,0,-11),0,0,'L');
$pdf->Cell(30, 5,$sSit,0,0,'L');
$pdf->Cell(30, 5,'Data Enc: '.$sDataEnc,0,1,'L');
$pdf->SetFont('arial','B',9);
$pdf->Cell(206,5,"Problema",0,1,'L');
$pdf->SetFont('arial','',9);
$pdf->MultiCell(206,5,$sProblema,0,'J');
$pdf->SetFont('arial','B',9);
$pdf->Cell(206,5,"Solução",0,1,'L');
$pdf->SetFont('arial','',9);
$pdf->MultiCell(206,5,$sSolucao,0,'J');
$pdf->SetFont('arial','B',9);
$pdf->Cell(206,5,"Consumo",0,1,'L');
$pdf->SetFont('arial','',9);
$pdf->MultiCell(206,5,$sConsumo,0,'J');
$pdf->Cell(0,0,'',1);

$pdf->Ln(5);

$iAlturaCausa = 10;  

}

$pdf->Output('','RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
