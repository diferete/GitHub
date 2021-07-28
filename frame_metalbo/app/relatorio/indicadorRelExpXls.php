<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
include("../../includes/Config.php");

//variáveis
if (isset($_REQUEST["usu"])) {
    $usu = $_REQUEST["usu"];
}
$dataEmis = date('d/m/Y');
if (isset($_REQUEST["dataini"])) {
    $data1 = $_REQUEST["dataini"];
}

if (isset($_REQUEST["datafim"])) {
    $data2 = $_REQUEST["datafim"];
}
// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'INDICADOR DE PRODUÇÃO DA EXPEDIÇÃO');

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

/* Peso geral */
$sSql = "  select SUM(Pesotudo-PesoSucata-pesodev)as PesoLiquido
                      from metfat_metalbo 
                      where DATA between '" . $data1 . "' and '" . $data2 . "' ";

$dadosTot = $PDO->query($sSql);
while ($row = $dadosTot->fetch(PDO::FETCH_ASSOC)) {
    $sTotalGeral = $row['PesoLiquido'];
}
/* Total da exceção */
$sSql = " select sum(nfspesolq) as totEx 
          from widl.NFC001(nolock),
          widl.mov01(nolock)
          where widl.nfc001.nfsmovcod = widl.MOV01.movcod 
          and nfsdtemiss between '" . $data1 . "' and '" . $data2 . "' 
          and nfscancela <> '*'
          and widl.NFC001.nfsfilcgc = '75483040000211'
          and movfin = 'S'
          and movvenda = 'S'
          and widl.NFC001.nfsnfser = 2 
          and nfssaida = 'XXX'
          and nfscomplem = '' 
          and nfsclicod in(select empcod from tbnotempqual) ";

$dadosEx = $PDO->query($sSql);
while ($row = $dadosEx->fetch(PDO::FETCH_ASSOC)) {
    $sTotalEx = $row['totEx'];
}

/* Total da exportação */
$sSql = "   select SUM(PesoExp)as PesoExport
                      from metfat_metalbo 
                      where DATA between '" . $data1 . "' and '" . $data2 . "'  ";

$dadosExPort = $PDO->query($sSql);
while ($row = $dadosExPort->fetch(PDO::FETCH_ASSOC)) {
    $sTotalExPort = $row['PesoExport'];
}
/* dias de expediçao */
/* Monta a média */
$sSql = " select COUNT(*) as cont 
          from metfat_metalbo
          where data between '" . $data1 . "' and '" . $data2 . "'   ";

$dadosCount = $PDO->query($sSql);
while ($row = $dadosCount->fetch(PDO::FETCH_ASSOC)) {
    $sTotalCount = $row['cont'];
}
$sMedia = ($sTotalGeral - $sTotalEx - $sTotalExPort) / $sTotalCount;
$sTotalExpedido = $sTotalGeral - $sTotalEx - $sTotalExPort;

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'Usuário:')
        ->setCellValue('B2', $usu)
        ->setCellValue('A3', 'Data:')
        ->setCellValue('B3', $dataEmis)
        ->setCellValue('A5', 'Total expedido em KG:')
        ->setCellValue('B5', number_format($sTotalGeral, 2, ',', '.'))
        ->setCellValue('A6', 'Total da exceção:')
        ->setCellValue('B6', number_format($sTotalEx, 2, ',', '.'))
        ->setCellValue('A7', 'Total da exportação:')
        ->setCellValue('B7', number_format($sTotalExPort, 2, ',', '.'))
        ->setCellValue('A8', 'Dias de expedição:')
        ->setCellValue('B8', number_format($sTotalCount, 1, ',', '.'))
        ->setCellValue('A9', 'Média da expedição:')
        ->setCellValue('B9', number_format($sMedia, 2, ',', '.'))
        ->setCellValue('A10', 'Total da expedição:')
        ->setCellValue('B10', number_format($sTotalExpedido, 2, ',', '.'));
// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
/* $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);
  $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
  $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); */


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Solicitação nº');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="IndicadorExpedicao.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;

