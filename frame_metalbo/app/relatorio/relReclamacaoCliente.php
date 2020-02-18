<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$dataInicial = $_REQUEST['dataini'];
$dataFinal = $_REQUEST['datafim'];
$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSetor = $_REQUEST['tagsetor'];
$sSituaca = $_REQUEST['situaca'];
$sReclamacao = $_REQUEST['reclamacao'];
$sDevolucao = $_REQUEST['devolucao'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 15, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetAutoPageBreak(true, 2);

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);


$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(50);
// Title
$pdf->Cell(95, 10, 'Relatorio de Reclamações de Cliente', 0, 0, 'C');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 15, 'Per.: ' . $dataInicial .
        ' - ' . $dataFinal, 0, 'L');

$pdf->Ln(5);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "select * from tbrncqual"
        . " where datains BETWEEN '" . $dataInicial . "' and '" . $dataFinal . "' ";

if ($sSetor != '' || $sSituaca != '' || $sReclamacao != '' || $sDevolucao != '') {
    if (($sSetor !== '')) {
        $sql .= " and ";
        $sql .= " tagsetor =" . $sSetor . "";
    }
    if (($sSituaca !== '')) {
        $sql .= " and ";
        $sql .= " situaca ='" . $sSituaca . "'";
    }
    if (($sReclamacao !== '')) {
        $sql .= " and ";
        $sql .= " reclamacao ='" . $sReclamacao . "'";
    }
    if (($sDevolucao !== '')) {
        $sql .= " and ";
        $sql .= " devolucao ='" . $sDevolucao . "'";
    }
}
$sql .= " order by nr";

$sth = $PDO->query($sql);

//SELECT PARA CONTAR PROJETOS APROVADOS, REPROVADOS
$sqlCont = "SELECT DISTINCT tagsetor, situaca, reclamacao, devolucao,"
        . " COUNT(*) AS quantidade"
        . " from tbrncqual"
        . " where datains BETWEEN '" . $dataInicial . "' and '" . $dataFinal . "'";


if ($sSetor != '' || $sSituaca != '' || $sReclamacao != '' || $sDevolucao != '') {
    if (($sSetor !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " tagsetor =" . $sSetor . "";
    }
    if (($sSituaca !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " situaca ='" . $sSituaca . "'";
    }
    if (($sReclamacao !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " reclamacao ='" . $sReclamacao . "'";
    }
    if (($sDevolucao !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " devolucao ='" . $sDevolucao . "'";
    }
}
$sqlCont .= " group by tagsetor, situaca, reclamacao, devolucao";

$sCont = $PDO->query($sqlCont);

//Inicializa as variáveis de porjetos aprovados/reprovados
$qSetorVendas = 0;
$qSetorQualidade = 0;
$qSetorExpedicao = 0;
$qSetorEmbalagem = 0;

$qSitAguardando = 0;
$qSitLiberada = 0;
$qSitApontada = 0;
$qSitFinalizada = 0;

$qStatusAguradando = 0;
$qStatusEmAnalise = 0;
$qStatusInterna = 0;
$qStatusCliente = 0;
$qStatusRepresentante = 0;
$qStatusTransportadora = 0;

$qDevolucaoAguardando = 0;
$qDevolucaoAceita = 0;
$qDevolucaoRecusada = 0;

//Calcula projetos aprovados/reprovados por setor
while ($row = $sCont->fetch(PDO::FETCH_ASSOC)) {

    if ($row['tagsetor'] == "34") {
        $qSetorVendas = $qSetorVendas + (int) $row['quantidade'];
    }
    if (($row['tagsetor'] == "25")) {
        $qSetorQualidade = $qSetorQualidade + (int) $row['quantidade'];
    }
    if ($row['tagsetor'] == "3") {
        $qSetorExpedicao = $qSetorExpedicao + (int) $row['quantidade'];
    }

    if ($row['situaca'] == "Aguardando") {
        $qSitAguardando = $qSitAguardando + (int) $row['quantidade'];
    }
    if ($row['tagsetor'] == "Liberada") {
        $qSitLiberada = $qSitLiberada + (int) $row['quantidade'];
    }
    if (($row['situaca'] == "Apontada")) {
        $qSitApontada = $qSitApontada + (int) $row['quantidade'];
    }
    if ($row['situaca'] == "Finalizada") {
        $qSitFinalizada = $qSitFinalizada + (int) $row['quantidade'];
    }

    if ($row['reclamacao'] == "Aguardando") {
        $qStatusAguradando = $qStatusAguradando + (int) $row['quantidade'];
    }
    if ($row['reclamacao'] == "Em análise") {
        $qStatusEmAnalise = $qStatusEmAnalise + (int) $row['quantidade'];
    }
    if (($row['reclamacao'] == "Interna")) {
        $qStatusInterna = $qStatusInterna + (int) $row['quantidade'];
    }
    if ($row['reclamacao'] == "Cliente") {
        $qStatusCliente = $qStatusCliente + (int) $row['quantidade'];
    }
    if ($row['reclamacao'] == "Representante") {
        $qStatusRepresentante = $qStatusRepresentante + (int) $row['quantidade'];
    }
    if ($row['reclamacao'] == "Transportadora") {
        $qStatusTransportadora = $qStatusTransportadora + (int) $row['quantidade'];
    }

    if ($row['devolucao'] == "Aguardando") {
        $qDevolucaoAguardando = $qDevolucaoAguardando + (int) $row['quantidade'];
    }
    if ($row['devolucao'] == "Aceita") {
        $qDevolucaoAceita = $qDevolucaoAceita + (int) $row['quantidade'];
    }
    if ($row['devolucao'] == "Recusada") {
        $qDevolucaoRecusada = $qDevolucaoRecusada + (int) $row['quantidade'];
    }
}

$iContaAltura = $pdf->GetY();

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    if ($iContaAltura >= 270) {    // 275 tamanho máximo da página
        $pdf->AddPage();   // nova pagina 
        $iContaAltura = 10;

        $pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
        //seta as margens
        $pdf->SetMargins(2, 10, 2);

        $pdf->SetFont('Arial', 'B', 16);

        //cabeçalho
        $pdf->SetMargins(3, 0, 3);
        // Move to the right
        $pdf->Cell(50);
        // Title
        $pdf->Cell(95, 10, 'Relatorio de Novos Projetos', 0, 0, 'C');

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
        $pdf->SetXY($x, $y + 5);
        $pdf->MultiCell(50, 5, 'Data: ' . $sData .
                '  Hora: ' . $sHora, 0, 'L');
        $pdf->SetXY($x, $y + 5);
        $pdf->MultiCell(50, 15, 'Per.: ' . $dataInicial .
                ' - ' . $dataFinal, 0, 'L');

        $pdf->Ln(5);

        //define a altura inicial dos dados
        $pdf->SetFont('arial', '', 8);
        $pdf->SetY(45);
    }

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(6, 5, 'Nr:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(25, 5, $row['nr'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(15, 5, 'Situação:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['situaca'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(12, 5, 'Status:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['reclamacao'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(18, 5, 'Devolução:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['devolucao'], 0, 1);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(11, 5, 'Nr. NF:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(20, 5, $row['nf'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(24, 5, 'Representante:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(38, 5, $row['usunome'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Escritório:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['officedes'], 0, 1);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(10, 5, 'CNPJ:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(28, 5, $row['empcod'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(12, 5, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['empdes'], 0, 1);



    $aProdutos = explode(';', $row['produtos']);
    foreach ($aProdutos as $key => $value) {
        $aProduto = explode('-', $value);

        $pdf->SetFont('arial', 'B', 9);
        $pdf->Cell(24, 5, 'Produto:', 0, 0, 'L');
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(31, 5, 'Código: ' . $aProduto[0] . ' - ' . $aProduto[1], 0, 1);
        $pdf->Cell(31, 5, 'Quantidade: ' . $aProduto[2] . '                  Quantidade não conforme: ' . $aProduto[3], 0, 1);
    }

    $pdf->Ln(2);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Aplicação:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['aplicacao'], 0, 1);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Descrição:', 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(208, 5, $row['naoconf'], 0, 'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Análise:', 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(208, 5, $row['apontamento'], 0, 'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Ação:', 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(208, 5, $row['obs_aponta'], 0, 'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Resolução:', 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(208, 5, $row['obs_fim'], 0, 'L');

    $pdf->Cell(0, 5, "", "B", 1, 'C');

    $pdf->Ln(2);
    $iContaAltura = $pdf->GetY() + 10;
}



//Conta o total de porcas e parafusos dentro do período de datas selecionado
//Imprime relatório projetos aprovados/reprovados por setor

$pdf->SetFont('arial', 'B', 14);
$pdf->Cell(200, 5, 'Totais', 0, 1, 'C');

$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(200, 5, 'Setor responsável pela Análise:', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(31, 5, 'Análisado - Vendas:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $qSetorVendas, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(35, 5, 'Análisado - Qualidade:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $qSetorQualidade, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(36, 5, 'Análisado - Expedição:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $qSetorExpedicao, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(38, 5, 'Análisado - Embalagem:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(19, 5, $qSetorEmbalagem, 0, 1);

$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(200, 5, 'Situações:', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(36, 5, 'Aguardando Liberação:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(14, 5, $qSitAguardando, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(33, 5, 'Aguardando Análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(21, 5, $qSitLiberada, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(29, 5, 'Análise Apontada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(26, 5, $qSitApontada, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(17, 5, 'Finalizada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(16, 5, $qSitFinalizada, 0, 1);


$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(200, 5, 'Status:', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(33, 5, 'Aguardando Análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(17, 5, $qStatusAguradando, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(19, 5, 'Em Análise:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(25, 5, $qStatusEmAnalise, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(13, 5, 'Interna:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(22, 5, $qStatusInterna, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(13, 5, 'Cliente:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(21, 5, $qStatusCliente, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(24, 5, 'Representante:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $qStatusRepresentante, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(15, 5, 'Transportador:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $qStatusTransportadora, 0, 1);

$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(200, 5, 'Devoluções:', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(39, 5, 'Devolução - Aguardando:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(11, 5, $qDevolucaoAguardando, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(30, 5, 'Devolução - Aceita:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(20, 5, $qDevolucaoAceita, 0, 0);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(36, 5, 'Devolução - Recusada:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->Cell(31, 5, $qDevolucaoRecusada, 0, 1);


$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);



//number_format($quant, 2, ', ', '.')
$pdf->Output('I', 'relReclamacaoCliente.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
