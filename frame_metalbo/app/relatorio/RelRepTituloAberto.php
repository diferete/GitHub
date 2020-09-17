<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
if ($_REQUEST['empcod'] !== '') {
    $empcod = $_REQUEST['empcod'];
    $empdes = $_REQUEST['empdes'];
} else {
    $empcod = 'Todos';
    $empdes = 'Todos';
}

$dataIni = $_REQUEST['dataini'];
$dataFim = $_REQUEST['datafim'];

if (isset($_REQUEST['rep'])) {
    $rep = $_REQUEST['rep'];
}

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(195, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

$pdf = new PDF('L', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(3, 0, 3);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 9, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(180, 15, 'TÍTULOS A RECEBER EM ABERTO', 0, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(8);

//Filtros
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "FILTROS - ", 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(11, 5, "CNPJ: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(27, 5, $empcod, 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(13, 5, "Cliente:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(132, 5, $empdes, 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(21, 5, 'Data Inicial: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(25, 5, $dataIni, 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(19, 5, 'Data Final: ', 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(25, 5, $dataFim, 0, 1, 'L');

$pdf->Cell(289, 6, '', 'T', 1, 'C');

$pdf->SetFont('arial', '', 8);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select replace(rTrim(replace(bcoagencia+bcoconta,' ','')),'-','') + CONVERT(varchar(20),recprcarco) + CONVERT(varchar(20),recprnrobc) AS NossoNumero,"
        . "recprnrobc, bcodes,"
        . "replace(rTrim(replace(bcoagencia+''+bcoconta,' ','')),'-','')as agConta,"
        . "recprcarco,recparnro,recprbconr,convert(varchar,recdtemiss,103) as recdtemiss,widl.REC001.empcod,empdes,widl.REC001.recdocto,"
        . "convert(varchar,recprdtpro,103) as recprdtpro,MONTH(recprdtpro) as mes, recprdtpgt,"
        . "recprvlr,recprvlpgt,recprindtr,recprtirec,"
        . "DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) as dias,"
        . "recof from widl.REC001(nolock) "
        . "left outer join widl.REC0012(nolock) "
        . "on widl.REC001.recdocto = widl.REC0012.recdocto "
        . "left outer join widl.EMP01(nolock) "
        . "on widl.REC001.empcod = widl.EMP01.empcod "
        . "left outer join WIDL.BANCOS "
        . "on WIDL.BANCOS.bconro = widl.REC0012.recprbconr "
        . "where recprdtpgt = '1753-01-01' "
        . "and widl.REC001.recdocto NOT LIKE 'T%' "
        . "and widl.REC001.recdocto NOT LIKE 'D%' "
        . "and widl.REC001.filcgc = '75483040000211' "
        . "and tpdcod = 1 ";
if ($rep !== '') {
    $sSql = $sSql . "and repcod in(" . $rep . ") ";
}
if ($empcod !== 'Todos') {
    $sSql = $sSql . "and widl.REC001.empcod = " . $empcod . "";
}if ($dataIni !== '' && $dataFim !== '') {
    $sSql = $sSql . "and recprdtpro between '" . $dataIni . "' and '" . $dataFim . "'";
}
$sSql = $sSql . "group by "
        . "repcod,widl.REC001.empcod,recdtemiss,empdes,widl.REC001.recdocto,recprdtpro,recprdtpgt,recprvlr,recprvlpgt,recprindtr,recprtirec,"
        . "recof,recparnro, recprcarco,recprnrobc,recprbconr,recparnro,bcodes,bcoagencia,bcoconta "
        . "order by mes asc";


$Dados = $PDO->query($sSql);
$iSomaCliente = 0;
$iTotal = 0;
$iEmp = 0;
while ($row = $Dados->fetch(PDO::FETCH_ASSOC)) {

    if (isset($_REQUEST['atrasados'])) {
        $pdf->SetTextColor(0, 0, 0);
        if ($row['dias'] < 0) {
            if ($iEmp !== $row['empcod']) {
                if ($iEmp != 0) {
                    $pdf->SetFont('arial', 'B', 9);
                    $pdf->Cell(25, 5, "Soma Cliente: ", 0, 0, 'L');
                    $pdf->SetFont('Arial', '', 10);
                    $pdf->Cell(120, 5, 'R$ '. number_format($iSomaCliente, 2, ',', '.'), 0, 1, 'L');
                    $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
                }
                $pdf->Ln(5);
                //Cabeçalhos
                $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(13, 5, "Cliente: ", 0, 0, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(145, 5, $row['empdes'], 0, 0, 'L');

                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(28, 5, 'CNPJ - Cliente: ', 0, 0, 'L');
                $pdf->SetFont('arial', '', 10);
                $pdf->Cell(50, 5, $row['empcod'], 0, 0, 'L');

                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(30, 5, 'CNPJ - Metalbo: ', 0, 0, 'L');
                $pdf->SetFont('arial', '', 9);
                $pdf->Cell(25, 5, '75483040000130', 0, 1, 'L');

                $pdf->Cell(289, 1, '', 'T', 1, 'C');

                $pdf->SetFont('arial', '', 8);
                $pdf->Cell(18, 5, "Docto", 0, 0, 'L');
                $pdf->Cell(20, 5, "Emissão", 0, 0, 'L');
                $pdf->Cell(20, 5, "Vencimento", 0, 0, 'L');
                $pdf->Cell(15, 5, "Pedido", 0, 0, 'L');
                $pdf->Cell(27, 5, "Vlr.Receber", 0, 0, 'L');
                $pdf->Cell(26, 5, "Dias para pagar", 0, 0, 'L');
                $pdf->Cell(66, 5, "Ag.-Beneficiario-Carteira-Nosso Número", 0, 0, 'L');
                $pdf->Cell(15, 5, "Parcela", 0, 0, 'L');
                $pdf->Cell(35, 5, "Banco", 0, 0, 'L');
                $pdf->Cell(22, 5, "Nosso Numero", 0, 1, 'R');
                $iEmp = $row['empcod'];
                $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
                $iSomaCliente = 0;
            }

            if ($row['dias'] < 0) {
                $pdf->SetTextColor(255, 0, 0);
            }
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(18, 5, $row['recdocto'], 0, 0, 'L');
            $pdf->SetFont('arial', '', 9);
            $pdf->Cell(20, 5, $row['recdtemiss'], 0, 0, 'L');
            $pdf->Cell(20, 5, $row['recprdtpro'], 0, 0, 'L');
            $pdf->Cell(15, 5, $row['recof'], 0, 0, 'L');
            $pdf->Cell(27, 5, 'R$ '. number_format($row['recprvlr'], 2, ',', '.'), 0, 0, 'L');
            $pdf->Cell(26, 5, $row['dias'], 0, 0, 'L');
            $pdf->Cell(55, 5, str_replace(' ', '', $row['NossoNumero']), 0, 0, 'L');
            $pdf->Cell(15, 5, $row['recparnro'], 0, 0, 'R');
            $pdf->Cell(49, 5, $row['bcodes'], 0, 0, 'R');
            $pdf->Cell(30, 5, $row['recprnrobc'], 0, 1, 'R');
            $pdf->Cell(289, 1, '', 'T', 1, 'C');
            $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
            $iSomaCliente = $iSomaCliente + $row['recprvlr'];
            $iTotal = $iTotal + $row['recprvlr'];
        }
    } else {
        $pdf->SetTextColor(0, 0, 0);
        if ($iEmp !== $row['empcod']) {
            if ($iEmp != 0) {
                $pdf->SetFont('arial', 'B', 9);
                $pdf->Cell(25, 5, "Soma Cliente: ", 0, 0, 'L');
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(120, 5, number_format($iSomaCliente, 2, ',', '.'), 0, 1, 'L');
                $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
            }
            $pdf->Ln(5);
            //Cabeçalhos
            $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(13, 5, "Cliente: ", 0, 0, 'L');
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(151, 5, $row['empdes'], 0, 0, 'L');

            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(24, 5, 'CNPJ - Cliente: ', 0, 0, 'L');
            $pdf->SetFont('arial', '', 10);
            $pdf->Cell(50, 5, $row['empcod'], 0, 0, 'L');

            $pdf->SetFont('arial', 'B', 9);
            $pdf->Cell(25, 5, 'CNPJ - Metalbo: ', 0, 0, 'L');
            $pdf->SetFont('arial', '', 9);
            $pdf->Cell(25, 5, '75483040000130', 0, 1, 'L');

            $pdf->Cell(289, 1, '', 'T', 1, 'C');

            $pdf->SetFont('arial', '', 8);
            $pdf->Cell(18, 5, "Docto", 0, 0, 'L');
            $pdf->Cell(20, 5, "Emissão", 0, 0, 'L');
            $pdf->Cell(20, 5, "Vencimento", 0, 0, 'L');
            $pdf->Cell(15, 5, "Pedido", 0, 0, 'L');
            $pdf->Cell(27, 5, "Vlr.Receber", 0, 0, 'L');
            $pdf->Cell(26, 5, "Dias para pagar", 0, 0, 'L');
            $pdf->Cell(66, 5, "Ag.-Beneficiario-Carteira-Nosso Número", 0, 0, 'L');
            $pdf->Cell(15, 5, "Parcela", 0, 0, 'L');
            $pdf->Cell(35, 5, "Banco", 0, 0, 'L');
            $pdf->Cell(22, 5, "Nosso Numero", 0, 1, 'R');
            $iEmp = $row['empcod'];
            $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
            $iSomaCliente = 0;
        }

        if ($row['dias'] < 0) {
            $pdf->SetTextColor(255, 0, 0);
        }
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(18, 5, $row['recdocto'], 0, 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(20, 5, $row['recdtemiss'], 0, 0, 'L');
        $pdf->Cell(20, 5, $row['recprdtpro'], 0, 0, 'L');
        $pdf->Cell(15, 5, $row['recof'], 0, 0, 'L');
        $pdf->Cell(27, 5, 'R$ '. number_format($row['recprvlr'], 2, ',', '.'), 0, 0, 'L');
        $pdf->Cell(26, 5, $row['dias'], 0, 0, 'L');
        $pdf->Cell(55, 5, str_replace(' ', '', $row['NossoNumero']), 0, 0, 'L');
        $pdf->Cell(15, 5, $row['recparnro'], 0, 0, 'R');
        $pdf->Cell(49, 5, $row['bcodes'], 0, 0, 'R');
        $pdf->Cell(30, 5, $row['recprnrobc'], 0, 1, 'R');
        $pdf->Cell(289, 1, '', 'T', 1, 'C');
        $pdf = quebraPagina($pdf->GetY() + 10, $pdf);
        $iSomaCliente = $iSomaCliente + $row['recprvlr'];
        $iTotal = $iTotal + $row['recprvlr'];
    }
}

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(25, 5, "Soma Cliente: ", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(120, 5, 'R$ ' . number_format($iSomaCliente, 2, ',', '.'), 0, 1, 'L');

$pdf->Ln(5);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(65, 5, "TOTAL DOS TÍTULOS EM ABERTO: ", 0, 0, 'L');
$pdf->Cell(120, 5, number_format($iTotal, 2, ',', '.'), 0, 1, 'L');

$pdf->Output('I', 'titulosEmAberto.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  

/**
 * Função que quebra página em uma dada altura do PDF
 * @param type $i
 * @param type $pdf
 * @return type
 */
function quebraPagina($i, $pdf) {
    if ($i >= 187) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
