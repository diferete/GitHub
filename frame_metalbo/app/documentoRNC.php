<?php

// Diretórios
require '../../biblioteca/Utilidades/Util.php';
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sNr = $_REQUEST['nr'];
$sFilcgc = $_REQUEST['filcgc'];

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

$pdf->SetFont('Arial', 'B', 12);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'RELATÓRIO DE NÃO CONFORMIDADE (RNC)', 0, 0, 'L');


$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x, $y);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sql = "select prodes, * from MET_QUAL_Rnc
            left outer join widl.prod01
            on  widl.prod01.procod = MET_QUAL_Rnc.codprod 
            where nr = " . $sNr . " and filcgc = " . $sFilcgc . "";

$sth = $PDO->query($sql);

$row = $sth->fetch(PDO::FETCH_ASSOC);


$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');
$pdf->SetXY($x, $y + 10);
$pdf->MultiCell(50, 5, 'Situação: ' . $row['sit'], 0, 'L');
$pdf->SetXY($x, $y + 15);
$pdf->MultiCell(50, 5, 'RNC Nº: ' . $sNr, 0, 'L');
$pdf->Ln(3);
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);


$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180);
$pdf->Cell(204, 6, 'MATERIAL PRODUTO NÃO CONFORMIDADE', 0, 1, 'C', 1);
$pdf->SetFillColor(255);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(102, 5, 'CORRIDA/ MATERIAL', 1, 0, 'L', 1);
$pdf->Cell(102, 5, 'PRODUTO', 1, 1, 'L', 1);
$pdf->SetFont('Arial', '', 8);

$aDados = explode(';', $row['corrida']);
$x = $pdf->GetX();
$y = $pdf->GetY();

$sSql2 = "select corrida, MetQual_MovOi .procod,prodes from MetQual_MovOi 
              left outer join widl.PROD01 on  MetQual_MovOi .procod  =widl.PROD01.procod  
              where corrida like '" . $row['corrida'] . "' ";
$sth2 = $PDO->query($sSql2);
$row2 = '';
$row2 = $sth2->fetch(PDO::FETCH_ASSOC);

$pdf->Cell(102, 6, rtrim($row['corrida']), 1, 1, 'C', 1);

$pdf->SetXY($x + 102, $y);

$pdf->Cell(102, 6, $row['codprod'] . ' - ' . $row['prodes'], 1, 1, 'C', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(51, 5, 'Nº OF E/OU NF', 1, 0, 'C', 1);
$pdf->Cell(51, 5, 'LOTE', 1, 0, 'C', 1);
$pdf->Cell(102, 5, 'RESPONSÁVEL PELA RNC', 1, 1, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(51, 6, $row['op'], 1, 0, 'C', 1);
$pdf->Cell(51, 6, $row['lote'], 1, 0, 'C', 1);
$pdf->Cell(102, 6, $row['userf'], 1, 1, 'C', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(102, 5, 'QUANT.PÇS DO LOTE', 1, 0, 'L', 1);
$pdf->Cell(102, 5, 'QUANT.NÃO CONFORME', 1, 1, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(102, 6, $row['qtlote'], 1, 0, 'C', 1);
$pdf->Cell(102, 6, $row['qtloternc'], 1, 1, 'C', 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180);
$pdf->Cell(204, 6, 'DESCRIÇÃO DA NÃO CONFORMIDADE', 0, 1, 'C', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(255);
$pdf->Cell(30, 6, 'PROBLEMA:', 'T', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(174, 6, $row['desccausa'], 'B,T', 1, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6, 'FORNECEDOR:', 'B,T', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(174, 6, $row['fornec'], 'B,T', 1, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 6, 'DESCRIÇÃO:', 'T', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(174, 6, $row['descrnc'], 'T', 1, 'L', 1);

$pdf->Ln(5);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(102, 5, 'SETOR QUE CAUSOU', 1, 0, 'C', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(102, 5, 'SETOR QUE DECTECTOU', 1, 1, 'C', 1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(51, 5, 'ORIGEM DA NÃO CONFORMIDADE:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(51, 5, $row['tipornc'], 'B,T,R', 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(51, 5, 'SE PROCESSO, QUAL?', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(51, 5, '', 'B,T,R', 1, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'SETOR:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, $row['descset02'], 'B,T,R', 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'SETOR:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, $row['descset01'], 'B,T,R', 1, 'L', 1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(102, 5, 'COLABORADOR(ES)', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'COLABORADOR:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, $row['lidercausa'], 'B,T,R', 1, 'L', 1);
$aUsers = explode(';', $row['usercausa']);
foreach ($aUsers as $key) {
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(102, 5, $key, 1, 0, 'L', 1);
    $pdf->Cell(102, 5, '--------', 1, 1, 'C', 1);
}


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'TURNO:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, $row['turno01'], 'B,T,R', 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'TURNO:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, $row['turno02'], 'B,T,R', 1, 'L', 1);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'DATA:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, Util::converteData($row['databert']), 'B,T,R', 0, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 5, 'DATA:', 'B,T,L', 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(62, 5, Util::converteData($row['databert']), 'B,T,R', 1, 'L', 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180);
$pdf->Cell(204, 6, 'CAUSA DA NÃO CONFORMIDADE', 0, 1, 'C', 1);
//$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(255);
//$pdf->Cell(40, 6, 'CAUSA:', 1, 0, 'L',1);
//$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(164, 6, $row['causarnc'], 1, 1, 'L',1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(204, 5, 'OBSERVAÇÃO:', 'R,L,T', 1, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(204, 6, $row['desccausa'], 'R,L,B', 1, 'L', 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180);
$pdf->Cell(204, 6, 'DECISÃO DE CORREÇÃO', 0, 1, 'C', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFillColor(250);
$pdf->Cell(40, 6, 'CORREÇÃO:', 1, 0, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(164, 6, $row['decisaornc'], 1, 1, 'L', 1);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(204, 5, 'OBSERVAÇÃO:', 'R,L,T', 1, 'L', 1);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(204, 5, $row['descdescirnc'], 'R,L,B', 1, 'L', 1);

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(180);
$pdf->Cell(204, 6, 'CONHECIMENTOS NOTIFICADOS (Resposáveis e Assinaturas)', 0, 1, 'C', 1);
$pdf->SetFillColor(255);
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(164, 7, 'CAUSADOR(ES) DA NÃO CONFORMIDADE', 'T,R,L', 0, 'C', 1);
$pdf->Cell(40, 7, 'DATA', 'T,R,L', 1, 'C', 1);

foreach ($aUsers as $key) {
    $pdf->Cell(164, 7, 'Colaborador (' . $key . '):', 1, 0, 'L', 1);
    $pdf->Cell(40, 7, 'DATA:', 1, 1, 'L', 1);
}
$pdf->Ln(1);
$pdf->Cell(164, 7, 'LÍDER DO SETOR CAUSADOR (' . $row['respcausa'] . '):', 1, 0, 'L', 1);
$pdf->Cell(40, 7, 'DATA:', 1, 1, 'L', 1);
$pdf->Ln(1);
$pdf->Cell(164, 7, 'GERENTE DA PRODUÇÃO (Volnei Hoffmann):', 1, 0, 'L', 1);
$pdf->Cell(40, 7, 'DATA:', 1, 1, 'L', 1);
$pdf->Ln(1);
$pdf->Cell(164, 7, 'LABORATÓRIO (' . $row['userf'] . '):', 1, 0, 'L', 1);
$pdf->Cell(40, 7, 'DATA:', 1, 1, 'L', 1);
$pdf->Ln(1);
$pdf->Cell(164, 7, 'OUTRO:', 1, 0, 'L', 1);
$pdf->Cell(40, 7, 'DATA:', 1, 1, 'L', 1);
//$pdf->Ln(1);
//$pdf->Cell(164, 8, 'RESPONSÁVEL DO SETOR ('.$row['respcausa'].'):', 1, 0, 'L',1);
//$pdf->Cell(40, 8, 'DATA:', 1, 1, 'L',1);
$pdf->Ln(1);
$pdf->Cell(204, 7, 'Nº O.R.::', 1, 1, 'L', 1);

if (strstr($row['anexo1'], 'png') || strstr($row['anexo1'], 'jpg')) {
    if (isset($row['anexo1'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo = $row['anexo1'];
        $pdf->Image('../../Uploads/' . $sAnexo, null, null, 190, 250);
    }
}
if (strstr($row['anexo2'], 'png') || strstr($row['anexo2'], 'jpg')) {
    if (isset($row['anexo2'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo2 = $row['anexo2'];
        $pdf->Image('../../Uploads/' . $sAnexo2, null, null, 190, 250);
    }
}
$pdf->Output('I', 'documentoRNC.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
