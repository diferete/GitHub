<?php

// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$data1 = $_REQUEST['dataini'];
$data2 = $_REQUEST['datafim'];
$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sSitProj = $_REQUEST['sitproj'];
$sSitVenda = $_REQUEST['sitvendas'];
$sSitCli = $_REQUEST['sitcli'];
$sSitGeral = $_REQUEST['geralsit'];
$sTipoProd = $_REQUEST['grucod'];
$sClienteCnpj = $_REQUEST['empcod'];

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 278);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 1, 'C'); // paginação

        $this->Image('../../biblioteca/assets/images/metalbo-preta.png', 180, 286, 20);
    }

}

class PDF_AutoPrint extends PDF_JavaScript {

    function AutoPrint($printer = '') {
        // Open the print dialog
        if ($printer) {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        } else {
            $script = 'print(true);';
            $this->IncludeJS($script);
        }
    }

}

$pdf = new PDF_AutoPrint('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
//$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
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
$pdf->Cell(90, 10, 'Relatório Entrada de Projetos', 0, 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $sData
        . '        Hora:' . $sHora
        . ' Usuário:' . $sUserRel
        . ' ', '', 'L', 0);
$pdf->Ln(1);
$pdf->Cell(0, 0, "", "B", 1, 'C');

$pdf->Ln(5);

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sql = "select nr,sitvendas,sitcliente,sitgeralproj,sitproj,tbqualNovoProjeto.procod,desc_novo_prod,repnome,resp_venda_nome,respvalproj, tbqualNovoProjeto.empcod,widl.EMP01.empdes,
                 convert(varchar,dtimp,103) as dtimp,
                 quant_pc,lotemin,prazoentregautil,precofinal,acabamento 
                 from tbqualNovoProjeto
                 left outer join widl.EMP01
                 on tbqualNovoProjeto.empcod = widl.EMP01.empcod"
        . " where dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "' ";

if (($sSitProj !== '') || ($sSitVenda !== '') || ($sSitCli !== '') || ($sSitGeral !== '') || ($sTipoProd !== '') || $sClienteCnpj !== '') {
    if (($sSitProj !== '')) {
        $sql .= " and ";
        $sql .= " sitproj ='" . $sSitProj . "'";
    }
    if (($sSitVenda !== '')) {
        $sql .= " and ";
        $sql .= " sitvendas ='" . $sSitVenda . "'";
    }
    if (($sSitCli !== '')) {
        $sql .= " and ";
        $sql .= " sitcliente ='" . $sSitCli . "'";
    }
    if (($sSitGeral !== '')) {
        $sql .= " and ";
        $sql .= " sitgeralproj ='" . $sSitGeral . "'";
    }
    if (($sTipoProd !== '')) {
        $sql .= " and ";
        $sql .= " grucod = '" . $sTipoProd . "'";
    }
    if (($sClienteCnpj !== '')) {
        $sql .= " and ";
        $sql .= " tbqualNovoProjeto.empcod = '" . $sClienteCnpj . "'";
    }
}
$sql .= " group by nr,sitvendas,sitcliente,sitgeralproj,sitproj,tbqualNovoProjeto.procod,desc_novo_prod,repnome,resp_venda_nome,respvalproj,
          tbqualNovoProjeto.empcod,widl.EMP01.empdes,
          dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento order by nr";

$sth = $PDO->query($sql);

//SELECT PARA CONTAR PROJETOS APROVADOS, REPROVADOS
$sqlCont = "SELECT DISTINCT sitvendas, sitproj, sitcliente, sitgeralproj
               ,COUNT(*) AS quantidade
                FROM tbqualNovoProjeto
                where dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "'";

if (($sSitProj !== '') || ($sSitVenda !== '') || ($sSitCli !== '') || ($sSitGeral !== '') || ($sTipoProd !== '')) {
    if (($sSitProj !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " sitproj ='" . $sSitProj . "'";
    }
    if (($sSitVenda !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " sitvendas ='" . $sSitVenda . "'";
    }
    if (($sSitCli !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " sitcliente ='" . $sSitCli . "'";
    }
    if (($sSitGeral !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " sitgeralproj ='" . $sSitGeral . "'";
    }
    if (($sTipoProd !== '')) {
        $sqlCont .= " and ";
        $sqlCont .= " grucod = '" . $sTipoProd . "'";
    }
}

$sqlCont .= " GROUP BY sitvendas, sitproj, sitcliente, sitgeralproj
            ORDER BY quantidade DESC ";

$sCont = $PDO->query($sqlCont);

//Inicializa as variáveis de porjetos aprovados/reprovados
$qAprovVend = 0;
$qReproVend = 0;
$qAprovProj = 0;
$qReproProj = 0;
$qAprovClie = 0;
$qReproClie = 0;
$qExpiraClie = 0;

//Calcula projetos aprovados/reprovados por setor
while ($row = $sCont->fetch(PDO::FETCH_ASSOC)) {

    if ($row['sitvendas'] == "Aprovado") {
        $qAprovVend = $qAprovVend + (int) $row['quantidade'];
    } else
    if (($row['sitvendas'] == "Reprovado")) {
        $qReproVend = $qReproVend + (int) $row['quantidade'];
    }

    if ($row['sitproj'] == "Aprovado" || $row['sitproj'] == "Cód. enviado") {
        $qAprovProj = $qAprovProj + (int) $row['quantidade'];
    } else
    if (($row['sitproj'] == "Reprovado")) {
        $qReproProj = $qReproProj + (int) $row['quantidade'];
    }

    if ($row['sitcliente'] == "Aprovado") {
        $qAprovClie = $qAprovClie + (int) $row['quantidade'];
    } else
    if (($row['sitcliente'] == "Reprovado")) {
        $qReproClie = $qReproClie + (int) $row['quantidade'];
    }
    if (($row['sitcliente'] == "Expirado")) {
        $qExpiraClie = $qExpiraClie + (int) $row['quantidade'];
    }
}


//Conta o total de porcas e parafusos dentro do período de datas selecionado


$sqlTotalPo = "select count(*) as quantidade from tbqualNovoProjeto
                 where grucod = 12 and dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "'";
$iTotalPo = $PDO->query($sqlTotalPo)->fetch(PDO::FETCH_ASSOC);

$sqlTotalPa = "select count(*) as quantidade from tbqualNovoProjeto
                     where grucod = 13 and dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "'";
$iTotalPa = $PDO->query($sqlTotalPa)->fetch(PDO::FETCH_ASSOC);



//Imprime relatório projetos aprovados/reprovados por setor
$pdf->Cell(199, 5, 'Aprovados Projetos: ' . $qAprovVend . ''
        . '  -   Aprovados Vendas: ' . $qAprovProj . ''
        . '  -   Aprovados Cliente: ' . $qAprovClie . ''
        . '  -   Total de Parafusos: ' . $iTotalPa['quantidade'], 0, 1, 'L');
$pdf->Cell(199, 5, 'Reprovados Projetos: ' . $qReproVend . ''
        . '  -   Reprovados Vendas: ' . $qReproProj . ''
        . '  -   Reprovados Cliente: ' . $qReproClie . ''
        . '  -   Expirados: ' . $qExpiraClie . ''
        . '  -   Total de Porcas: ' . $iTotalPo['quantidade'], 0, 1, 'L');
$pdf->Cell(0, 0, "", "B", 1, 'C');
$pdf->Ln(3);

$iContaAltura = $pdf->GetY();

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
        $pdf->Cell(95, 10, 'Relatorio de Novos Projetos', 0, 0, 'C');

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(50, 5, 'Usuário: ' . $sUserRel, 0, 'L');
        $pdf->SetXY($x, $y + 5);
        $pdf->MultiCell(50, 5, 'Data: ' . $sData .
                '  Hora: ' . $sHora, 0, 'L');
        $pdf->SetXY($x, $y + 5);
        $pdf->MultiCell(50, 15, 'Per.: ' . $data1 .
                ' - ' . $data2, 0, 'L');

        $pdf->Ln(5);

        //define a altura inicial dos dados
        $pdf->SetFont('arial', '', 8);
        $pdf->SetY(45);
    }

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Projetos:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['sitproj'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Vendas:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['sitvendas'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['sitcliente'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Sit. Geral:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(31, 5, $row['sitgeralproj'], 0, 1);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(5, 5, 'Nr:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(10, 5, $row['nr'], 0, 0, 'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(13, 5, 'Cliente:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(114, 5, $row['empdes'], 0, 0, 'L');

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Data Imp.:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(18, 5, $row['dtimp'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(10, 5, 'Prazo:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(18, 5, $row['prazoentregautil'] . ' dias', 0, 1); //quebra de linha

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(18, 5, 'Cód. Novo:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(18, 5, $row['procod'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(17, 5, 'Descrição:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->MultiCell(180, 5, $row['desc_novo_prod'], 0, 'J'); //quebra de linha

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(25, 5, 'Acabamento:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(35, 5, $row['acabamento'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(12, 5, 'Quant.:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(18, 5, number_format($row['quant_pc'], 0, ', ', '.'), 0, 0); //formata casas decimais

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(16, 5, 'Lote Min.:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(18, 5, number_format($row['lotemin'], 0, ', ', '.'), 0, 0); //formata casas decimais

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(11, 5, 'Preço:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(20, 5, number_format($row['precofinal'], 2, ', ', '.'), 0, 1); //formata casas decimais

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(25, 5, 'Representante:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(35, 5, $row['repnome'], 0, 0);

    $pdf->SetFont('arial', 'B', 9);
    $pdf->Cell(24, 5, 'Resp. Vendas:', 0, 0, 'L');
    $pdf->SetFont('arial', '', 9);
    $pdf->Cell(35, 5, $row['resp_venda_nome'], 0, 1);

    $pdf->Cell(0, 5, "", "B", 1, 'C');

    $pdf->Ln(2);
    $iContaAltura = $pdf->GetY() + 10;
}


//number_format($quant, 2, ', ', '.')
$pdf->AutoPrint();
$pdf->Output('I', 'relNovoProjeto.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE  
