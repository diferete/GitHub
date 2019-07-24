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

$pdf->Image('biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);

$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(45);
// Title
$pdf->Cell(100, 10, 'Itens do carrinho', 0, 0, 'L');

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
$pdf->SetXY($x, $y + 5);
$pdf->MultiCell(50, 5, 'Data: HOJE
          Hora: AGORA', 0, 'L');

$oCart = Fabrica::FabricarController('MET_TEC_Catalogo');
$aItens = $oCart->buscaPDF($aDados);

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

    $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $nrAq . ' da empresa ' . $filcgcAq));
    $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $nrAq . ' da empresa ' . $filcgcAq . ' da qual você está envolvido. '
                    . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
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
