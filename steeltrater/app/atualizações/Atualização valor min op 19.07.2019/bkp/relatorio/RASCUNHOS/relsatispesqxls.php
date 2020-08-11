<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
include("../../includes/Config.php");


$Empcod = $_REQUEST['filcgc'];
$nr = $_REQUEST['nr'];
$usuario = $_REQUEST['usuario'];

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:H1')
        ->setCellValue('A1', 'PESQUISA DE SATISFAÇÃO DE CLIENTES');


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'Cnpj')
        ->setCellValue('B2', 'Empresa')
        ->setCellValue('C2', 'Comercial')
        ->setCellValue('D2', 'Requisito Prod.')
        ->setCellValue('E2', 'Embalagem')
        ->setCellValue('F2', 'Prazo')
        ->setCellValue('G2', 'Expectativa')
        ->setCellValue('H2', 'Indicação');

$objPHPExcel->getActiveSheet()->getStyle('A2:A55')->getNumberFormat()->setFormatCode('#');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);



$sql = "select empcod,empdes,comercial,prodrequisito,
prodembalagem,prodprazo,geralexpectativa,geralindica,obs,contato,seqrel 
from tbsatisclientepesq
where filcgc = '" . $Empcod . "' and nr ='" . $nr . "' order by seqrel";

$dadosEx = $PDO->query($sql);
$i = 3;
while ($row = $dadosEx->fetch(PDO::FETCH_ASSOC)) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['empcod'])
            ->setCellValue('B' . $i, $row['empdes'])
            ->setCellValue('C' . $i, $row['comercial'])
            ->setCellValue('D' . $i, $row['prodrequisito'])
            ->setCellValue('E' . $i, $row['prodembalagem'])
            ->setCellValue('F' . $i, $row['prodprazo'])
            ->setCellValue('G' . $i, $row['geralexpectativa'])
            ->setCellValue('H' . $i, $row['geralindica']);
    $i++;
}

/*
  $objPHPExcel->setActiveSheetIndex(0)
  ->setCellValue('A2', 'Usuário:' )
  ->setCellValue('B2', $usu )
  ->setCellValue('A3','Data:')
  ->setCellValue('B3',$dataEmis)
  ->setCellValue('A5','Total expedido em KG:')
  ->setCellValue('B5',number_format($sTotalGeral, 2, ',', '.'))
  ->setCellValue('A6','Total da exceção:')
  ->setCellValue('B6',number_format($sTotalEx, 2, ',', '.'))
  ->setCellValue('A7','Total da exportação:')
  ->setCellValue('B7',number_format($sTotalExPort, 2, ',', '.'))
  ->setCellValue('A8','Dias de expedição:')
  ->setCellValue('B8',number_format($sTotalCount, 1, ',', '.'))
  ->setCellValue('A9','Média da expedição:')
  ->setCellValue('B9',number_format($sMedia, 2, ',', '.'))
  ->setCellValue('A10','Total da expedição:')
  ->setCellValue('B10',number_format($sTotalExpedido, 2, ',', '.'));
  // Podemos configurar diferentes larguras paras as colunas como padrão
  $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
  $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
 */


// Podemos renomear o nome da planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Pesquisa de satisfação');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="PesquisaSatisfação.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;



