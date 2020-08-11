<?php

/* 
 * Autor: Cleverton Hoffmann
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php'; 
include("../../includes/Config.php"); 

//Cabeçalho
if(isset($_REQUEST["userRel"])){
    $usu = $_REQUEST["userRel"];
}
date_default_timezone_set('America/Sao_Paulo');
$data      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date

//$aSeq = $_REQUEST["nSeq"]; //Não usado no momento

// Instanciamos a classe
$objPHPExcel = new PHPExcel();
      
// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'RELATÓRIO PRODUTOS/MATERIAL/RECEITA');
     
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSql = "select seqmat,prod,pro_descricao,STEEL_PCP_prodMatReceita.matcod,matdes,STEEL_PCP_prodMatReceita.cod,peca,
               durezaNucMin,durezaNucMax,NucEscala,tratrevencomp,ppap
               from STEEL_PCP_prodMatReceita left outer join 
               PRO_Produto on STEEL_PCP_prodMatReceita.prod = PRO_Produto.PRO_Codigo left outer join 
               STEEL_PCP_material on STEEL_PCP_prodMatReceita.matcod = STEEL_PCP_material.matcod left outer join 
               STEEL_PCP_receitas on STEEL_PCP_prodMatReceita.cod = STEEL_PCP_receitas.cod
               order by seqmat desc ";
     
          
   $dadosRela = $PDO->query($sSql);
   
    //Títulos da planhilha e filtros
    $objPHPExcel->setActiveSheetIndex(0)
        //Filtros
            ->setCellValue('A2', 'Usuário' )
            ->setCellValue('B2', "$usu" )
            ->setCellValue('C2','Data')
            ->setCellValue('D2',"$data")
            ->setCellValue('E2','Hora')
            ->setCellValue('F2',"$hora")
        //Títulos ds dados
            ->setCellValue('A3', 'SeqMat' )
            ->setCellValue('B3', 'Prod' )
            ->setCellValue('C3', 'ProdDes' )
            ->setCellValue('D3', 'MatCod' )
            ->setCellValue('E3', 'MatDes' )
            ->setCellValue('F3', 'Cod' )
            ->setCellValue('G3', 'Peça' )
            ->setCellValue('H3', 'DurezaNucMin' )
            ->setCellValue('I3', 'DurezaNucMax' )
            ->setCellValue('J3', 'NucEscala' )
            ->setCellValue('K3', 'TratRevnComp' )
            ->setCellValue('L3', 'PPAP' )
        ;
    
  $ik=4;
  
while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){  
    
    $sSeq = $row['seqmat'];
    $sProd = $row['prod'];
    $sProdDes = $row['pro_descricao'];
    $sMatCod = $row['matcod'];
    $sMatDes = $row['matdes'];
    $sCod = $row['cod'];
    $sPeca = $row['peca'];
    $sDurezaNucMin = $row['durezaNucMin'];
    $sDurezaNucMax = $row['durezaNucMax'];
    $sNucEscala = $row['NucEscala'];
    $sTratRevnComp = $row['tratrevencomp'];
    $sPPAP = $row['ppap'];
    
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik), "$sSeq" ) //concatenação de variável indice/ Pulando Linha
        ->setCellValue('B'.($ik), "$sProd" )
        ->setCellValue('C'.($ik), "$sProdDes" )
        ->setCellValue('D'.($ik), "$sMatCod" )
        ->setCellValue('E'.($ik), "$sMatDes" )
        ->setCellValue('F'.($ik), "$sCod" )
        ->setCellValue('G'.($ik), "$sPeca" )
        ->setCellValue('H'.($ik), "$sDurezaNucMin" )
        ->setCellValue('I'.($ik), "$sDurezaNucMax" )
        ->setCellValue('J'.($ik), "$sNucEscala" )
        ->setCellValue('K'.($ik), "$sTratRevnComp" )
        ->setCellValue('L'.($ik), "$sPPAP" )
    ;
$ik++;
}

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(48);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(45);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório ProdMatReceita');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Relatório Produto Material Receita.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

