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
$dataEmis      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date

//Datas escolhidas pelo usuário
if(isset($_REQUEST["dataini"])){
    $dtinicial = $_REQUEST["dataini"];
}

if(isset($_REQUEST["datafinal"])){
    $dtfinal = $_REQUEST["datafinal"];
}

// Instanciamos a classe
$objPHPExcel = new PHPExcel();
      
// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Relatório apontamentos de produção');

     //Pega dados que passados pelo usuário na tela de relatório
     $sRetrabalho = $_REQUEST['retrabalho'];
     $sSituacao=$_REQUEST['situa'];
     $iEmpCodigo=$_REQUEST['emp_codigo'];
     $sEmpDescricao=$_REQUEST['emp_razaosocial'];
     $sFornodes=$_REQUEST['fornodes'];
     $iFornoCod=$_REQUEST['fornocod'];
     
   
     
     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sSqli = "select STEEL_PCP_ordensFabApont.op,STEEL_PCP_ordensFabApont.fornodes, steel_pcp_ordensfabapont.turnoSteel,
               STEEL_PCP_ordensFabApont.prodes,convert(varchar,steel_pcp_ordensfabapont.dataent_forno,103)as dataent_forno,
               convert(varchar,steel_pcp_ordensfabapont.horaent_forno,8)as horaent_forno,
               convert(varchar,steel_pcp_ordensfabapont.datasaida_forno,103)as datasaida_forno,
               convert(varchar,steel_pcp_ordensfabapont.horasaida_forno,8)as horasaida_forno,STEEL_PCP_ordensFab.peso,quant,documento,
               STEEL_PCP_ordensFab.situacao,steel_pcp_ordensfab.emp_razaosocial,emp_pessoa.emp_fantasia,convert(varchar,data,103)as data,
               steel_pcp_ordensfabapont.dataent_forno as dataent_forno2,tratdes, steel_pcp_ordensfabapont.usernome as userEntrada
               from STEEL_PCP_ordensFabApont left outer join STEEL_PCP_ordensFab
               on STEEL_PCP_ordensFabApont.op = STEEL_PCP_ordensFab.op left outer join steel_pcp_ordensfabitens
               on STEEL_PCP_ordensFab.op = steel_pcp_ordensfabitens.op and steel_pcp_ordensfabitens.opseq = 1 left outer join steel_pcp_tratamentos
	       on steel_pcp_ordensfabitens.tratamento = steel_pcp_tratamentos.tratcod left outer join emp_pessoa
	       on steel_pcp_ordensfab.emp_codigo = emp_pessoa.emp_codigo
               where steel_pcp_ordensfabapont.dataent_forno between  '".$dtinicial."' and '".$dtfinal."'";
               if($iEmpCodigo!==''){     
               $sSqli.= " and steel_pcp_ordensfab.emp_codigo ='".$iEmpCodigo."'";
    
               } 
               if($iFornoCod!==''){
                   $sSqli.=" and STEEL_PCP_ordensFabApont.fornocod ='".$iFornoCod."'";
               }
               if($sSituacao!=='Todas'){
               if ($sSituacao=='Processo'){
                 $sSqli.=" and STEEL_PCP_ordensFabApont.situacao='Processo' ";
                 } else {
                 $sSqli.=" and STEEL_PCP_ordensFabApont.situacao='Finalizado' ";
                 }
               }
               if($sRetrabalho!='Incluir'){
                    $sSqli.=" and retrabalho='".$sRetrabalho."' ";
               }else{
                   $sSqli.=" and retrabalho<>'Retorno não Ind.' "; 
               }
               
        $sSqli.="order by dataent_forno2";
          
$dadosRela = $PDO->query($sSqli);
   

   if($sFornodes==null){
       $sFornodes='Todos';
   }   
   if($iEmpCodigo==null){
       $iEmpCodigo='Todos';
       $sEmpDescricao='Todos';
   }      

//Títulos da planhilha e filtros
$objPHPExcel->setActiveSheetIndex(0)
        //Filtros
            ->setCellValue('A2', 'Usuário:' )
            ->setCellValue('B2', "$usu" )
            ->setCellValue('A3','Data:')
            ->setCellValue('B3',"$dataEmis")
            ->setCellValue('A4','Hora:')
            ->setCellValue('B4',"$hora")
            ->setCellValue('C1', 'Filtros escolhidos' )
            ->setCellValue('C2', 'Situação' )
            ->setCellValue('D2', "$sSituacao" )
            ->setCellValue('E2', 'Forno' )
            ->setCellValue('F2', "$sFornodes" )
            ->setCellValue('C3', 'Data Inicial' )
            ->setCellValue('D3', "$dtinicial" )
            ->setCellValue('C4', 'Data Final' )
            ->setCellValue('D4', "$dtfinal" )
            ->setCellValue('E3', 'Empresa' )
            ->setCellValue('F3', "$iEmpCodigo" )
            ->setCellValue('E4', 'Retrabalho' )
            ->setCellValue('F4', "$sRetrabalho" )
        
        //titulos
            ->setCellValue('A5', 'Data' )
            ->setCellValue('B5', 'OP' )
            ->setCellValue('C5', 'Hora Entrada' )
            ->setCellValue('D5', 'Turno' )
            ->setCellValue('E5', 'Operador' )
            ->setCellValue('F5', 'Equipamento' )
            ->setCellValue('G5', 'Serviço' )
            ->setCellValue('H5', 'Produto' )
            ->setCellValue('I5', 'Cliente' )
            ->setCellValue('J5', 'Peso' )
            ->setCellValue('K5', 'Data Saída' )
            ->setCellValue('L5', 'Hora Saída' )  
            ->setCellValue('M5', 'Data OP' )  
        ;
  $ik=6;
  $iPesototal=0;
 // $iQuantidadetotal=0;
while($row = $dadosRela->fetch(PDO::FETCH_ASSOC)){  
    
    $dDataEnt = $row['dataent_forno'];
    $iOp = $row['op'];
    $dHoraEnt = $row['horaent_forno'];
    $sTurnoSt = $row['turnoSteel'];
    $sOperador = $row['userEntrada'];
    $sDesForno = $row['fornodes'];
    $sDesServico = $row['tratdes'];
    $sDesProd = $row['prodes'];
    $sEmpresa = $row['emp_fantasia'];
    $iPesototal=$iPesototal+$row['peso'];
    $iPeso = number_format($row['peso'], 2, ',', '.');
    $dDataSaid = $row['datasaida_forno'];
    $dHoraSaid = $row['horasaida_forno'];
    $dData = $row['data'];
   
    //$iQuantidadetotal=$iQuantidadetotal+$iQuant;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik), "$dDataEnt" ) //concatenação de variável indice/ Pulando Linha
        ->setCellValue('B'.($ik), "$iOp" )
        ->setCellValue('C'.($ik), "$dHoraEnt" )
        ->setCellValue('D'.($ik), "$sTurnoSt" )
        ->setCellValue('E'.($ik), "$sOperador" )
        ->setCellValue('F'.($ik), "$sDesForno" )
        ->setCellValue('G'.($ik), "$sDesServico" )
        ->setCellValue('H'.($ik), "$sDesProd" )
        ->setCellValue('I'.($ik), "$sEmpresa" )
        ->setCellValue('J'.($ik), "$iPeso" )
        ->setCellValue('K'.($ik), "$dDataSaid" )
        ->setCellValue('L'.($ik), "$dHoraSaid" )
        ->setCellValue('M'.($ik), "$dData" )
               
    ;
$ik++;
}
//pesos
$iPesototal = number_format($iPesototal, 2, ',', '.');
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik), 'Peso Total' )
        ->setCellValue('B'.($ik), "$iPesototal" );
       // ->setCellValue('A'.($ik), 'Quant.Total' ) 
       // ->setCellValue('B'.($ik), "$iQuantidadetotal" )


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12); //data
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(8); //op
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12); //hora entrada
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); //turno
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15); //operador
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15); //forno
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30); //serviço
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(45); //produto
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); //cliente
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(8); //peso
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(12); //data saída
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(12); //hora saída
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(12); //data op

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório apontamentos');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Relatório apontamentos de produção.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

 