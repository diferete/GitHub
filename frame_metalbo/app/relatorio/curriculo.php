<?php

$oDados = $_REQUEST['campos'];
$aDados = explode(',', $sDados);

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$hora = date('H:i:s');

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
$pdf->Cell(100, 10, 'Currículo', 0, 0, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(45, 4, 'Data: ' . $data . '                Hora: ' . $hora . '', 0, 'J');

$pdf->Ln(10);

$x = $pdf->GetX();
$y = $pdf->GetY();


$pdf->Output('F', 'app/relatorio/curriculos/curriculo' . $oDados->cpf . '.pdf');  // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE

$oEmail = new Email();
$oEmail->setMailer();
$oEmail->setEnvioSMTP();
$oEmail->setServidor(Config::SERVER_SMTP);
$oEmail->setPorta(Config::PORT_SMTP);
$oEmail->setAutentica(true);
$oEmail->setUsuario(Config::EMAIL_SENDER);
$oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
$oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
$oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Currículo WEB'));

$oEmail->setAssunto(utf8_decode('Currículo WEB'));
$oEmail->setMensagem(utf8_decode('Em anexo PDF de currículo preenchido no site da Metalbo.<hr><br/>'
                . '<br/><br/><br/E-mail enviado automaticamente, favor não responder!</b>'));
$oEmail->limpaDestinatariosAll();

// Para
$oEmail->addDestinatario('alexandre@metalbo.com.br');

$oEmail->addAnexo('app/relatorio/curriculos/curriculo' . $oDados->cpf . '.pdf', utf8_decode('curriculo' . $oDados->cpf . '.pdf'));
$aRetorno = $oEmail->sendEmail();
if ($aRetorno[0]) {
    $sMensagem = 'success';
} else {
    $sMensagem = 'error';
}
return $sMensagem;

/**
 * Função que quebra página em uma dada altura do PDF
 * @param type $i
 * @param type $pdf
 * @return type
 */
function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
