<?php

if (isset($_REQUEST['email'])) {
    $sEmailRequest = 'S';
} else {
    $sEmailRequest = 'N';
}
date_default_timezone_set('America/Sao_Paulo');

// Diretórios extras para email

use setasign\Fpdi\Fpdi;

if ($sEmailRequest == 'S') {
    include 'biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");

    $sDir = '';

    require ('biblioteca/FPDI-2.3.3/FPDI/autoload.php');
} else {
    include '../../biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");

    $sDir = '../../';

    require ('../../biblioteca/FPDI-2.3.3/FPDI/autoload.php');
}

//use setasign\Fpdi\PdfReader;
// Diretórios
//require '../../biblioteca/fpdf/fpdf.php';
//include("../../includes/Config.php");

class PDF extends FPDI {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 285);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

//variaveis request
if ($sEmailRequest == 'S') {
    $filcgc = $_REQUEST['filcgcRc'];
    $nr = $_REQUEST['nrRc'];
} else {
    if (isset($_REQUEST['nr'])) {
        $nr = $_REQUEST['nr'];
        $filcgc = $_REQUEST['filcgc'];
    } else {
        $nr = '0';
        $filcgc = '0';
    }
}

$pdf = new FPDI('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetAutoPageBreak(true, 2);
$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sSql = "select filcgc,nr,tbrncqual.empcod,tbrncqual.empdes,celular,email,contato,widl.emp01.cidcep,usucodigo,usunome,horains,nf,usucancela, motivocancela,"
        . "convert(varchar,datacancela,103) as datacancela,"
        . "convert(varchar,horacancela,8) as horacancela,"
        . "convert(varchar,datains,103) as datains,"
        . "convert(varchar,datanf,103) as datanf,"
        . "convert(varchar,data,103)as data,"
        . "convert(varchar,datafim,103) as datafim,"
        . "convert(varchar,data_disposicao,103) as data_disposicao,"
        . "convert(varchar,datalibdevolucao,103) as datalibdevolucao,"
        . "convert(varchar,data_reabriu,103) as data_reabriu,"
        . "odcompra,pedido,valor,peso,lote,op,naoconf,procod,prodes,aplicacao,quant,quantnconf,nome,cargo,officecod,officedes,"
        . "anexo1,anexo2,anexo3,situaca,obsSit,resp_venda_cod,resp_venda_nome,obs_fim,horafim,usucod_fim,usunome_fim,devolucao,"
        . "usuaponta,apontamento,tagsetor,tbrncqual.repcod,produtos,usuapontavenda,obs_aponta,reclamacao,tagexcecao,"
        . "nfdevolucao,nfsIpi,valorfrete,inspecao,correcao,obs_inspecao,hora_disposicao,resp_disposicao,anexo_inspecao,"
        . "anexo_inspecao1,anexo_analise,anexo_analise1,procedencia,numcad,nomfun,obs_analiseret,sollibdevolucao,usulibdevolucao,obslibdevolucao,"
        . "horalibdevolucao,usu_reabriu,hora_reabriu,motivo_reabriu,apontaNF,empfone,celular,empend,empendbair,usunome,cidnome,"
        . "case when ind = 'true' then 'x' else '' end as ind,"
        . "case when comer = 'true' then 'x' else '' end as comer,"
        . "case when disposicao = '1' then 'x' else '' end as aceitar,"
        . "case when disposicao = '2' then 'x' else '' end as devolver "
        . "from tbrncqual "
        . "left outer join widl.EMP01 "
        . "on widl.emp01.empcod = tbrncqual.empcod "
        . "left outer join widl.CID01 "
        . "on widl.CID01.cidcep = widl.EMP01.cidcep "
        . "where nr=" . $nr;
$dadoscab = $PDO->query($sSql);
$row = $dadoscab->fetch(PDO::FETCH_ASSOC);
//cabeçalho
$pdf->SetMargins(3, 5, 3);
$pdf->Rect(2, 10, 38, 18);

$aProdutos = explode(';', $row['produtos']);

// Logo
if ($sEmailRequest == 'S') {
    $pdf->Image('biblioteca/assets/images/logopn.png', 4, 13, 26);
} else {
    $pdf->Image('../../biblioteca/assets/images/logopn.png', 4, 13, 26);
}

// Arial bold 15
$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(30);
// Title
$pdf->Cell(120, 18, '        Relatório de não conformidade nº   ' . $nr, 1, 0, 'L');

$pdf->Rect(160, 10, 48, 18);
$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(45, 5, 'Emissão: ' . $row['datains'] . '       Usuário: ' . $row['usunome'] . '                        ', 0, 'J');

$iPosY = 0;

if ($row['situaca'] == 'Cancelada') {
    $pdf->Cell(50, 10);
    $pdf->Ln(10);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(50, 5, "RC Cancelada!", 0, 0, 'L');
    $pdf->Cell(15, 5, "Usuário: ", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(65, 5, $row['usucancela'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(10, 5, "Data: ", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(25, 5, $row['datacancela'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(10, 5, "Hora: ", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(25, 5, $row['horacancela'], 0, 1, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(200, 5, "Motivo: ", 0, 1, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->MultiCell(205, 5, $row['motivocancela'], 0, 'L');
    $iQ = round((strlen($row['motivocancela']) / 120));
    if ($iQ == 0) {
        $iQ = 1;
    }
    $pdf->Rect(2, 32, 206, 17 + 6 * $iQ);
    $iPosY = 5 + $iQ;
}

$pdf->Rect(2, 30 + $iPosY * 5, 206, 30);
$pdf->Ln(10);
//cliente
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cliente:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['empcod'], 0, 0, 'L');
$pdf->Cell(116, 5, $row['empdes'], 0, 1, 'L');
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Tipo:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(19, 5, '(' . $row['ind'] . ') Indústria', 0, 0, 'L');
$pdf->Cell(19, 5, '(' . $row['comer'] . ') Comécio', 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cidade:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(70, 5, $row['cidnome'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(13, 5, "Bairro:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(78, 5, $row['empendbair'], 0, 1, 'L');


$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Cep:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['cidcep'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Endereço:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(98, 5, $row['empend'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Fone:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['empfone'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Celular:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(38, 5, $row['celular'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(13, 5, "E-mail:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(28, 5, $row['email'], 0, 1, 'L');

$pdf->Rect(2, 65 + $iPosY * 5, 206, 25);

$pdf->Ln(10);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Nota Fiscal:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(80, 5, $row['nf'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Data:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['datanf'], 0, 1, '1');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Ordem Compra:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(80, 5, $row['odcompra'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Pedido de venda:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['pedido'], 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Valor:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(80, 5, number_format($row['valor'], 2, ',', '.'), 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(32, 5, "Peso:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, number_format($row['peso'], 2, ',', '.'), 0, 1, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Lote:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(80, 5, $row['lote'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(40, 5, "Ordem de produção:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['op'], 0, 0, 'L');

$pdf->Ln(10);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Descrição da não conformidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['naoconf'], 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Disposição:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, '(' . $row['aceitar'] . ') Aceito condicionalmente', 0, 0, 'L');
$pdf->Cell(50, 5, '(' . $row['devolver'] . ') Devolver', 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Dados do produto", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Aplicação:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['aplicacao'], 0, 1, 'L');

if ($aProdutos[0] != '') {

    foreach ($aProdutos as $key => $value) {
        $aDadosProd = explode('-', $value);

        $iAltura = $pdf->GetY();
        $pdf->Rect(2, $iAltura, 206, 25);
        $pdf->Ln(3);

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(31, 5, "Produto:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[1], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(31, 5, "Código:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[0], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Quantidade:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[2], 0, 1, 'L');

        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(30, 5, "Quant. não conf:", 0, 0, 'L');
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 5, $aDadosProd[3], 0, 1, 'L');
    }
}

//PARTE DOS ANEXOS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//ANEXO 1
if ($row['anexo1'] != '' && (strstr(strtolower($row['anexo1']), 'png') || strstr(strtolower($row['anexo1']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo1'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo1 = $row['anexo1'];
        $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexo1, null, null, 190, 250);
    }
}

if ($row['anexo1'] != '' && (strstr(strtolower($row['anexo1']), 'pdf'))) {

    $sAnexo1 = $row['anexo1'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexo1, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexo1;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexo1;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}

//ANEXO 2
if ($row['anexo2'] != '' && (strstr(strtolower($row['anexo2']), 'png') || strstr(strtolower($row['anexo2']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo2'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo2 = $row['anexo2'];
        $pdf->Cell(26, 5, "ANEXO 2", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexo2, null, null, 190, 250);
    }
}

if ($row['anexo2'] != '' && (strstr(strtolower($row['anexo2']), 'pdf'))) {
    $sAnexo2 = $row['anexo2'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexo2, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexo2;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexo2;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}


//ANEXO 3
if ($row['anexo3'] != '' && (strstr(strtolower($row['anexo3']), 'png') || strstr(strtolower($row['anexo3']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo3'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexo3 = $row['anexo3'];
        $pdf->Cell(26, 5, "ANEXO 3", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexo3, null, null, 190, 250);
    }
}

if ($row['anexo3'] != '' && (strstr(strtolower($row['anexo3']), 'pdf'))) {
    $sAnexo3 = $row['anexo3'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexo3, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexo3;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexo3;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}
if (($row['anexo1'] != '') || ($row['anexo2'] != '') || ($row['anexo3'] != '')) {
    $pdf->AddPage();
    $pdf->SetY(10);
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
$pdf = quebraPagina($pdf->GetY() + 10, $pdf);

$pdf->Ln(8);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da RC por setor interno:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$iAltura = $pdf->GetY();
//$pdf->Rect(2, $iAltura, 206, 20 + round((strlen($row['apontamento']) / 120) * 5));
$pdf->Rect(2, $iAltura, 206, 25 + round((strlen($row['apontamento']) / 120) * 5));

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(45, 5, "Responsável pela análise:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(30, 5, $row['usuaponta'], 0, 1, 'L');

/* Isso aqui é tipo a RNC, quem foi o colaborador que causou, caso eles saibam quem foi...
  Por isso é capaz de a maioria das vezes, ficar em branco
 */
if ($row['numcad'] != null) {
    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(45, 5, "Colaborador que causou:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(30, 5, $row['numcad'] . ' - ' . $row['nomfun'], 0, 1, 'L');
}

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da RC:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['apontamento'], 0, 'L');

$pdf = quebraPagina($pdf->GetY() + 24, $pdf);

$pdf->Ln(6 + round((strlen($row['apontamento']) / 120) * 5));
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Análise da RC pelo setor de Vendas:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$iAltura = $pdf->GetY();
$h = 0;
if ($row['usu_reabriu'] != null) {
    $h = $h + 9 + round((strlen($row['motivo_reabriu']) / 120) * 5);
}
if ($row['sollibdevolucao'] != null) {
    $h = $h + 14;
}
if ($row['apontaNF'] != null) {
    $h = $h + 9;
}

$pdf->Rect(2, $iAltura, 206, 25 + $h + round((strlen($row['obs_aponta']) / 120) * 6));

/*
 * Usuário que reabriu, hora, data, motivo.
 */
if ($row['usu_reabriu'] != null) {

    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(35, 5, "Usuário que reabriu:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(80, 5, $row['usu_reabriu'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(12, 5, "Data:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, $row['data_reabriu'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(12, 5, "Hora:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, date('H:i', strtotime($row['hora_reabriu'])), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(30, 5, "Motivo de reabertura:", 0, 1, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->MultiCell(205, 5, $row['motivo_reabriu'], 0, 'L');
}
$pdf = quebraPagina($pdf->GetY() + 10, $pdf);
$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(45, 5, "Responsável pela análise:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['resp_venda_nome'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(18, 5, "Procede?:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(45, 5, $row['procedencia'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(20, 5, "Devolução:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['devolucao'], 0, 1, 'L');

$pdf->Ln(2);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Análise da RC:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(205, 5, $row['obs_aponta'], 0, 'L');

$pdf = quebraPagina($pdf->GetY() + 10, $pdf);
/*
 * Solicitação de Devolução
 */
if ($row['sollibdevolucao'] != null) {
    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(70, 5, "Responsável pela análise da devolução:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(50, 5, $row['usulibdevolucao'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(12, 5, "Data:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, $row['datalibdevolucao'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(12, 5, "Hora:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, date('H:i', strtotime($row['horalibdevolucao'])), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(30, 5, "Observação:", 0, 1, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->MultiCell(205, 5, $row['obslibdevolucao'], 0, 'L');
}

$pdf = quebraPagina($pdf->GetY() + 10, $pdf);
/*
 * Apontamento de nota fiscal
 */
if ($row['apontaNF'] != null) {
    $pdf->Ln(2);
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(40, 5, "Nota Fiscal Devolução:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, $row['nfdevolucao'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(15, 5, "NFS IPI.:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(30, 5, $row['nfsIpi'], 0, 0, 'L');
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(30, 5, "Valor do Frete:", 0, 0, 'L');
    $pdf->SetFont('arial', '', 10);
    $pdf->Cell(20, 5, $row['valorfrete'], 0, 0, 'L');
    $pdf->Ln(2);
}
$pdf = quebraPagina($pdf->GetY() + 10, $pdf);
//PARTE DOS ANEXOS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//ANEXO ANÁLISE
if ($row['anexo_analise'] != '' && (strstr(strtolower($row['anexo_analise']), 'png') || strstr(strtolower($row['anexo_analise']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo_analise'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexoAnalise = $row['anexo_analise'];
        $pdf->Cell(26, 5, "ANEXO ANÁLISE", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexoAnalise, null, null, 190, 250);
    }
}

if ($row['anexo_analise'] != '' && (strstr(strtolower($row['anexo_analise']), 'pdf'))) {
    $sAnexoAnalise = $row['anexo_analise'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexoAnalise, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexoAnalise;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexoAnalise;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}

//ANEXO ANÁLISE 1
if ($row['anexo_analise1'] != '' && (strstr(strtolower($row['anexo_analise1']), 'png') || strstr(strtolower($row['anexo_analise1']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo_analise1'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexoAnalise1 = $row['anexo_analise1'];
        $pdf->Cell(26, 5, "ANEXO ANÁLISE 1", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexoAnalise1, null, null, 190, 250);
    }
}

if ($row['anexo_analise1'] != '' && (strstr(strtolower($row['anexo_analise1']), 'pdf'))) {
    $sAnexoAnalise1 = $row['anexo_analise1'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexoAnalise1, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexoAnalise1;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexoAnalise1;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
////////////////////////////
if (($row['anexo_analise'] != '') || ($row['anexo_analise1'] != '')) {
    $pdf->AddPage();
    $pdf->SetY(10);
}
$pdf->Ln(10);
/////////////////////////////////////////////
$pdf->Ln(2 + round((strlen($row['obs_fim']) / 120) * 10));
$pdf = quebraPagina($pdf->GetY() + 10, $pdf);

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(30, 5, "Inspeção/Recebimento - Qualidade:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);

$iAltura = $pdf->GetY();
$pdf->Rect(2, $iAltura, 206, 30);

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Responsável:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['resp_disposicao'], 0, 0, 'L');

$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Correção:", 0, 0, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->Cell(50, 5, $row['correcao'], 0, 1, 'L');

$pdf->Ln(2);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(26, 5, "Inspeção:", 0, 1, 'L');
$pdf->SetFont('arial', '', 10);
$pdf->MultiCell(190, 5, $row['inspecao'], 0, 'L');

//PARTE DOS ANEXOS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
//ANEXO INSPEÇÃO
if ($row['anexo_inspecao'] != '' && (strstr(strtolower($row['anexo_inspecao']), 'png') || strstr(strtolower($row['anexo_inspecao']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo_inspecao'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexoInspecao = $row['anexo_inspecao'];
        $pdf->Cell(26, 5, "ANEXO INSPEÇÃO", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexoInspecao, null, null, 190, 250);
    }
}

if ($row['anexo_inspecao'] != '' && (strstr(strtolower($row['anexo_inspecao']), 'pdf'))) {
    $sAnexoInspecao = $row['anexo_inspecao'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexoInspecao, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexoInspecao;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexoInspecao;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}

//ANEXO INSPEÇÃO 1
if ($row['anexo_inspecao1'] != '' && (strstr(strtolower($row['anexo_inspecao1']), 'png') || strstr(strtolower($row['anexo_inspecao1']), 'jpg') || strstr(strtolower($row['anexo1']), 'jpeg'))) {
    if (isset($row['anexo_inspecao1'])) {
        $pdf->AddPage();
        $pdf->SetXY(10, 10);
        $sAnexoInspecao1 = $row['anexo_inspecao1'];
        $pdf->Cell(26, 5, "ANEXO INSPEÇÃO 1", 0, 1, 'L');
        $pdf->Image('' . $sDir . 'Uploads/' . $sAnexoInspecao1, null, null, 190, 250);
    }
}

if ($row['anexo_inspecao1'] != '' && (strstr(strtolower($row['anexo_inspecao1']), 'pdf'))) {
    $sAnexoInspecao1 = $row['anexo_inspecao1'];
    $filepdf = fopen('' . $sDir . 'Uploads/' . $sAnexoInspecao1, "r");
    if ($filepdf) {
        $line_first = fgets($filepdf);
        fclose($filepdf);
    }

    preg_match_all('!\d+!', $line_first, $matches);
    // save that number in a variable
    $pdfversion = implode('.', $matches[0]);
    $NEW_PDF = $sDir . 'Uploads2/' . $sAnexoInspecao1;
    $OLD_PDF = $sDir . 'Uploads/' . $sAnexoInspecao1;

    if ($pdfversion > "1.4") {
        shell_exec('"C:\Program Files\gs\gs9.53.3\bin\gswin64c" -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile="' . $NEW_PDF . '" "' . $OLD_PDF . '"');
        $pageCount = $pdf->setSourceFile($NEW_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    } else {
        $pageCount = $pdf->setSourceFile($OLD_PDF);
        for ($i = 0; $i < $pageCount; $i++) {
            $tpl = $pdf->importPage($i + 1, '/MediaBox');
            $pdf->addPage();
            $pdf->useImportedPage($tpl, null, null, null, null, true);
            $pdf->Cell(26, 5, "ANEXO 1", 0, 1, 'L');
        }
    }
}
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
if ($sEmailRequest == 'S') {
    $pdf->Output('F', 'app/relatorio/rc/RC' . $nr . '_empresa_' . $filcgc . '.pdf'); // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'RC' . $nr . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}

if ($sEmailRequest == 'S') {
    $aDados = array();
    parse_str($sDados, $aDados);
    $sClasse = $this->getNomeClasse();
    date_default_timezone_set('America/Sao_Paulo');
    $data = date('d/m/Y');
    $hora = date('H:m');

    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    $oEmail->setServidor(Config::SERVER_SMTP);
    $oEmail->setPorta(Config::PORT_SMTP);
    $oEmail->setAutentica(true);
    $oEmail->setUsuario(Config::EMAIL_SENDER);
    $oEmail->setSenha(Config::PASWRD_EMAIL_SENDER);
    $oEmail->setProtocoloSMTP(Config::PROTOCOLO_SMTP);
    $oEmail->setRemetente(utf8_decode(Config::EMAIL_SENDER), utf8_decode('Relatórios Web Metalbo'));

    $sSqlRC = "select convert(varchar,datanf,103)as data,nr,officedes,empcod,empdes,nf,odcompra,pedido,valor,peso,aplicacao,naoconf,resp_venda_cod from tbrncqual"
            . " where filcgc = '" . $filcgc . "' and nr = '" . $nr . "'";
    $DadosRC = $PDO->query($sSqlRC);
    $aRow = $DadosRC->fetch(PDO::FETCH_ASSOC);

    $oEmail->setAssunto(utf8_decode('Inserida nova RNC - Reclamação de cliente'));

    $oEmail->setMensagem(utf8_decode('RECLAMAÇÃO Nº ' . $aRow['nr'] . ' FOI LIBERADA PELO REPRESENTANTE<hr><br/>'
                    . '<b>Representante: ' . $_SESSION['nome'] . ' </b><br/>'
                    . '<b>Escritório: ' . $aRow['officedes'] . ' </b><br/>'
                    . '<b>Hora:' . $hora . '  </b><br/>'
                    . '<b>Data do Cadastro: ' . $data . ' </b><br/><br/><br/>'
                    . '<table border = 1 cellspacing = 2 cellpadding = 2 width = "100%">'
                    . '<tr><td><b>Cnpj:</b></td><td> ' . $aRow['empcod'] . ' </td></tr>'
                    . '<tr><td><b>Razão Social:</b></td><td> ' . $aRow['empdes'] . ' </td></tr>'
                    . '<tr><td><b>Nota fiscal:</b></td><td> ' . $aRow['nf'] . ' </td></tr>'
                    . '<tr><td><b>Data da NF.:</b></td><td> ' . $aRow['data'] . ' </td></tr>'
                    . '<tr><td><b>Od. de compra:</b></td><td> ' . $aRow['odcompra'] . ' </td></tr>'
                    . '<tr><td><b>Pedido Nº:</b></td><td> ' . $aRow['pedido'] . ' </td></tr>'
                    . '<tr><td><b>Valor: R$</b></td><td> ' . number_format($aRow['valor'], 2, ',', '.') . ' </td></tr>'
                    . '<tr><td><b>Peso:</b></td><td> ' . number_format($aRow['peso'], 2, ',', '.') . ' </td></tr>'
                    . '<tr><td><b>Aplicação: </b></td><td> ' . $aRow['aplicacao'] . '</td></tr>'
                    . '<tr><td><b>Não conformidade:</b></td><td> ' . $aRow['naoconf'] . ' </td></tr>'
                    . '</table><br/><br/>'
                    . '<a href = "https://sistema.metalbo.com.br">Clique aqui para acessar o sistema!</a>'
                    . '<br/><br/><br/><b>E-mail enviado automaticamente, favor não responder!</b>'));

    $oEmail->limpaDestinatariosAll();

    //busca email venda
    $sSqlMail = "select usuemail from tbusuario where usucodigo ='" . $aRow['resp_venda_cod'] . "' ";
    $DadosMail = $PDO->query($sSqlMail);
    $aRowMail = $DadosMail->fetch(PDO::FETCH_ASSOC);

    //enviar e-mail vendas
    $oEmail->addDestinatario($aRowMail['usuemail']);
    //$oEmail->addDestinatario('alexandre@metalbo.com.br');
    //$oEmail->addAnexo('app/relatorio/rc/RC' . $nr . '_empresa_' . $filcgc . '.pdf', utf8_decode('RC nº' . $nr . '_empresa_' . $filcgc . '.pdf'));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
        echo $oMensagem->getRender();
    } else {
        $oMensagem = new Mensagem('E-mail', 'Erro ao tentar enviar o e-mail', Mensagem::TIPO_ERROR);
        echo $oMensagem->getRender();
    }
    return $aRetorno;
}

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
