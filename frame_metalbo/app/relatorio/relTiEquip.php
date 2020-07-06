<?php

// Diretórios
require('../../biblioteca/graficos/Grafico.php');
//require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

$pdf = new PDF_Grafico('P', 'mm', 'A4');
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 9, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

//cabeçalho
$pdf->SetMargins(3, 0, 3);


$pdf->SetFont('Arial', 'B', 15);
// Move to the right
$pdf->Cell(50);
// Title
$pdf->Cell(120, 10, 'Relatorio de Equipamentos TI', 0, 1, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, 'Usuário: ' . $sUserRel, 0, 1, 'L');
$pdf->Cell(30, 5, 'Data: ' . $sData, 0, 0, 'L');
$pdf->Cell(30, 5, 'Hora: ' . $sHora, 0, 1, 'L');
$pdf->Cell(0, 0, "", "B", 1, 'C');  //linha em branco 


$sEqpTipo = $_REQUEST['TiEquipamentoTipo_eqtipcod'];
$sSetorCod = $_REQUEST['Setor_codsetor'];
$sOffice = $_REQUEST['office'];
$sLicWind = $_REQUEST['equiplicenca'];
$oSistema = $_REQUEST['equipsistema'];
$oIp = $_REQUEST['ip'];
$oSituac = $_REQUEST['situaca'];
$sEqp = '';
if(isset($_REQUEST['semeqp'])){
    $aDados = explode('&', $_SERVER['QUERY_STRING']);
    foreach ($aDados as $skey){
        if(strpos($skey, 'semeqp')!==false){
            if($sEqp==''){
                $sEqp = $sEqp.(explode('=', $skey)[1]);
            }else{
                $sEqp = $sEqp.",".(explode('=', $skey)[1]);
            }
        }  
    }
}else{
    $sEqp = false;
}
$pdf->SetY(45);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "select * from tbtiequipamento 
	left outer join  tbtiequiptipo
            on (tbtiequipamento.eqtipcod = tbtiequiptipo.eqtipcod)
            left outer join MetCad_Setores
            on (tbtiequipamento.codsetor =  MetCad_Setores.codsetor) ";

if (($sEqpTipo !== '') || ($sSetorCod !== '')) {
    $sql .= " where ";

    if (($sEqpTipo !== '') && ($sSetorCod == '')) {
        $sql .= " tbtiequipamento.eqtipcod = " . $sEqpTipo;
    }
    if (($sEqpTipo == '') && ($sSetorCod !== '')) {
        $sql .= " tbtiequipamento.codsetor = " . $sSetorCod;
    }
    if (($sEqpTipo !== '') && ($sSetorCod !== '')) {
        $sql .= " tbtiequipamento.eqtipcod = " . $sEqpTipo . " and tbtiequipamento.codsetor = " . $sSetorCod;
    }
    if ($sEqpTipo == '1') {
        if ($sOffice !== 'Todos') {
            $sql .= " and office = '" . $sOffice . "' ";
        }
        if ($sLicWind !== 'Todos') {
            $sql .= " and equiplicenca = '" . $sLicWind . "' ";
        }
    }
    if ($oSistema !== 'N/A') {
        $sql .= " and equipsistema = '" . $oSistema . "' ";
    }
}
if (($oIp == 'N') && ($sEqpTipo == '') && ($sSetorCod == '')) {
    $sql .= " where ipfixo = 'DHCP'";
} else if (($oIp == 'S') && ($sEqpTipo == '') && ($sSetorCod == '')) {
    $sql .= " where ipfixo <> 'DHCP' and ipfixo <> '' ";
} else if ($oIp == 'S') {
    $sql .= " and ipfixo <> 'DHCP' and ipfixo <> '' ";
} else if ($oIp == 'N') {
    $sql .= " and ipfixo = 'DHCP'";
}
if (($oSituac != 'Todas')) {
    if (($oIp == 'Todos') && ($sEqpTipo == '') && ($sSetorCod == '')) {
        $sql .= " where situaca = '" . $oSituac . "'";
    } else {
        $sql .= " and situaca = '" . $oSituac . "'";
    }
}
if($sEqp!=false){
    $sql .= " and tbtiequipamento.eqtipcod not in (".$sEqp.")";
}

$sql .= " order by tbtiequipamento.codsetor,equipcod,office,equiplicenca ";
$sth = $PDO->query($sql);

$iContaAltura = $pdf->GetY();
$icontaQnt = 0;
$icontLicOff = 0;
$icontLicWind = 0;
$aEquipamentos = array();
$aQuantEquipamentosSetor = array();

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

    if ($iContaAltura >= 270) {    // 275 tamanho máximo da página
        $pdf->AddPage();   // nova pagina 
        $iContaAltura = 10;

        $pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
        //seta as margens
        $pdf->SetMargins(2, 10, 2);

        $pdf->SetFont('Arial', 'B', 16);

        //cabeçalho
        $pdf->SetMargins(3, 0, 3);
        // Move to the right
        $pdf->Cell(50);
        // Title
        $pdf->Cell(120, 10, 'Relatorio de Equipamentos TI', 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', '', 9);
        //$pdf->Cell(40, 5, 'Empresa:', 0, 1, 'L');
        $pdf->Cell(40, 5, 'Usuário: ' . $sUserRel, 0, 1, 'L');
        $pdf->Cell(30, 5, 'Data: ' . $sData, 0, 0, 'L');
        $pdf->Cell(30, 5, 'Hora: ' . $sHora, 0, 1, 'L');
        $pdf->Cell(0, 0, "", "B", 1, 'C');

        $pdf->SetFont('Arial', '', 9);

        //define a altura inicial dos dados
        $pdf->SetFont('arial', '', 8);
        $pdf->SetY(45);
    }
    if ($row['situaca'] == 'A') {
        if (isset($aEquipamentos[$row['eqtipdescricao']])) {
            $aEquipamentos[$row['eqtipdescricao']] = $aEquipamentos[$row['eqtipdescricao']] + 1;
        } else {
            $aEquipamentos[$row['eqtipdescricao']] = 1;
        }

        if (isset($aQuantEquipamentosSetor[$row['descsetor']])) {
            $aQuantEquipamentosSetor[$row['descsetor']] = $aQuantEquipamentosSetor[$row['descsetor']] + 1;
        } else {
            $aQuantEquipamentosSetor[$row['descsetor']] = 1;
        }
    }
    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(5, 5, 'Nr:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(7, 5, $row['equipcod'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(9, 5, 'Tipo:', 0, 0, 'L');
    $pdf->SetFont('arial', 'U', 8);
    $pdf->Cell(43, 5, $row['eqtipdescricao'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(10, 5, 'Setor:', 0, 0, 'L');
    $pdf->SetFont('arial', 'U', 8);
    $pdf->Cell(59, 5, $row['descsetor'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(14, 5, 'Usuário:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(30, 5, $row['equipusuario'], 0, 1);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(18, 5, 'Fabricante:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(46, 5, $row['equipfabricante'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(13, 5, 'Modelo:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(56, 5, $row['equipmodelo'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(9, 5, 'S.O.:', 0, 0, 'L');
    $pdf->SetFont('arial', 'U', 8);
    $pdf->Cell(30, 5, $row['equipsistema'], 0, 1);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(17, 5, 'Hostname:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(47, 5, $row['equiphostname'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(5, 5, 'IP:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(64, 5, $row['ipfixo'], 0, 0);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(22, 5, 'MAC address:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(20, 5, $row['equipmac'], 0, 1);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(10, 4, 'Key:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(64, 4, $row['numlic'], 0, 1);

    $pdf->SetFont('arial', 'B', 8);
    $pdf->Cell(22, 5, 'Obs:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->MultiCell(150, 5, $row['obs'], 0, 1);

    $pdf->Cell(0, 1, "", "B", 1, 'C');

    $icontaQnt++;
    if ($sEqpTipo == '1') {
        if ($row['equiplicenca'] == 'Ativado') {
            $icontLicWind++;
        }
        if ($row['office'] == 'A') {
            $icontLicOff++;
        }
    }
    $pdf->Ln(2);
    $iContaAltura = $pdf->GetY() + 10;
}

$pdf->SetFont('arial', 'B', 9);
$pdf->Cell(50, 5, 'Quantidade de Equipamentos:', 0, 0, 'L');
$pdf->SetFont('arial', '', 9);
$pdf->MultiCell(150, 5, $icontaQnt, 0, 1);
if ($sEqpTipo == '1') {
    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(40, 5, 'Office ativado:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(150, 5, $icontLicOff, 0, 1);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(40, 5, 'Windows Ativado:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(150, 5, $icontLicWind, 0, 1);
}

$pdf->AddPage();
$pdf->Ln(10);
//Colunm diagram
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '1 - Gráfico quantidade de Equipamentos ativados por Tipo', 0, 1);
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();

/*
 * Largura do Campo do Gráfico
 * Altura do Campo Gráfico
 * Array de dados
 * %1 = texto
 * %v = valor
 * (%p) = porcentagem
 * Array de corres do Gráfico
 * Comprimento máximo das Barras de 1 á 3 e 0 como padrão
 * Quantidade de Divisões
 */
if($aEquipamentos!=null){
$iTam = count($aEquipamentos);

//$pdf->ColunmDiagram(100, 150,$aEquipamentos, '%l : %v (%p)', null, 0, 5);
$pdf->BarDiagram(195, $iTam * 8, $aEquipamentos, '%l : %v (%p)', null, 0, 10);

$pdf->AddPage();
$pdf->Ln(10);
//Colunm diagram
$pdf->SetFont('Arial', 'BIU', 12);
$pdf->Cell(0, 5, '2 - Gráfico quantidade de Equipamentos ativados por Setor', 0, 1);
$pdf->Ln(8);
$valX = $pdf->GetX();
$valY = $pdf->GetY();

/*
 * Largura do Campo do Gráfico
 * Altura do Campo Gráfico
 * Array de dados
 * %1 = texto
 * %v = valor
 * (%p) = porcentagem
 * Array de corres do Gráfico
 * Comprimento máximo das Barras de 1 á 3 e 0 como padrão
 * Quantidade de Divisões
 */
$iTam2 = count($aQuantEquipamentosSetor);

$pdf->BarDiagram(195, $iTam2 * 8, $aQuantEquipamentosSetor, '%l : %v (%p)', null, 0, 10);
}
//number_format($quant, 2, ',', '.')
$pdf->Output('I', 'Relatório Equip.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
