<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$data1 = $_REQUEST['dataini'];
$data2 = $_REQUEST['datafim'];
$sUserRel = $_REQUEST['userRel'];
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


$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(95, 10, 'Relatório de Ranking dos Clientes', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: ' . $sData .
        '  Hora: ' . $sHora, 0, 'L');

$pdf->Ln(5);
$pdf->Cell(199, 5, 'Solicitações de clientes entre as datas de '.$data1.' até '.$data2, 0, 1, 'L');
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "SELECT DISTINCT tbqualNovoProjeto.empcod, empdes 
        ,COUNT(*) AS quantidade
        FROM tbqualNovoProjeto left join widl.EMP01 
        on widl.EMP01.empcod = tbqualNovoProjeto.empcod
        where dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "'
        GROUP BY tbqualNovoProjeto.empcod, empdes
        ORDER BY quantidade DESC";

$sth = $PDO->query($sql);

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(55, 5, 'CLIENTE', 'R', 0, 'L');
$pdf->Cell(115, 5, 'DESCRIÇÃO', 'R', 0, 'L');
$pdf->Cell(10, 5, 'Nº SOLICITAÇÕES', 0, 1, 'L');
$pdf->Cell(199, 0, '', "B", 1, 'L');

$iQntSolicitacoes = 0;
$iCont = 0;
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    $pdf->Cell(199, 1, '', 0, 1, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(55, 5, $row['empcod'], 'B, R', 0, 'L');
    $pdf->Cell(115, 5, $row['empdes'], 'B,R', 0, 'L');
    $pdf->Cell(29, 5, $row['quantidade'], 'B', 1, 'L');
    
    if ($pdf->GetY() >= 270) {    // 275 é o tamanho da página
    $pdf->AddPage();   // adiciona se ultrapassar o limite da página
    $pdf->SetY(10);
    }
    
    $iCont++;
    $iQntSolicitacoes = $iQntSolicitacoes + $row['quantidade'];
    
}

$pdf->Cell(199, 2, '', 0, 1, 'L');
$pdf->SetFont('arial', 'B', 12);
$pdf->Cell(199, 5, 'Quantidade de clientes: '.$iCont.'     Total solicitações: '.$iQntSolicitacoes, 0, 0, 'R');



$pdf->Output('I', 'relNovoProjetoRanking.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
