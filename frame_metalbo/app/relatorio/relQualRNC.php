<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
//require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

date_default_timezone_set('America/Sao_Paulo');
$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSit = $_REQUEST['sitmp'];
$sDataIni = $_REQUEST['dataini'];
$sDataFin = $_REQUEST['datafinal'];
$sTipRnc = $_REQUEST['tipornc'];
$sTipFix = $_REQUEST['tipfix'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Relatório Geral de Não Conformidade', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(5);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(15, 5, 'Filtros:', 0, 0, 'L');
$pdf->Cell(15, 5, 'Tipo: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sTipRnc, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Tipo Fixador: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sTipFix, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(20, 5, 'Situação: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sSit, 0, 1, 'L');
$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data Inicial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sDataIni, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, 'Data Final: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $sDataFin, 0, 1, 'L');

$pdf->Cell(203, 2, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L'); 
$pdf->Ln(3);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//1 - Quantidade de RNC mensal
$sql = "select count(nr) as TotalRnc from Met_Qual_rnc "
        . "left outer join widl.PROD01 
           on Met_Qual_rnc.codprod = widl.PROD01.procod";

$sql.=" where databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 

if($sTipRnc!='Todos'){
$sql.=" and tipornc = '".$sTipRnc."'";
}
if($sSit!='Todos'){
$sql.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql.=" and grucod in(13)";
}

$sth = $PDO->query($sql);

$row = $sth->fetch(PDO::FETCH_ASSOC);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'QUANTIDADE DE RNCs:', 0, 1, 'L');
$pdf->Ln(2);
$pdf->Cell(15, 5, 'Total:', 0, 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(9, 5, $row['TotalRnc'], 0, 1, 'L');    

$pdf->Cell(203, 2, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

//2 - Quantidade de RNC aberta e fechada mensalmente 
$sql1 = " select count(nr) as totalrnc,sit   from Met_Qual_rnc left outer join widl.PROD01 
           on Met_Qual_rnc.codprod = widl.PROD01.procod ";

$sql1.=" where databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 

if($sTipRnc!='Todos'){
$sql1.=" and tipornc = '".$sTipRnc."'";
}
if($sSit!='Todos'){
$sql1.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql1.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql1.=" and grucod in(13)";
}

$sql1.=" group by sit ";

$sth1 = $PDO->query($sql1);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'QUANTIDADE DE RNCs DE ACORDO COM A SITUAÇÃO:', '', 1, 'L');
$pdf->Ln(2);

while ($row1 = $sth1->fetch(PDO::FETCH_ASSOC)){
    
$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Situação:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row1['sit'], 'B', 0, 'L');     

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row1['totalrnc'], 'B', 1, 'L'); 
    
}

$pdf->Cell(203, 5, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

//3 - Número de RNC gerada em porcas - Número de RNC gerada em Parafusos
$sql2 = " select count(nr) as totalrnc,case grucod when 12  then ' 12-Porca '
        when 13 then  '13-Parafuso ' END grucod from  Met_Qual_rnc  
        left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod ";

if ($sTipFix=="Porca"){
    $sql2.=" where grucod in(12) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
}else if($sTipFix=="Parafuso"){
    $sql2.=" where grucod in(13) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
}else{
    $sql2.=" where grucod in(12,13) and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
}
if($sTipRnc!='Todos'){
$sql2.=" and tipornc = '".$sTipRnc."'";
}
if($sSit!='Todos'){
$sql2.=" and sit = '".$sSit."'";
}
$sql2.= " group by grucod";

$sth2 = $PDO->query($sql2);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'NÚMERO DE RNCs GERADAS EM PORCAS E PARAFUSOS:', '', 1, 'L');
$pdf->Ln(2);

while ($row2 = $sth2->fetch(PDO::FETCH_ASSOC)){
    
$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Tipo:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row2['grucod'], 'B', 0, 'L');     

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row2['totalrnc'], 'B', 1, 'L'); 
    
}

$pdf->Cell(203, 5, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

/*3.1.1 - Quando for do PROCESSO considerar o peso da peça X quantidade de peças não conformes.
Assim tenho a informação do montante de peças não conformes geradas no processo. 
Se possivel conseguir o peso separado por setor causador e correção.*/

$sql3 = "select tipornc ,sum  (qtloternc * propesprat ) as PesoNconforme ,decisaornc
from Met_Qual_rnc left outer join widl.PROD01 
on Met_Qual_rnc.codprod = widl.PROD01.procod  
where tipornc ='Processo'  and databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 
if($sSit!='Todos'){
$sql3.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql3.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql3.=" and grucod in(13)";
}
$sql3.=" group by tipornc,decisaornc";

$sth3 = $PDO->query($sql3);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'PESO DAS PEÇAS NÃO CONFORMES GERADAS DE ACORDO COM A DECISÃO DAS RNCs:', '', 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(57, 5, 'Tipo', 'B', 0, 'L');
$pdf->Cell(77, 5, 'Peso não Conforme', 'B', 0, 'L');
$pdf->Cell(67, 5, 'Decisão RNC', 'B', 1, 'L');

while ($row3 = $sth3->fetch(PDO::FETCH_ASSOC)){

$pdf->SetFont('arial', '', 8);
$pdf->Cell(57, 5, $row3['tipornc'], 'B', 0, 'L');     
$pdf->Cell(77, 5, number_format($row3['PesoNconforme'],2,',','.'), 'B', 0, 'L');     
$pdf->Cell(67, 5, $row3['decisaornc'], 'B', 1, 'L');   
    
}
  
$pdf->Ln(5);

/*3.1.2 - Quando for do PROCESSO considerar o peso da peça X quantidade de peças não conformes.
Assim tenho a informação do montante de peças não conformes geradas no processo. 
Se possivel conseguir o peso separado por setor causador e correção.*/

$sql4 = "select  descset02,sum  (qtloternc * propesprat ) as PesoNconforme ,decisaornc  
from Met_Qual_rnc left outer join widl.PROD01 
on Met_Qual_rnc.codprod = widl.PROD01.procod  
where tipornc <> 'Fornecedor' and descset02 is not null and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";
if($sSit!='Todos'){
$sql4.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql4.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql4.=" and grucod in(13)";
}
$sql4.=" group by descset02,decisaornc";

$sth4 = $PDO->query($sql4);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'PESO DAS PEÇAS NÃO CONFORMES GERADAS DE ACORDO COM A DECISÃO DAS RNCs POR SETOR:', '', 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(81, 5, 'Descrição setor', 'B', 0, 'L');
$pdf->Cell(60, 5, 'Peso não Conforme', 'B', 0, 'L');
$pdf->Cell(60, 5, 'Decisão RNC', 'B', 1, 'L');

while ($row4 = $sth4->fetch(PDO::FETCH_ASSOC)){
    

$pdf->SetFont('arial', '', 8);
$pdf->Cell(81, 5, $row4['descset02'], 'B', 0, 'L');     
$pdf->Cell(60, 5, number_format($row4['PesoNconforme'],2,',','.'), 'B', 0, 'L');     
$pdf->Cell(60, 5, $row4['decisaornc'], 'B', 1, 'L');   
    
}

$pdf = quebraPagina($pdf->GetY()+15, $pdf);
$pdf->Cell(203, 5, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

/* 3.2 - Quando for FORNECEDOR preciso das duas informações: peso da peça X quantidade de peças não conformes 
 Assim tenho a informação do montante de peças não conformes geradas no processo. 
 Peso da peça X quantidade do lote, para ter a informação do peso do lote devolvido. Se possivel conseguir o peso separado por setor causador e correção.*/

$sql5 = "select tipornc , fornec,decisaornc,
        sum  (qtloternc * propesprat ) as PesoNconforme , sum  (qtlote * propesprat ) as PesoLote  
        from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod  
        where tipornc ='Fornecedor' and databert between '" . $sDataIni . "' and '" . $sDataFin . "'";

if($sSit!='Todos'){
$sql5.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql5.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql5.=" and grucod in(13)";
}            
$sql5.=" group by tipornc,fornec,decisaornc";

$sth5 = $PDO->query($sql5);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'QUANTIDADE DE PEÇAS NÃO CONFORMES NO PROCESSO E LOTE DEVOLVIDO:', '', 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(25, 5, 'Tipo RNC', 'B', 0, 'L');
$pdf->Cell(85, 5, 'Fornecedor', 'B', 0, 'L');
$pdf->Cell(35, 5, 'Decisao RNC', 'B', 0, 'L');
$pdf->Cell(30, 5, 'Peso não Conforme', 'B', 0, 'L');
$pdf->Cell(25, 5, 'Peso Lote', 'B', 1, 'L');

while ($row5 = $sth5->fetch(PDO::FETCH_ASSOC)){

$pdf->SetFont('arial', '', 8);
$pdf->Cell(25, 5, $row5['tipornc'], 'B', 0, 'L');     
$pdf->Cell(85, 5, $row5['fornec'], 'B', 0, 'L');     
$pdf->Cell(35, 5, $row5['decisaornc'], 'B', 0, 'L');   
$pdf->Cell(30, 5, number_format($row5['PesoNconforme'],2,',','.'), 'B', 0, 'L');   
$pdf->Cell(25, 5, number_format($row5['PesoLote'],2,',','.'), 'B', 1, 'L');   
    
}

$pdf = quebraPagina($pdf->GetY()+15, $pdf);
$pdf->Cell(203, 5, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

/*4 - Quantidades baseadas na origem da RNC*/
$sql6 = " select tipornc,count(nr) as TotalRnc from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod   ";

$sql6.=" where databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 

if($sSit!='Todos'){
$sql6.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql6.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql6.=" and grucod in(13)";
}           

$sql6.=" group by tipornc ";

$sth6 = $PDO->query($sql6);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'QUANTIDADES BASEADAS NA ORIGEM DA RNC:', '', 1, 'L');
$pdf->Ln(2);

while ($row6 = $sth6->fetch(PDO::FETCH_ASSOC)){
    
$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Tipo RNC:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row6['tipornc'], 'B', 0, 'L');     

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(50, 5, 'Total RNC:', 'B', 0, 'L');
$pdf->SetFont('arial', '', 8);
$pdf->Cell(50, 5, $row6['TotalRnc'], 'B', 1, 'L'); 
    
}

$pdf = quebraPagina($pdf->GetY()+15, $pdf);
$pdf->Cell(203, 5, '', 'B', 1, 'L');  
$pdf->Cell(203, 1, '', 'B', 1, 'L');  
$pdf->Ln(5);

/*5 - Quantidades baseadas no setor causador da RNC*/
$sql7 = " select descset02,count(nr) as TotalRnc from Met_Qual_rnc left outer join widl.PROD01 
        on Met_Qual_rnc.codprod = widl.PROD01.procod   ";

$sql7.=" where databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 

if($sSit!='Todos'){
$sql7.=" and sit = '".$sSit."'";
}
if ($sTipFix=="Porca"){
    $sql7.=" and grucod in(12)";
}else if($sTipFix=="Parafuso"){
    $sql7.=" and grucod in(13)";
}          
$sql7.=" and tipornc <> 'Fornecedor' and descset02 is not null group by descset02 ";

$sth7 = $PDO->query($sql7);

$pdf->SetFont('arial', 'B', 8);
$pdf->Cell(203, 5, 'QUANTIDADES BASEADAS NO SETOR CAUSADOR DA RNC:', '', 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(100, 5, 'Descrição Setor:', 'B', 0, 'L');
$pdf->Cell(100, 5, 'Total RNC:', 'B', 1, 'L');

while ($row7 = $sth7->fetch(PDO::FETCH_ASSOC)){

$pdf->SetFont('arial', '', 8);
$pdf->Cell(100, 5, $row7['descset02'], 'B', 0, 'L');     
$pdf->Cell(100, 5, $row7['TotalRnc'], 'B', 1, 'L'); 
    
}

$pdf->Output('I', 'relQualRNC.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}