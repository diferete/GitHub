<?php

/*
 * Autor: Cleverton Hoffmann
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
include("../../includes/Config.php");
include("../../biblioteca/Utilidades/Util.php");

date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
$sUser = $_REQUEST['userRel'];
$iGrucod = $_REQUEST['grucod'];
$iGrucodFin = $_REQUEST['grucodfin'];
$iSubcod = $_REQUEST['subcod'];
$iSubcodFin = $_REQUEST['subcodfin'];
$iFamcod = $_REQUEST['famcod'];
$iFamcodFin = $_REQUEST['famcodfin'];
$iFamsub = $_REQUEST['famsub'];
$iFamsubFin = $_REQUEST['famsubfin'];

$sGrudes = $_REQUEST['grudes'];
$sGrudesFin = $_REQUEST['grudesfin'];
$sSubGrudes = $_REQUEST['subdes'];
$sSubGrudesFin = $_REQUEST['subdesfin'];
$sFamdes = $_REQUEST['famdes'];
$sFamdesFin = $_REQUEST['famdesfin'];
$sSubFamdes = $_REQUEST['famsdes'];
$sSubFamdesFin = $_REQUEST['famsdesfin'];

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);

$sSql = "SELECT "
        . "tbestWeb.procod,tbestWeb.prodes,estoque,unm,estoquePeso,DataEst "
        . "FROM tbestWeb "
        . "LEFT JOIN widl.prod01 "
        . "ON tbestWeb.procod = widl.prod01.procod "
        . "WHERE grucod BETWEEN '" . $iGrucod . "' AND '" . $iGrucodFin . "' "
        . "AND subcod BETWEEN '" . $iSubcod . "' AND '" . $iSubcodFin . "' "
        . "AND famcod BETWEEN '" . $iFamcod . "' AND '" . $iFamcodFin . "' "
        . "AND famsub BETWEEN '" . $iFamsub . "' AND '" . $iFamsubFin . "' "
        . "and widl.prod01.procod not in('54264') "
        . "and tbestWeb.procod is not null "
        . "ORDER BY  widl.prod01.procod asc ";
$dadosSql = $PDO->query($sSql);

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Relatório de Estoque de produto acabado');

$NomeArquivo = 'Consulta de Estoque - ' . $sData . ' - ' . $sHora ;

//Títulos da planhilha e filtros
    $objPHPExcel->setActiveSheetIndex(0)
            //Filtros
            ->setCellValue('A2', 'Filtros:')
            ->setCellValue('A3', 'Grupo:')
            ->setCellValue('A4', 'Sub.Grupo:')
            ->setCellValue('A5', 'Família:')
            ->setCellValue('A6', 'Sub.Família:')
            ->setCellValue('B3', "$iGrucod")
            ->setCellValue('C3', "$sGrudes")
            ->setCellValue('D3', "$iGrucodFin")
            ->setCellValue('E3', "$sGrudesFin")
            ->setCellValue('B4', "$iSubcod")
            ->setCellValue('C4', "$sSubGrudes")
            ->setCellValue('D4', "$iSubcodFin")
            ->setCellValue('E4', "$sSubGrudesFin")
            ->setCellValue('B5', "$iFamcod")
            ->setCellValue('C5', "$sFamdes")
            ->setCellValue('D5', "$iFamcodFin")
            ->setCellValue('E5', "$sFamdesFin")
            ->setCellValue('B6', "$iFamsub")
            ->setCellValue('C6', "$sSubFamdes")
            ->setCellValue('D6', "$iFamsubFin")
            ->setCellValue('E6', "$sSubFamdesFin")
    ;

$objPHPExcel->setActiveSheetIndex(0)
                    //titulos
                    ->setCellValue('A7', 'Item')
                    ->setCellValue('B7', 'Estoque')
                    ->setCellValue('C7', 'Und')
                    ->setCellValue('D7', 'Peso(Kg)')
            ;

$ik =8;
while ($aRow = $dadosSql->fetch(PDO::FETCH_ASSOC)) {

    $sProcod = ltrim(rtrim($aRow['procod']));
    $fEstoque = number_format($aRow['estoque'], 2, ',', '.');
    /* montar linhas a partir daqui para cada item */

    if ($fEstoque != '0,00') {
        $sProd = $sProcod . ' - ' . $aRow['prodes'];
        $sEst = $fEstoque;
        $sUnd = $aRow['unm'];
        $sEstPes = number_format($aRow['estoquePeso'], 2, ',', '.');
        
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . ($ik), "$sProd")
                ->setCellValue('B' . ($ik), "$sEst")
                ->setCellValue('C' . ($ik), "$sUnd")
                ->setCellValue('D' . ($ik), "$sEstPes")
        ;
        $ik++;
    }
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório de Estoque Acabado');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename=' . $NomeArquivo . '.xls');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;
