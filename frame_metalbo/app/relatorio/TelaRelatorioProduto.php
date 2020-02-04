<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Header() { //Cabeçalho do relatporio
        $l = 5; // Define a altura da linha como 5
        $this->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA

        /*
         * Margem da página
         * 
         * Cria retangulo que começa nos ponto x = 10 e y = 10 
         * com a largura de 190 e altura de 280
         * 
         */
        $this->Rect(10, 10, 190, 280);

        /*
         * Adiona imagem na posição do eixo x = 10 e eixo y = 15
         */
        $this->Image('../../biblioteca/assets/images/logo.png', 10, 15, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
        $this->SetFont('Arial', 'B', 8); // DEFINE A FONTE ARIAL, NEGRITO (B), DE TAMANHO 8

        $this->Ln(); // QUEBRA DE LINHA

        $this->Cell(190, 10, '', 0, 0, 'L');
        $this->Ln();
        $l = 17;
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(10, 15);
        $this->Cell(190, $l, 'RELATÓRIO DE PRODUTOS', 'B', 1, 'C');
        $l = 5;
    }

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


/* * ********************** CABEÇALHO DA TABELA ************************* */
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(213, 213, 213);
$y = 32;
$l = 6;

$pdf->SetY($y);
$pdf->SetX(10);
$pdf->Rect(10, $y, 22, $l);
$pdf->SetDrawColor(0, 0, 0);
$pdf->Cell(22, $l, 'CÓDIGO', 0, 0, 'C', TRUE);

$pdf->SetY($y);
$pdf->SetX(32);
$pdf->Rect(32, $y, 140, $l);
$pdf->Cell(140, $l, 'DESCRIÇÃO', 0, 2, '', TRUE);

$pdf->SetY($y);
$pdf->SetX(172);
$pdf->Rect(172, $y, 10, $l);
$pdf->Cell(10, $l, 'UN', 0, 2, 'C', TRUE);

$pdf->SetY($y);
$pdf->SetX(182);
$pdf->Rect(182, $y, 18, $l);
$pdf->Cell(18, $l, 'PESO', 0, 2, 'C', TRUE);

/* * ******************************************************************* */

$pdf->SetFont('Arial', '', 8);
$y = 39; // Y (altura) INICIAL DOS DADOS 
$l = 6; // ALTURA DA LINHA

/*
 * Conexão com banco de dados 
 */
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

//grupo=1&grupo1=2&subgrupo=1&subgrupo1=2&familia=1&familia1=2&subfamilia=1&subfamilia1=2&codigo=10110101
$aRequest = $_REQUEST;

$Codigo = $aRequest['codigo'];

$GrupoInicial = $aRequest['grupo'];
$GrupoFinal = $aRequest['grupo1'];

$SubGrupoInicial = $aRequest['subgrupo'];
$SubGrupoFinal = $aRequest['subgrupo1'];

$FamiliaInicial = $aRequest['familia'];
$FamiliaFinal = $aRequest['familia1'];

$SubFamiliaInicial = $aRequest['subfamilia'];
$SubFamiliaFinal = $aRequest['subfamilia1'];

if (!empty($Codigo)) {
    $sFiltro = "where procod = " . $Codigo;
} else {
    $sFiltro = "where grucod between " . $GrupoInicial . " and " . $GrupoFinal
            . " and subcod between " . $SubGrupoInicial . " and " . $SubGrupoFinal
            . " and famcod between " . $FamiliaInicial . " and " . $FamiliaFinal
            . " and famsub between " . $SubFamiliaInicial . " and " . $SubFamiliaFinal . " order by procod";
}
$sql = "select * from widl.prod01 " . $sFiltro;
$sth = $PDO->query($sql);

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

// ENQUANTO OS DADOS VÃO PASSANDO, O FPDF VAI INSERINDO OS DADOS NA PAGINA

    $procod = $row["procod"];
    $prodes = $row["prodes"];
    $pround = $row["pround"];
    $propesprat = number_format($row["propesprat"], 3);

    if ($y + $l >= 275) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $y = 34;             // Altura na segunda página
    }

    //DADOS
    $pdf->SetY($y);
    $pdf->SetX(15);
    //  $pdf->Rect(10,$y,18,$l);
    $pdf->Cell(22, $l, $procod, 0, 0, 'C');


    $pdf->SetY($y);
    $pdf->SetX(32);
    //$pdf->Rect(28,$y,85,$l);
    $pdf->Cell(130, $l, $prodes, 0, 2);

    $pdf->SetY($y);
    $pdf->SetX(172);
    //$pdf->Rect(113,$y,10,$l);
    $pdf->Cell(10, $l, $pround, 0, 2, 'C');

    $pdf->SetY($y);
    $pdf->SetX(182);
    //$pdf->Rect(123,$y,15,$l);
    $pdf->Cell(18, $l, $propesprat . ' KG', 0, 2, 'C');

    $y += $l;
}

$pdf->Output('', 'RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE