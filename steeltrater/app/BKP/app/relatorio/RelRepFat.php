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
$Empcod = $_REQUEST['cnpj'];
$dataini= $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];
if(isset($_REQUEST['orddata1'])){
   $ordena = $_REQUEST['orddata1'];
}else {$ordena = 'asc';}
 
if(isset($_REQUEST['codrep'])){
   $codrep = $_REQUEST['codrep'];
}else {$codrep = '';}
    
if(isset($_REQUEST['itens'])){
 $bitens = $_REQUEST['itens'];
}else{$bitens = false;};

if(isset($_REQUEST['apresen'])){
   $apresen = $_REQUEST['apresen'];
}else {$apresen='valor';}



$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10,10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2,10,2); 
  
$pdf->Image('../../biblioteca/assets/images/logoemp.png',3,10,40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial','B',16);
      
$pdf->Cell(190,18,'Relatório de Faturamento',0,1,'C');
$pdf->Ln(5);
 //seta o cabeçalho dos pedidos
//define a altura inicial dos dados
$pdf->SetFont('arial','',8);
$pdf->SetY(30);
$iAlturaRet = 122; // Y (altura) INICIAL DOS DADOS 
$l=5; // ALTURA DA LINHA
//seta o cabeçalho
if($apresen == 'peso'){
 $pdf->Cell(0,5,"NF               Cliente                                                                                  Emissão         Quant              Peso Bruto     "
        . "   Peso Líquido                                              ",1,1,'L');   
}else{
$pdf->Cell(0,5,"NF               Cliente                                                                                  Emissão         Quant           Vlr. Total     "
        . "        IPI                Icms            ST            Vlr.Liq       ",1,1,'L');
}
$PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
//gera o resumo das notas
$sSql = "select widl.NFC001.nfsnfnro,nfsclicod,nfsclinome, 
          nfsdtemiss,convert(varchar,nfsdtemiss,103)as dataemissao,sum(nfsitqtd) as qt,sum(nfsitqtd * propesprat)as peso, 

          sum (nfsitvlrto) as vlrprod, 

          sum(nfsitvlrip)as ipi,sum(nfsitvlric) as icms, 

          sum(nfsitpis) as pis,sum(nfsitcofin) as cofin,SUM(nfsitvlrsu)as st, 

          SUM(nfsitvlrto + nfsitvlrip + nfsitvlrsu -nfsitvlrde) vlrtotal, 

          SUM(nfsitvlrto + nfsitvlrsu -nfsitvlrde) vlrLiqSt, 
          sum(nfsitqtd * propesprat) as pesoBruto, sum(nfsitqtd * propesliq) as pesoLiq, 

          SUM(nfsitvlrto + nfsitvlrip -nfsitvlrde) vlrtotalCipi, 

          case when sum(nfsitqtd * propesprat)> 0 then 
          (sum (nfsitvlrto) / sum(nfsitqtd * propesprat)) else 0 end as mediaSimp, 

           case when sum(nfsitqtd * propesprat)> 0 then 
          (sum (nfsitvlrto + nfsitvlrip + nfsitvlrsu) / sum(nfsitqtd * propesprat)) else 0 end as mediaCimp, 

          case when sum(nfsitqtd * propesprat)> 0 then 
          (sum (nfsitvlrto + nfsitvlrip) / sum(nfsitqtd * propesprat)) else 0 end as mediaCipi, 

          case when sum(nfsitqtd * propesprat)> 0 then 
          (sum (nfsitvlrto) / sum(nfsitqtd * propesprat)) else 0 end as mediaSipi


          from widl.NFC001(nolock),widl.NFC003(nolock), 
          widl.mov01(nolock),widl.prod01(nolock) 
          where widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro 
          and widl.NFC003.nfsitcod = widl.prod01.procod 
          and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc 
          and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser 
          and widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and nfsdtemiss between '".$dataini."' and '".$datafim."' 
          and nfscancela <> '*' and widl.NFC001.nfsfilcgc = '75483040000211' ";
            if($Empcod!==''){
                $sSql.="  and nfsclicod =".$Empcod." ";
            }
            if($codrep !== ''){
                 $sSql.="   and nfsrepcod in (".$codrep.") ";
            }
          $sSql.="and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC003.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = ''
          group by widl.NFC001.nfsnfnro,nfsclicod,nfsclinome,  
          nfsdtemiss 
          order by nfsdtemiss ".$ordena;
$Dados = $PDO->query($sSql);
$Itotal = 0;
$iTotalLiq = 0;
$iTotalLiqSt = 0;
$iPeso = 0;
while ($row = $Dados->fetch(PDO::FETCH_ASSOC)){
     if($iAlturaRet + $l >= 275){    // 275 é o tamanho da página

        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $iAlturaRet = 10;  // Altura na segunda página
        $pdf->Rect(2,$iAlturaRet,206,5); 
       if($apresen == 'peso'){
        $pdf->Cell(0,5,"NF               Cliente                                                                                  Emissão         Quant              Peso Bruto     "
               . "   Peso Líquido                                              ",1,1,'L');   
       }else{
       $pdf->Cell(0,5,"NF               Cliente                                                                                  Emissão         Quant           Vlr. Total     "
               . "        IPI                Icms            ST            Vlr.Liq       ",1,1,'L');
       }
        $iAlturaRet = $iAlturaRet+5; 
    } 
    
    $pdf->Cell(14,5,$row['nfsnfnro'],0,0,'L');
    $pdf->Cell(75,5,$row['nfsclinome'],0,0,'L');
    $pdf->Cell(19,5,$row['dataemissao'],0,0,'L');
    $pdf->Cell(17,5,number_format($row['qt'], 2, ',', '.'),0,0,'L');
    if($apresen=='valor'){
    $pdf->Cell(19,5,number_format($row['vlrtotal'], 2, ',', '.'),0,0,'L');//
    $pdf->Cell(16,5,number_format($row['ipi'], 2, ',', '.'),0,0,'L');  //icms
    $pdf->Cell(16,5,number_format($row['icms'], 2, ',', '.'),0,0,'L');//st
    $pdf->Cell(13,5,number_format($row['st'], 2, ',', '.'),0,0,'L');//
    $pdf->Cell(16,5,number_format($row['vlrLiqSt'], 2, ',', '.'),0,1,'L');
    }
    if($apresen == 'peso'){
    $pdf->Cell(21,5,number_format($row['pesoBruto'], 2, ',', '.'),0,0,'L');//
    $pdf->Cell(16,5,number_format($row['pesoLiq'], 2, ',', '.'),0,1,'L');  //icms
    
    }
    //insere o detalhe se for necessário
    if($bitens == true){
        $sSqlDet = "select widl.NFC003.nfsnfnro,nfsitcod,nfsitdes,nfsitund,nfsitvlrun, 
          nfsdtemiss, nfsitnbmde,(nfsitqtd) as qt,(nfsitqtd * propesprat)as peso, 
          (nfsitvlrto) as vlrprod, 
          (nfsitvlrip)as ipi,(nfsitvlric) as icms, 
          (nfsitpis) as pis,(nfsitcofin) as cofin,(nfsitvlrsu)as st, 
          (nfsitvlrto + nfsitvlrip + nfsitvlrsu -nfsitvlrde) vlrtotal, 
          (nfsitvlrto + nfsitvlrsu -nfsitvlrde) vlrLiqSt, 
          (nfsitqtd * propesprat) as pesoBruto, (nfsitqtd * propesliq) as pesoLiq, 
          (nfsitvlrto + nfsitvlrip -nfsitvlrde) vlrtotalCipi, 
          case when (nfsitqtd * propesprat)> 0 then 
          ( (nfsitvlrto) / (nfsitqtd * propesprat)) else 0 end as mediaSimp, 
           case when (nfsitqtd * propesprat)> 0 then 
          ((nfsitvlrto + nfsitvlrip + nfsitvlrsu) / (nfsitqtd * propesprat)) else 0 end as mediaCimp, 
           case when (nfsitqtd * propesprat)> 0 then 
          ((nfsitvlrto + nfsitvlrip) / (nfsitqtd * propesprat)) else 0 end as mediaCipi, 
          case when (nfsitqtd * propesprat)> 0 then 
          ((nfsitvlrto) / (nfsitqtd * propesprat)) else 0 end as mediaSipi
           from widl.NFC001(nolock),widl.NFC003(nolock), 
          widl.mov01(nolock),widl.prod01(nolock) 
          where widl.NFC001.nfsnfnro = widl.NFC003.nfsnfnro 
          and widl.NFC003.nfsitcod = widl.prod01.procod 
          and widl.NFC003.nfsfilcgc = widl.NFC001.nfsfilcgc 
          and widl.NFC003.nfsnfser =  widl.NFC001.nfsnfser 
          and widl.nfc001.nfsmovcod = widl.MOV01.movcod  
          and widl.NFC003.nfsnfser = 2 
          and widl.NFC003.nfsnfnro = '221258'
          order by nfsitseq";
         $dadosDet = $PDO->query($sSqlDet);
         if($apresen=='valor'){
          $pdf->Cell(0,5,"                  Produto                                                                                                          Un"
        . "        Qtd              Unit            Total                   ",0,1,'L');
         }else{
           $pdf->Cell(0,5,"                  Produto                                                                                                          Un"
        . "        Qtd              Peso Bruto          Peso Líquido                  ",0,1,'L');  
         }
         while ($rowDet = $dadosDet->fetch(PDO::FETCH_ASSOC)){
             
        $pdf->Cell(14,5,'',0,0,'L');
        $pdf->Cell(18,5,$rowDet['nfsitcod'],0,0,'L');
        $pdf->Cell(75,5,$rowDet['nfsitdes'],0,0,'L');
        $pdf->Cell(10,5,$rowDet['nfsitund'],0,0,'L');//qt
        $pdf->Cell(16,5,number_format($rowDet['qt'], 2, ',', '.'),0,0,'L');//vlrprod
        if($apresen=='valor'){
        $pdf->Cell(14,5,number_format($rowDet['nfsitvlrun'], 2, ',', '.'),0,0,'L');
        $pdf->Cell(16,5,number_format($rowDet['vlrprod'], 2, ',', '.'),0,1,'L');
        }else{
         $pdf->Cell(21,5,number_format($rowDet['pesoBruto'], 2, ',', '.'),0,0,'L');//
         $pdf->Cell(16,5,number_format($rowDet['pesoLiq'], 2, ',', '.'),0,1,'L');  //icms   
        }
        
        
    }
    $pdf->Ln(2);
   }
    
    
    
    
    
    
    
    
    $Itotal = $Itotal + $row['vlrtotal'];
    $iTotalLiq = $iTotalLiq + $row['vlrprod'];
    $iTotalLiqSt = $iTotalLiqSt + $row['vlrLiqSt'];
    $iPeso = $iPeso + $row['pesoLiq'];
}
$pdf->Ln(10);
$pdf->SetFont('arial','',10);
$pdf->Cell(45,5,'Total Faturado/Liq+St+IPI:',0,0,'L');
$pdf->Cell(16,5,number_format($Itotal, 2, ',', '.'),0,1,'L');

$pdf->Cell(45,5,'Total Líquido:',0,0,'L');
$pdf->Cell(16,5,number_format($iTotalLiq, 2, ',', '.'),0,1,'L');

$pdf->Cell(45,5,'Total Líquido C/St:',0,0,'L');
$pdf->Cell(16,5,number_format($iTotalLiqSt, 2, ',', '.'),0,1,'L');

$pdf->Cell(45,5,'Peso Líquido:',0,0,'L');
$pdf->Cell(16,5,number_format($iPeso, 2, ',', '.'),0,1,'L');


$pdf->Output('','RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE