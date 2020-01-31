<?php

/* 
 * Autor: Cleverton Hoffmann
 */

require '../../biblioteca/phpexcel/Classes/PHPExcel.php'; 
include("../../includes/Config.php"); 

//Cabeçalho
date_default_timezone_set('America/Sao_Paulo');
$dataEmis      = date("d/m/y");                     //função para pegar a data local
$hora      = date("H:i");                       //para pegar a hora com a função date
$NomeArquivo='Rel-';
$sUserRel = $_REQUEST['userRel'];
$sData = date('d/m/Y');
$sHora = date('H:i');
if (isset($_REQUEST['det'])){
    $bTip = $_REQUEST['det'];
}else{
    $bTip = false;
}
$dDatini = $_REQUEST['dataini'];
$dDatfin = $_REQUEST['datafinal'];
$sNrFat = $_REQUEST['nrfat'];
$sNrNota = $_REQUEST['nrnotaoc'];    
$sNrCon = $_REQUEST['nrconhe'];  
if (isset($_REQUEST['cnpj'])){
    $sCnpj = $_REQUEST['cnpj'];
    $sCnpjdes = $_REQUEST['cnpj'];
}else{
    $sCnpj = '';
    $sCnpjdes = 'Todos';
}

$sCodtip = $_REQUEST['codtipo'];
$sCodtipDes ='';
if($sCodtip==1){
                $sCodtipDes = 'Venda';
            }else if($sCodtip==2){
                $sCodtipDes = 'Compra';
            }else{
                $sCodtipDes = 'Todos';
}

// Instanciamos a classe
$objPHPExcel = new PHPExcel();
      
// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Relatório de Conhecimento de Frete');


     //busca os dados do banco
     $PDO = new PDO("sqlsrv:server=".Config::HOST_BD.",".Config::PORTA_BD."; Database=".Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
     $sql = "select nr,tbgerecfrete.cnpj,empdes,
            nrconhe,nrfat,nrnotaoc,totakg,totalnf,valorserv,convert (varchar,data,103) as data,sit,usuario,
            convert (varchar,dataem,103) as dataem, codtipo
            from tbgerecfrete left outer join widl.EMP01
            on tbgerecfrete.cnpj = widl.EMP01.empcod";
    
    $sql.=" where dataem between '" . $dDatini . "' and '" . $dDatfin . "'"; 
    
    if(isset($sCnpj)){
        $sql.=" and cnpj = '" . $sCnpj . "'";
    }
    if(isset($sNrFat)&&$sNrFat!=''){
        $sql.=" and nrfat ='" . $sNrFat . "'";
    }
    if(isset($sCodtip)&&$sCodtip!=0){
        $sql.=" and codtipo = '" . $sCodtip . "'";
    } 
    if(isset($sNrNota)&&$sNrNota!=''){
        $sql.=" and nrnotaoc = '" . $sNrNota . "'";
    } 
    if(isset($sNrCon)&&$sNrCon!=''){
        $sql.=" and nrconhe = '" . $sNrCon . "'";
    } 
    
    $sth = $PDO->query($sql);
    
    $iQntTotal = 0;
    $iTotalServVenda = 0;
    $iTotalServCompra = 0;
    $iVenda = 0;
    $iCompra = 0;
    $iTotalMedSevNot = 0;
    $iTotalPorcMedPrecKg = 0;

 
//Títulos da planhilha e filtros
$objPHPExcel->setActiveSheetIndex(0)
        //Filtros
            ->setCellValue('A2', 'Filtros:' )
            ->setCellValue('B2', 'Tipo:' )
            ->setCellValue('C2', "$sCodtipDes")
            ->setCellValue('D2', 'CNPJ')
            ->setCellValue('E2', "$sCnpjdes")
            ->setCellValue('F2', 'Data entre:')
            ->setCellValue('G2', "$dDatini")
            ->setCellValue('H2', "$dDatfin")
       ;
 
  $ik=6;
  $ik1=0;
while($row = $sth->fetch(PDO::FETCH_ASSOC)){  
   
   if($ik1==0){
    $sEmpresa = $row['empdes'];
    $objPHPExcel->setActiveSheetIndex(0)
      //titulos
            ->setCellValue('A3', 'CNPJ' )
            ->setCellValue('B3', 'EMPRESA' )
            ->setCellValue('A4', "$sCnpjdes" )
            ->setCellValue('B4', "$sEmpresa" )
            ->setCellValue('A5', 'Nr' )
            ->setCellValue('B5', 'Conhecimento' )
            ->setCellValue('C5', 'Fatura' )
            ->setCellValue('D5', 'Nota' )
            ->setCellValue('E5', 'Total Kg' )
            ->setCellValue('F5', 'Total R$' )
            ->setCellValue('G5', 'Valor Serviço' )
            ->setCellValue('H5', 'Tipo' )  
            ->setCellValue('I5', 'Dt. Emissão' )  
        ;
        $NomeArquivo = $row['nrfat'].'-'.rtrim($sCnpjdes).'-'. rtrim($sEmpresa);
   $ik1++;
   }

    $iNr = $row['nr'];
    $iConh = $row['nrconhe'];
    $sFat = $row['nrfat'];
    $sNota = $row['nrnotaoc'];
    $sTotalKg = $row['totakg'];
    $sTotalRs = $row['totalnf'];
    $sValorSer = $row['valorserv'];
    $sTipo ='';
    if($row['codtipo']==1){
                $sTipo = 'Venda'; 
                $iTotalServVenda = $iTotalServVenda+$sValorSer;
                $iVenda++;
    
            }else if($row['codtipo']==2){
                $sTipo = 'Compra';
                $iTotalServCompra = $iTotalServCompra+$sValorSer;
                $iCompra++;
    }
    $sDataEm = $row['dataem'];

   
    //$iQuantidadetotal=$iQuantidadetotal+$iQuant;
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik), "$iNr" ) //concatenação de variável indice/ Pulando Linha
        ->setCellValue('B'.($ik), "$iConh" )
        ->setCellValue('C'.($ik), "$sFat" )
        ->setCellValue('D'.($ik), "$sNota" )
        ->setCellValue('E'.($ik), "$sTotalKg" )
        ->setCellValue('F'.($ik), "$sTotalRs" )
        ->setCellValue('G'.($ik), "$sValorSer" )
        ->setCellValue('H'.($ik), "$sTipo" )
        ->setCellValue('I'.($ik), "$sDataEm" )
               
    ;
$ik++;
$iQntTotal++;

if($row['totalnf']!=0){
            $iTotalMedSevNot = $iTotalMedSevNot + ($row['valorserv']/$row['totalnf']);
        }else{
            $iTotalMedSevNot = $iTotalMedSevNot + ($row['valorserv']);
}
if($row['totakg']!=0){
            $iTotalPorcMedPrecKg = $iTotalPorcMedPrecKg + ($row['totalnf']/$row['totakg']);
        }else{
            $iTotalPorcMedPrecKg = $iTotalPorcMedPrecKg + ($row['totalnf']);   
}        
    
}
$iTotalMedSevNot = number_format(($iTotalMedSevNot*100)/$iQntTotal, 2);
$iTotalPorcMedPrecKg = number_format($iTotalPorcMedPrecKg/$iQntTotal, 2);
//Cálculos
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.($ik+1), 'Notas' ) 
        ->setCellValue('B'.($ik+1), '=COUNT(A5:A'.$ik.')' ) 
        ->setCellValue('A'.($ik+2), "Quantidade Venda" ) 
        ->setCellValue('B'.($ik+2), "$iVenda") 
        ->setCellValue('A'.($ik+3), "Quantidade Compra" ) 
        ->setCellValue('B'.($ik+3), "$iCompra" ) 
        ->setCellValue('A'.($ik+4), "Valor Total Notas(R$)" ) 
        ->setCellValue('B'.($ik+4), '=SUM(F5:F'.$ik.')' ) 
        ->setCellValue('A'.($ik+5), "Total de peso(Kg)" ) 
        ->setCellValue('B'.($ik+5), '=SUM(E5:E'.$ik.')' ) 
        ->setCellValue('A'.($ik+6), "Valor Serviços Venda(R$)" ) 
        ->setCellValue('B'.($ik+6), "$iTotalServVenda" ) 
        ->setCellValue('A'.($ik+7), "Valor Serviços Compra(R$)" ) 
        ->setCellValue('B'.($ik+7), "$iTotalServCompra") 
        ->setCellValue('A'.($ik+8), "Valor Serviços Total(R$)" ) 
        ->setCellValue('B'.($ik+8), '=SUM(G5:G'.$ik.')' ) 
        ->setCellValue('A'.($ik+9), "Total Valor Médio Preço/Kg(R$)" ) 
        ->setCellValue('B'.($ik+9), "$iTotalPorcMedPrecKg" ) 
        ->setCellValue('A'.($ik+10), "Total Valor Médio (valor serviço/valor nota)" ) 
        ->setCellValue('B'.($ik+10), "$iTotalMedSevNot" ) 
;


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12); 
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(12); 

// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório de Frete');

if($sCnpj==''){
    $NomeArquivo = "Relatorio de Frete";
}

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$NomeArquivo.'.xls');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

 