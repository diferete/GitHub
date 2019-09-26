<?php

$sDados = $_REQUEST['dados'];
$aDados = explode(',', $sDados);

$sEmail = $_REQUEST['email'];
$aDadosUF = explode(',', $_REQUEST['dadosUF']);

require 'biblioteca/fpdf/fpdf.php';
include '../includes/Config.php';
include '../includes/Fabrica.php';
include '../biblioteca/Utilidades/Email.php';

function Footer() { // Cria rodapé
    $this->SetXY(15, 278);
    $this->Ln(); //quebra de linha
    $this->SetFont('Arial', '', 7); // seta fonte no rodape
    $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

    $this->Image('biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('biblioteca/assets/images/logo.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Itens do carrinho', 0, 0, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(45, 4, 'Data:' . date('d/m/Y') . '                Hora: ' . date('H:i:s') . '', 0, 'J');

$pdf->Ln(10);

$x = $pdf->GetX();
$y = $pdf->GetY();


$oCart = Fabrica::FabricarController('MET_TEC_Catalogo');
$aItens = $oCart->buscaPDF($aDados);

$aSomaValorTotal = array();

foreach ($aItens as $key => $aValue) {

    $valor = $aValue['quant'];
    $sValorTot = number_format($aValue['quant'] * $aValue['precoItem'], 2, ',', '.');
    if ($sValorTot == 0) {
        array_push($aSomaValorTotal, '0.00');
    } else {
        $sValorTot = Util::ValorSql($sValorTot);
        array_push($aSomaValorTotal, $sValorTot);
    }

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(14, 5, "Código: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, $aValue['procod'], 0, 0, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(19, 5, "Descrição: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, $aValue['prodes'], 0, 1, 'L');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Quant. Cento: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, $aValue['quant'], 0, 0, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Quant. Peças: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, $aValue['quant'] * 100, 0, 0, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(27, 5, "Valor do cento: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(18, 5, 'R$ ' . $aValue['preco'], 0, 1, 'L');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Total do item: ", 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(25, 5, 'R$ ' . number_format($sValorTot, 2, ',', '.'), 0, 1, 'L');
    $pdf->Ln(5);
}

$totalPedido = '';
$cont = 0;
foreach ($aSomaValorTotal as $key => $value) {
    $totalPedido = $aSomaValorTotal[$cont] + $totalPedido;
    $cont++;
}


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, "Total do pedido:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(18, 5, 'R$ ' . number_format($totalPedido, 2, ',', '.'), 0, 1, 'L');
$pdf->Ln(5);

if ($sEmail != '') {
    $nr = rand();
    $pdf->Output('F', 'catalogo/PDF/Itens-carrinho-metalbo' . $nr . '.pdf');  // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $nr = rand();
    $pdf->Output('I', 'catalogo/PDF/Itens-carrinho-metalbo' . $nr . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}

if ($sEmail != '') {

    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    $oEmail->setServidor('smtp.terra.com.br');
    $oEmail->setPorta(587);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario('metalboweb@metalbo.com.br');
    $oEmail->setSenha('Metalbo@@50');
    $oEmail->setRemetente(utf8_decode('metalboweb@metalbo.com.br'), utf8_decode('Relatórios Web Metalbo'));

    $oEmail->setAssunto(utf8_decode('Cotação do Catálogo Metalbo'));
    $oEmail->setMensagem(utf8_decode('Em anexo PDF com os itens.<hr><br/>'
                    . '<b>E-mail: ' . $sEmail . '<br/>'
                    . '<b>Estado: ' . $aDadosUF[0] . '<br/>'
                    . '<b>Cidade: ' . $aDadosUF[1] . '<br/>'
                    . '<br/><br/><br/><b>Obrigado pelo contato. E-mail enviado automaticamente, favor não responder!</b>'));
    $oEmail->limpaDestinatariosAll();

    // Para
    $oEmail->addDestinatario('alexandre@metalbo.com.br');
    $oEmail->addDestinatarioCopia($sEmail);


    $oEmail->addAnexo('catalogo/PDF/Itens-carrinho-metalbo' . $nr . '.pdf', utf8_decode('catalogo/PDF/Itens-carrinho-metalbo' . $nr . '.pdf'));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $sMensagem = 'success';
    } else {
        $sMensagem = 'error';
    }
    $sMensagem;
}
return $sMensagem;
