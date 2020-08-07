<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');

$sCodSetor = $_REQUEST['codsetor'];
$sDtIni = $_REQUEST['dataini'];
$sDtFin = $_REQUEST['datafim'];
$sSituacao = $_REQUEST['situacao'];
$sSituacao2 = $_REQUEST['situacao2'];
$sTipo = $_REQUEST['tipoacao'];
if (isset($_REQUEST['vencido'])) {
    $sVencido = $_REQUEST['vencido'];
} else {
    $sVencido = "";
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

$pdf = new PDF('P', 'mm', 'A4');
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
$pdf->Cell(100, 10, 'Relatório Ações da Qualidade', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "select nr, filcgc, empdes, titulo, convert(varchar,dtimp,103) as dtimp, userimp, convert(varchar,dataini,103) as dataini, datafim, tipoacao, origem, sit, descsetor, equipe from tbacaoqual
        left outer join widl.EMP01 
        on tbacaoqual.filcgc = widl.EMP01.empcnpj
        where filcgc = '75483040000211' and empdes = 'METALBO INDUSTRIA DE FIXADORES METALICOS LTDA' ";

if ($sSituacao == 'A') {
    $sql .= " and sit = 'Aberta' ";
}
if ($sSituacao == 'F') {
    $sql .= " and sit = 'Finalizada' ";
}
if ($sTipo !== 'T') {
    $sql .= " and tipoacao = '" . $sTipo . "' ";
}
if ($sCodSetor !== '') {
    $sql .= " and codsetor = '" . $sCodSetor . "' ";
}
if ($sDtIni != '') {
    $sql .= " and dtimp between '" . $sDtIni . "' and '" . $sDtFin . "' ";
}
$sql .= " order by nr";

$sth = $PDO->query($sql);

$iQntAq = 0;
$iQntAqIni = 0;
$iQntAqAbert = 0;
$iQntAqFinal = 0;
$iQntVencido = 0;
$iQntPlanos = 0;
$iQntAqAcaoCorr = 0;
$iQntAqAcaoPrev = 0;

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    $iQntAq++;

    if ($sVencido != 'true') {

        $pdf->Ln(5);

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(5, 5, "Nr:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 5, $row['nr'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(23, 5, "CNPJ/Empresa:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(95, 5, $row['filcgc'] . ' - ' . $row['empdes'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(25, 5, "Data implantação:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(17, 5, $row['dtimp'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(14, 5, "Situação:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(16, 5, $row['sit'], 'B,R,T', 1, 'L');

        quebraPagina($pdf->GetY(), $pdf);

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(10, 5, "Ação: ", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(100, 5, $row['titulo'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(15, 5, "Origem:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 5, $row['origem'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(10, 5, "Tipo:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 5, $row['tipoacao'], 'B,R,T', 1, 'L');

        quebraPagina($pdf->GetY(), $pdf);

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(9, 5, "Setor:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 5, $row['descsetor'], 'B,R,T', 0, 'L');

        $pdf->SetFont('arial', 'B', 8);
        $pdf->Cell(12, 5, "Equipe:", 'B,L,T', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(127, 5, $row['equipe'], 'B,R,T', 1, 'L');

        quebraPagina($pdf->GetY(), $pdf);
    }
    $sql2 = "select plano,seq, convert(varchar,dataprev,103) as dataprev,"
            . " convert(varchar,datafim,103) as datafim, "
            . " datediff(day,datafim,dataprev) as dt"
            . " from tbacaoqualplan where nr =" . $row['nr'] . " and filcgc = '75483040000211' ";
    if ($sSituacao2 == 'F') {
        $sql2 .= " and sitfim = 'Finalizado' ";
    }
    if ($sSituacao2 == 'A') {
        $sql2 .= " and sitfim is null";
    }

    $sth2 = $PDO->query($sql2);
    $nr2 = $row['nr'];

    while ($row2 = $sth2->fetch(PDO::FETCH_ASSOC)) {

        if ($nr2 == $row['nr'] && ($row2['dt'] < 0) && ($sVencido == 'true')) {

            $pdf->Ln(5);

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(5, 5, "Nr:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(10, 5, $row['nr'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(23, 5, "CNPJ/Empresa:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(95, 5, $row['filcgc'] . ' - ' . $row['empdes'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(25, 5, "Data implantação:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(17, 5, $row['dtimp'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(14, 5, "Situação:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(16, 5, $row['sit'], 'B,R,T', 1, 'L');

            quebraPagina($pdf->GetY(), $pdf);

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(10, 5, "Ação: ", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(100, 5, $row['titulo'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(15, 5, "Origem:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(35, 5, $row['origem'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(10, 5, "Tipo:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(35, 5, $row['tipoacao'], 'B,R,T', 1, 'L');

            quebraPagina($pdf->GetY(), $pdf);

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(9, 5, "Setor:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(57, 5, $row['descsetor'], 'B,R,T', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(12, 5, "Equipe:", 'B,L,T', 0, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(127, 5, $row['equipe'], 'B,R,T', 1, 'L');

            $pdf->Ln(1);

            quebraPagina($pdf->GetY(), $pdf);
            $nr2++;
        }

        if (($sVencido != 'true')) {

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(109, 5, "PLANO " . $row2['seq'], 'B,T,L,R', 0, 'C');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(16, 5, "Data Final:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 5, $row2['datafim'], 'B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(20, 5, "Data Prevista:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 5, $row2['dataprev'], 'B,T,R', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(10, 5, "Atraso:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            if ($row2['dt'] > 0) {
                $pdf->Cell(10, 5, "0", 'B,T,R', 1, 'L');
            } else {
                $pdf->Cell(10, 5, -$row2['dt'], 'B,T,R', 1, 'L');
            }
            quebraPagina($pdf->GetY(), $pdf);

            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(205, 5, $row2['plano'], 1, 1, 0);
            $iQntPlanos++;

            quebraPagina($pdf->GetY(), $pdf);
        }
        if (($sVencido == 'true') && ($row2['dt'] < 0)) {

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(109, 5, "PLANO " . $row2['seq'], 'B,T,L,R', 0, 'C');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(16, 5, "Data Final:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 5, $row2['datafim'], 'B,T,R', 0, 'L');
            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(20, 5, "Data Prevista:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(20, 5, $row2['dataprev'], 'B,T,R', 0, 'L');

            $pdf->SetFont('arial', 'B', 8);
            $pdf->Cell(10, 5, "Atraso:", 'B,T,L', 0, 'L');
            $pdf->SetFont('Arial', '', 8);
            if ($row2['dt'] > 0) {
                $pdf->Cell(10, 5, "0", 'B,T,R', 1, 'L');
            } else {
                $pdf->Cell(10, 5, -$row2['dt'], 'B,T,R', 1, 'L');
            }
            quebraPagina($pdf->GetY(), $pdf);

            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(205, 5, $row2['plano'], 1, 1, 0);

            quebraPagina($pdf->GetY(), $pdf);
            $iQntPlanos++;

            $pdf->Ln(1);
        }
        if ($row2['dt'] < 0) {
            $iQntVencido++;
        }
    }

    if ($row['sit'] == 'Aberta') {
        $iQntAqAbert++;
    }
    if ($row['sit'] == 'Iniciada') {
        $iQntAqIni++;
    }
    if ($row['sit'] == 'Finalizada') {
        $iQntAqFinal++;
    }
    if ($row['tipoacao'] == 'Ação Corretiva') {
        $iQntAqAcaoCorr++;
    }
    if ($row['tipoacao'] == 'Ação Preventiva') {
        $iQntAqAcaoPrev++;
    }
}

$pdf->Ln(1);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Total de Aqs:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAq, 0, 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Abertas:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAqAbert, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Iniciadas:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAqIni, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Finalizadas:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAqFinal, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Aqs com Ação Corretiva:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAqAcaoCorr, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Aqs com Ação Preventiva:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntAqAcaoPrev, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Total de Planos:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntPlanos, 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(50, 5, "Planos Vencidos:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 5, $iQntVencido, 0, 1, 'L');

//$pdf->AutoPrint();
$pdf->Output('I', 'relAcaoQualidade.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

function quebraPagina($i, $pdf) {

    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }

    return $pdf;
}

function limpaString($sString) {

    $sStringLimpa = str_replace("\n", " ", $sString);
    $sStringLimpa1 = str_replace("'", "\'", $sStringLimpa);
    $sStringLimpa2 = str_replace("\r", "", $sStringLimpa1);

    return $sStringLimpa2;
}
