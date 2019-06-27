<?php

if (isset($_REQUEST['email'])) {
    $sEmailRequest = 'S';
    if (isset($_REQUEST['todos'])) {
        $sEmailRequestTodos = 'S';
    }
} else {
    $sEmailRequest = 'N';
    $sEmailRequestTodos = 'N';
}

// Diretórios extras para email
if ($sEmailRequest == 'S') {
    include 'biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");
} else {
    include '../../biblioteca/fpdf/fpdf.php';
    include("../../includes/Config.php");
    include("../../includes/Fabrica.php");
    include("../../biblioteca/Utilidades/Email.php");
}

// Diretórios
//require '../../biblioteca/fpdf/fpdf.php';
//include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

//cptura dados

if ($sEmailRequest == 'S') {
    $filcgcAq = $_REQUEST['filcgcAq'];
    $nrAq = $_REQUEST['nrAq'];
} else {
    if (isset($_REQUEST['nr'])) {
        $nrAq = $_REQUEST['nr'];
        $filcgcAq = $_REQUEST['EmpRex_filcgc'];
    } else {
        $nrAq = '0';
        $filcgcAq = '0';
    }
}

//tratar se tem avaliação aberta ou nao
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select COUNT(*)as total from tbacaoeficaz where nr = '" . $nrAq . "' and filcgc ='" . $filcgcAq . "'";
$dadosSql = $PDO->query($sSql);
$eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);

if ($eficaz['total'] == 0) {
    $avFim = 'aberta';
} else {
    /* ver se tem alguma aberta sem apontamento */
    $sSql = " select COUNT(*) total2 from tbacaoeficaz where nr = '" . $nrAq . "' and eficaz <> 'Sim' and filcgc ='" . $filcgcAq . "'";
    $dadosSql = $PDO->query($sSql);
    $eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);
    if ($eficaz['total2'] > 0) {
        $avFim = 'aberta';
    } else {
        $avFim = 'fechada';
    }
}
$iCon = 0;

$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//dados do cabeçalho
$sSql = "select certificacao,userimp,convert(varchar,dtimp,103) as dtimp,titulo,usunome,equipe,convert(varchar,dataini,103) as dataini, "
        . "convert(varchar,datafim,103) as datafim,tipoacao,origem,tipmelhoria,problema,objetivo,tipocausa,desctipocausa,"
        . "pq1,pq2,pq3,pq4,pq5,anexo1,anexo2 "
        . " from tbacaoqual where filcgc ='" . $filcgcAq . "' and nr=" . $nrAq;
$dadoscab = $PDO->query($sSql);
while ($row = $dadoscab->fetch(PDO::FETCH_ASSOC)) {
    $userImp = $row['userimp'];
    $dtimp = $row['dtimp'];
    $sTitulo = $row['titulo'];
    $sResp = $row['usunome'];
    $sEquipe = $row['equipe'];
    $sDataini = $row['dataini'];
    $sDataFim = $row['datafim'];
    $sTipoAcao = $row['tipoacao'];
    $sOrigem = $row['origem'];
    $sTipMelhoria = $row['tipmelhoria'];
    $sProblema = $row['problema'];
    $sObjetivo = $row['objetivo'];
    $sTipocausa = $row['tipocausa'];
    $sDescCausa = $row['desctipocausa'];
    $sCertificacao = $row['certificacao'];
    $sPq1 = $row['pq1'];
    $sPq2 = $row['pq2'];
    $sPq3 = $row['pq3'];
    $sPq4 = $row['pq4'];
    $sPq5 = $row['pq5'];
    if($row['anexo1']!=''){
        $iCon++;
    }
}

//cabeçalho
$pdf->SetMargins(3, 0, 3);
$pdf->Rect(2, 10, 38, 18);

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
$pdf->Cell(120, 18, '                   Ação da qualidade nº ' . $nrAq . '   ', 1, 0, 'L');

$pdf->Rect(160, 10, 48, 18);
$pdf->SetFont('Arial', '', 9);

if ($avFim == 'aberta') {
    $pdf->MultiCell(45, 4, 'Emissão: ' . $dtimp . '            Usuário: ' . $userImp . ' Início: ' . $sDataini . '            Fim: ', 0, 'J');
} else {
    if ($avFim == 'fechada') {
        $pdf->MultiCell(45, 4, 'Emissão: ' . $dtimp . '            Usuário: ' . $userImp . ' Início: ' . $sDataini . '            Fim: ' . $sDataFim . '', 0, 'J');
    }
}


$pdf->Ln(5);
$pdf->SetFont('arial', 'B', 10);
$pdf->Cell(27, 5, "Tema da ação:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(70, 5, $sTitulo, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, 5, "Classificação:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(178, 5, $sCertificacao, 0, 1, 'L');
//$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, 5, "Responsável:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(47, 5, $sResp, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(27, 5, "Equipe:", 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(178, 5, $sEquipe, 0, 1, 'L');
$pdf->Ln(5);

$pdf->SetFillColor(213, 213, 213);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(69, 5, "Tipo de ação", 1, 0, 'L', TRUE);
$pdf->Cell(69, 5, "Origem", 1, 0, 'L', TRUE);
$pdf->Cell(68, 5, "Melhoria de", 1, 1, 'L', TRUE);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(69, 5, $sTipoAcao, 1, 0, 'L');
$pdf->Cell(69, 5, $sOrigem, 1, 0, 'L');
$pdf->Cell(68, 5, $sTipMelhoria, 1, 1, 'L');

$pdf->Ln(5);
//$pdf->Rect(3,68,206,20); 
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Problema", 1, 1, 'C', TRUE);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(206, 5, $sProblema, 1, 'J');

$pdf->Ln(5);

//$pdf->Rect(3,98,206,20); 
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Objetivo", 1, 1, 'C', TRUE);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(206, 5, $sObjetivo, 1, 'J');


$pdf->Rect(2, 31, 206, 5);
$pdf->Rect(2, 36, 206, 5);
$pdf->Rect(2, 41, 206, 5);
$pdf->Rect(2, 46, 206, 5);

$pdf->Ln(1);
if($iCon>0){
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(103, 5, "- Possui Anexo Ação Qualidade", 0, 1, 'L');
}
$pdf->Ln(1);
//############################### Conteção/Abrangência #######################################

$sSqlContencao = "select COUNT(*) as total "
        . "from MET_QUAL_Contencao "
        . "where filcgc = '" . $filcgcAq . "' and nr ='" . $nrAq . "'";
$iContecao = $PDO->query($sSqlContencao);
$existeContencao = $iContecao->fetch(PDO::FETCH_ASSOC);
$iConCont = 0;

if ($existeContencao['total'] > 0) {
    $sSqlDadosContencao = "select plano, anexoplan1,convert(varchar,dataprev,103) as dataprev,usunome,situaca "
            . "from MET_QUAL_Contencao "
            . "where filcgc = '" . $filcgcAq . "' and nr ='" . $nrAq . "'";
    $dadosContencao = $PDO->query($sSqlDadosContencao);


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(206, 5, "Conteção/Abrangência", 1, 1, 'C', TRUE);

    while ($rowContencao = $dadosContencao->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFillColor(213, 213, 213);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(103, 5, "Nome", 1, 0, 'L', TRUE);
        $pdf->Cell(103, 5, "Data Prevista", 1, 1, 'L', TRUE);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(103, 5, $rowContencao['usunome'], 1, 0, 'L');
        $pdf->Cell(103, 5, $rowContencao['dataprev'], 1, 1, 'L');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(206, 5, 'Análise = ' . $rowContencao['plano'], 1, 'L');
        $iAlturaAcao = $pdf->GetY();
        if($rowContencao['anexoplan1']!=''){
            $iConCont++;
        }
    }
}

$pdf->Ln(1);
if($iConCont>0){
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(103, 5, "- Possui Anexo Contenção/Abrangência", 0, 1, 'L');
}
$pdf->Ln(1);

//############################### Correção #######################################
$iConCorre = 0;
$sCorr ="";

$sSqlContencao = "select COUNT(*) as total "
        . "from MET_QUAL_Correcao "
        . "where filcgc = '" . $filcgcAq . "' and nr ='" . $nrAq . "'";
$iCorrecao = $PDO->query($sSqlContencao);
$existeCorrecao = $iCorrecao->fetch(PDO::FETCH_ASSOC);

if ($existeCorrecao['total'] > 0) {
    $sSqlDadosCorrecao = "select plano, anexoplan1, convert(varchar,dataprev,103) as dataprev,usunome,situaca "
            . "from MET_QUAL_Correcao "
            . "where filcgc = '" . $filcgcAq . "' and nr ='" . $nrAq . "'";
    $dadosCorrecao = $PDO->query($sSqlDadosCorrecao);


    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(206, 5, "Correção", 1, 1, 'C', TRUE);

    while ($rowCorrecao = $dadosCorrecao->fetch(PDO::FETCH_ASSOC)) {

        $pdf->SetFillColor(213, 213, 213);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(103, 5, "Nome", 1, 0, 'L', TRUE);
        $pdf->Cell(103, 5, "Data Prevista", 1, 1, 'L', TRUE);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(103, 5, $rowCorrecao['usunome'], 1, 0, 'L');
        $pdf->Cell(103, 5, $rowCorrecao['dataprev'], 1, 1, 'L');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->MultiCell(206, 5, 'Ação efetuada = ' . $rowCorrecao['plano'], 1, 'L');
        $iAlturaAcao = $pdf->GetY();
        
        if($rowCorrecao['anexoplan1']!=''){
            $iConCorre++;
            $sCorr = $sCorr.$iConCorre.", ";
        }
    }
}

$pdf->Ln(1);
if($iConCorre>0){
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(103, 5, "As ações de correção ".$sCorr."contém anexo", 0, 1, 'L');
}
$pdf->Ln(1);

//########################### causa raiz do problema #########################################

$sSelectExisteNr = "select COUNT(nr) as total from MET_QUAL_DiagramaCausa where nr = '" . $nrAq . "' and filcgc = '" . $filcgcAq . "'";
$oExisteNr = $PDO->query($sSelectExisteNr);
$aNr = $oExisteNr->fetch(PDO::FETCH_ASSOC);

if ($aNr['total'] == 1) {
    $sSqlC = "select matprimades, metododes, maodeobrades, "
            . "equipamentodes, meioambientedes, medidades"
            . " from MET_QUAL_DiagramaCausa where nr='" . $nrAq . "' and filcgc ='" . $filcgcAq . "' ";
    $dadosCausa1 = $PDO->query($sSqlC);
    $row1 = $dadosCausa1->fetch(PDO::FETCH_ASSOC);

    //Tira formatação do texto
    $row1['matprimades'] = limpaString($row1['matprimades']);
    $row1['maodeobrades'] = limpaString($row1['maodeobrades']);
    $row1['equipamentodes'] = limpaString($row1['equipamentodes']);
    $row1['meioambientedes'] = limpaString($row1['meioambientedes']);
    $row1['metododes'] = limpaString($row1['metododes']);
    $row1['medidades'] = limpaString($row1['medidades']);
} else {
    $sSqlC = "select matprimades, metododes, maodeobrades, "
            . "equipamentodes, meioambientedes, medidades"
            . " from tbacaoqualcausa where nr='" . $nrAq . "' and filcgc ='" . $filcgcAq . "' ";
    $dadosCausa1 = $PDO->query($sSqlC);
    $row1 = $dadosCausa1->fetch(PDO::FETCH_ASSOC);

    if ($row1 != false) {

        $arraySize = 0;
        foreach ($row1 as $key => $value) {
            if ($value != null) {
                $arraySize++;
            }
        }
        if ($arraySize == 0) {
            $row1 = montaCausaDes($row1, $nrAq, $filcgcAq);
        }
    } elseif ($row1 == false) {
        $row1['matprimades'] = null;
        $row1['maodeobrades'] = null;
        $row1['equipamentodes'] = null;
        $row1['meioambientedes'] = null;
        $row1['metododes'] = null;
        $row1['medidades'] = null;
    } else {
        //Tira formatação do texto
        $row1['matprimades'] = limpaString($row1['matprimades']);
        $row1['maodeobrades'] = limpaString($row1['maodeobrades']);
        $row1['equipamentodes'] = limpaString($row1['equipamentodes']);
        $row1['meioambientedes'] = limpaString($row1['meioambientedes']);
        $row1['metododes'] = limpaString($row1['metododes']);
        $row1['medidades'] = limpaString($row1['medidades']);
    }
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Causa raiz do problema", 1, 1, 'C', TRUE);

$pdf->Ln(5);

$pdf->Cell(67, 5, "Matéria Prima", 1, 0, 'C');
$pdf->Cell(2, 5, "", 0, 0, 'C');
$pdf->Cell(68, 5, "Mão de Obra", 1, 0, 'C');
$pdf->Cell(2, 5, "", 0, 0, 'C');
$pdf->Cell(67, 5, "Máquinas", 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

$h = $pdf->GetY();
$x = $pdf->GetX();
$y = $pdf->GetY();

//strlen($sSqlC)   Conta a quantidade de caracteres
$t1 = strlen($row1['matprimades']);
$t2 = strlen($row1['maodeobrades']);
$t3 = strlen($row1['equipamentodes']);

$iMaior1 = max($t1, $t2, $t3);

if (($iMaior1 % 34) > 0) {
    $iLinhas = (int) ($iMaior1 / 34);
    $iLinhas++;
} else {
    $iLinhas = (int) ($iMaior1 / 34);
}


//Cria bordas da tabela com base no tamanho do texto.
$pdf->Rect(3, $h, 67, 5 * $iLinhas);
$pdf->Rect(72, $h, 68, 5 * $iLinhas);
$pdf->Rect(142, $h, 67, 5 * $iLinhas);

//Preenche os dados
$pdf->MultiCell(67, 5, $row1['matprimades'], 0);
$pdf->SetXY($x + 69, $y);

$pdf->MultiCell(68, 5, $row1['maodeobrades'], 0);
$pdf->SetXY($x + 139, $y);

$pdf->MultiCell(67, 5, $row1['equipamentodes'], 0);

//*************Insere linhas que disponibiliza altura dos campos para não sobrepor aos demais
if ($row1['matprimades'] != '') {
    $pdf->Ln($iLinhas * 5);
} else if ($row1['maodeobrades'] != '') {
    $pdf->Ln($iLinhas * 5);
} else {
    $pdf->Ln($iLinhas);
}
//*******************//************************

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(67, 5, "Meio ambiente", 1, 0, 'C');
$pdf->Cell(2, 5, "", 0, 0, 'C');
$pdf->Cell(68, 5, "Método", 1, 0, 'C');
$pdf->Cell(2, 5, "", 0, 0, 'C');
$pdf->Cell(67, 5, "Medida", 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);

$x = $pdf->GetX();
$y = $pdf->GetY();

//strlen - Conta a quantidade de caracteres
$t4 = strlen($row1['meioambientedes']);
$t5 = strlen($row1['metododes']);
$t6 = strlen($row1['medidades']);

$iMaior2 = max($t4, $t5, $t6);

if (($iMaior2 % 34) > 0) {
    $iLinhas = (int) ($iMaior2 / 34);
    $iLinhas++;
} else {
    $iLinhas = (int) ($iMaior2 / 34);
}

//Cria bordas da tabela com base no tamanho do texto.
$pdf->Rect(3, $y, 67, 5 * $iLinhas);
$pdf->Rect(72, $y, 68, 5 * $iLinhas);
$pdf->Rect(142, $y, 67, 5 * $iLinhas);

//Preenche os dados
$pdf->MultiCell(67, 5, $row1['meioambientedes'], 0);
$pdf->SetXY($x + 69, $y);

$pdf->MultiCell(68, 5, $row1['metododes'], 0);
$pdf->SetXY($x + 139, $y);

$pdf->MultiCell(67, 5, $row1['medidades'], 0);

$pdf->Ln(5 * $iLinhas);
$pdf->Ln(5);

//###########################Análise dos Porquês#########################################
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Análise dos Porquês", 1, 1, 'C', TRUE);

$pdf->SetFont('Arial', '', 10);

$sSql = "select causades,pq1,pq2,pq3,pq4,pq5,seq from tbacaoqualcausa where nr=" . $nrAq . " and filcgc ='" . $filcgcAq . "' order by seq";
$dadosCausa = $PDO->query($sSql);

while ($row = $dadosCausa->fetch(PDO::FETCH_ASSOC)) {


    $arraySize = 0;
    foreach ($row as $key => $value) {
        if ($value != null) {
            $arraySize++;
        }
    }

    switch ($arraySize) {
        case 2:
            break;
        default:
            //Método que limpa as strings
            if (isset($row['causades'])) {
                $row['causades'] = limpaString($row['causades']);
            }
            if (isset($row['pq1'])) {
                $row['pq1'] = limpaString($row['pq1']);
            }
            if (isset($row['pq2'])) {
                $row['pq2'] = limpaString($row['pq2']);
            }
            if (isset($row['pq3'])) {
                $row['pq3'] = limpaString($row['pq3']);
            }
            if (isset($row['pq4'])) {
                $row['pq4'] = limpaString($row['pq4']);
            }
            if (isset($row['pq5'])) {
                $row['pq5'] = limpaString($row['pq5']);
            }

            //Conta quantidade de caracteres para definir Tamanho do campo
            $c1 = strlen($row['causades']);
            $p1 = strlen($row['pq1']);
            $p2 = strlen($row['pq2']);
            $p3 = strlen($row['pq3']);
            $p4 = strlen($row['pq4']);
            $p5 = strlen($row['pq5']);

            //Determina a quantidade de linhas de cada campo
            if (($c1 % 101) > 0) {
                $iL1 = (int) ($c1 / 99);
                $iL1++;
            } else {
                $iL1 = (int) ($c1 / 101);
            }
            if (($p1 % 101) > 0) {
                $iL2 = (int) ($p1 / 102);
                $iL2++;
            } else {
                $iL2 = (int) ($p1 / 101);
            }
            if (($p2 % 101) > 0) {
                $iL3 = (int) ($p2 / 102);
                $iL3++;
            } else {
                $iL3 = (int) ($p2 / 101);
            }
            if (($p3 % 101) > 0) {
                $iL4 = (int) ($p3 / 102);
                $iL4++;
            } else {
                $iL4 = (int) ($p3 / 101);
            }
            if (($p4 % 101) > 0) {
                $iL5 = (int) ($p4 / 102);
                $iL5++;
            } else {
                $iL5 = (int) ($p4 / 101);
            }
            if (($p5 % 101) > 0) {
                $iL6 = (int) ($p5 / 102);
                $iL6++;
            } else {
                $iL6 = (int) ($p5 / 101);
            }
            //Fim das variáveis que contém as quantidade de linhas de cada campo
            //Preenche os campos com os valores
            if (isset($row['causades'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL1 * 5, 'Causa', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', 'B', 10);
                $pdf->MultiCell(179, 5, $row['causades'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            if (isset($row['pq1'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL2 * 5, '1º Porque', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(179, 5, $row['pq1'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            if (isset($row['pq2'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL3 * 5, '2º Porque', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(179, 5, $row['pq2'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            if (isset($row['pq3'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL4 * 5, '3º Porque', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(179, 5, $row['pq3'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            if (isset($row['pq4'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL5 * 5, '4º Porque', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(179, 5, $row['pq4'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            if (isset($row['pq5'])) {
                $pdf->SetFont('Arial', 'B', 10);
                $x = $pdf->GetX();
                $y = $pdf->GetY();
                $pdf->MultiCell(27, $iL6 * 5, '5º Porque', 1, 'C');

                $pdf->SetXY($x + 27, $y);

                $pdf->SetFont('Arial', '', 10);
                $pdf->MultiCell(179, 5, $row['pq5'], 1, 'J');
                $pdf = quebraPagina($pdf->GetY(), $pdf);
            }

            $pdf->Ln(1);
    }
}
$pdf->Ln(5);


//###########################plano de ação#########################################
$pdf = quebraPagina($pdf->GetY(), $pdf);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Planos de ação", 1, 1, 'C', TRUE);
$pdf = quebraPagina($pdf->GetY(), $pdf);

$iConPlan = 0;
$sPlanAx = "";

$sSql = "select seq,plano,sitfim,convert(varchar,dataprev,103) as dataprev,usunome,anexoplan1, anexofim,convert(varchar,datafim,103) as datafim,obsfim "
        . " from tbacaoqualplan where nr=" . $nrAq . " and filcgc ='" . $filcgcAq . "' and tipo <> 'Eficiência' order by seq";
$dadosEf = $PDO->query($sSql);
while ($row = $dadosEf->fetch(PDO::FETCH_ASSOC)) {
    
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(206, 5, 'Ação Nº' . $row['seq'] . ' = ' . $row['plano'], 1, 'L');

    $pdf = quebraPagina($pdf->GetY(), $pdf);
    
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Quem:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(51, 5, $row['usunome'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Data prev.:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, $row['dataprev'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(25, 5, "Quando:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(40, 5, $row['datafim'], 1, 1, 'C');
 
    $pdf = quebraPagina($pdf->GetY(), $pdf);


    $pdf->MultiCell(206, 5, 'Obs. Final = ' . $row['obsfim'], 1, 'L');
    // $iAlturaAcao = $pdf->GetY();
    $pdf = quebraPagina($pdf->GetY(), $pdf);

    if ($row['sitfim'] == 'Finalizado') {

        $sSqlDocumentos = "select procedimento,it,planocontrole,fluxograma,ppap,contexto,preventiva,funcao,treinamento "
                . " from tbacaoqualplan where nr=" . $nrAq . " and filcgc ='" . $filcgcAq . "' and tipo <> 'Eficiência' and seq ='" . $row['seq'] . "' order by seq";
        $documentos = $PDO->query($sSqlDocumentos);
        $aRowDocumentos = $documentos->fetch(PDO::FETCH_ASSOC);

        $iCountString = 0;
        foreach ($aRowDocumentos as $key => $value) {
            if ($value == true) {
                $iCountString++;
            }
        }

        if ($iCountString > 0) {

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(206, 5, 'Documentos alterados pela Ação Nº' . $row['seq'], 1, 1, 'C', TRUE);
            $pdf = quebraPagina($pdf->GetY(), $pdf);

            $sDoc = '';

            if ($aRowDocumentos['procedimento'] == true) {
                $sProc = 'Procedimento';
                if ($iCountString > 1) {
                    $sProc = 'Procedimento, ';
                }
                $sDoc .= $sProc;
            }
            if ($aRowDocumentos['it'] == true) {
                $sIT = 'IT';
                if ($sDoc != '') {
                    $sIT = 'IT, ';
                    $sDoc .= $sIT;
                } else {
                    $sDoc .= $sIT;
                }
            }
            if ($aRowDocumentos['planocontrole'] == true) {
                $sPlanCont = 'Plano de Controle';
                if ($sDoc != '') {
                    $sPlanCont = 'Plano de Controle, ';
                    $sDoc .= $sPlanCont;
                } else {
                    $sDoc .= $sPlanCont;
                }
            }
            if ($aRowDocumentos['fluxograma'] == true) {
                $sFlux = 'Fluxograma';
                if ($sDoc != '') {
                    $sFlux = 'Fluxograma, ';
                    $sDoc .= $sFlux;
                } else {
                    $sDoc .= $sFlux;
                }
            }
            if ($aRowDocumentos['ppap'] == true) {
                $sPpap = 'PPAP';
                if ($sDoc != '') {
                    $sPpap = 'PPAP, ';
                    $sDoc .= $sPpap;
                } else {
                    $sDoc .= $sPpap;
                }
            }
            if ($aRowDocumentos['contexto'] == true) {
                $sContexto = 'Contexto da Organização';
                if ($sDoc != '') {
                    $sContexto = 'Contexto da Organização, ';
                    $sDoc .= $sContexto;
                } else {
                    $sDoc .= $sContexto;
                }
            }
            if ($aRowDocumentos['preventiva'] == true) {
                $sManutencao = 'Manutenção Preventiva';
                if ($sDoc != '') {
                    $sIT = 'Manutenção Preventiva, ';
                    $sDoc .= $sManutencao;
                } else {
                    $sDoc .= $sManutencao;
                }
            }
            if ($aRowDocumentos['funcao'] == true) {
                $sDescFunc = 'Descrição de Função';
                if ($sDoc != '') {
                    $sDescFunc = 'Descrição de Função, ';
                    $sDoc .= $sDescFunc;
                } else {
                    $sDoc .= $sDescFunc;
                }
            }
            if ($aRowDocumentos['treinamento'] == true) {
                $sContTreinamento = 'Controle de Treinamento';
                if ($sDoc != '') {
                    $sContTreinamento = 'Controle de Treinamento.';
                    $sDoc .= $sContTreinamento;
                } else {
                    $sDoc .= $sContTreinamento;
                }
            }

            $pdf->SetFont('Arial', '', 10);
            $pdf->MultiCell(206, 5, $sDoc, 1, 'J');
            $pdf->Ln(1);
            $pdf = quebraPagina($pdf->GetY(), $pdf);
        }
    }
    
    if($row['anexoplan1']!='' || $row['anexofim']){
       $iConPlan++;
       $sPlanAx = $sPlanAx.$row['seq'].", ";
    }
    $pdf->Ln(1);
}

$pdf->Ln(1);
if($iConPlan>0){
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(103, 5, "- Os planos de ação ".$sPlanAx." contém anexo.", 0, 1, 'L');
}
$pdf->Ln(1);

/* * ******************************AVALIAÇÃO DA EFICÁCIA******************************************************************************* */

$pdf = quebraPagina($pdf->GetY(), $pdf);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Avaliação da eficácia", 1, 1, 'C', TRUE);

$pdf = quebraPagina($pdf->GetY(), $pdf);
//$pdf->SetY($iAlturaAcao+12);

$iAlturaEfi = $pdf->GetY();

$sSql = "select seq,acao,convert(varchar,dataprev,103) as dataprev,"
        . "usunome,convert(varchar,datareal,103) as datareal,eficaz,obs,comAcao "
        . "from tbacaoeficaz where nr =" . $nrAq . " and filcgc ='" . $filcgcAq . "' order by seq";
$dadosEficaz = $PDO->query($sSql);

while ($row = $dadosEficaz->fetch(PDO::FETCH_ASSOC)) {

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Avaliação nº' . $row['seq'] . ': ' . $row['acao'], 1, 'L');

    $pdf = quebraPagina($pdf->GetY(), $pdf);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, "Quando:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(25, 5, $row['dataprev'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(17, 5, "Quem:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(41, 5, $row['usunome'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(20, 5, "Eficaz:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(20, 5, $row['eficaz'], 1, 0, 'C');

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(30, 5, "Data realizada:", 1, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(33, 5, $row['datareal'], 1, 1, 'C');

    $pdf = quebraPagina($pdf->GetY(), $pdf);

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Obs. apontamento = ' . $row['obs'], 1, 'L');

    $pdf = quebraPagina($pdf->GetY(), $pdf);

    if ($row['comAcao'] == 'S') {

        /* Mostra os planos de ação para esta ação da eficácia */
        $sSql = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,convert(varchar,datafim,103) as datafim"
                . " from tbacaoqualplan where nr=" . $nrAq . " and filcgc ='" . $filcgcAq . "' "
                . "and nrEfi ='" . $row['seq'] . "' order by seq"; //nr=".$nrAq." and filcgc ='".$filcgcAq."'
        $dadosEf = $PDO->query($sSql);
        while ($rowPlanEf = $dadosEf->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->Cell(206, 5, "Plano de ação da avaliação da eficácia nº " . $row['seq'] . "", 1, 1, 'C', true);
            $pdf->Cell(70, 5, "Responsável", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data prev.", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data realiz.", 1, 1, 'C', true);

            $pdf = quebraPagina($pdf->GetY(), $pdf);

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(70, 5, $rowPlanEf['usunome'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['dataprev'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['datafim'], 1, 1, 'C', true);

            $pdf = quebraPagina($pdf->GetY(), $pdf);

            $pdf->MultiCell(206, 5, 'Ação = ' . $rowPlanEf['plano'], 1, 'L', true);

            $pdf = quebraPagina($pdf->GetY(), $pdf);
        }
    }


    $pdf->SetY($pdf->GetY() + 2);
    $iAlturaEfi = $pdf->GetY();
}

// $pdf->Output();
if ($sEmailRequest == 'S') {
    $pdf->Output('F', 'app/relatorio/qualidade/Aq' . $nrAq . '_empresa_' . $filcgcAq . '.pdf');  // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'Aq' . $nrAq . '_empresa_' . $filcgcAq . '.pdf');
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
}

if ($sEmailRequest == 'S') {

    $oEmail = new Email();
    $oEmail->setMailer();
    $oEmail->setEnvioSMTP();
    //$oEmail->setServidor('mail.construtoramatosteixeira.com.br');
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

    if ($sEmailRequestTodos == 'S') {
        $sSqlEmail = "select emailEquip from tbacaoqual where nr =" . $nrAq . " and filcgc ='" . $filcgcAq . "'";
        $oRow = $PDO->query($sSqlEmail);
        $aDadosEmail = $oRow->fetch(PDO::FETCH_ASSOC);
        $sDadosEmail = $aDadosEmail['emailEquip'];
        $aEmail = explode(';', $sDadosEmail);
        foreach ($aEmail as $sCopia) {
            $oEmail->addDestinatario($sCopia);
        }
    } else {
        $oEmail->addDestinatario($_SESSION['email']);
    }

    $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $nrAq . '_empresa_' . $filcgcAq . '.pdf', utf8_decode('Aq nº' . $nrAq . '_empresa_' . $filcgcAq));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
    } else {
        $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
    }
    echo $oMensagem->getRender();
    return $aRetorno;
}

//Função que quebra página em uma dada altura do PDF
function quebraPagina($i, $pdf) {
    if ($i >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}

function limpaString($sString) {

    $sStringLimpa = str_replace("\n", " ", $sString);
    $sStringLimpa1 = str_replace("'", "\'", $sStringLimpa);
    $sStringLimpa2 = str_replace("\r", "", $sStringLimpa1);

    return $sStringLimpa2;
}

function montaCausaDes($row1, $nrAq, $filcgcAq) {
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select causa,causades "
            . "from tbacaoqualcausa "
            . "where nr ='" . $nrAq . "' and filcgc ='" . $filcgcAq . "'";
    $dadosCausa = $PDO->query($sSql);

    while ($aRow = $dadosCausa->fetch(PDO::FETCH_ASSOC)) {

        if ($aRow['causa'] == 'Método') {
            if ($row1['metododes'] == null) {
                $row1['metododes'] = limpaString($aRow['causades']);
            } else {
                $row1['metododes'] .= "- " . limpaString($aRow['causades']);
            }
        }


        if ($aRow['causa'] == 'Medida') {
            if ($row1['medidades'] == null) {
                $row1['medidades'] = limpaString($aRow['causades']);
            } else {
                $row1['medidades'] .= "- " . limpaString($aRow['causades']);
            }
        }


        if ($aRow['causa'] == 'Máquinas') {
            if ($row1['equipamentodes'] == null) {
                $row1['equipamentodes'] = limpaString($aRow['causades']);
            } else {
                $row1['equipamentodes'] .= "- " . limpaString($aRow['causades']);
            }
        }


        if ($aRow['causa'] == 'Matéria prima') {
            if ($row1['matprimades'] == null) {
                $row1['matprimades'] = limpaString($aRow['causades']);
            } else {
                $row1['matprimades'] .= "- " . limpaString($aRow['causades']);
            }
        }


        if ($aRow['causa'] == 'Meio ambiente') {
            if ($row1['meioambientedes'] == null) {
                $row1['meioambientedes'] = limpaString($aRow['causades']);
            } else {
                $row1['meioambientedes'] .= "- " . limpaString($aRow['causades']);
            }
        }


        if ($aRow['causa'] == 'Mão de obra') {
            if ($row1['maodeobrades'] == null) {
                $row1['maodeobrades'] = limpaString($aRow['causades']);
            } else {
                $row1['maodeobrades'] .= "- " . limpaString($aRow['causades']);
            }
        }
    }
    return $row1;
}
