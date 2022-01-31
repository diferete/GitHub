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
$sSituaca = $_REQUEST['situaca'];
$sRetrabalho = $_REQUEST['retrabalho'];

//Inserção do cabeçalho
$pdf->Cell(37, 15, $pdf->Image($sLogo, $pdf->GetX(), $pdf->GetY(), 45), 0, 0, 'J');

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(110, 15, 'Comparativo Devoluções', '', 0, 'C', 0);

$pdf->SetFont('Arial', '', 9);
$pdf->MultiCell(52, 7, 'Data: ' . $data
        . '        Hora:' . $hora
        . ' Usuário:' . $useRel
        . ' ', '', 'L', 0); //'B,R,T'
$pdf->Cell(0, 5, '', '', 1, 'L');
$pdf->Cell(0, 5, '', 'T', 1, 'L');


//Inicio

$iEmpCodigo = $_REQUEST['emp_codigo'];
$sNf_Ent = $_REQUEST['nf_ent'];
//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "select op,prod,prodes,quant,documento,
              peso,opcliente,data as dataorder,convert(varchar,data,103) as data,convert(varchar,dataprev,103) as dataprev,
              situacao,nrcarga,prodfinal 
              from STEEL_PCP_OrdensFab 
              where data between '" . $dtinicial . "' and '" . $dtfinal . "'";
if ($iEmpCodigo !== '') {
    $sSqli .= " and emp_codigo='" . $iEmpCodigo . "' ";
}
if ($sNf_Ent !== '') {
    $sSqli .= " and documento='" . $sNf_Ent . "' ";
}
if ($sSituaca !== 'Todos') {
    if ($sSituaca == 'Retornado') {
        $sSqli .= " and situacao= 'Retornado' ";
    } else {
        $sSqli .= " and situacao <> 'Retornado' ";
    }
}
if ($sRetrabalho != 'Incluir') {
    $sSqli .= " and retrabalho='" . $sRetrabalho . "' ";
} else {
    $sSqli .= " and retrabalho<>'Retorno não Ind.' ";
}

$sSqli .= " order by dataorder desc ";
$dadosRela = $PDO->query($sSqli);

//Filtros escolhidos
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 10, 'Filtros escolhidos:', '', 0, 'L', 0);

if ($iEmpCodigo == null) {
    $iEmpCodigo = 'Todos';
}
if ($sNf_Ent == null) {
    $sNf_Ent = 'Todos';
}

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 10, 'Data inicial: ' . $dtinicial .
        '   Data final: ' . $dtfinal .
        '   Empresa: ' . $iEmpCodigo .
        '   Situação: ' . $sSituaca .
        '   Nota Fiscal: ' . $sNf_Ent . ' ', '', 1, 'L', 0);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 5, 'Retrabalho: ' . $sRetrabalho, '', 1, 'L', 0);

//$pdf->SetFont('Arial','',9);
//$pdf->Cell(30,10,'Data inicial: '.$dtfinal, '',1, 'L',0);
$pdf->Cell(0, 3, '', '', 1, 'L');

//Títulos do relatório
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(12, 5, 'OP', 'B,R,L,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(13, 5, 'Nota', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(18, 5, 'Data', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(83, 5, 'Produto de entrada', 'B,R,T', 0, 'C', 0);

//$pdf->SetFont('Arial','B',9);
//$pdf->Cell(14,5,'Quant.', 'B,R,T',0, 'C',0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'Peso', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(15, 5, 'Situação', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'Nota Saída', 'B,R,T', 0, 'C', 0);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(14, 5, 'Data Saída', 'B,R,T', 0, 'C', 0);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(17, 5, 'Quantidade', 'B,R,T', 1, 'C', 0);

$Pesototal = 0;
$Quanttotal = 0;
$iContEntrada = 0;
$iContSaida = 0;

while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {
    $iContEntrada++;
    //busca sequencia 
    if ($row['nrcarga'] == 'Sem Carga' || $row['nrcarga'] == 'Sem carga') {
        $iCarga = 0;
    } else {
        $iCarga = $row['nrcarga'];
    }
    $sSqlSeqPed = "select pdv_pedidoitemseq from STEEL_PCP_CargaInsumoServ 
                where op ='" . $row['op'] . "'
                and pdv_pedidocodigo ='" . $iCarga . "'
                and pdv_insserv ='RETORNO' ";
    $dadosSeqPed = $PDO->query($sSqlSeqPed);
    $oRowSeqPed = $dadosSeqPed->fetch(PDO::FETCH_ASSOC);
    $iSeqPed = $oRowSeqPed['pdv_pedidoitemseq'];
    //busca a nota fiscal da sequencia
    $sSqlNota = "select NFS_NotaFiscalNumero,convert(varchar,NFS_NotaFiscalDataEmissao,103) as NFS_NotaFiscalDataEmissao,
                nfs_notafiscalitem.NFS_NotaFiscalItemQuantidade 
                from nfs_notafiscalitem left outer join NFS_NOTAFISCAL
                on nfs_notafiscalitem.NFS_NotaFiscalFilial = NFS_NOTAFISCAL.NFS_NotaFiscalFilial
                and nfs_notafiscalitem.NFS_NotaFiscalSeq = NFS_NOTAFISCAL.NFS_NotaFiscalSeq
                where nfs_notafiscalitempedidocodigo = '" . $iCarga . "' and nfs_notafiscalcancelada = 'N'
                and nfs_notafiscalitem.NFS_NotaFiscalFilial ='8993358000174'
                and nfs_notafiscalitemproduto = '" . $row['prodfinal'] . "'
                and NFS_NotaFiscalItemPedidoItemSe ='" . $iSeqPed . "'
                and NFS_NotaFiscalSituacao <>'X'
                group by NFS_NotaFiscalNumero,NFS_NotaFiscalDataEmissao,nfs_notafiscalitem.NFS_NotaFiscalItemQuantidade ";
    $dadosNota = $PDO->query($sSqlNota);
    $oRowNota = $dadosNota->fetch(PDO::FETCH_ASSOC);
    $sNota = $oRowNota['NFS_NotaFiscalNumero'];
    $sDataSaida = $oRowNota['NFS_NotaFiscalDataEmissao'];
    $sQuantidade = $oRowNota['NFS_NotaFiscalItemQuantidade'];

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(12, 6, $row['op'], 'L,B,T', 0, 'C');

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(13, 6, $row['documento'], 'L,B,T', 0, 'L');

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(18, 6, $row['data'], 'L,B,T', 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->Cell(83, 6, substr($row['prodes'], 0, 65), 'L,B,T', 0, 'L');

    // $pdf->SetFont('Arial','',7);
    // $pdf->Cell(14, 6, number_format($row['quant'], 2, ',', '.'),'L,B',0,'R');

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(14, 6, number_format($row['peso'], 2, ',', '.'), 'L,B,T', 0, 'R');

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(15, 6, $row['situacao'], 'L,B,T', 0, 'C');

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(14, 6, $sNota, 'L,B,T', 0, 'C', 0);  //$sDataSaida

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(14, 6, $sDataSaida, 'L,B,T', 0, 'C', 0);

    $pdf->SetFont('Arial', '', 7);
    $pdf->Cell(17, 6, number_format($sQuantidade, 2, ',', '.'), 'L,B,T,R', 1, 'C', 0);

    $Pesototal = ($row['peso'] + $Pesototal);
    //$Quanttotal=($row['quant']+$Quanttotal);
    if ($row['situacao'] == 'Retornado') {
        $iContSaida++;
    }
}

$pdf->Cell(50, 5, '', 'B', 1, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 2, '', '', 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(99, 8, 'Peso Total: ' . number_format($Pesototal, 2, ',', '.'), '', 1, 'J');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(99, 8, 'Volumes: ' . $iContEntrada, '', 1, 'J');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(99, 8, 'Volumes Retornados: ' . $iContSaida, '', 1, 'J');

//Fim  

$pdf->Output('I', 'RelOpSteel2.pdf');
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE 
 