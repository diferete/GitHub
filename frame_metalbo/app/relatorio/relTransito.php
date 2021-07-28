<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$data1 = $_REQUEST['dataini'];
$data2 = $_REQUEST['datafim'];
$sMotivo = $_REQUEST['motivo'];
$sUserRel = $_REQUEST['userRel'];
$sEmpcod = $_REQUEST['empcod'];
$sEmpdes = $_REQUEST['empdes'];
$sSituacao = $_REQUEST['situacao'];

date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');

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

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);
// Move to the right
$pdf->Cell(50);
// Title
$pdf->Cell(95, 10, 'Relatorio de Trânsito', 0, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 15, 'Per.: ' . $data1 .
        ' - ' . $data2, 0, 'L');

$pdf->Ln(5);

//define a altura inicial dos dados
$pdf->SetFont('arial', '', 8);
$pdf->SetY(30);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sSql = "select * from MET_PORT_Transito where datachegou BETWEEN '" . $data1 . "' and '" . $data2 . "'";

if ($sMotivo != '') {
    $sSql .= " and ";
    $sSql .= " motivo = '" . $sMotivo . "'";
}  
if($sEmpcod!= ''){
    $sSql .= " and ";
    $sSql .= " empcod = '" . $sEmpcod . "'";
} 
if($sSituacao!= ''){
    $sSql .= " and ";
    $sSql .= " situaca = '" . $sSituacao . "'";
} 

$sth = $PDO->query($sSql);

$iMot1 = 0;
$iMot2 = 0;
$iMot3 = 0;
$iMot4 = 0;
$iMot5 = 0;
$iMot6 = 0;
$iMot7 = 0;
$iSit1 = 0;
$iSit2 = 0;
$iSit3 = 0;

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    if ($row['motivo'] == '1') {
        $sMotivo = 'Coleta';
        $iMot1++;
    }
    if ($row['motivo'] == '2') {
        $sMotivo = 'Entrega Mat.P.';
        $iMot2++;
    }
    if ($row['motivo'] == '3') {
        $sMotivo = 'Outras Coletas';
        $iMot3++;
    }
    if ($row['motivo'] == '4') {
        $sMotivo = 'Outras Entregas';
        $iMot4++;
    }
    if ($row['motivo'] == '5') {
        $sMotivo = 'Serviços';
        $iMot5++;
    }
    if ($row['motivo'] == '6') {
        $sMotivo = 'Visita';
        $iMot6++;
    }
    if ($row['motivo'] == '7') {
        $sMotivo = 'Outro';
        $iMot7++;
    }
    if($row['situaca']== 'Chegada'){
        $iSit1++;
    }
    if($row['situaca']== 'Entrada'){
        $iSit2++;
    }
    if($row['situaca']== 'Saída'){
        $iSit3++;
    }
    

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(24, 5, 'CNPJ', 'L,B,R,T', 0, 'L');
    $pdf->Cell(82, 5, 'Empresa', 'L,B,R,T', 0, 'L');    
    $pdf->Cell(60, 5, 'Motorista', 'L,B,R,T', 0, 'L');
    $pdf->Cell(16, 5, 'Placa', 'L,B,R,T', 0, 'L');
    $pdf->Cell(23, 5, 'Motivo', 'L,B,R,T', 1, 'L');
    
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(24, 5, $row['empcod'], 'L,B,R,T', 0, 'L');
    $pdf->Cell(82, 5, $row['empdes'], 'L,B,R,T', 0, 'L');   
    $pdf->Cell(60, 5, $row['motorista'], 'L,B,R,T', 0, 'L');
    $pdf->Cell(16, 5, $row['placa'], 'L,B,R,T', 0, 'L');
    $pdf->Cell(23, 5, $sMotivo, 'L,B,R,T', 1, 'L');
    
    $pdf = quebraPagina($pdf->GetY(), $pdf);
    
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(19, 5, 'Situação', 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, 'Data Chegada', 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, 'Hora Chegada', 'L,B,R,T', 0, 'L');    
    $pdf->Cell(31, 5, 'Data Entrada', 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, 'Hora Entrada', 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, 'Data Saída', 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, 'Hora Saída', 'L,B,R,T', 1, 'L');
    
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(19, 5, $row['situaca'], 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, inverteData($row['datachegou']), 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, substr($row['horachegou'],0,8), 'L,B,R,T', 0, 'L');    
    $pdf->Cell(31, 5, inverteData($row['dataentrou']), 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, substr($row['horaentrou'],0,8), 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, inverteData($row['datasaiu']), 'L,B,R,T', 0, 'L');
    $pdf->Cell(31, 5, substr($row['horasaiu'],0,8), 'L,B,R,T', 1, 'L');
    
    $pdf = quebraPagina($pdf->GetY(), $pdf);
    
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(29, 5, 'Descrição Motivo:', 'L,B,T', 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(176, 5, $row['descmotivo'], 'B,R,T', 1, 'L');
    $pdf->Cell(0, 3, "", "B", 1, 'C');
    $pdf->Cell(0, 2, "", "", 1, 'C');

    $pdf = quebraPagina($pdf->GetY(), $pdf);
}

$pdf = quebraPagina($pdf->GetY()+30, $pdf);

//$pdf->Rect($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+201, $pdf->GetY()+30);
        
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(204, 5, 'Quantidade dos Motivos:','L,B,R,T', 1, 'L');
$pdf->Cell(0, 2, "", 0, 1, 'C');
$pdf->Cell(20, 5, 'Coleta:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot1, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Entrega mat.p.:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot2, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Outras coletas:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot3, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Outras entregas:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot4, 0, 1, 'L');
$pdf->Cell(0, 1, "", 0, 1, 'C');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(20, 5, 'Serviços:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot5, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Visita:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot6, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Outros:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iMot6, 0, 1, 'L');

$pdf->Cell(0, 2, "", "", 1, 'C');
$pdf->Cell(0, 2, "", 0, 1, 'C');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(204, 5, 'Quantidade das Situações:','L,B,R,T', 1, 'L');
$pdf->Cell(0, 2, "", 0, 1, 'C');
$pdf->Cell(20, 5, 'Chegada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iSit1, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Entrada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iSit2, 0, 0, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, 'Saída:', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(20, 5, $iSit3, 0, 0, 'L');

$pdf->Output('I', 'Rel.Transito' . $data1 . '.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}

//Função que recebe a data no formato Y-m-d e a inverte para d/m/Y ou vice versa
function inverteData($data){
    if(count(explode("/",$data)) > 1){
        return implode("-",array_reverse(explode("/",$data)));
    }elseif(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }
}