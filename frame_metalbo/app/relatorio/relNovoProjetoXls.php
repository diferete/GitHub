<?php

// Diretórios
require '../../biblioteca/phpexcel/Classes/PHPExcel.php';
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

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->getFont()->setBold(true);


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:P1')
        ->setCellValue('A1', 'RELATÓRIO DE PROJETOS GERADOS');


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'Nr')
        ->setCellValue('B2', 'Sit.Projetos')
        ->setCellValue('C2', 'Sit.Vendas')
        ->setCellValue('D2', 'Sit.Cliente')
        ->setCellValue('E2', 'Sit.Geral')
        ->setCellValue('F2', 'Cliente')
        ->setCellValue('G2', 'Dt.Imp')
        ->setCellValue('H2', 'Cód.Novo')
        ->setCellValue('I2', 'Descrição')
        ->setCellValue('J2', 'Acabamento')
        ->setCellValue('K2', 'Quant.')
        ->setCellValue('L2', 'Lote Min.')
        ->setCellValue('M2', 'Preço')
        ->setCellValue('N2', 'Prazo')
        ->setCellValue('O2', 'Representante')
        ->setCellValue('P2', 'Resp.Vendas')
;

$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(120);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);


$sql = "select nr,sitvendas,sitcliente,sitgeralproj,sitproj,procod,desc_novo_prod,repnome,resp_venda_nome,respvalproj,"
        . " tbqualNovoProjeto.empcod,empdes,convert(varchar,dtimp,103) as dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento"
        . " from tbqualNovoProjeto left outer join  widl.EMP01"
        . " on tbqualNovoProjeto.empcod  = widl.EMP01.empcod"
        . " where dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "' ";

if (($sSitProj !== '') || ($sSitVenda !== '') || ($sSitCli !== '') || ($sSitGeral !== '')) {
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
        if ($sSitProj == 'Cód. enviado') {
            $sql .= " and ";
            $sql .= " grucod = '" . $sTipoProd . "'";
        }
    }
}
$sql .= " group by nr,sitvendas,sitcliente,sitgeralproj,sitproj,procod,desc_novo_prod,repnome,resp_venda_nome,respvalproj,"
        . " tbqualNovoProjeto.empcod,empdes,dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento"
        . " order by nr";

$sth = $PDO->query($sql);

$i = 3;

while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {


    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['nr'])
            ->setCellValue('B' . $i, $row['sitproj'])
            ->setCellValue('C' . $i, $row['sitvendas'])
            ->setCellValue('D' . $i, $row['sitcliente'])
            ->setCellValue('E' . $i, $row['sitgeralproj'])
            ->setCellValue('F' . $i, $row['empdes'])
            ->setCellValue('G' . $i, $row['dtimp'])
            ->setCellValue('H' . $i, $row['procod'])
            ->setCellValue('I' . $i, $row['desc_novo_prod'])
            ->setCellValue('J' . $i, $row['acabamento'])
            ->setCellValue('K' . $i, $row['quant_pc'])
            ->setCellValue('L' . $i, $row['lotemin'])
            ->setCellValue('M' . $i, $row['precofinal'])
            ->setCellValue('N' . $i, $row['prazoentregautil'])
            ->setCellValue('O' . $i, $row['repnome'])
            ->setCellValue('P' . $i, $row['resp_venda_nome'])
    ;
    $i++;
}

// Podemos renomear o nome da planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatorio de Projetos');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relnovoprojeto.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;
