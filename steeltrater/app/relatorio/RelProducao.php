<?php

// Diretórios
//require '../../biblioteca/fpdf/fpdf.php';
require('../../biblioteca/graficos/Grafico.php');
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage('L'); // ADICIONA UMA PAGINA
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

//Inserção do cabeçalho
$pdf->Cell(37, 15, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(110, 15, 'Relatório de Produção', '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora:' . $hora
        . ' Usuário:' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', '', 1, 'L');
$pdf->Cell(0, 5, '', 'T', 1, 'L');

//Inicio
//Pega data que o usuário digitou
$dtinicial = $_REQUEST['dataini'];
$dtfinal = $_REQUEST['datafinal'];

//Pega dados que passados pelo usuário na tela de relatório
$iEmpCodigo = $_REQUEST['emp_codigo'];
$sEmpDescricao = $_REQUEST['emp_razaosocial'];
$sFornodes = $_REQUEST['fornodes'];
$iFornoCod = $_REQUEST['fornocod'];
$sTurnoSteel = $_REQUEST['turnoSteel'];
$sListaEtapa = '';
if (isset($_REQUEST['listaEtapa'])) {
    $sListaEtapa = $_REQUEST['listaEtapa'];
}
$bRes = true;
if (isset($_REQUEST['resumido'])) {
    $bRes = false;
}

//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "select STEEL_PCP_ordensFabApont.op,STEEL_PCP_ordensFabApont.fornodes, STEEL_PCP_ordensFabApont.fornocod, steel_pcp_ordensfabapont.turnoSteel,
               STEEL_PCP_ordensFabApont.prodes,convert(varchar,steel_pcp_ordensfabapont.dataent_forno,103)as dataent_forno,
               convert(varchar,steel_pcp_ordensfabapont.horaent_forno,8)as horaent_forno,
               convert(varchar,steel_pcp_ordensfabapont.datasaida_forno,103)as datasaida_forno,
               convert(varchar,steel_pcp_ordensfabapont.horasaida_forno,8)as horasaida_forno,STEEL_PCP_ordensFab.peso,quant,documento,
               STEEL_PCP_ordensFab.situacao,steel_pcp_ordensfab.emp_razaosocial,emp_pessoa.emp_fantasia,convert(varchar,data,103)as data,
               steel_pcp_ordensfabapont.dataent_forno as dataent_forno2,tratdes, SUBSTRING(steel_pcp_ordensfabapont.usernome, 1,16) as userEntrada,
               DATEDIFF(Minute,steel_pcp_ordensfabapont.horaent_forno,steel_pcp_ordensfabapont.horasaida_forno) as minutosh,
               DATEDIFF(minute,steel_pcp_ordensfabapont.dataent_forno, steel_pcp_ordensfabapont.datasaida_forno) as minutosd,
               eficienciaHora,
               DATEDIFF(minute,'" . $dtinicial . "', '" . $dtfinal . "') as diferencaFiltro
               from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op left outer join steel_pcp_ordensfabitens
               on STEEL_PCP_ordensFab.op = steel_pcp_ordensfabitens.op and steel_pcp_ordensfabitens.opseq = 1 left outer join steel_pcp_tratamentos
	       on steel_pcp_ordensfabitens.tratamento = steel_pcp_tratamentos.tratcod left outer join emp_pessoa
	       on steel_pcp_ordensfab.emp_codigo = emp_pessoa.emp_codigo
               where steel_pcp_ordensfabapont.dataent_forno between '" . $dtinicial . "' and '" . $dtfinal . "'";
if ($iEmpCodigo !== '') {
    $sSqli .= " and steel_pcp_ordensfab.emp_codigo ='" . $iEmpCodigo . "'";
}
if ($iFornoCod !== '') {
    $sSqli .= " and STEEL_PCP_ordensFabApont.fornocod ='" . $iFornoCod . "'";
}
if ($sTurnoSteel != 'Todos') {
    $sSqli .= " and steel_pcp_ordensfabapont.turnoSteel = '" . $sTurnoSteel . "' ";
}

$sSqli .= " and STEEL_PCP_ordensFabApont.situacao='Finalizado' ";

$sSqli .= " and retrabalho<>'Retorno não Ind.' ";


$sSqli .= "order by dataent_forno2, STEEL_PCP_ordensFabApont.fornodes, steel_pcp_ordensfabapont.turnoSteel, horaent_forno";

$dadosRela = $PDO->query($sSqli);

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 10, 'Filtros escolhidos:', '', 0, 'L', 0);

if ($sFornodes == null) {
    $sFornodes = 'Todos';
}
if ($iEmpCodigo == null) {
    $iEmpCodigo = 'Todos';
    $sEmpDescricao = 'Todos';
}
$sEmpDescricao = substr($sEmpDescricao, 0, 58) . '.';
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 10, 'Data inicial: ' . $dtinicial .
        '   Data final: ' . $dtfinal .
        '   Forno: ' . $sFornodes .
        '   Cliente: ' . $iEmpCodigo .
        '   Razão Social: ' . $sEmpDescricao .
        ' ', '', 1, 'L', 0);

$pdf->Cell(0, 3, '', '', 1, 'L');

$Pesototal = 0;
$Quanttotal = 0;
if ($bRes) {
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(17, 5, 'OP', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(18, 5, 'DATA OP', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(21, 5, 'DT ENTRADA', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(20, 5, 'H. ENTRADA', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(19, 5, 'DT SAIDA', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(17, 5, 'H. SAIDA', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(22, 5, 'TURNO', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(29, 5, 'EQUIPAMENTO', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(43, 5, 'SERVIÇO', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(63, 5, 'CLIENTE', 'B,T,L,R', 0, 'C', 0);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(15, 5, 'PESO', 'B,T,L,R', 1, 'C', 0);
}
$aPesoEficEq = array();
$aPesoEq = array();
$aPesoTur = array();
$iPesoT1 = 0;
$iPesoT2 = 0;
$iPesoT3 = 0;
$iPesoT4 = 0;
$iPesoG = 0;
$iPesoF = 0;

$sForno = '';
$sTurno = '';

while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {
    //IF que realiza contagem de peso para os gráficos
    if (($sForno == '' || $sForno != $row['fornodes']) && !isset($aPesoEq[$row['fornodes']])) {
        $aPesoEq[$row['fornodes']] = [$row['peso'], $row['fornodes']];
        $aPesoEficEq[$row['fornodes']] = [$row['peso'], $row['fornodes'], $row['minutosd'] + $row['minutosh'], (float) number_format($row['eficienciaHora'], 2, ',', '.'), $row['fornocod']];
    } else {
        $aPesoEq[$row['fornodes']] = [$aPesoEq[$row['fornodes']][0] + $row['peso'], $row['fornodes']];
        $aPesoEficEq[$row['fornodes']] = [$aPesoEficEq[$row['fornodes']][0] + $row['peso'], $row['fornodes'], $aPesoEficEq[$row['fornodes']][2] + ($row['minutosd'] + $row['minutosh']), (float) number_format($row['eficienciaHora'], 2, ',', '.'), $row['fornocod']];
    }

    $sForno = $row['fornodes'];
    if ($bRes) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(17, 5, $row['op'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 5, $row['data'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(21, 5, $row['dataent_forno'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(20, 5, $row['horaent_forno'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(19, 5, $row['datasaida_forno'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(17, 5, $row['horasaida_forno'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(22, 5, $row['turnoSteel'], 'B,T,L,R', 0, 'C');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(29, 5, $row['fornodes'], 'B,T,L,R', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(43, 5, $row['tratdes'], 'B,T,L,R', 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(63, 5, $row['emp_fantasia'], 'B,T,L,R', 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(15, 5, number_format($row['peso'], 2, ',', '.'), 'B,T,L,R', 1, 'R');
    }
    $Pesototal = ($row['peso'] + $Pesototal);

    if (!isset($aPesoTur[$row['turnoSteel']])) {
        $aPesoTur[$row['turnoSteel']] = [$row['peso'], $row['turnoSteel']];
    } else {
        $aPesoTur[$row['turnoSteel']] = [$aPesoTur[$row['turnoSteel']][0] + $row['peso'], $row['turnoSteel']];
    }
    $nTempFiltroH = $row['diferencaFiltro'] / 60;
}

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 2, '', '', 1, 'C');
if ($bRes) {
    $pdf->Cell(200, 2, '', '', 0, 'C');
    $pdf->Cell(90, 5, '', 'B', 1, 'L');
    $pdf->Cell(230, 2, '', '', 0, 'C');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(99, 8, 'Peso Total: ' . number_format($Pesototal, 2, ',', '.'), '', 1, 'J');
} else {
    $pdf->Cell(80, 5, '', 'B', 1, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(99, 8, 'Peso Total Produzido: ' . number_format($Pesototal, 2, ',', '.'), '', 1, 'J');
}
$pdf->Ln(5);

$pdf->Cell(279, 8, 'Tabela de Eficiência:', 'B', 1, 'J');

$pdf->Cell(25, 5, 'Equipamento', 'B', 0, 'R');
$pdf->Cell(33, 5, 'Eficiencia fixa', 'B', 0, 'R');
$pdf->Cell(48, 5, 'Produção no período', 'B', 0, 'R');
$pdf->Cell(51, 5, 'Projeção S/H. paradas', 'B', 0, 'R');
$pdf->Cell(51, 5, 'Projeção C/H. paradas', 'B', 0, 'R');
$pdf->Cell(40, 5, 'Total H. Paradas', 'B', 0, 'R');
$pdf->Cell(31, 5, 'Eficiência(%)', 'B', 1, 'R');
$pdf->Ln(2);
if (isset($nTempFiltroH)) {
    if ($nTempFiltroH == 0) {
        $nTempFiltroH = 24;
    }
} else {
    $nTempFiltroH = 24;
}

$nEficiencia = 0;
//Apresenta a tabela de eficiencia por equipamento
foreach ($aPesoEficEq as $key) {
    $nTempFiltroH1 = $nTempFiltroH;
    $sSqlh = "SELECT sum(horasparadas) AS totalhoras FROM STEEL_PCP_HorasParadas "
            . "WHERE "
            . "dataini between '" . $dtinicial . "' AND '" . $dtfinal . "' "
            . "and datafim between '" . $dtinicial . "' AND '" . $dtfinal . "' "
            . "and fornocod ='" . $key[4] . "'";
    $dadosHora = $PDO->query($sSqlh);
    $rowH = $dadosHora->fetch(PDO::FETCH_ASSOC);

    if ($rowH != null) {
        $nTempFiltroH1 = $nTempFiltroH1 - $rowH['totalhoras'];
        $iHorasTotal = $rowH['totalhoras'];
        if ($iHorasTotal >= 24) {
            $qDias = (int) ($iHorasTotal / 24);
            $qHoras = (int) ($iHorasTotal % 24);
            $qMin = round(((($iHorasTotal - ($qDias * 24)) - $qHoras) * 60), 0);
            $sTempoParada = $qDias . " dia(s) " . $qHoras . "h(s) e " . $qMin . "min.";
        } else {
            if ($iHorasTotal < 24 && $iHorasTotal >= 1) {
                $qHoras = (int) ($iHorasTotal);
                $qMin = round((($iHorasTotal - $qHoras) * 60), 0);
                $sTempoParada = $qHoras . "h(s) e " . $qMin . "min.";
            } else {
                $qMin = (int) (($iHorasTotal) * 60);
                $sTempoParada = $qMin . " minutos";
            }
        }
    } else {
        $sTempoParada = '';
    }
    if ($key[3] != 0) {
        $nEfDias = ($nTempFiltroH1) * $key[3];
        $nEficiencia = ($key[0] / $nEfDias) * 100;
    }

    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(25, 5, '  ' . $key[1], '', 0, 'R');
    $pdf->Cell(33, 5, '  ' . number_format($key[3], 2, ',', '.') . 'Kg/H', '', 0, 'R');
    $pdf->Cell(48, 5, '  ' . number_format($key[0], 2, ',', '.') . 'Kg', '', 0, 'R');
    $pdf->Cell(51, 5, '  ' . number_format($key[3] * $nTempFiltroH, 2, ',', '.') . 'Kg', '', 0, 'R');
    $pdf->Cell(51, 5, '  ' . number_format($key[3] * $nTempFiltroH1, 2, ',', '.') . 'Kg', '', 0, 'R');
    $pdf->Cell(40, 5, '  ' . $sTempoParada, '', 0, 'R');
    $pdf->Cell(31, 5, '  ' . number_format($nEficiencia, 2, ',', '.') . '%', '', 1, 'R');
    $pdf->Cell(279, 2, '', 'T', 1, 'L');
}

$pdf->Ln(10);

$aVal3 = array();
$corTurno = array();
$iCor1 = 0;
$iCor2 = 0;
$iCor3 = 0;
//Prepara array pesoturno para gráfico e array de cores
foreach ($aPesoTur as $key) {
    $aVal3 = array_merge(array($key[1] => $key[0]), $aVal3);
    array_push($corTurno, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
    if ($iCor1 < 255) {
        $iCor1 = $iCor1 + 128;
    } else {
        if ($iCor2 < 255) {
            $iCor2 = $iCor2 + 128;
            $iCor1 = 0;
        } else {
            if ($iCor3 < 255) {
                $iCor3 = $iCor3 + 128;
                $iCor1 = 0;
                $iCor2 = 0;
            }
        }
    }
}

$aVal2 = array();
$corForno = array();
$iCor1 = 0;
$iCor2 = 0;
$iCor3 = 0;
//Prepara array pesoequipamento para gráfico e array de cores
foreach ($aPesoEq as $key) {
    $aVal2 = array_merge(array($key[1] => $key[0]), $aVal2);
    array_push($corForno, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
    if ($iCor1 < 255) {
        $iCor1 = $iCor1 + 128;
    } else {
        if ($iCor2 < 255) {
            $iCor2 = $iCor2 + 128;
            $iCor1 = 0;
        } else {
            if ($iCor3 < 255) {
                $iCor3 = $iCor3 + 128;
                $iCor1 = 0;
                $iCor2 = 0;
            }
        }
    }
}

$iQnt = count($aPesoTur);
//Gráfico Peso por turno
$pdf->AddPage();
$pdf->SetY(10);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '1 - Produção por turno em (Kg)', 0, 1);
$pdf->Ln(5);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
arsort($aVal3);

if ($iQnt != null) {
    //Gráfico peso por turno
    $pdf->SetXY(10, $valY);
    $pdf->BarDiagram(195, $iQnt * 8, $aVal3, '%l : %v (%p)', $corTurno, 0, 3);
    $pdf->SetXY($valX, $valY + 45);
}


$iQnt1 = count($aPesoEq);
//Gráfico Peso por turno
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '2 - Produção por forno em (Kg)', 0, 1);
$pdf->Ln(5);
$valX = $pdf->GetX();
$valY = $pdf->GetY();
arsort($aVal2);

if ($iQnt != null) {
    //Gráfico de produção por forno
    $pdf->SetXY(10, $valY);
    $pdf->BarDiagram(195, $iQnt1 * 8, $aVal2, '%l : %v (%p)', $corForno, 0, 3);
    $pdf->SetXY($valX, $valY + 70);
}


$pdf->Output('I', 'RelProducao.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 