<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
include("../../includes/Config.php");
date_default_timezone_set('America/Sao_Paulo');

//Variaveis auxiliares
$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
$sTipo = $_REQUEST['tipo'];
$sSubtipo = $_REQUEST['subtipo_nome'];
$sRep = $_REQUEST['repr'];
$sEmpresa = $_REQUEST['empresa'];
$sDataIni = $_REQUEST['dataini'];
$sDataFin = $_REQUEST['datafinal'];
$sSit = $_REQUEST['sit'];
$sCodSetor = $_REQUEST['setor'];
if (isset($_REQUEST['usunome'])) {
    $sUsuario = $_REQUEST['usunome'];
} else {
    $sUsuario = '';
}
if (isset($_REQUEST['relant'])) {
    $bRelAnt = $_REQUEST['relant'];
    $sTipo = $_REQUEST['tipoant'];
    $sSit = $_REQUEST['sitant'];
} else {
    $bRelAnt = false;
}
$bGrafico = false;
if (isset($_REQUEST['apgrafico'])) {
    $bGrafico = true;
}

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE
$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

if (!$bRelAnt) {
//cabeçalho
    $pdf->SetMargins(3, 0, 3);
    $pdf->SetFont('Arial', 'B', 15);
// Move to the right
    $pdf->Cell(45);
// Title
    $pdf->Cell(120, 10, 'Relatório Chamados TI', 0, 0, 'C');

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->Ln(15);
    $pdf->Cell(0, 0, "", "B", 1, 'C');
    $pdf->Ln(3);

    $sql = "select convert(varchar,datacad,103) as datacad1, convert(varchar,datafim,103) as datafim1,SUBSTRING(usunome, 1, 20) AS usunome1, * from MET_TEC_Chamados ";

    $sql .= " left outer join widl.emp01 on MET_TEC_Chamados.filcgc = widl.emp01.empcod "
            . " where datacad between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($sCodSetor != 'Todos') {
        $sql .= " and MET_TEC_Chamados.setor =" . $sCodSetor . " ";
    }
    if ($sTipo != 'Todos') {
        $sql .= " and tipo = " . $sTipo;
    }
    if ($sSubtipo != 'Todos') {
        $sql .= " and  subtipo_nome = '" . $sSubtipo . "'";
    }
    if ($sRep != 'Todos' && $sRep != null) {
        $sql .= " and repoffice = '" . $sRep . "'";
    }
    if ($sEmpresa != 'Todos') {
        $sql .= " and  filcgc = '" . $sEmpresa . "' ";
    }
    if ($sUsuario != 'Todos') {
        $sql .= " and usunome like '%" . $sUsuario . "%'";
    }
    if ($sSit != 'Todos') {
        $sql .= " and situaca = '" . $sSit . "'";
    }
    $sql .= " order by filcgc , repoffice, nr ";
    $sth = $PDO->query($sql);
//Variáveis de Contagem dos gráficos e totalizadores
    $iCont = 0;
    $iContEmp = 0;
    $iEmp = '';
    $aEmp = array();
    $iContRep = 0;
    $aRep = array();
    $iRepTotal = 0;
    $aEmp['Representantes'] = [0, 'Representantes', 'REPRESENTANTES'];
    $aSubTip = array();
    $aSit = array();
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

        //Cabeçalho - Empresa
        $iFilcgc = $row['filcgc'];
        if ($iFilcgc != $iEmp) {
            $iContEmp = 0;
            $aEmp[$row['filcgc'] . $row['empdes']] = 0;
            if (!$bGrafico) {
                $pdf->Ln(3);
                $pdf->SetTextColor(0, 0, 156);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(204, 5, $row['filcgc'] . " - " . $row['empdes'], "B", 1, 'L');
                $pdf->Ln(2);
            }
            $iEmp = $row['filcgc'];
        }

        //Representante
        if ($row['repoffice'] != null && $row['repoffice'] != $sRep && $row['repoffice'] != 'METALBOF' && $row['repoffice'] != 'POLIAMIDOS') {
            if (!$bGrafico) {
                $pdf->Ln(1);
                $pdf->SetTextColor(66, 111, 66);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->SetFillColor(200, 200, 200);
                $pdf->MultiCell(204, 5, 'REPRESENTANTE:  ' . $row['repoffice'], 1, 'L', true);
                $pdf->Ln(1);
            }
            $sRep = $row['repoffice'];
            $iContRep = 0;
        }
        if (!$bGrafico) {
            //Contador de caracteres da descrição do problema para quebra de página
            $var = strlen($row['problema']);
            if ($var != 0) {
                $q = round($var / 160) + 5;
                $pdf = quebraPagina($pdf->GetY() + 5 * $q, $pdf);
            } else {
                $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
            }

            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, 'NÚMERO', "L,T", 0, 'L');
            $pdf->Cell(46, 5, 'USUÁRIO QUE ABRIU', "L,T", 0, 'L');
            $pdf->Cell(25, 5, 'DT ABERTURA', "L,T", 0, 'L');
            $pdf->Cell(46, 5, 'RESPONSÁVEL POR INICIAR', "L,T", 0, 'L');
            $pdf->Cell(47, 5, 'RESPONSÁVEL POR FINALIZAR', "L,T", 0, 'L');
            $pdf->Cell(25, 5, 'DT FINALIZADO', "L,T,R", 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(15, 5, $row['nr'], "T,R,L", 0, 'L');
            $pdf->Cell(46, 5, $row['usunome1'], "T,R", 0, 'L');
            $pdf->Cell(25, 5, $row['datacad1'], "T,R", 0, 'L');
            $pdf->Cell(46, 5, $row['usunomeinicio'], "T,R", 0, 'L');
            $pdf->Cell(47, 5, $row['usunomefim'], "T,R", 0, 'L');
            $pdf->Cell(25, 5, $row['datafim1'], "T,L,R", 1, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(204, 5, "Problema: " . $row['problema'], 1, 'L');
            $pdf->Ln(2);
        }
        $iCont++;
        $iContRep++;
        if (!isset($aSubTip[$row['subtipo_nome']])) {
            $aSubTip[$row['subtipo_nome']] = [1, $row['subtipo_nome']];
        } else {
            $aSubTip[$row['subtipo_nome']] = [$aSubTip[$row['subtipo_nome']][0] = $aSubTip[$row['subtipo_nome']][0] + 1, $row['subtipo_nome']];
        }
        //Contador de Chamados por representantes
        if ($row['repoffice'] == '' || $row['repoffice'] == null || $row['repoffice'] == 'METALBOF' || $row['repoffice'] == 'POLIAMIDOS') {
            $iContEmp++;
            $aEmp[$row['filcgc'] . $row['empdes']] = [$iContEmp, $row['filcgc'] . " - " . $row['empdes'], $row['empdes']];
        } else {
            $iRepTotal++;
            $aEmp['Representantes'] = [$iRepTotal, 'Representantes', 'REPRESENTANTES'];
            $aRep[$row['repoffice']] = [$iContRep, $row['repoffice']];
        }
        if (!isset($aSit[$row['situaca']])) {
            $aSit[$row['situaca']] = [1, $row['situaca']];
        } else {
            $aSit[$row['situaca']] = [$aSit[$row['situaca']][0] = $aSit[$row['situaca']][0] + 1, $row['situaca']];
        }
    }

//Gráficos personalizados
    if (!$bGrafico) {
        $pdf->AddPage();
        $pdf->SetY(10);
    } else {
        $pdf->SetY(30);
    }
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '1 - Quantidade de chamados por empresa', 0, 1);
    $pdf->Ln(5);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(28, 5, 'Total de Chamados: ' . $iCont, '', 1, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Ln(1);
    $aVal = array();
    $corEmp = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
//Prepara array empresa para gráfico e array de cores
    foreach ($aEmp as $key) {
        $aVal = array_merge(array($key[2] => $key[0]), $aVal);
        array_push($corEmp, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    $corRep = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
//Prepara array representantes para gráfico e array de cores
    foreach ($aRep as $key) {
        $aVal2 = array_merge(array($key[1] => $key[0]), $aVal2);
        array_push($corRep, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    $aVal4 = array();
    $corSit = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
//Prepara array situação para gráfico e array de cores
    foreach ($aSit as $key) {
        $aVal4 = array_merge(array($key[1] => $key[0]), $aVal4);
        array_push($corSit, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    $aVal3 = array();
    $corSubTip = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
//Prepara array subtipo para gráfico e array de cores
    foreach ($aSubTip as $key) {
        $aVal3 = array_merge(array($key[1] => $key[0]), $aVal3);
        array_push($corSubTip, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    if ((count($aEmp) > 1)) {
        //Gráfico empresas
        $pdf->SetXY(10, $valY + 15);
        $pdf->PieChart(170, 50, $aVal, '%l : %v  (%p)', $corEmp);
        $pdf->SetXY($valX, $valY + 70);
    }
    if ($aEmp['Representantes'][0] != 0) {
        $pdf->SetFont('Arial', 'BIU', 12);
        $pdf->Cell(0, 5, '2 - Quantidade de chamados por representante', 0, 1);
        $pdf->Ln(5);
        $valX = $pdf->GetX();
        $valY = $pdf->GetY();
        $pdf->SetFont('arial', 'B', 10);
        $pdf->Cell(28, 5, 'Total de Chamados Representantes: ' . $aEmp['Representantes'][0], '', 1, 'L');
        $pdf->SetFont('arial', 'B', 9);
        $pdf->Ln(1);
        //Gráfico representantes
        $pdf->SetXY(10, $valY + 20);
        $pdf->PieChart(170, 50, $aVal2, '%l : %v  (%p)', $corRep);
        $pdf->SetXY($valX, $valY + 70);
    }


//Gráfico Situação
    $pdf->Ln(15);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '3 - Quantidade de chamados por Situação', 0, 1);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->SetXY(10, $valY + 10);
    $pdf->PieChart(170, 50, $aVal4, '%l : %v  (%p)', $corSit);
    $pdf->SetXY($valX, $valY + 70);

    $iQnt = count($aSubTip);
//Gráfico subtipo
    $pdf->AddPage();
    $pdf->SetY(10);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '4 - Quantidade de chamados por subtipo', 0, 1);
    $pdf->Ln(5);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    arsort($aVal3);
    if ($iQnt != null) {
        //Gráfico subtipo
        $pdf->SetXY(10, $valY);
        $pdf->BarDiagram(195, $iQnt * 8, $aVal3, '%l : %v (%p)', $corSubTip, 0, 10);
        $pdf->SetXY($valX, $valY + 70);
    }

//Relatório de setores
    $sRep = $_REQUEST['repr'];
    $sql1 = "select * from MET_TEC_Chamados "
            . "left outer join MetCad_Setores "
            . "on MetCad_Setores.codsetor = MET_TEC_Chamados.setor "
            . "where filcgc = 75483040000211 and MET_TEC_Chamados.setor <> 48 "
            . "and datacad between '" . $sDataIni . "' and '" . $sDataFin . "'";
    if ($sCodSetor != 'Todos') {
        $sql1 .= " and MET_TEC_Chamados.setor =" . $sCodSetor . " ";
    }
    if ($sTipo != 'Todos') {
        $sql1 .= " and tipo = " . $sTipo;
    }
    if ($sSubtipo != 'Todos') {
        $sql1 .= " and  subtipo_nome = '" . $sSubtipo . "'";
    }
    if ($sRep != 'Todos' && $sRep != null) {
        $sql1 .= " and repoffice = '" . $sRep . "'";
    }
    if ($sEmpresa != 'Todos') {
        $sql1 .= " and  filcgc = '" . $sEmpresa . "' ";
    }
    if ($sUsuario != 'Todos') {
        $sql1 .= " and usunome like '%" . $sUsuario . "%'";
    }
    if ($sSit != 'Todos') {
        $sql1 .= " and situaca = '" . $sSit . "'";
    }
    $sth1 = $PDO->query($sql1);

    $aSet = array();
    $iSet = '';
    $iContSet = 0;
    while ($row1 = $sth1->fetch(PDO::FETCH_ASSOC)) {

        $iSetor = $row1['codsetor'];
        if ($iSetor != $iSet) {
            $iContSet = 0;
            $aSet[$row1['codsetor'] . $row1['descsetor']] = 0;
            $iSet = $row1['codsetor'];
        }
        $iContSet++;
        $aSet[$row1['codsetor'] . $row1['descsetor']] = [$iContSet, $row1['descsetor'], $row1['descsetor']];
    }
    $pdf->AddPage();
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '5 - Quantidade de chamados por Setor - Empresa Metalbo Filial', 0, 1);
    $pdf->Ln(5);

    $aVal = array();
    $corSet = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
    //Prepara array setor para gráfico e array de cores
    foreach ($aSet as $key) {
        $aVal = array_merge(array($key[1] => $key[0]), $aVal);
        array_push($corSet, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    arsort($aVal);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $iQnt = count($aSet);
    if ($iQnt != null) {
        //Gráfico setor
        $pdf->SetXY(10, $valY);
        $pdf->BarDiagram(195, $iQnt * 9, $aVal, '%l : %v (%p)', $corSet, 0, 10);
        $pdf->SetXY($valX, $valY + 70);
    }

//RELATÓRIO ANTIGO - CHAMADOS SISTEMA_METALBO
} else {

    //cabeçalho
    $pdf->SetMargins(3, 0, 3);
    $pdf->SetFont('Arial', 'B', 15);
    // Move to the right
    $pdf->Cell(45);
    // Title
    $pdf->Cell(120, 10, 'Relatório Chamados TI Antigos', 0, 0, 'C');

    $x = $pdf->GetX();
    $y = $pdf->GetY();

    $pdf->Ln(15);
    $pdf->Cell(0, 0, "", "B", 1, 'C');
    $pdf->Ln(3);

    $sql = "select convert(varchar,datacad,103) as datacad1, convert(varchar,datafinal,103) as datafim1,* from metcham "
            . "left outer join  MetCad_User on metcham.coduser = MetCad_User.coduser "
            . "left outer join metsitcham on metcham.codsit = metsitcham.codsit "
            . "left outer join MetCad_Setores on MetCad_Setores.codsetor = MetCad_User.codsetor ";

    $sql .= " where datacad between '" . $sDataIni . "' and '" . $sDataFin . "'";

    if ($sTipo != 'Todos') {
        $sql .= " and tipo = '" . $sTipo . "'";
    }
    if ($sCodSetor != 'Todos') {
        $sql .= " and MetCad_User.codsetor =" . $sCodSetor . " ";
    }
    if ($sSit != 'Todos') {
        $sql .= " and metsitcham.sit = '" . $sSit . "'";
    }
    $sql .= " order by MetCad_Setores.descsetor, datacad";
    $sth = $PDO->query($sql);

    $aTip = array();
    $aSit = array();
    $aSet = array();
    $iSet = '';
    $iContSet = 0;
    $iCont = 0;
    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
        if (!$bGrafico) {
            //Contador de caracteres da descrição do problema para quebra de página
            $var = strlen($row['probl']);
            if ($var != 0) {
                $q = round($var / 160) + 5;
                $pdf = quebraPagina($pdf->GetY() + 5 * $q, $pdf);
            } else {
                $pdf = quebraPagina($pdf->GetY() + 15, $pdf);
            }
        }
        //Cabeçalho - Setor
        $iSetor = $row['codsetor'];
        if ($iSetor != $iSet) {
            $iContSet = 0;
            $aSet[$row['codsetor'] . $row['descsetor']] = 0;
            if (!$bGrafico) {
                $pdf->Ln(3);
                $pdf->SetTextColor(0, 0, 156);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(204, 5, $row['descsetor'], "B", 1, 'L');
                $pdf->Ln(2);
            }
            $iSet = $row['codsetor'];
        }
        if (!$bGrafico) {
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(15, 5, 'NÚMERO', "L,T", 0, 'L');
            $pdf->Cell(46, 5, 'USUÁRIO QUE ABRIU', "L,T", 0, 'L');
            $pdf->Cell(25, 5, 'DT ABERTURA', "L,T", 0, 'L');
            $pdf->Cell(46, 5, 'RESPONSÁVEL POR INICIAR', "L,T", 0, 'L');
            $pdf->Cell(47, 5, 'RESPONSÁVEL POR FINALIZAR', "L,T", 0, 'L');
            $pdf->Cell(25, 5, 'DT FINALIZADO', "L,T,R", 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', 'B', 8);

            $pdf->Cell(15, 5, $row['id'], "T,R,L", 0, 'L');
            $pdf->Cell(46, 5, $row['nome'], "T,R", 0, 'L');
            $pdf->Cell(25, 5, $row['datacad1'], "T,R", 0, 'L');
            $pdf->Cell(46, 5, $row['userinicial'], "T,R", 0, 'L');
            $pdf->Cell(47, 5, $row['userfinal'], "T,R", 0, 'L');
            $pdf->Cell(25, 5, $row['datafim1'], "T,L,R", 1, 'L');
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(204, 5, "Problema: " . $row['probl'], 1, 'L');
            $pdf->Ln(2);
        }
        $iContSet++;
        $aSet[$row['codsetor'] . $row['descsetor']] = [$iContSet, $row['descsetor'], $row['descsetor']];
        $iCont++;

        if (!isset($aTip[$row['tipo']])) {
            $aTip[$row['tipo']] = [1, $row['tipo']];
        } else {
            $aTip[$row['tipo']] = [$aTip[$row['tipo']][0] = $aTip[$row['tipo']][0] + 1, $row['tipo']];
        }

        if (!isset($aSit[$row['sit']])) {
            $aSit[$row['sit']] = [1, $row['sit']];
        } else {
            $aSit[$row['sit']] = [$aSit[$row['sit']][0] = $aSit[$row['sit']][0] + 1, $row['sit']];
        }
    }

    //Gráficos personalizados chamados antigos
    if (!$bGrafico) {
        $pdf->AddPage();
        $pdf->SetY(10);
    } else {
        $pdf->SetY(30);
    }
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '1 - Quantidade de chamados por Setor', 0, 1);
    $pdf->Ln(5);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->SetFont('arial', 'B', 10);
    $pdf->Cell(28, 5, 'Total de Chamados: ' . $iCont, '', 1, 'L');
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Ln(1);

    $aVal = array();
    $corSet = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
    //Prepara array setor para gráfico e array de cores
    foreach ($aSet as $key) {
        $aVal = array_merge(array($key[1] => $key[0]), $aVal);
        array_push($corSet, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    arsort($aVal);
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $iQnt = count($aSet);
    if ($iQnt != null) {
        //Gráfico setor
        $pdf->SetXY(10, $valY);
        $pdf->BarDiagram(195, $iQnt * 9, $aVal, '%l : %v (%p)', $corSet, 0, 10);
        $pdf->SetXY($valX, $valY + 70);
    }

    //Gráfico Tipo 
    $pdf->AddPage();
    $pdf->SetY(10);
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '2 - Quantidade de chamados por Tipo', 0, 1);
    $pdf->Ln(5);

    $aVal2 = array();
    $corTip = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
    //Prepara array tipo para gráfico e array de cores
    foreach ($aTip as $key) {
        $aVal2 = array_merge(array($key[1] => $key[0]), $aVal2);
        array_push($corTip, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $iQnt = count($aTip);
    if ($iQnt != null) {
        //Gráfico tipo
        $pdf->SetXY(10, $valY);
        $pdf->BarDiagram(195, $iQnt * 9, $aVal2, '%l : %v (%p)', $corTip, 0, 10);
        $pdf->SetXY($valX, $valY + 70);
    }

    //Gráfico Tipo 
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'BIU', 12);
    $pdf->Cell(0, 5, '3 - Quantidade de chamados por Situação', 0, 1);
    $pdf->Ln(5);

    $aVal3 = array();
    $corSit = array();
    $iCor1 = 0;
    $iCor2 = 0;
    $iCor3 = 0;
    //Prepara array situação para gráfico e array de cores
    foreach ($aSit as $key) {
        $aVal3 = array_merge(array($key[1] => $key[0]), $aVal3);
        array_push($corSit, array(0 + $iCor1, 0 + $iCor2, 0 + $iCor3));
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
    $valX = $pdf->GetX();
    $valY = $pdf->GetY();
    $pdf->SetXY(10, $valY + 10);
    $pdf->PieChart(170, 50, $aVal3, '%l : %v  (%p)', $corSit);
    $pdf->SetXY($valX, $valY + 70);
}

$pdf->Output('I', 'relChamados.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
//Função que quebra página em uma dada altura do PDF

function quebraPagina($i, $pdf) {
    if ($i >= 278) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $pdf->SetY(10);
    }
    return $pdf;
}
