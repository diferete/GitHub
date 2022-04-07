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
            " . $sTabCab . ".DATA as dataemiss,
            CONVERT(varchar,DTENT,103)as dtent,contato,cidnome,estcod,frete
            from " . $sTabCab . " left outer join widl.EMP01
            on " . $sTabCab . ".CNPJ = widl.EMP01.empcod left outer join widl.CID01
            on widl.EMP01.cidcep = widl.CID01.cidcep
            where " . $sTabCab . ".NR =" . $nrHeader;
$dadoscab = $PDO->query($sSql);
while ($row = $dadoscab->fetch(PDO::FETCH_ASSOC)) {
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
    $dataEmiss = $row["dataemiss"];
}




// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Solicitação nº')
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
        ->setCellValue('D13', 'Qt.Cto')
        ->setCellValue('E13', 'Unit')
        ->setCellValue('F13', 'Total');
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);


$sSql = "select seq,CODIGO,DESCRICAO,QUANT,VLRUNIT,VLRTOT from " . $sTabIten . " where NR =" . $nrHeader . " order by seq";
$dadosItens = $PDO->query($sSql);
$linha = 14;
while ($row = $dadosItens->fetch(PDO::FETCH_ASSOC)) {
    $seq = $row['seq'];
    $codigo = $row['CODIGO'];
    $descricao = $row['DESCRICAO'];
    $quant = $row['QUANT'];
    $vlrunit = $row['VLRUNIT'];
    $vlrtot = $row['VLRTOT'];



    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $linha, $seq)
            ->setCellValue('B' . $linha, $codigo)
            ->setCellValue('C' . $linha, $descricao)
            ->setCellValue('D' . $linha, $quant)
            ->setCellValue('E' . $linha, $vlrunit)
            ->setCellValue('F' . $linha, $vlrtot);
    $linha++;
}

if (strtotime($dataEmiss) >= strtotime('2022-03-01')) {
    $sIpi = '7.5';
} else {
    $sIpi = '10';
}

$sSql = "select sum(VLRTOT)as total,sum(coalesce(quant*propesprat,0))as peso,
sum(VLRTOT+(VLRTOT*" . $sIpi . "/100))as totalipi 
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

// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);
/* $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 2, "Fulano");
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 2, " da Silva");
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 2, "fulano@exemplo.com.br");

  // Exemplo inserindo uma segunda linha, note a diferença no segundo parâmetro
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, "Beltrano");
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 3, " da Silva Sauro");
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 3, "beltrando@exemplo.com.br"); */

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Solicitação nº' . $nrHeader);

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Solicitação nº' . $nrHeader . '.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;

