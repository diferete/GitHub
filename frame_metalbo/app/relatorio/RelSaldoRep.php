<?php

// Diretórios
require '../../biblioteca/fpdf/fpdf.php';
include("../../includes/Config.php");

class PDF extends FPDF {

    function Footer() { // Cria rodapé
        $this->SetXY(15, 283);
        $this->Ln(); //quebra de linha
        $this->SetFont('Arial', '', 7); // seta fonte no rodape
        $this->Cell(190, 7, 'Página ' . $this->PageNo() . ' de {nb}', 0, 0, 'C'); // paginação
    }

}

//pega os dados para parametro
$Empcod = $_REQUEST['cnpj'];
$dataini = $_REQUEST['dataini'];
$datafim = $_REQUEST['datafim'];
$ordena = $_REQUEST['orddata1'];
$rep = $_REQUEST['rep'];



$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AddPage(); // ADICIONA UMA PAGINA
$pdf->AliasNbPages(); // SELECIONA O NUMERO TOTAL DE PAGINAS, USADO NO RODAPE


$pdf->SetXY(10, 10); // DEFINE O X E O Y NA PAGINA
//seta as margens
$pdf->SetMargins(2, 10, 2);

$pdf->Image('../../biblioteca/assets/images/logopn.png', 3, 10, 40); // INSERE UMA LOGOMARCA NO PONTO X = 11, Y = 11, E DE TAMANHO 40.
$pdf->SetFont('Arial', 'B', 16);

$pdf->Cell(190, 18, 'Saldos de pedidos de venda', 0, 1, 'C');
$pdf->Ln(5);
//seta o cabeçalho dos pedidos
//define a altura inicial dos dados
$pdf->SetFont('arial', '', 9);
$pdf->SetY(30);
$iAlturaRet = 122; // Y (altura) INICIAL DOS DADOS 
$l = 5; // ALTURA DA LINHA
//seta o cabeçalho
$pdf->Cell(0, 5, "Pedido     Od                  Emissão         Entrega           Cliente           "
        . "                                                                                     Cidade                       UF", 1, 1, 'L');

//traz os dados 
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sSql = "SELECT widl.PEV01.pdvnro,widl.PEV01.pdvordcomp,convert(varchar,pdvemissao,103)as pdvemissao,
     convert(varchar,pdvdtentre,103)as pdvdtentreS,pdvdtentre,
     widl.PEV01.empcod,widl.EMP01.empdes,widl.CID01.cidnome, 
          widl.CID01.estcod
          FROM 
          widl.PEV01,widl.EMP01,widl.CID01
          WHERE widl.CID01.cidcep = widl.EMP01.cidcep and widl.PEV01.empcod = widl.EMP01.empcod 
          and widl.pev01.filcgc <> '75483040000130'
          and widl.pev01.empcod <> '75483040000211'
          AND PDVSITUACA IN ('O','T','B') 
          and pdvemissao between '" . $dataini . "'  and '" . $datafim . "'
          and widl.pev01.pdvrepcod in (" . $rep . ")  
          and widl.pev01.filcgc = '75483040000211'
          and pdvsituaca ='O'
          and widl.EMP01.empcod =" . $Empcod . "
          order by pdvdtentre " . $ordena;
$dadosItens = $PDO->query($sSql);
$iTotalGeral = 0;
$iTotalSaldo = 0;
while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
    $pdf->SetFont('arial', '', 9);
    //adiciona nova página se necessário
    if ($iAlturaRet + $l >= 275) {    // 275 é o tamanho da página
        $pdf->AddPage();   // adiciona se ultrapassar o limite da página
        $iAlturaRet = 10;  // Altura na segunda página
        $pdf->Rect(2, $iAlturaRet, 206, 5);
        $pdf->Cell(0, 5, "Pedido1     Od Emissão         Entrega          Cliente           "
                . "                                                                            Cidade                       UF", 1, 1, 'L');
        $iAlturaRet = $iAlturaRet + 5;
    }
    //adiciona primeira linha

    $pdf->Cell(14, 5, $row['pdvnro'], 0, 0, 'L');
    $pdf->Cell(20, 5, $row['pdvordcomp'], 0, 0, 'L');
    $pdf->Cell(20, 5, $row['pdvemissao'], 0, 0, 'L');
    $pdf->Cell(21, 5, $row['pdvdtentreS'], 0, 0, 'L');
    $pdf->Cell(95, 5, $row['empdes'], 0, 0, 'L');
    $pdf->Cell(30, 5, $row['cidnome'], 0, 0, 'L');
    $pdf->Cell(20, 5, $row['estcod'], 0, 1, 'L');
    $pdf->SetFont('arial', '', 8);
    $pdf->Cell(0, 5, "Produto                                                                                           "
            . "                                               Vlr.Tot          Qt.Pedida      Qt.Fat            Saldo                                 ", 'T', 1, 'L');

    $sSqlDet = " select widl.pedv01.procod,pdvprodes,pdvproqtdp,pdvprovlta,pdvproipi,pdvprovlrp,pdvproqtdf, 
          case when(pdvproqtdp - pdvproqtdf)*pdvprovlta < 0 then 0 else (pdvproqtdp - pdvproqtdf)*pdvprovlta end as total, 
		  case when (pdvproqtdp - pdvproqtdf) < 0 then 0 else (pdvproqtdp - pdvproqtdf) end as saldo, 
          case when (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 < 0 then 0 else (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 end as IPI, 
          case when (pdvproqtdp - pdvproqtdf)*pdvprovlta + (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 < 0 then 0 else 
          (pdvproqtdp - pdvproqtdf)*pdvprovlta + (pdvproqtdp - pdvproqtdf)* (pdvprovlta)*0.1 end as TotalComIpi, 
          case when (pdvproqtdp - pdvproqtdf)*propesprat < 0 then 0 else (pdvproqtdp - pdvproqtdf)*propesprat end as Peso, 
          (pdvproqtdp*pdvprovlta)as totalInicial,pdvproobs  
          from widl.PEDV01 left outer join widl.prod01 on 
          widl.PEDV01.procod = widl.prod01.procod 
          where pdvnro =" . $row['pdvnro'] . " 
          and filcgc = '75483040000211'
          and (pdvproqtdp - pdvproqtdf) > '0'
          order by pdvproseq";
    $dadosDet = $PDO->query($sSqlDet);
    $iTotalPed = 0;
    $iFat = 0;
    $iSaldo = 0;
    while ($rowDet = $dadosDet->fetch(PDO::FETCH_ASSOC)) {
        $pdf->Cell(18, 5, $rowDet['procod'], 0, 0, 'L');
        $pdf->Cell(100, 5, $rowDet['pdvprodes'], 0, 0, 'L');
        $pdf->Cell(17, 5, number_format($rowDet['total'], 2, ',', '.'), 0, 0, 'L');
        $pdf->Cell(17, 5, number_format($rowDet['pdvproqtdp'], 2, ',', '.'), 0, 0, 'L');
        $pdf->Cell(17, 5, number_format($rowDet['pdvproqtdf'], 2, ',', '.'), 0, 0, 'L');
        $pdf->Cell(15, 5, number_format($rowDet['saldo'], 2, ',', '.'), 0, 1, 'L');
        $iTotalPed = $iTotalPed + $rowDet['pdvproqtdp'];
        $iFat = $iFat + $rowDet['pdvproqtdf'];
        $iSaldo = $iSaldo + $rowDet['saldo'];
        $iTotalGeral = $iTotalGeral + $rowDet['totalInicial'];
        $iTotalSaldo = $iTotalSaldo + $rowDet['total'];
    }
    $pdf->Cell(118, 5, 'Total', 0, 0, 'R');
    $pdf->Cell(17, 5, number_format($iTotalPed, 2, ',', '.'), 0, 0, 'L');
    $pdf->Cell(16, 5, number_format($iFat, 2, ',', '.'), 0, 0, 'L');
    $pdf->Cell(15, 5, number_format($iSaldo, 2, ',', '.'), 0, 1, 'L');
    $pdf->Cell(0, 2, '', 'T', 1, 'L');








    /* $pdf->Cell(18,5,$row['procod'],0,0,'L');
      $pdf->Cell(85,5,$row['pdvprodes'],0,0,'L');
      $pdf->Cell(15,5,number_format($row['total'], 2, ',', '.'),0,0,'L');
      $pdf->Cell(15,5,number_format($row['pdvproqtdp'], 2, ',', '.'),0,0,'L');
      $pdf->Cell(15,5,number_format($row['pdvproqtdf'], 2, ',', '.'),0,1,'L'); */
}

//adiciona os totalizadores
$pdf->SetFont('arial', '', 10);
$pdf->Cell(25, 5, 'Total Geral:', 0, 0, 'L');
$pdf->Cell(25, 5, number_format($iTotalGeral, 2, ',', '.'), 0, 1, 'L');

$pdf->Cell(25, 5, 'Total Saldo:', 0, 0, 'L');
$pdf->Cell(25, 5, number_format($iTotalSaldo, 2, ',', '.'), 0, 1, 'L');






$pdf->Output('', 'RelatorioDeProdutos.pdf'); // GERA O PDF NA TELA
Header('Pragma: public'); // FUNÇÃO USADA PELO FPDF PARA PUBLICAR NO IE
