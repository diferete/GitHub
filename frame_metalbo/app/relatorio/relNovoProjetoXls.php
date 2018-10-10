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

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);


// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
        ->mergeCells('A1:K1')
        ->setCellValue('A1', 'RELATÓRIO DE PROJETOS GERADOS');


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);


$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A2', 'Nr')
        ->setCellValue('B2', 'Cliente')
        ->setCellValue('C2', 'Data Imp')
        ->setCellValue('D2', 'Prazo')
        ->setCellValue('E2', 'Situação')
        ->setCellValue('F2','Cód.Novo')
        ->setCellValue('G2', 'Descrição')
        ->setCellValue('H2', 'Acabamento')
        ->setCellValue('I2', 'Quantidade')
        ->setCellValue('J2', 'Lote Mínimo')
        ->setCellValue('K2', 'Representante')
        ->setCellValue('L2', 'Resp. Vendas')
        ->setCellValue('M2', 'Preço')
;

$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(4);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(120);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12);




$sql = "select nr,sitvendas,sitcliente,sitgeralproj,sitproj,procod,desc_novo_prod,repnome,resp_venda_nome,respvalproj,
tbqualNovoProjeto.empcod,empdes,convert(varchar,dtimp,103) as dtimp,quant_pc,lotemin,prazoentregautil,precofinal,acabamento
            from tbqualNovoProjeto left outer join  widl.EMP01
            on tbqualNovoProjeto.empcod  = widl.EMP01.empcod
            where dtimp BETWEEN '" . $data1 . "' and '" . $data2 . "' 
            order by nr";
$sth = $PDO->query($sql);
$row = $sth->fetch(PDO::FETCH_ASSOC);
$i = 3;




while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {

//    if ($row['sitproj'] == 'Reprovado') {
//        $sSitProj = 'Repr. em Projetos';
//    }
//    if ($row['sitvendas'] == 'Reprovado') {
//        $sSitProj = 'Repr. em Vendas';
//    }
//    if ($row['sitcliente'] == 'Reprovado') {
//        $sSitProj = 'Repr no Cliente';
//    }
//    if ($row['respvalproj'] == true) {
//        $sSitProj = 'Aprovado Geral';
//    }

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['nr'])
            ->setCellValue('B' . $i, $row['empdes'])
            ->setCellValue('C' . $i, $row['dtimp'])
            ->setCellValue('D' . $i, $row['prazoentregautil'])
            ->setCellValue('E' . $i, $row['sitproj'])
            ->setCellValue('F' . $i, $row['procod'])
            ->setCellValue('G' . $i, $row['desc_novo_prod'])
            ->setCellValue('H' . $i, $row['acabamento'])
            ->setCellValue('I' . $i, $row['quant_pc'])
            ->setCellValue('J' . $i, $row['lotemin'])
            ->setCellValue('K' . $i, $row['repnome'])
            ->setCellValue('L' . $i, $row['resp_venda_nome'])
            ->setCellValue('M' . $i, $row['precofinal'])
    ;
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
