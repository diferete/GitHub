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
$pdf->AddPage('L'); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5,5); // DEFINE O X E O Y NA PAGINA

//Caminho da logo
$sLogo ='../../biblioteca/assets/images/steelrel.png'; 
$pdf->SetMargins(5,5,5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$useRel= $_REQUEST['userRel'];

//Pega data que o usuário digitou
$dtinicial= $_REQUEST['dataini'];
$dtfinal= $_REQUEST['datafinal'];

//Inserção do cabeçalho
$pdf->Cell(37,15,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45),0,0,'J');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'Relatório Ordem de Produção', '',0, 'C',0); 

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0); //'B,R,T'
$pdf->Cell(0,5,'','',1,'L');
$pdf->Cell(0,5,'','T',1,'L');


//Inicio
     $sRetrabalho = $_REQUEST['retrabalho'];
     $sSituacao=$_REQUEST['situa'];
     $iEmpCodigo=$_REQUEST['emp_codigo'];
     $iTratCod = $_REQUEST['tratcod'];
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select op,prod,prodes,prodesfinal,quant,
              peso,opcliente,convert(varchar,data,103) as data,convert(varchar,dataprev,103) as dataprev,
              situacao 
              from STEEL_PCP_OrdensFab left outer join STEEL_PCP_receitasItens
              on STEEL_PCP_OrdensFab.receita = STEEL_PCP_receitasItens.cod 
              and seq = ( select top 1 seq from STEEL_PCP_receitasItens where cod = STEEL_PCP_OrdensFab.receita order by seq ) 
              where data between '".$dtinicial."' and '".$dtfinal."'";
          if($sSituacao!=='Todas'){
              $sSqli.=" and situacao='".$sSituacao."' ";
          }else{
              $sSqli.=" and situacao not in ('Cancelada','Retornado') ";
          }
          if($iEmpCodigo!==''){
              $sSqli.=" and emp_codigo='".$iEmpCodigo."' ";
          }
          if($sRetrabalho!='Incluir'){
              $sSqli.=" and retrabalho='".$sRetrabalho."' ";
          }else{
              $sSqli.=" and retrabalho <> 'Retorno não Ind.' and retrabalho <> 'OP origem retrabalho' "; 
          }
          if($iTratCod!==''){
              $sSqli.=" and tratcod ='".$iTratCod."'  ";
          }
          
   $dadosRela = $PDO->query($sSqli);
   
   //Filtros escolhidos
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35, 10,'Filtros escolhidos:', '',0, 'L',0);
   
   if($_REQUEST['tratdes']!==''){
        $sTratDes = $_REQUEST['tratdes'];
   }else{
        $sTratDes = 'Todos';
   }
   if($iEmpCodigo==null){
       $iEmpCodigo = 'Todas';
   }
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(50,10,'Data inicial: '.$dtinicial.
           '   Data final: '.$dtfinal.
           '   Empresa: '.$iEmpCodigo.
           '   Situação: '.$sSituacao.
           '   Retrabalho: '.$sRetrabalho.
           '   Tratamento: '.$sTratDes.
           ' ', '',1, 'L',0);
   
   $pdf->Cell(0,3,'','',1,'L');
   
   //Títulos do relatório
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(12,5,'OP', 'B,R,L,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(15,5,'Prod.', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(95,5,'Descrição', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(95,5,'Descrição Final', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(14,5,'Peso', 'B,R,T',0, 'C',0);
      
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(18,5,'Data', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(18,5,'Data Prev.', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(15,5,'Situação', 'B,R,T',1, 'C',0);
   
   $Pesototal=0;
   $Quanttotal=0;
   
   while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   
  
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(12, 6, $row['op'],'L,B,T',0,'C');
       
   $pdf->SetFont('Arial','',8);
   $pdf->Cell(15, 6, $row['prod'],'L,B,T',0,'L');
       
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(95, 6, $row['prodes'],'L,B,T',0,'L');
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(95, 6, $row['prodesfinal'],'L,B,T',0,'L');
   
  // $pdf->SetFont('Arial','',7);
  // $pdf->Cell(14, 6, number_format($row['quant'], 2, ',', '.'),'L,B',0,'R');
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(14, 6, number_format($row['peso'], 2, ',', '.'),'L,B,T',0,'R');
       
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(18, 6, $row['data'],'L,B,T',0,'C');
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(18, 6, $row['dataprev'],'L,B,T',0,'C');
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(15, 6, $row['situacao'],'L,B,R,T',1,'C');
  
   
   $Pesototal=($row['peso']+$Pesototal);
   //$Quanttotal=($row['quant']+$Quanttotal);
   }

   $pdf->Cell(50,5,'','B',1,'L');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(100, 2, '','',1,'C');
   
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(99, 8, 'Peso Total: '.number_format($Pesototal, 2, ',', '.'),'',0,'J');
    
//Fim  

$pdf->Output('I','RelOpSteel2.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 