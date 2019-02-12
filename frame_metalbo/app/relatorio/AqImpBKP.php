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
    $Filcgc = $_REQUEST['filcgcAq'];
    $nrAq = $_REQUEST['nrAq'];
} else {
    if (isset($_REQUEST['nr'])) {
        $nrAq = $_REQUEST['nr'];
        $Filcgc = $_REQUEST['EmpRex_filcgc'];
    } else {
        $nrAq = '0';
        $Filcgc = '0';
    }
}

//tratar se tem avaliação aberta ou nao
$PDO2 = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select COUNT(*)as total from tbacaoeficaz where nr = '" . $nrAq . "' and filcgc ='" . $Filcgc . "'";
$dadosSql = $PDO2->query($sSql);
$eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);

if ($eficaz['total'] == 0) {
    $avFim = 'aberta';
} else {
    /* ver se tem alguma aberta sem apontamento */
    $PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = " select COUNT(*) total2 from tbacaoeficaz where nr = '" . $nrAq . "' and eficaz <> 'Sim' and filcgc ='" . $Filcgc . "'";
    $dadosSql = $PDO->query($sSql);
    $eficaz = $dadosSql->fetch(PDO::FETCH_ASSOC);
    if ($eficaz['total2'] > 0) {
        $avFim = 'aberta';
    } else {
        $avFim = 'fechada';
    }
}


$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE

$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//dados do cabeçalho
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
    $sSql = "select certificacao,userimp,convert(varchar,dtimp,103) as dtimp,titulo,usunome,equipe,convert(varchar,dataini,103) as dataini, "
        . "convert(varchar,datafim,103) as datafim,tipoacao,origem,tipmelhoria,problema,objetivo,tipocausa,desctipocausa,"
        . "pq1,pq2,pq3,pq4,pq5 "
        . " from tbacaoqual where filcgc ='" . $Filcgc . "' and nr=" . $nrAq;
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

$pdf->Ln(5);

//############################### Conteção/Abrangência #######################################

$sSqlContencao = "select COUNT(*) as total "
        . "from MET_QUAL_Contencao "
        . "where filcgc = '" . $Filcgc . "' and nr ='" . $nrAq . "'";
$iContecao = $PDO->query($sSqlContencao);
$existeContencao = $iContecao->fetch(PDO::FETCH_ASSOC);

if ($existeContencao['total'] > 0) {
    $sSqlDadosContencao = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,situaca "
            . "from MET_QUAL_Contencao "
            . "where filcgc = '" . $Filcgc . "' and nr ='" . $nrAq . "'";
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
    }
}

$pdf->Ln(5);

//############################### Correção #######################################

$sSqlContencao = "select COUNT(*) as total "
        . "from MET_QUAL_Correcao "
        . "where filcgc = '" . $Filcgc . "' and nr ='" . $nrAq . "'";
$iCorrecao = $PDO->query($sSqlContencao);
$existeCorrecao = $iCorrecao->fetch(PDO::FETCH_ASSOC);

if ($existeCorrecao['total'] > 0) {
    $sSqlDadosCorrecao = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,situaca "
            . "from MET_QUAL_Correcao "
            . "where filcgc = '" . $Filcgc . "' and nr ='" . $nrAq . "'";
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
    }
}


//########################### causa raiz do problema #########################################

$pdf->Ln(5);

$sSqlC = "select matprimades, metododes, maodeobrades, "
        . "equipamentodes, meioambientedes, medidades"
        . " from MET_QUAL_DiagramaCausa where nr='" . $nrAq . "' and filcgc ='" . $Filcgc . "' ";
$dadosCausa1 = $PDO->query($sSqlC);
$row1 = $dadosCausa1->fetch(PDO::FETCH_ASSOC);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Causa raiz do problema", 1, 1, 'C', TRUE);

$pdf->SetFont('Arial', '', 10);
if ($row1['matprimades'] != null) {
    $pdf->MultiCell(206, 5, 'Materia Prima = ' . $row1['matprimades'], 1, 'L');
}
if ($row1['maodeobrades'] != null) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Mão de Obra = ' . $row1['maodeobrades'], 1, 'L');
}
if ($row1['equipamentodes'] != null) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Maquinas = ' . $row1['equipamentodes'], 1, 'L');
}
if ($row1['meioambientedes'] != null) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Meio ambiente: ' . $row1['meioambientedes'], 1, 'L');
}
if ($row1['metododes'] != null) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Método = ' . $row1['metododes'], 1, 'L');
}
if ($row1['medidades']) {
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Medida = ' . $row1['medidades'], 1, 'L');
}

$pdf->Ln(5);
////////////////////////////////////////////////////////////////////////////////////////////

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Análise dos Porquês", 1, 1, 'C', TRUE);

$sAlturaInicial = $pdf->GetY();
$pdf->SetY($sAlturaInicial);
$pdf->SetFont('Arial', '', 10);
$iAlturaCausa = $sAlturaInicial;
$l = 5;

$sSql = "select causades,pq1,pq2,pq3,pq4,pq5,seq from tbacaoqualcausa where nr=" . $nrAq . " and filcgc ='" . $Filcgc . "' order by seq";
$dadosCausa = $PDO->query($sSql);

while ($row = $dadosCausa->fetch(PDO::FETCH_ASSOC)) {

    if ($iAlturaCausa >= 270) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaCausa = 10;
    }

    if (isset($row['causades'])) {
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->MultiCell(206, 5, 'Causa = ' . $row['causades'], 1, 'J');
    }
    if (isset($row['pq1'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '1º Porque = ' . $row['pq1'], 1, 'J');
    }
    if (isset($row['pq2'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '2º Porque = ' . $row['pq2'], 1, 'J');
    }
    if (isset($row['pq3'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '3º Porque = ' . $row['pq3'], 1, 'J');
    }
    if (isset($row['pq4'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '4º Porque = ' . $row['pq4'], 1, 'J');
    }
    if (isset($row['pq5'])) {
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, '5º Porque = ' . $row['pq5'], 1, 'J');
    }
    $pdf->Ln(1);
    $iAlturaCausa = $pdf->GetY() + 5;
}


//$pdf->Cell(0,5,"","B",1,'C');
//###########################plano de ação#########################################

$pdf->SetY($iAlturaCausa);
$iAlturaAcao = $iAlturaCausa;
$l = 5;

if ($iAlturaAcao + $l >= 270) {    // 275 é o tamanho da página
    $pdf->AddPage();   // adiciona se ultrapassar o limite da página
    $pdf->SetY(10);
    $iAlturaAcao = 10;
}

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Planos de ação", 1, 1, 'C', TRUE);



//$iAlturaCausa = $iAlturaCausa + 10;
//$pdf->SetY($iAlturaCausa);
//$iAlturaAcao = $iAlturaCausa;


$sSql = "select seq,plano,sitfim,convert(varchar,dataprev,103) as dataprev,usunome,convert(varchar,datafim,103) as datafim,procedimento,it,planocontrole,fluxograma,ppap,contexto,preventiva,funcao,treinamento,obsfim "
        . " from tbacaoqualplan where nr=" . $nrAq . " and filcgc ='" . $Filcgc . "' and tipo <> 'Eficiência' order by seq";
$dadosEf = $PDO->query($sSql);
while ($row = $dadosEf->fetch(PDO::FETCH_ASSOC)) {

    $pdf->Cell(70, 5, "Responsável", 1, 0, 'C', true);
    $pdf->Cell(68, 5, "Data prev.", 1, 0, 'C', true);
    $pdf->Cell(68, 5, "Data realiz.", 1, 1, 'C', true);

    if ($iAlturaAcao >= 260) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaAcao = 10;
    }
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(70, 5, $row['usunome'], 1, 0, 'C');
    $pdf->Cell(68, 5, $row['dataprev'], 1, 0, 'C');
    $pdf->Cell(68, 5, $row['datafim'], 1, 1, 'C');
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->MultiCell(206, 5, 'Ação ' . $row['seq'] . ' = ' . $row['plano'], 1, 'L');
    $pdf->MultiCell(206, 5, 'Obs. Final = ' . $row['obsfim'], 1, 'L');
    $iAlturaAcao = $pdf->GetY();

    if ($row['sitfim'] == 'Finalizado') {

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(206, 5, 'Documentos alterados pelo plano de ação ' . $row['seq'], 1, 1, 'C', TRUE);

        $sDoc = '';

        if ($row['procedimento'] == true) {
            $sProc = ' Procedimento';
            $sDoc .= $sProc;
        }
        if ($row['it'] == true) {
            $sIT = ' IT';
            if ($sDoc != ' ') {
                $sIT = ', IT';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['planocontrole'] == true) {
            $sPlanCont = 'Plano de Controle';
            if ($sDoc != ' ') {
                $sIT = ', Plano de Controle';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['fluxograma'] == true) {
            $sFlux = 'Fluxograma';
            if ($sDoc != ' ') {
                $sIT = ', Fluxograma';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['ppap'] == true) {
            $sPpap = 'PPAP';
            if ($sDoc != ' ') {
                $sIT = ', PPAP';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['contexto'] == true) {
            $sContexto = 'Contexto da Organização';
            if ($sDoc != ' ') {
                $sIT = ', Contexto da Organização';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['preventiva'] == true) {
            $sMant = 'Manutenção Preventiva';
            if ($sDoc != ' ') {
                $sIT = ', Manutenção Preventiva';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['funcao'] == true) {
            $sDescFunc = 'Descrição de Função';
            if ($sDoc != ' ') {
                $sIT = ', Descrição de Função';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }
        if ($row['treinamento'] == true) {
            $sContTreinamento = 'Controle de Treinamento';
            if ($sDoc != ' ') {
                $sIT = ', IT';
                $sDoc .= $sIT;
            } else {
                $sDoc .= $sIT;
            }
        }

        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(206, 5, $sDoc, 1, 'J');
        $pdf->Ln(1);
    }
}

/* * ******************************AVALIAÇÃO DA EFICÁCIA******************************************************************************* */
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(206, 5, "Avaliação da eficácia", 1, 1, 'C', TRUE);

//$pdf->SetY($iAlturaAcao+12);

$iAlturaEfi = $pdf->GetY();
$l = 5;

$sSql = "select seq,acao,convert(varchar,dataprev,103) as dataprev,"
        . "usunome,convert(varchar,datareal,103) as datareal,eficaz,obs,comAcao "
        . "from tbacaoeficaz where nr =" . $nrAq . " and filcgc ='" . $Filcgc . "' order by seq";
$dadosEficaz = $PDO->query($sSql);

while ($row = $dadosEficaz->fetch(PDO::FETCH_ASSOC)) {

    if ($iAlturaEfi + $l >= 265) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
        $iAlturaEfi = 10;
    }

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Avaliação nº' . $row['seq'] . ': ' . $row['acao'], 1, 'L');

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

    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(206, 5, 'Obs. apontamento = ' . $row['obs'], 1, 'L');

    if ($row['comAcao'] == 'S') {

        /* Mostra os planos de ação para esta ação da eficácia */
        $sSql = "select plano,convert(varchar,dataprev,103) as dataprev,usunome,convert(varchar,datafim,103) as datafim"
                . " from tbacaoqualplan where nr=" . $nrAq . " and filcgc ='" . $Filcgc . "' "
                . "and nrEfi ='" . $row['seq'] . "' order by seq"; //nr=".$nrAq." and filcgc ='".$Filcgc."'
        $dadosEf = $PDO->query($sSql);
        while ($rowPlanEf = $dadosEf->fetch(PDO::FETCH_ASSOC)) {
            $pdf->SetY($pdf->GetY() + 2);
            $pdf->Cell(206, 5, "Plano de ação da avaliação da eficácia nº " . $row['seq'] . "", 1, 1, 'C', true);
            $pdf->Cell(70, 5, "Responsável", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data prev.", 1, 0, 'C', true);
            $pdf->Cell(68, 5, "Data realiz.", 1, 1, 'C', true);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(70, 5, $rowPlanEf['usunome'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['dataprev'], 1, 0, 'C', true);
            $pdf->Cell(68, 5, $rowPlanEf['datafim'], 1, 1, 'C', true);
            $pdf->MultiCell(206, 5, 'Ação = ' . $rowPlanEf['plano'], 1, 'L', true);
        }
    }


    $pdf->SetY($pdf->GetY() + 2);
    $iAlturaEfi = $pdf->GetY();
}

// $pdf->Output();
if ($sEmailRequest == 'S') {
    $pdf->Output('F', 'app/relatorio/qualidade/Aq' . $nrAq . '_empresa_' . $Filcgc . '.pdf');  // GERA O PDF NA TELA
    Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
} else {
    $pdf->Output('I', 'Aq' . $nrAq . '_empresa_' . $Filcgc . '.pdf');
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

    $oEmail->setAssunto(utf8_decode('Ação da qualidade nº' . $nrAq . ' da empresa ' . $Filcgc));
    $oEmail->setMensagem(utf8_decode('Anexo ação da qualidade nº' . $nrAq . ' da empresa ' . $Filcgc . ' da qual você está envolvido. '
                    . ' Verifique a ação em anexo para ficar por dentro dos detalhes!'));
    $oEmail->limpaDestinatariosAll();

    // Para

    if ($sEmailRequestTodos == 'S') {
        $sSqlEmail = "select emailEquip from tbacaoqual where nr =" . $nrAq . " and filcgc ='" . $Filcgc . "'";
        $oRow = $PDO->query($sSqlEmail);
        $aDadosEmail = $oRow->fetch(PDO::FETCH_ASSOC);
        $sDadosEmail = $aDadosEmail['emailEquip'];
        $aEmail = explode(',', $sDadosEmail);
        foreach ($aEmail as $sCopia) {
            $oEmail->addDestinatario($sCopia);
        }
    } else {
        $oEmail->addDestinatario($_SESSION['email']);
    }

    $oEmail->addAnexo('app/relatorio/qualidade/Aq' . $nrAq . '_empresa_' . $Filcgc . '.pdf', utf8_decode('Aq nº' . $nrAq . '_empresa_' . $Filcgc));
    $aRetorno = $oEmail->sendEmail();
    if ($aRetorno[0]) {
        $oMensagem = new Mensagem('E-mail', 'E-mail enviado com sucesso!', Mensagem::TIPO_SUCESSO);
    } else {
        $oMensagem = new Modal('E-mail', 'Problemas ao enviar o email, relate isso ao TI da Metalbo - ' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
    }
    echo $oMensagem->getRender();
    return $aRetorno;
}