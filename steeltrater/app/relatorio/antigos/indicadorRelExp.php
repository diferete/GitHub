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
if(isset($_REQUEST["dataini"])){
    $data1 = $_REQUEST["dataini"];
}

if(isset($_REQUEST["datafim"])){
    $data2 = $_REQUEST["datafim"];
}

if(isset($_REQUEST["usu"])){
    $usu = $_REQUEST["usu"];
}

$dataEmis = date('d/m/Y');


$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA


//cabeçalho
 $pdf->SetMargins(3,0,3);
 $pdf->Rect(2,10,38,18);
 // Logo
 $pdf->Image('../../biblioteca/assets/images/logopn.png',4,13,26);
    // Arial bold 15
 $pdf->SetFont('Arial','B',15);
    // Move to the right
 $pdf->Cell(30);
    // Title
 $pdf->Cell(120,18,' INDICADOR DE PRODUÇÃO DA EXPEDIÇÃO',1,0,'L');
    
 $pdf->Rect(160,10,48,18);
 $pdf->SetFont('Arial','',9);
 $pdf->MultiCell(45,5,'Emissão:'.$dataEmis.'       Usuário: '.$usu.'                       ',0,'J');
 
 //$pdf->Rect(2,29,206,39);
 $pdf->Ln(3);
 
/**/
 $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

 
 $sSql = "  select SUM(Pesotudo-PesoSucata-pesodev)as PesoLiquido
                      from metfat_metalbo 
                      where DATA between '".$data1."' and '".$data2."' ";
 
 $dadosTot = $PDO->query($sSql);
 while ($row = $dadosTot->fetch(PDO::FETCH_ASSOC)){
     $sTotalGeral = $row['PesoLiquido'];
 }
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Total expedido em KG:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,number_format($sTotalGeral, 2, ',', '.') , 0, 1, 'L');
 
 
 $sSql = " select sum(nfspesolq) as totEx 
          from widl.NFC001(nolock),
          widl.mov01(nolock)
          where widl.nfc001.nfsmovcod = widl.MOV01.movcod 
          and nfsdtemiss between '".$data1."' and '".$data2."' 
          and nfscancela <> '*'
          and widl.NFC001.nfsfilcgc = '75483040000211'
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC001.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = '' 
          and nfsclicod in(select empcod from tbnotempqual) ";
 
 $dadosEx = $PDO->query($sSql);
 while ($row = $dadosEx->fetch(PDO::FETCH_ASSOC)){
     $sTotalEx = $row['totEx'];
 }
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Total da exceção:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,number_format($sTotalEx, 2, ',', '.') , 0, 1, 'L');
 
 /*total da exportaçao */
 
 $sSql = "   select SUM(PesoExp)as PesoExport
                      from metfat_metalbo 
                      where DATA between '".$data1."' and '".$data2."'  ";
 
 $dadosExPort = $PDO->query($sSql);
 while ($row = $dadosExPort->fetch(PDO::FETCH_ASSOC)){
     $sTotalExPort = $row['PesoExport'];
 }
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Total da exportação:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,number_format($sTotalExPort, 2, ',', '.') , 0, 1, 'L');
 
 
 /*Monta a média */
 $sSql = " select COUNT(*) as cont 
          from metfat_metalbo
          where data between '".$data1."' and '".$data2."'   ";
 
 $dadosCount = $PDO->query($sSql);
 while ($row = $dadosCount->fetch(PDO::FETCH_ASSOC)){
     $sTotalCount = $row['cont'];
 }
 
 $sMedia = ($sTotalGeral - $sTotalEx - $sTotalExPort)/$sTotalCount; 
 
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Dias de expedição:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,$sTotalCount, 0, 1, 'L');
 
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Média da Expedição:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,number_format($sMedia, 2, ',', '.') , 0, 1, 'L');
 

 $sTotalExpedido = $sTotalGeral - $sTotalEx - $sTotalExPort;
 
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(50,5,"Total expedição:",0,0,'L');
 $pdf->SetFont('Arial','',12);
 $pdf->Cell(60,5,number_format($sTotalExpedido, 2, ',', '.') , 0, 1, 'L');
 $pdf->Cell(0,5,"","B",1,'C');
 
 $pdf->Ln(10);
 $pdf->SetFont('Arial','B',12);
 $pdf->Cell(206,5,"Empresas que não entram na produção",0,1,'L');
 $pdf->SetFont('Arial','',8);
 $sAlturaInicial = $pdf->GetY() + 2;
 $pdf->SetY($sAlturaInicial);
 $iAlturaCausa = $sAlturaInicial;
 $l=5;
 
 $sSql = " select * from tbnotempqual order by empcod";
 $dadosEmp = $PDO->query($sSql);
 $pdf->Cell(0,5,"Cnpj                                           Empresa                            "
        . "                                                  ",1,1,'L');
 while ($row = $dadosEmp->fetch(PDO::FETCH_ASSOC)){
     $empCnpj = $row['empcod'];
     $empresa = $row['empdes'];
     if($iAlturaCausa >= 270){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaCausa = 10;
      
    } 
    $pdf->Cell(40,5,$empCnpj,0,0,'L');
    $pdf->Cell(80,5,$empresa,0,1,'L');
    $iAlturaCausa = $pdf->GetY();
 }
 
 
 
 $pdf->Output();
