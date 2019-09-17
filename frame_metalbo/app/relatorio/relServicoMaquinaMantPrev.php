<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSit ='';

if(!isset($_REQUEST['dataini'])){
$sNr1 = $_SERVER['QUERY_STRING'];
$aNr1 = explode('&', $sNr1);
$aNr2 = array();
$i=0;
foreach ($aNr1 as $key){
    if(substr($key, 0, 2)=='nr'){
        $aNr2[$i] = substr($key, 3);
        $i++;
    }
    if(substr($key, 0, 3)=='Sit'){
        $sSit = substr($key, 4);
    }
}
}else{
    $sDataIni = $_REQUEST['dataini'];
    $sDataFin = $_REQUEST['datafinal'];
    $sResp = $_REQUEST['resp'];
    $sSeq = $_REQUEST['MET_Maquinas_seq']; 
    $sMaqTip = $_REQUEST['MET_Maquinas_maqtip'];
    $sSetor = $_REQUEST['MET_Maquinas_codsetor']; 
    $sSit = $_REQUEST['sitmp'];
    $sCodMaq = $_REQUEST['codmaq'];
}


class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
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
$pdf->Cell(100, 10, 'Relatório Serviço Maquinas Man.Prev.', 0, 0, 'L');

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

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//Entra no Foreach caso relatório tela
if(!isset($aNr2)){
    $aNr2[1] = 'i';
}

foreach ($aNr2 as $sNr){

    $sql = "select tbmanutmp.filcgc, tbmanutmp.nr, tbmanutmp.codmaq, tbmanutmp.codsetor, descsetor, tbitensmp.codsit, servico, ciclo, resp, dias, tbitensmp.sitmp,
            tbitensmp.userinicial, convert(varchar,tbitensmp.datafech,103) as datafech, 
            tbitensmp.userfinal, obs, oqfazer, maquina, maqtip, convert(varchar,tbitensmp.databert,103) as databert  
            from tbmanutmp
            left outer join 
            tbitensmp on tbmanutmp.nr = tbitensmp.nr 
            left outer join 
            MetCad_Setores on MetCad_Setores.codsetor = tbmanutmp.codsetor 
            left outer join 
            tbservmp on tbitensmp.codsit = tbservmp.codsit 
            left outer join
            metmaq on tbitensmp.codmaq = metmaq.cod ";
    
if($sNr!='i'&&$sNr!=' '){
    $sql.=" where tbmanutmp.nr = '" . $sNr . "' "; 
}
if(isset($sDataIni)){
    $sql.=" where tbitensmp.databert between '" . $sDataIni . "' and '" . $sDataFin . "'"; 
}
if(isset($sCodMaq) && $sCodMaq!=''){
    $sql.=" and tbmanutmp.codmaq = '" . $sCodMaq . "'"; 
}
if(isset($sResp) && $sResp!=''){
    $sql.=" and tbservmp.resp = '" . $sResp . "'"; 
}
if(isset($sSeq) && $sSeq!=''){
    $sql.=" and metmaq.seq = '" . $sSeq . "'";
}
if(isset($sMaqTip) && $sMaqTip!=' '){
    $sql.=" and metmaq.maqtip = '" . $sMaqTip . "'";
}
if(isset($sSetor) && $sSetor!=''){
    $sql.=" and metmaq.codsetor = '" . $sSetor . "'";
}
if($sSit == 'ABERTOS'){
    $sql.=" and tbitensmp.sitmp = 'ABERTO' "; 
}
if($sSit == 'FINALIZADOS'){
    $sql.=" and tbitensmp.sitmp = 'FINALIZADO' "; 
}
    $sth = $PDO->query($sql);

$iN = 0;
$iCont = 0;
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    if($iN != $row['codmaq']) {
        
        $pdf = quebraPagina($pdf->GetY()+15, $pdf);
        
        $pdf->Ln(5);
        $pdf->Cell(199, 1, '', 'T', 1, 'L');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(15, 5, 'Nr', 'R,L,B,T', 0, 'L');
        $pdf->Cell(15, 5, 'Maquina', 'R,L,B,T', 0, 'L');
        $pdf->Cell(77, 5, 'Descrição', 'R,L,B,T', 0, 'L');
        $pdf->Cell(20, 5, 'Setor', 'R,L,B,T', 0, 'L');
        $pdf->Cell(76, 5, 'Descrição','R,L,B,T', 1, 'L');
        $pdf->Cell(199, 0, '', "B", 1, 'L');
        
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(15, 5, $row['nr'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(15, 5, $row['codmaq'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(77, 5, $row['maquina'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(20, 5, $row['codsetor'], 'R,L,B,T', 0, 'L');
        $pdf->Cell(76, 5, $row['descsetor'], 'R,L,B,T', 1, 'L');
        $pdf->Cell(199, 5, '', '', 1, 'L');
        $iN = $row['codmaq'];
    }
        
        $pdf = quebraPagina($pdf->GetY()+15, $pdf);
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(15, 5, 'Código:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(9, 5, $row['codsit'], 'R,B,T', 0, 'L');
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(12, 5, 'Serviço:','L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 7);
        $pdf->Cell(167, 5, rtrim($row['oqfazer']).' '.rtrim($row['servico']), 'R,B,T', 1, 'L');
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(15, 5, 'Ciclo:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(9, 5, $row['ciclo'], 'R,B,T', 0, 'L');
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(15, 5, 'Dias:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(10, 5, $row['dias'], 'R,B,T', 0, 'L');
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(20, 5, 'Responsável:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(58, 5, $row['resp'], 'R,B,T', 0, 'L');
        
        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(15, 5, 'Situação:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(20, 5, $row['sitmp'], 'R,B,T', 0, 'L');
        
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(23, 5, 'Data Abertura:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(18, 5,$row['databert'], 'R,B,T', 1, 'L');  
        
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(25, 5, 'Usuário Inicial:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(53, 5, $row['userinicial'], 'R,B,T', 0, 'L');  
        
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(25, 5, 'Usuário Final:', 'L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(54, 5, $row['userfinal'], 'R,B,T', 0, 'L');  
        
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(28, 5, 'Data Fechamento:','L,B,T', 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(18, 5, $row['datafech'], 'R,B,T', 1, 'L');  
        $pdf->Cell(199, 5, '', '', 1, 'L');
}
}

$pdf->Output('I', 'relServicoMaquinaMantPrev.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}