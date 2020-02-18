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

//Pega data que o usuário digitou
$dtinicial = $_REQUEST['dataini'];
$dtfinal = $_REQUEST['datafinal'];
if (isset($_REQUEST['check1'])) {
    $bCheck1 = $_REQUEST['check1'];
} else {
    $bCheck1 = false;
}
//$sSituaca = $_REQUEST['situaca'];
//$sRetrabalho = $_REQUEST['retrabalho'];
//Inserção do cabeçalho
$pdf->Cell(37, 10, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(110, 10, 'Ops Não Apontadas', '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora: ' . $hora
        . ' Usuário: ' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', 'T', 1, 'L');

//Inicio

if (!$bCheck1) {
    //busca os dados do banco
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSqli = "select data,situacao,op,prodes,emp_razaosocial 
                from STEEL_PCP_ordensFab 
                where op not in (select op from STEEL_PCP_ordensFabApont) 
                and situacao in('Finalizado','Retornado')
                and data between '" . $dtinicial . "' and '" . $dtfinal . "' order by STEEL_PCP_ordensFab.data";

    $dadosRela = $PDO->query($sSqli);
} else {
    //busca os dados do banco
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSqli = "select * from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
			  on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op
              where codusersaida is null 
              and STEEL_PCP_ordensFab.situacao in('Finalizado','Retornado')";

    $dadosRela = $PDO->query($sSqli);
}

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 10, 'Filtros escolhidos:', '', 0, 'L', 0);
if (!$bCheck1) {
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(50, 10, 'Data inicial: ' . $dtinicial .
            '   Data final: ' . $dtfinal . ' ', '', 1, 'L', 0);
} else {
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(50, 10, 'Ops Finalizadas sem cadastro de usuário final', '', 1, 'L', 0);
}

$pdf->Cell(0, 3, '', '', 1, 'L');

//Títulos do relatório
if (!$bCheck1) {
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(10, 5, 'OP', 'B,R,L,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(85, 5, 'Produto', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(70, 5, 'Empresa', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(18, 5, 'Situação', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(18, 5, 'Data Saída', 'B,R,T', 1, 'C', 0);
} else {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(15, 5, 'OP', 'B,R,L,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, 'Cod. Prod.', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(85, 5, 'Produto', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(18, 5, 'Forno', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(23, 5, 'Data Entrada', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(23, 5, 'Data Saída', 'B,R,T', 0, 'C', 0);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(18, 5, 'Situação', 'B,R,T', 1, 'C', 0);
}

$iQnt = 0;

while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {

    if (!$bCheck1) {

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(10, 5, $row['op'], 'L,B,T', 0, 'C');

        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(85, 5, $row['prodes'], 'L,B,T', 0, 'L');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(70, 5, $row['emp_razaosocial'], 'L,B,T', 0, 'L');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(18, 5, $row['situacao'], 'L,B,T', 0, 'C');

        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(18, 5, $row['data'], 'L,B,T,R', 1, 'C', 0);
    } else {
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(15, 5, $row['op'], 'L,B,T', 0, 'C');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(20, 5, $row['procod'], 'L,B,T', 0, 'L');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(85, 5, $row['prodes'], 'L,B,T', 0, 'L');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $row['fornodes'], 'L,B,T', 0, 'C');

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(23, 5, $row['dataent_forno'], 'L,B,T', 0, 'C', 0);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(23, 5, $row['datasaida_forno'], 'L,B,T', 0, 'C', 0);

        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(18, 5, $row['situacao'], 'L,B,T,R', 1, 'C', 0);
    }

    $iQnt++;
}

$pdf->Cell(199, 5, '', '', 1, 'C', 0);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(18, 5, 'Total OPs: ' . $iQnt, '', 0, 'L', 0);

//Fim  

$pdf->Output('I', 'RelOpSteelNaoApont.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 