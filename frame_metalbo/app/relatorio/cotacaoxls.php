<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
include("../../includes/Config.php");

//monta o cabeçalho do excel

$nrHeader = $_REQUEST['nr'];
$sTabCab = $_REQUEST['tabcab'];
$sTabIten = $_REQUEST['itencab'];

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "  select " . $sTabCab . ".NR,CNPJ,CLIENTE,widl.emp01.empfone,
            CODPGT,CPGT,ODCOMPRA,
            TRANSCNPJ,TRANSP,CODREP,REP,convert(varchar," . $sTabCab . ".DATA,103)as data,OBS,
            CONVERT(varchar,DTENT,103)as dtent,contato,cidnome,estcod,frete
            from " . $sTabCab . " left outer join widl.EMP01
            on " . $sTabCab . ".CNPJ = widl.EMP01.empcod left outer join widl.CID01
            on widl.EMP01.cidcep = widl.CID01.cidcep
            where " . $sTabCab . ".NR =" . $nrHeader;
$dadoscab = $PDO->query($sSql);
while ($row = $dadoscab->fetch(PDO::FETCH_ASSOC)) {
    date_default_timezone_set('America/Sao_Paulo');
    $nrsol = $row["NR"];
    $cnpj = $row["CNPJ"];
    $cliente = $row["CLIENTE"];
    $empfone = $row["empfone"];
    $codpgt = $row["CODPGT"];
    $condpag = $row["CPGT"];
    $odcompra = $row["ODCOMPRA"];
    $transcnpj = $row["TRANSCNPJ"];
    $transp = $row["TRANSP"];
    $codrep = $row["CODREP"];
    $rep = $row["REP"];
    $data = $row["data"];
    $obs = $row["OBS"];
    $cidnome = $row["cidnome"];
    $estcod = $row["estcod"];
    $dtent = $row["dtent"];
    $contato = $row["contato"];
    $frete = $row["frete"];
}




// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Cotação nº')
        ->setCellValue('B1', $nrsol)
        ->setCellValue('A3', "Cliente: ")
        ->setCellValue('B3', $cnpj . ' ' . $cliente)
        ->setCellValue("A4", "Cidade:  ")
        ->setCellValue("B4", $cidnome . '     Estado:' . $estcod)
        ->setCellValue("A5", "Telefone: ")
        ->setCellValue("B5", $empfone)
        ->setCellValue("A6", "Ordem de Compra: ")
        ->setCellValue("B6", $odcompra)
        ->setCellValue("A7", "Transportadora: ")
        ->setCellValue("B7", $transcnpj . ' ' . $transp)
        ->setCellValue("A8", "Frete: " . $frete)
        ->setCellValue("B8", $frete)
        ->setCellValue("A8", "Representante: ")
        ->setCellValue("B8", $codrep . ' ' . $rep)
        ->setCellValue("A9", "Data Emissão: ")
        ->setCellValue("B9", $data . '     Cond. Pgto:' . $condpag)
        ->setCellValue("A10", "Data Faturamento: ")
        ->setCellValue("B10", $dtent)
        ->setCellValue("A11", "Obs: ")
        ->setCellValue("B11", $obs);

//monta a linha de cabeçalho
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A13', 'Seq')
        ->setCellValue('B13', 'Código')
        ->setCellValue('C13', 'Descrição')
        ->setCellValue('D13', 'Obs.Prod')
        ->setCellValue('E13', 'Qt.Cto')
        ->setCellValue('F13', 'Unit')
        ->setCellValue('G13', 'Total');
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);


$sSql = "select seq,CODIGO,DESCRICAO,OBSPROD,QUANT,VLRUNIT,VLRTOT from " . $sTabIten . " where NR =" . $nrHeader . " order by seq";
$dadosItens = $PDO->query($sSql);
$linha = 14;
while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
    date_default_timezone_set('America/Sao_Paulo');
    $seq = $row['seq'];
    $codigo = $row['CODIGO'];
    $descricao = $row['DESCRICAO'];
    $obsprod = $row['OBSPROD'];
    $quant = $row['QUANT'];
    $vlrunit = $row['VLRUNIT'];
    $vlrtot = $row['VLRTOT'];



    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $linha, $seq)
            ->setCellValue('B' . $linha, $codigo)
            ->setCellValue('C' . $linha, $descricao)
            ->setCellValue('D' . $linha, $obsprod)
            ->setCellValue('E' . $linha, $quant)
            ->setCellValue('F' . $linha, $vlrunit)
            ->setCellValue('G' . $linha, $vlrtot);
    $linha++;
}

$sSql = "select sum(VLRTOT)as total,sum(coalesce(quant*propesprat,0))as peso,
sum(VLRTOT+(VLRTOT*10/100))as totalipi 
from " . $sTabIten . " inner join widl.prod01(nolock) 
on " . $sTabIten . ".CODIGO = widl.prod01.procod   
where NR =" . $nrHeader;
$row = $PDO->query($sSql);
$rowTotal = $row->fetch(PDO::FETCH_OBJ);
$total = $rowTotal->total;
$totalPeso = $rowTotal->peso;
$totalipi = $rowTotal->totalipi;

//adiciona linha
$linha ++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $linha, 'Peso:')
        ->setCellValue('B' . $linha, $totalPeso)
        ->setCellValue('D' . $linha, 'Total Produtos:')
        ->setCellValue('E' . $linha, $total);
$linha++;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('D' . $linha, 'Total c/Ipi:')
        ->setCellValue('E' . $linha, $totalipi);

$objPHPExcel->getActiveSheet()->setTitle('Solicitação nº' . $nrHeader);

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Cotação nº' . $nrHeader . '.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;


