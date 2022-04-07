<?php

require 'biblioteca/fpdf/fpdf.php';
include '../includes/Config.php';
include '../includes/Fabrica.php';
include '../biblioteca/Utilidades/Email.php';

$oDados = $_REQUEST['campos'];

$aEstados = array();
array_push($aEstados, $oDados->ufNaturalidade);
array_push($aEstados, $oDados->ufMora);
array_push($aEstados, $oDados->ufAnt);
array_push($aEstados, $oDados->ufEmpresa1);
array_push($aEstados, $oDados->ufEmpresa2);
array_push($aEstados, $oDados->ufEmpresa3);

$aEstados = getEstado($aEstados);

date_default_timezone_set('America/Sao_Paulo');
$data = date('d/m/Y');
$hora = date('H:i:s');

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(5, 8, 5);

$pdf->Image('biblioteca/assets/images/logo.png', 8, 8, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

$pdf->SetFont('Arial', 'B', 20);
// Move to the right
$pdf->Cell(40);
// Title
$pdf->Cell(100, 10, 'Currículo', 0, 0, 'C');

//DATA/HORA
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(45, 4, 'Data: ' . $data . '                Hora: ' . $hora . '', 0, 'J');

$pdf->Ln(10);

$x = $pdf->GetX();
$y = $pdf->GetY();

//Dados pessoais.
$pdf->SetFont('Arial', '', 15);
// Move to the right
$pdf->Cell(50);
//Nome
$pdf->Cell(100, 12, $oDados->nomeCurr, 0, 1, 'C');

//telefone com imagem
$pdf->SetFont('Arial', 'B', 11);
$pdf->Image('biblioteca/assets/images/icone-telefone.png', 8, 42, 7); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->Cell(13);
//telefone
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->fone, 0, 0, 'L');

$pdf->Image('biblioteca/assets/images/icone-email.png', 142, 42, 7); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->Cell(93);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(85, 11, $oDados->email, 0, 1, 'L');

$pdf->Image('biblioteca/assets/images/icone-localizacao.png', 8, 54, 7); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->Cell(13);
$pdf->Cell(30, 11, $oDados->rua, 0, 0, 'L');
$pdf->Cell(2, 11, '|', '', 0, 'L');
$pdf->Cell(13, 11, $oDados->numero, 0, 0, 'L');
$pdf->Cell(2, 11, '|', '', 0, 'L');
$pdf->Cell(25, 11, $oDados->bairro, 0, 0, 'L');
$pdf->Cell(2, 11, '|', '', 0, 'L');
$pdf->Cell(25, 11, $oDados->cep, 0, 0, 'L');
$pdf->Cell(2, 11, '|', '', 0, 'L');
$pdf->Cell(45, 11, $oDados->cidadeMora, 0, 0, 'L');
$pdf->Cell(2, 11, '|', '', 0, 'L');
$pdf->Cell(32, 11, $aEstados[1], 0, 1, 'L');

$pdf->Cell(200, 5, '', 'T', 1, 'C');

/* $pdf->Cell(12, 11, $oDados->pais, 0, 0, 'L');
  $pdf->Cell(2, 11, '|', '', 0, 'L');
  $pdf->Cell(33, 11, $aEstados[0], 0, 0, 'L');
  $pdf->Cell(2, 11, '|', '', 0, 'L');
  $pdf->Cell(45, 11, $oDados->cidade, 0, 1, 'L'); */

//imagem email 


$pdf->SetFont('Arial', 'B', 13);

// Move to the right
//$pdf->Cell(60);  
$pdf->Cell(100, 15, 'Dados pessoais', 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);

$pdf->Cell(90, 0, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, 15, 'Data de nascimento: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(83, 15, Util::converteData($oDados->dataNasc), 0, 0, 'L');

$pdf->SetFillColor(249, 249, 250);
$pdf->Rect($pdf->GetX() - 1, $pdf->GetY(), 80, 200, 'F');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(25, 15, 'Nome da Mãe: ', '', 0, 'L', 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 15, $oDados->mae, 0, 1, 'L', 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(14, 15, 'Gênero: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(38, 15, $oDados->genero, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, 15, 'Altura: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(55, 15, $oDados->altura.'cm', 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 15, 'Nome do Pai: ', '', 0, 'L', 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 15, $oDados->pai, 0, 1, 'L', 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, 15, 'Peso: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(25, 15, $oDados->peso. 'Kg', 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, 15, 'Estado civil: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 15, $oDados->estCivil, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 15, 'Nome do cônjuge: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(88, 15, $oDados->conjuge, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(35, 15, 'Data de nascimento: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 15, Util::converteData($oDados->dateNascConj), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, 15, 'Filhos: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(107, 15, $oDados->filhos, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(33, 15, 'Menor de 14 Anos: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 15, $oDados->menor14, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(11, 15, 'PCD: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(109, 15, $oDados->pcd, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(33, 15, 'Especificação pcd: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(12, 15, $oDados->epcd, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 15, 'Tipo de PCD: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 15, $oDados->tipopcd, 0, 1, 'L');

//Dados para contato e endereço.
//Sub titulo
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 10, 'Endereço', 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);

$pdf->Cell(90, 0, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 15, 'Cidade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 15, $oDados->cidadeMora, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, 15, 'Bairro: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 15, $oDados->bairro, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 15, 'Rua: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 15, $oDados->rua, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 15, 'Numero: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(20, 15, $oDados->numero, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(9, 15, 'Cep: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, 15, $oDados->cep, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(31, 15, 'Tempo que mora: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 15, $oDados->tempoMora, 0, 1, 'L');

//Caso venha de outro estado
//Sub titulo

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(100, 15, 'Caso venha de outro estado', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(90, 0, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(15, 13, 'Estado: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 13, $aEstados[2], 0, 0, 'L');


$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(15, 13, 'Cidade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 13, $oDados->cidadeAnt, 0, 1, 'L');

//$pdf= quebraPagina(272, $pdf);

//Documentos
//Sub titulo
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(100, 17, 'Documentos', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(90, 5, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 11, 'RG: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(112, 11, $oDados->rg, 0, 0, 'L');

$pdf->Rect($pdf->GetX() - 1, $pdf->GetY(), 80, 250, 'F');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 11, 'N° Série da Carteira de Trab.: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 11, $oDados->seriectps, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(10, 11, 'CPF: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(110, 11, $oDados->cpf, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 11, 'Título de eleitor: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(58, 11, $oDados->titeleitor, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(41, 11, 'N° Carteira de trabalho: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(79, 11, $oDados->ctps, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 11, 'PIS: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->pis, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(39, 11, 'Nível de escolaridade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->escolaridade, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(36, 11, 'Entidade promotora: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(84, 11, $oDados->entidade, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, 11, 'Curso superior: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->curso, 0, 1, 'L');

//atividades profissionais| empresa 1
//Sub titulo
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 10, 'Atividades profissionais', 0, 1, 'L');

$pdf->Cell(90, 5, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(100, 15, 'Empresa 1', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(17, 11, 'Empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(103, 11, $oDados->Empresa1, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, 11, 'Da data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, Util::converteData($oDados->date1Empresa1), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(12, 11, 'Cargo: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(108, 11, $oDados->cargoEmpresa1, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 11, 'Até a data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, Util::converteData($oDados->date2Empresa1), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, 11, 'Telefone da empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->foneEmpresa1, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(14, 11, 'Estado: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 11, $aEstados[3], 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 11, 'Cidade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->cidadeEmpresa1, 0, 1, 'L');

//atividades profissionais| empresa 2
//Sub titulo
$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(100, 15, 'Empresa 2', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(70, 5, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(17, 11, 'Empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(103, 11, $oDados->Empresa2, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, 11, 'Da data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, Util::converteData($oDados->date1Empresa2), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, 11, 'Cargo: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(107, 11, $oDados->cargoEmpresa2, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 11, 'Até a data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, Util::converteData($oDados->date2Empresa2), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, 11, 'Telefone da empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->foneEmpresa2, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(14, 11, 'Estado: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 11, $aEstados[4], 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 11, 'Cidade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->cidadeEmpresa2, 0, 1, 'L');

//atividades profiss    ionais| empresa 3
//Sub titulo

$pdf->SetFont('Arial', 'B', 13);
$pdf->Cell(100, 15, 'Empresa 3', 0, 1, 'L');
$pdf->Cell(70, 5, '', 'T', 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(17, 11, 'Empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(103, 11, $oDados->Empresa3, 0, 0, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(22, 11, 'Da data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(40, 11, Util::converteData($oDados->date1Empresa3), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(13, 11, 'Cargo: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(107, 11, $oDados->cargoEmpresa3, 0, 0, 'L');


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(24, 11, 'Até a data de: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, Util::converteData($oDados->date2Empresa3), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(37, 11, 'Telefone da empresa: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->foneEmpresa3, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(14, 11, 'Estado: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(105, 11, $aEstados[5], 0, 0, 'L');

$pdf->Rect($pdf->GetX() - 1, $pdf->GetY(), 80, 40, 'F');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(15, 11, 'Cidade: ', '', 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->cidadeEmpresa3, 0, 1, 'L');


$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(100, 17, 'Referencias', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);

$pdf->Cell(70, 5, '', 'T', 1, 'L');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(40, 11, $oDados->referencia, 0, 1, 'L');

$pdf->Output('F', 'app/relatorio/curriculos/curriculo-' . $oDados->cpf . '.pdf');  // GERA O PDF NA TELA
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

//$oEmail->addAnexo('app/relatorio/curriculos/curriculo' . $oDados->cpf . '.pdf', utf8_decode('curriculo' . $oDados->cpf . '.pdf'));
//$aRetorno = $oEmail->sendEmail();
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

function getEstado($aEstados) {

    foreach ($aEstados as $key => $value) {
        switch ($value) {
            case 11:
                $aEstados[$key] = 'Acre';
                break;
            case 27:
                $aEstados[$key] = 'Alagoas';
                break;
            case 16:
                $aEstados[$key] = 'Amapá';
                break;
            case 13:
                $aEstados[$key] = 'Amazonas';
                break;
            case 29:
                $aEstados[$key] = 'Bahia';
                break;
            case 23:
                $aEstados[$key] = 'Ceará';
                break;
            case 53:
                $aEstados[$key] = 'Distrito Federal';
                break;
            case 32:
                $aEstados[$key] = 'Espírito Santo';
                break;
            case 52:
                $aEstados[$key] = 'Goiás';
                break;
            case 21:
                $aEstados[$key] = 'Maranhão';
                break;
            case 51:
                $aEstados[$key] = 'Mato Grosso';
                break;
            case 50:
                $aEstados[$key] = 'Mato Grosso do Sul';
                break;
            case 31:
                $aEstados[$key] = 'Minas Gerais';
                break;
            case 41:
                $aEstados[$key] = 'Paraná';
                break;
            case 25:
                $aEstados[$key] = 'Paraíba';
                break;
            case 15:
                $aEstados[$key] = 'Pará';
                break;
            case 26:
                $aEstados[$key] = 'Pernambuco';
                break;
            case 22:
                $aEstados[$key] = 'Piauí';
                break;
            case 33:
                $aEstados[$key] = 'Rio de Janeiro';
                break;
            case 24:
                $aEstados[$key] = 'Rio Grande do Norte';
                break;
            case 43:
                $aEstados[$key] = 'Rio Grande do Sul';
                break;
            case 12:
                $aEstados[$key] = 'Rondônia';
                break;
            case 14:
                $aEstados[$key] = 'Roraima';
                break;
            case 42:
                $aEstados[$key] = 'Santa Catarina';
                break;
            case 28:
                $aEstados[$key] = 'Sergipe';
                break;
            case 35:
                $aEstados[$key] = 'São Paulo';
                break;
            case 17:
                $aEstados[$key] = 'Tocantins';
                break;
        }
    }
    return $aEstados;
}
