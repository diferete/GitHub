<?php

// Diretórios
require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');
if ($_REQUEST['empcod'] !== '') {
    $empcod = $_REQUEST['empcod'];
    $empdes = $_REQUEST['empdes'];
} else {
    $empcod = 'Todos';
    $empdes = 'Todos';
}

$dataIni = $_REQUEST['dataini'];
$dataFim = $_REQUEST['datafim'];

if (isset($_REQUEST['rep'])) {
    $rep = $_REQUEST['rep'];
}

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte - FORMATO NEGRITO DE CADA CÉLULA
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);

///////////Cabeçalho para a logo da metalbo//////////////
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:B2');

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('../../biblioteca/assets/images/logopn.png');
$objDrawing->setCoordinates('A1');
//setOffsetX works properly
$objDrawing->setOffsetX(5);
$objDrawing->setOffsetY(5);
//set width, height
$objDrawing->setWidth(100);
$objDrawing->setHeight(35);
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
////////Fim Cabeçalho para a logo da metalbo///////////////////
// Título do documento
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('C1:G2')
        ->setCellValue('C1', 'TÍTULOS A RECEBER EM ABERTO');
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('H1', 'Usuário:')
        ->setCellValue('I1', $sUserRel)
        ->mergeCells('I1:K1')
        ->setCellValue('H2', 'Data:')
        ->setCellValue('I2', $sData)
        ->setCellValue('J2', 'Hora:')
        ->setCellValue('K2', $sHora);

//Filtros
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A4', 'FILTROS')
        ->setCellValue('C4', 'CNPJ:')
        ->setCellValue('D4', $empcod)
        ->setCellValue('E4', 'Empresa')
        ->setCellValue('F4', $empdes)
        ->setCellValue('H4', 'Dt.Inicial')
        ->setCellValue('I4', $dataIni)
        ->setCellValue('J4', 'Dt.Final')
        ->setCellValue('K4', $dataFim)
;
$objPHPExcel->getActiveSheet()->getStyle('D4')->getNumberFormat()->setFormatCode("0");

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select replace(rTrim(replace(bcoagencia+bcoconta,' ','')),'-','') + CONVERT(varchar(20),recprcarco) + CONVERT(varchar(20),recprnrobc) AS NossoNumero,"
        . "recprnrobc, bcodes,"
        . "replace(rTrim(replace(bcoagencia+''+bcoconta,' ','')),'-','')as agConta,"
        . "recprcarco,recparnro,recprbconr,convert(varchar,recdtemiss,103) as recdtemiss,widl.REC001.empcod,empdes,widl.REC001.recdocto,"
        . "convert(varchar,recprdtpro,103) as recprdtpro,MONTH(recprdtpro) as mes, recprdtpgt,"
        . "recprvlr,recprvlpgt,recprindtr,recprtirec,"
        . "DATEDIFF(day,CONVERT (date, SYSDATETIME()),recprdtpro) as dias,"
        . "recof from widl.REC001(nolock) "
        . "left outer join widl.REC0012(nolock) "
        . "on widl.REC001.recdocto = widl.REC0012.recdocto "
        . "left outer join widl.EMP01(nolock) "
        . "on widl.REC001.empcod = widl.EMP01.empcod "
        . "left outer join WIDL.BANCOS "
        . "on WIDL.BANCOS.bconro = widl.REC0012.recprbconr "
        . "where recprdtpgt = '1753-01-01' "
        . "and widl.REC001.recdocto NOT LIKE 'T%' "
        . "and widl.REC001.recdocto NOT LIKE 'D%' "
        . "and widl.REC001.filcgc = '75483040000211' "
        . "and tpdcod = 1 ";
if ($rep !== '') {
    $sSql = $sSql . "and repcod in(" . $rep . ") ";
}
if ($empcod !== 'Todos') {
    $sSql = $sSql . "and widl.REC001.empcod = " . $empcod . "";
}if ($dataIni !== '' && $dataFim !== '') {
    $sSql = $sSql . "and recprdtpro between '" . $dataIni . "' and '" . $dataFim . "'";
}
$sSql = $sSql . "group by "
        . "repcod,widl.REC001.empcod,recdtemiss,empdes,widl.REC001.recdocto,recprdtpro,recprdtpgt,recprvlr,recprvlpgt,recprindtr,recprtirec,"
        . "recof,recparnro, recprcarco,recprnrobc,recprbconr,recparnro,bcodes,bcoagencia,bcoconta "
        . "order by mes asc";


$Dados = $PDO->query($sSql);
$iSomaCliente = 0;
$iTotal = 0;
$iEmp = 0;
$i = 6;
while ($row = $Dados->fetch(PDO::FETCH_ASSOC)) {

    if (isset($_REQUEST['atrasados'])) {
        if ($row['dias'] < 0) {
            if ($iEmp !== $row['empcod']) {
                $i++;
                if ($iEmp != 0) {
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $i, 'Soma Cliente:')
                            ->setCellValue('B' . $i, 'R$ ' . number_format($iSomaCliente, 2, ',', '.'));
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
                    $i++;
                }
                $i++;
                //Cabeçalhos
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, 'Cliente')
                        ->setCellValue('B' . $i, $row['empdes'])
                        ->setCellValue('D' . $i, 'CNPJ - Cliente')
                        ->setCellValue('E' . $i, $row['empcod'])
                        ->setCellValue('G' . $i, 'CNPJ - Metalbo')
                        ->setCellValue('H' . $i, '75483040000130')
                ;
                $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode("0");
                $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode("0");
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(true);
                $i++;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, 'Docto')
                        ->setCellValue('B' . $i, 'Emissão')
                        ->setCellValue('C' . $i, 'Vencimento')
                        ->setCellValue('D' . $i, 'Pedido')
                        ->setCellValue('E' . $i, 'Vlr.Receber')
                        ->setCellValue('F' . $i, 'Dias para pagar')
                        ->setCellValue('G' . $i, 'Ag.Benificiário-Carteira-Nosso Número')
                        ->setCellValue('H' . $i, 'Parcela')
                        ->setCellValue('I' . $i, 'Banco')
                        ->setCellValue('J' . $i, 'Nosso Número')
                ;
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFont()->setBold(true);
                $iEmp = $row['empcod'];
                $iSomaCliente = 0;
            }
            $i++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $row['recdocto'])
                    ->setCellValue('B' . $i, $row['recdtemiss'])
                    ->setCellValue('C' . $i, $row['recprdtpro'])
                    ->setCellValue('D' . $i, $row['recof'])
                    ->setCellValue('E' . $i, 'R$ ' . number_format($row['recprvlr'], 2, ',', '.'))
                    ->setCellValue('F' . $i, $row['dias'])
                    ->setCellValue('G' . $i, $row['NossoNumero'])
                    ->setCellValue('H' . $i, $row['recparnro'])
                    ->setCellValue('I' . $i, $row['bcodes'])
                    ->setCellValue('J' . $i, $row['recprnrobc'])
            ;
            if ($row['dias'] < 0) {
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFont()->getColor()->setRGB('FF0000');
            }
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode("0");
            $iSomaCliente = $iSomaCliente + $row['recprvlr'];
            $iTotal = $iTotal + $row['recprvlr'];
        }
    } else {
        if ($iEmp !== $row['empcod']) {
            $i++;
            if ($iEmp != 0) {
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $i, 'Soma Cliente:')
                        ->setCellValue('B' . $i, 'R$ ' . number_format($iSomaCliente, 2, ',', '.'));
                $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
                $i++;
            }
            $i++;
            //Cabeçalhos
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, 'Cliente')
                    ->setCellValue('B' . $i, $row['empdes'])
                    ->setCellValue('D' . $i, 'CNPJ - Cliente')
                    ->setCellValue('E' . $i, $row['empcod'])
                    ->setCellValue('G' . $i, 'CNPJ - Metalbo')
                    ->setCellValue('H' . $i, '75483040000130')
            ;
            $objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getNumberFormat()->setFormatCode("0");
            $objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getNumberFormat()->setFormatCode("0");
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(true);
            $i++;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, 'Docto')
                    ->setCellValue('B' . $i, 'Emissão')
                    ->setCellValue('C' . $i, 'Vencimento')
                    ->setCellValue('D' . $i, 'Pedido')
                    ->setCellValue('E' . $i, 'Vlr.Receber')
                    ->setCellValue('F' . $i, 'Dias para pagar')
                    ->setCellValue('G' . $i, 'Ag.Benificiário-Carteira-Nosso Número')
                    ->setCellValue('H' . $i, 'Parcela')
                    ->setCellValue('I' . $i, 'Banco')
                    ->setCellValue('J' . $i, 'Nosso Número')
            ;
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFont()->setBold(true);
            $iEmp = $row['empcod'];
            $iSomaCliente = 0;
        }
        $i++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['recdocto'])
                ->setCellValue('B' . $i, $row['recdtemiss'])
                ->setCellValue('C' . $i, $row['recprdtpro'])
                ->setCellValue('D' . $i, $row['recof'])
                ->setCellValue('E' . $i, 'R$ ' . number_format($row['recprvlr'], 2, ',', '.'))
                ->setCellValue('F' . $i, $row['dias'])
                ->setCellValue('G' . $i, $row['NossoNumero'])
                ->setCellValue('H' . $i, $row['recparnro'])
                ->setCellValue('I' . $i, $row['bcodes'])
                ->setCellValue('J' . $i, $row['recprnrobc'])
        ;
        if ($row['dias'] < 0) {
            $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':J' . $i)->getFont()->getColor()->setRGB('FF0000');
        }
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getNumberFormat()->setFormatCode("0");
        $iSomaCliente = $iSomaCliente + $row['recprvlr'];
        $iTotal = $iTotal + $row['recprvlr'];
    }

    $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#');
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
}
$i++;
$objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, 'Soma Cliente:')
        ->setCellValue('B' . $i, 'R$ ' . number_format($iSomaCliente, 2, ',', '.'));
$i++;
$i++;
$objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, 'TOTAL DOS TÍTULOS EM ABERTO:')
        ->setCellValue('B' . $i, 'R$ ' . number_format($iTotal, 2, ',', '.'));

// Podemos renomear o nome da planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatorio de Projetos');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="RelTitulosEmAberto.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;
