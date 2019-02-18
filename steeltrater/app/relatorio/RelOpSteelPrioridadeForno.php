<?php
// Autor: Cleverton Hoffmann
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

$oDesForno = $_REQUEST['fornoDes'];
$oCodForno = $_REQUEST['fornoCod'];
//Inserção do cabeçalho
$pdf->Cell(37,12,$pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45),0,0,'J');

$pdf->SetFont('Arial','',15);
$pdf->Cell(110,10,'Relatório Prioridade do '.$oDesForno, '',0, 'C',0); 

$pdf->SetFont('Arial','',9);
$pdf->MultiCell(52,5,'Data: '.$data
        .'        Hora:'.$hora
        .' Usuário:'.$useRel 
        .' ','','L',0); //'B,R,T'
$pdf->Cell(0,3,'','',1,'L');
$pdf->Cell(0,3,'','T',1,'L');

//Inicio
              
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select STEEL_PCP_ordensFabLista.op, STEEL_PCP_ordensFabLista.situacao, prioridade, 
               tempForno, prod, STEEL_PCP_ordensFab.prodes, peso, emp_razaosocial 
               from STEEL_PCP_ordensFabLista left join STEEL_PCP_ordensFab on
               STEEL_PCP_ordensFabLista.op = STEEL_PCP_ordensFab.op
               where STEEL_PCP_ordensFabLista.fornocod = '".$oCodForno."' and STEEL_PCP_ordensFabLista.situacao = 'Liberado'
               order by prioridade"; 
          
   $dadosRela = $PDO->query($sSqli);
   
   //Filtros escolhidos
   //$pdf->SetFont('Arial','B',10);
   //$pdf->Cell(35,10,'Filtros escolhidos:', '',1, 'L',0);
   /*
   $pdf->SetFont('Arial','',10);
   $pdf->Cell(30,10,'Codigo: '.$iCodigo.
           '         Peça: '.$oPeca, '',1, 'L',0);
   
   $pdf->Cell(0,3,'','',1,'L');
   */
   $peso=0;
   
   while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){
   
   //Títulos do relatório
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(12,4,'Priorid.', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(12,4,'Temp.', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(14,4,'Op', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(15,4,'Produto', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(62,4,'Descrição', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(14,4,'Peso', '',0, 'L',0);
   
   $pdf->SetFont('Arial','B',8);
   $pdf->Cell(50,4,'Cliente', '',1, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(12,4,$row['prioridade'], '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(12,4,number_format($row['tempForno'], 0, ',', '.'), '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(14,4,$row['op'], '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(15,4,$row['prod'], '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(62,4,$row['prodes'], '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(14,4,number_format($row['peso'], 2, ',', '.'), '',0, 'L',0);
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(50,4,$row['emp_razaosocial'], '',1, 'L',0);   
   
   $sSqliItens = "select tratdes, temperatura 
                  from STEEL_PCP_Tratamentos left outer join STEEL_PCP_ordensFAbItens on 
                  STEEL_PCP_Tratamentos.tratcod = STEEL_PCP_ordensFAbItens.tratamento
                  where STEEL_PCP_ordensFabItens.op ='".$row['op']."'"; 
          
   $dadosItens = $PDO->query($sSqliItens);
      
   while($rowItens = $dadosItens->fetch(PDO::FETCH_ASSOC)){
       
       $pdf->SetFont('Arial','',7);
       $pdf->Cell(50,4,$rowItens['tratdes'], '',0, 'L',0);
   
       $pdf->SetFont('Arial','',7);
       $pdf->Cell(5,4,number_format($rowItens['temperatura'], 0, ',', '.'), '',0, 'L',0);
       
   }
   $pdf->SetFont('Arial','B',7);
   $pdf->Cell(0,4,'', '',1, 'L',0);
   
   $pdf->SetFont('Arial','B',5);
   $pdf->Cell(200,2,'', 'T',1, 'L',0);
   $peso = ($peso + $row['peso']);
//Fim  
   }
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(200,3,'Peso Total:  '.$peso, '',1, 'L',0);
   
$pdf->Output('I','RelOpSteelPrioridadeForno.pdf');
 Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 