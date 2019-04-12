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
$useRel= $_REQUEST['userRel'];


//Inserção do cabeçalho
$pdf->Cell(37,15,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45),0,0,'J');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,15,'Relatório Apontamento de Produção', '',0, 'C',0); 

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,7,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0); //'B,R,T'
$pdf->Cell(0,5,'','',1,'L');
$pdf->Cell(0,5,'','T',1,'L');


//Inicio
     //Pega data que o usuário digitou
        
        
        
     //Pega dados que passados pelo usuário na tela de relatório
    // $dtReceita= $_REQUEST['dataatual'];
     $iCodigo=$_REQUEST['cod'];
     $oPeca=$_REQUEST['peca'];
          
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select cod, convert(varchar,data,103)as data,
               peca, material, classe, dureza from STEEL_PCP_Receitas"; 
               if($iCodigo!==''){     
               $sSqli.= " where cod='".$iCodigo."'";
               } 
            /*   if($dtReceita!==''){
                   $sSqli.=" and data ='".$dtReceita."'";
               }
            */   
          
   $dadosRela = $PDO->query($sSqli);
   
   if (($iCodigo=='')||($oPeca=='')){
       $iCodigo='Todos';
       $oPeca='Todas';
   }
   //Filtros escolhidos
   $pdf->SetFont('Arial','B',10);
   $pdf->Cell(35,10,'Filtros escolhidos:', '',0, 'L',0);
   
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,'Codigo: '.$iCodigo.
           '         Peça: '.$oPeca, '',1, 'L',0);
   
   $pdf->Cell(0,3,'','',1,'L');
   
   $iContaAltura=12;
   while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   $iContaAltura=12;
   //Títulos do relatório
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(15,5,'CÓDIGO', 'B,R,L,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(59,5,'PEÇA', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(20,5,'MATERIAL', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(51,5,'CLASSE', 'B,R,T',0, 'C',0);
   
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(54,5,'DUREZA', 'B,R,T',1, 'C',0);
   
  // $pdf->SetFont('Arial','B',9);
  // $pdf->Cell(20,5,'DATA', 'B,R,T',1, 'C',0);
          
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(15, 6, $row['cod'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(59, 6, $row['peca'],'L,B',0,'C');
       
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(20, 6, $row['material'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(51, 6, $row['classe'],'L,B',0,'C');
   
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(54, 6, $row['dureza'],'L,B,R',1,'C');
   
  // $pdf->SetFont('Arial','',9); 
  // $pdf->Cell(20, 6, $row['data'],'L,B,R',1,'C');

   $sSqlint = "select seq, STEEL_PCP_Tratamentos.tratcod, camada_min, camada_max, 
                temperatura, tempo, resfriamento, tratdes 
                from STEEL_PCP_ReceitasItens left outer join STEEL_PCP_Tratamentos 
                on STEEL_PCP_ReceitasItens.tratcod = STEEL_PCP_Tratamentos.tratcod
                where cod='".$row['cod']."'"; 
                        
   $dadosRelaciona = $PDO->query($sSqlint);
   
   //Títulos do relatório
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,5,'SEQ', 'B,R,L,T',0, 'C',0);
   
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(23,5,'TRATAMENTO', 'B,R,T',0, 'C',0);
   
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(56,5,'DESCRIÇÃO', 'B,R,T',0, 'C',0);
    
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(18,5,'TEMP.ºC', 'B,R,T',0, 'C',0);
        
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(15,5,'TEMPO', 'B,R,T',0, 'C',0);
   
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(26,5,'RESFRIAMENTO', 'B,R,T',0, 'C',0);
        
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(23,5,'CAMADA MIN', 'B,R,T',0, 'C',0);
   
        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(23,5,'CAMADA MAX', 'B,R,T',1, 'C',0);
        
    while($rowint = $dadosRelaciona->fetch(PDO::FETCH_ASSOC)){
        
          
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(15, 6, $rowint['seq'],'L,B',0,'C');
       
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(23, 6, $rowint['tratcod'],'L,B',0,'C');
       
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(56, 6, $rowint['tratdes'],'L,B',0,'C');
   
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(18, 6, number_format($rowint['temperatura'],0,',','.'),'L,B',0,'C');
   
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(15, 6, number_format($rowint['tempo'], 0,',','.'),'L,B',0,'C');
   
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(26, 6, $rowint['resfriamento'],'L,B',0,'C');
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(23, 6, number_format($rowint['camada_min'], 2, ',', '.'),'L,B',0,'C');
        
        $pdf->SetFont('Arial','',9);
        $pdf->Cell(23, 6, number_format($rowint['camada_max'], 2, ',', '.'),'L,B,R',1,'C');
        
    }
    
    $pdf->Cell(100,6,'', '',1, '',0);
    $iContaAltura=$iContaAltura+$pdf->GetY();
    if ($iContaAltura >= 260) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
   }
   
//Fim  
   
$pdf->Output('I','RelOpSteelForno.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 