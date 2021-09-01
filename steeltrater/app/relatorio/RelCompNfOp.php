<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(5, 5); // DEFINE O X E O Y NA PAGINA
//Caminho da logo
$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);

//Caminho do usuário, data e hora
date_default_timezone_set('America/Sao_Paulo');
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];
//$op = $_REQUEST['op'];
$nfEnt = $_REQUEST['nfEnt'];
$serie = $_REQUEST['serie'];
$empcod = $_REQUEST['empcod'];

//Inserção do cabeçalho
$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 13);
$pdf->Cell(110, 10, 'Conferência da nota de entrada ' . $nfEnt, '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora: ' . $hora
        . ' Usuário: ' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', 'T', 1, 'L');
if ($nfEnt !== '' && $serie !== '' && $empcod !== '') {
//Inicio
//busca os dados do banco
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSqli = "select op,emp_codigo,emp_razaosocial,documento,serie_nf,quant,peso,vlrNfEnt,
        convert(varchar,data,103) as data, convert(varchar,hora,8) as hora 
        from STEEL_PCP_ordensFab  
        where documento ='" . $nfEnt . "' 
        and serie_nf = " . $serie . " 
        and emp_codigo ='" . $empcod . "' 
        and situacao <>'Cancelada'
        and retrabalho ='Não'
        order by seqitem_nf";


    $dadosRela = $PDO->query($sSqli);
    $pdf->Ln(5);
    $iK = 1;
    $iSomaQuant = 0;
    $iSomaPeso = 0;
    $iSomaValor = 0;

    while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {

        if ($iK == 1) {
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->Cell(120, 5, 'Empresa: ' . $row['emp_razaosocial'], '', 1, 'L', 0);
            $pdf->Ln(5);
            $pdf->Cell(27, 5, 'OP', 1, 0, 'C', 0);
            $pdf->Cell(26, 5, 'Nota', 1, 0, 'C', 0);
            $pdf->Cell(17, 5, 'Série', 1, 0, 'C', 0);
            $pdf->Cell(27, 5, 'Quantidade', 1, 0, 'C', 0);
            $pdf->Cell(28, 5, 'Peso Líquido', 1, 0, 'C', 0);
            $pdf->Cell(30, 5, 'Valor Produto', 1, 0, 'C', 0);
            $pdf->Cell(21, 5, 'Data', 1, 0, 'C', 0);
            $pdf->Cell(21, 5, 'Hora', 1, 1, 'C', 0);
            $iK++;
        }
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(27, 5, $row['op'], 1, 0, 'L', 0);
        $pdf->Cell(26, 5, $row['documento'], 1, 0, 'L', 0);
        $pdf->Cell(17, 5, $row['serie_nf'], 1, 0, 'L', 0);
        $pdf->Cell(27, 5, number_format($row['quant'], 4, ',', '.'), 1, 0, 'R', 0);
        $pdf->Cell(28, 5, number_format($row['peso'], 4, ',', '.'), 1, 0, 'R', 0);
        $pdf->Cell(30, 5, number_format($row['vlrNfEnt'], 4, ',', '.'), 1, 0, 'R', 0);
        $pdf->Cell(21, 5, $row['data'], 1, 0, 'C', 0);
        $pdf->Cell(21, 5, $row['hora'], 1, 1, 'C', 0);
        $iSomaQuant = $row['quant'] + $iSomaQuant;
        $iSomaPeso = $row['peso'] + $iSomaPeso;
        $iSomaValor = $row['vlrNfEnt'] + $iSomaValor;
    }
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(70, 6, 'Totais ', 1, 0, 'L', 0);
    $pdf->Cell(27, 6, number_format($iSomaQuant, 4, ',', '.'), 1, 0, 'R', 0);
    $pdf->Cell(28, 6, number_format($iSomaPeso, 4, ',', '.'), 1, 0, 'R', 0);
    $pdf->Cell(30, 6, number_format($iSomaValor, 4, ',', '.'), 1, 0, 'R', 0);
    $pdf->Cell(21, 6, '', 1, 0, 'R', 0);
    $pdf->Cell(21, 6, '', 1, 1, 'R', 0);

    $pdf->Ln(3);
    $pdf->Cell(50, 6, 'Total Quantidade:', 0, 0, 'L', 0);
    $pdf->Cell(20, 6, number_format($iSomaQuant, 2, ',', '.'), 0, 1, 'R', 0);
    $pdf->Cell(50, 6, 'Total Peso Líquido:', 0, 0, 'L', 0);
    $pdf->Cell(20, 6, number_format($iSomaPeso, 2, ',', '.'), 0, 1, 'R', 0);
    $pdf->Cell(50, 6, 'Total Valor Produtos:', 0, 0, 'L', 0);
    $pdf->Cell(20, 6, number_format($iSomaValor, 2, ',', '.'), 0, 1, 'R', 0);
} else {
    $pdf->SetFont('Arial', 'B', 12);
    if ($nfEnt == '') {
        $pdf->Cell(50, 6, 'Número da Nota de entrada não encontrado!', 0, 1, 'L', 0);
    }
    if ($serie == '') {
        $pdf->Cell(50, 6, 'Número da série não encontrado!', 0, 1, 'L', 0);
    }
    if ($empcod == '') {
        $pdf->Cell(50, 6, 'Número da empresa não encontrado! ', 0, 1, 'L', 0);
    }
}
//Fim  

$pdf->Output('I', 'RelFaturamento.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 