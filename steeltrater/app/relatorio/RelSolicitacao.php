<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

//Pega os dados do Request
date_default_timezone_set('America/Sao_Paulo');
$iSeq = $_REQUEST['SUP_SolicitacaoSeq'];
$iCod = $_REQUEST['FIL_Codigo'];
$data = date("d/m/y");                     //função para pegar a data local
$hora = date("H:i");                       //para pegar a hora com a função date
$useRel = $_REQUEST['userRel'];

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

$sLogo = '../../biblioteca/assets/images/steelrel.png';
$pdf->SetMargins(5, 5, 5);
$icont = 0;
$iQnt = 0;

    //busca os dados do banco pegando a op do foreach
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "SELECT FIL_Codigo,SUP_SolicitacaoSeq, convert(varchar,SUP_SolicitacaoDataHora,103) as SUP_SolicitacaoDataHora,SUP_SolicitacaoObservacao,"
            . " SUP_SolicitacaoUsuCadastro,SUP_SolicitacaoObsEntrega, SUP_SolicitacaoTipo,"
            . " SUP_SolicitacaoSituacao, SUP_SolicitacaoFaseApr, SUP_SolicitacaoMRP, SUP_SolicitacaoUsuAprovador,"
            . " SUP_SolicitacaoCCTCod, SUP_SolicitacaoDataCanc, SUP_SolicitacaoUsuCanc "
            . "   FROM SUP_SOLICITACAO WHERE FIL_Codigo = " . $iCod . " AND SUP_SolicitacaoSeq = " . $iSeq . " ";
    $dadosOp = $PDO->query($sSql);
    $row = $dadosOp->fetch(PDO::FETCH_ASSOC);

//inicia os dados da op
$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 33.78), 1, 0, 'L');

$pdf->SetFont('Arial', '', 15);

$pdf->Cell(110, 10, '                  SOLICITAÇÃO DE COMPRAS ', 1, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(53, 5, 'Usuário: ' . $useRel, 'T,R', 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(53, 5, 'Data: ' . $data .
        '  Hora: ' . $hora, 'B, R', 'L');
$pdf->SetFillColor(180, 180, 180);
$pdf->Cell(52, 5, 'Solicitação: ' . $iSeq, 'L,B', 0, 'L', true);
$pdf->Cell(148, 5, 'Data: ' . $row['SUP_SolicitacaoDataHora'], 'B,R', 1, 'L', true);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(200, 6, 'Observações: '. $row['SUP_SolicitacaoObservacao'], 1, 'L');
$pdf->MultiCell(200, 6, 'Observações Entrega: '. $row['SUP_SolicitacaoObsEntrega'], 1, 'L');

$pdf->Ln(2);

//Cabeçalhos Itens
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(83, 5, 'Produto', 'L,B,T', 0, 'L');
$pdf->Cell(8, 5, 'Und.', 'L,B,T', 0, 'L');
$pdf->Cell(36, 5, 'Solicitante', 'L,B,T', 0, 'L');
$pdf->Cell(36, 5, 'Comprador', 'L,B,T', 0, 'L');
$pdf->Cell(25, 5, 'Data Necessidade', 'L,B,T', 0, 'L');
$pdf->Cell(12, 5, 'Qnt.', 'L,B,T,R', 1, 'L');

$sSqlItens = "SELECT SUP_SolicitacaoItemUnidade, PRO_Codigo, SUP_SolicitacaoItemDescricao, "
        . " SUP_SolicitacaoItemUsuSol, SUP_SolicitacaoItemUsuCom, "
        . " convert(varchar,SUP_SolicitacaoItemDataNecessi,103) as SUP_SolicitacaoItemDataNecessi, SUP_SolicitacaoItemObservacao, SUP_SolicitacaoItemComQtd "
            . " FROM SUP_SOLICITACAOITEM WHERE FIL_Codigo = " . $iCod . " AND SUP_SolicitacaoSeq = " . $iSeq . " ";
    $dadosItens = $PDO->query($sSqlItens);

while ($rowIten = $dadosItens->fetch(PDO::FETCH_ASSOC)) {

$pdf->Cell(83, 5, trim($rowIten['PRO_Codigo']).' - '.$rowIten['SUP_SolicitacaoItemDescricao'], 0, 'L');
$pdf->Cell(8, 5,  $rowIten['SUP_SolicitacaoItemUnidade'], 0, 'L');
$pdf->Cell(36, 5, $rowIten['SUP_SolicitacaoItemUsuSol'], 0, 'L');
$pdf->Cell(36, 5, $rowIten['SUP_SolicitacaoItemUsuCom'], 0, 'L');
$pdf->Cell(25, 5, $rowIten['SUP_SolicitacaoItemDataNecessi'], 0, 'L');
$pdf->Cell(12, 5, number_format($rowIten['SUP_SolicitacaoItemComQtd'], 2), 0, 1, 'L');
$pdf->MultiCell(200, 5, 'Observação: '.$rowIten['SUP_SolicitacaoItemObservacao'], 0, 'L');

$pdf->Cell(200, 5, '', 'B', 1, 'L');
$pdf->Ln(2);
}


$pdf->Output('I', 'RelSolicitacao.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
