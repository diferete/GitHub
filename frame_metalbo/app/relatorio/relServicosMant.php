<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
include("../../includes/Config.php");

date_default_timezone_set('America/Sao_Paulo');

$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');

$sResp = $_REQUEST['resp'];
$sTipCod = $_REQUEST['tipcod'];
$sSetor = $_REQUEST['MET_Maquinas_codsetor'];
$sSit = $_REQUEST['sit'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('L', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->SetTextColor(0, 50, 0);
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Serviços para as Máquinas', 0, 0, 'L');

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

$sql = " SELECT descsetor, tbservmp.codsit, tbservmp.servico, tbservmp.ciclo, tbservmp.resp, tbservmp.codsetor, tbservmp.tipcod FROM tbservmp "
        . "left outer join 
           MetCad_Setores on MetCad_Setores.codsetor = tbservmp.codsetor ";
    if ($sSit != '') {
        $sql .= " where tbservmp.sit = '" . $sSit . "' ";
    }
    if (isset($sResp) && $sResp != '') {
        $sql .= " and tbservmp.resp = '" . $sResp . "'";
    }
    if (isset($sTipCod) && $sTipCod != '') {
        $sql .= " and tbservmp.tipcod = '" . $sTipCod . "'";
    }
    if (isset($sSetor) && $sSetor != '') {
        $sql .= " and tbservmp.codsetor = '" . $sSetor . "'";
    }

    $sth = $PDO->query($sql);
    
    //Cabeçalho
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(15, 5, 'COD', "B,R", 0, 'C');
    $pdf->Cell(158, 5, 'SERVIÇO', "B,L,R", 0, 'C');
    $pdf->Cell(15, 5, 'CICLO', "B,L,R", 0, 'C');
    $pdf->Cell(25, 5, 'RESP', "B,L,R", 0, 'C');
    $pdf->Cell(78, 5, 'SETOR', "B,L", 1, 'C');

    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, $row['codsit'], "B", 0, 'L');
        $pdf->Cell(158, 5, $row['servico'], "B,L,R", 0, 'L');
        $pdf->Cell(15, 5, $row['ciclo'], "B,L,R", 0, 'L');
        $pdf->Cell(25, 5, $row['resp'], "B,L,R", 0, 'L');
        $pdf->Cell(78, 5, $row['codsetor'].' - '.$row['descsetor'], "B", 1, 'L');
        $i = $pdf->GetY();
        if ($i+10 >= 190) {    // 275 é o tamanho da página
            $pdf->AddPage();   // adiciona se ultrapassar o limite da página
            $pdf->SetY(10);
        }
    }

$pdf->Output('I', 'relServicosMant.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

