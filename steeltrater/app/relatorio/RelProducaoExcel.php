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

// Instanciamos a classe
$objPHPExcel = new PHPExcel();
      
// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

$style = array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, ) );

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Relatório de produção')
            ->mergeCells('A1:K1')
            ->getStyle("A1:K1")->applyFromArray($style);


//Inicio
//Pega data que o usuário digitou
$dtinicial = $_REQUEST['dataini'];
$dtfinal = $_REQUEST['datafinal'];

//Pega dados que passados pelo usuário na tela de relatório
$iEmpCodigo = $_REQUEST['emp_codigo'];
$sEmpDescricao = $_REQUEST['emp_razaosocial'];
$sFornodes = $_REQUEST['fornodes'];
$iFornoCod = $_REQUEST['fornocod'];
$sTurnoSteel = $_REQUEST['turnoSteel'];
$sListaEtapa = '';
if (isset($_REQUEST['listaEtapa'])) {
    $sListaEtapa = $_REQUEST['listaEtapa'];
}
$bRes = true;
if (isset($_REQUEST['resumido'])) {
    $bRes = false;
}
   
     
//busca os dados do banco
$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSqli = "SELECT "
        . "STEEL_PCP_ordensFabItens.op,"
        . "STEEL_PCP_ordensFabItens.fornodes,"
        . "STEEL_PCP_ordensFabItens.fornocod,"
        . "STEEL_PCP_ordensFabItens.turnoSteel,"
        . "STEEL_PCP_ordensFabApont.prodes,"
        . "convert(varchar,STEEL_PCP_ordensFabItens.dataent_forno,103)as dataent_forno,"
        . "convert(varchar,STEEL_PCP_ordensFabItens.horaent_forno,8)as horaent_forno,"
        . "convert(varchar,STEEL_PCP_ordensFabItens.datasaida_forno,103)as datasaida_forno,"
        . "convert(varchar,STEEL_PCP_ordensFabItens.horasaida_forno,8)as horasaida_forno,"
        . "STEEL_PCP_ordensFab.peso,"
        . "quant,"
        . "documento,"
        . "STEEL_PCP_ordensFab.situacao,"
        . "steel_pcp_ordensfab.emp_razaosocial,"
        . "emp_pessoa.emp_fantasia,"
        . "convert(varchar,data,103)as data,"
        . "STEEL_PCP_ordensFabItens.dataent_forno as dataent_forno2,"
        . "tratdes,"
        . "SUBSTRING(STEEL_PCP_ordensFabItens.usernome, 1,16) as userEntrada,"
        . "DATEDIFF(Minute,STEEL_PCP_ordensFabItens.horaent_forno,STEEL_PCP_ordensFabItens.horasaida_forno) as minutosh,"
        . "DATEDIFF(minute,STEEL_PCP_ordensFabItens.dataent_forno, STEEL_PCP_ordensFabItens.datasaida_forno) as minutosd,"
        . "eficienciaHora,"
        /* ------------ adicionados dados da fabitens ------------ */
        . "steel_pcp_ordensfabitens.temperatura,"
        . "steel_pcp_ordensfabitens.tempo,"
        . "steel_pcp_ordensfabitens.tratamento,"
        . "steel_pcp_ordensfabitens.CamadaEspessura,"
        . "steel_pcp_ordensfabitens.TempoZinc,"
        . "steel_pcp_ordensfabitens.PesoDoCesto,"
        /* ------------ ----------------------------- ------------ */
        . "DATEDIFF(minute,'" . $dtinicial . "', '" . $dtfinal . "') as diferencaFiltro "
        . "FROM steel_pcp_ordensfabitens "
        . "LEFT OUTER JOIN STEEL_PCP_ordensFabApont "
        . "ON steel_pcp_ordensfabitens.op = STEEL_PCP_ordensFabApont.op "
        . "LEFT OUTER JOIN steel_pcp_ordensfab "
        . "ON STEEL_PCP_ordensFabApont.op = steel_pcp_ordensfab.op "
        . "LEFT OUTER JOIN steel_pcp_tratamentos "
        . "ON steel_pcp_ordensfabitens.tratamento = steel_pcp_tratamentos.tratcod "
        . "LEFT OUTER JOIN emp_pessoa "
        . "ON steel_pcp_ordensfab.emp_codigo = emp_pessoa.emp_codigo "
        . "WHERE  steel_pcp_ordensfabitens.dataent_forno BETWEEN '" . $dtinicial . "' AND '" . $dtfinal . "'";

if ($iEmpCodigo !== '') {
    $sSqli .= " and steel_pcp_ordensfab.emp_codigo ='" . $iEmpCodigo . "'";
}
if ($iFornoCod !== '') {
    $sSqli .= " and steel_pcp_ordensfabitens.fornocod ='" . $iFornoCod . "'";
}
if ($sTurnoSteel != 'Todos') {
    $sSqli .= " and steel_pcp_ordensfabitens.turnoSteel = '" . $sTurnoSteel . "' ";
}

$sSqli .= " and steel_pcp_ordensfabitens.situacao = 'Finalizado' ";

$sSqli .= " and retrabalho<>'Retorno não Ind.' ";


$sSqli .= "ORDER  BY dataent_forno2,steel_pcp_ordensfabitens.fornodes,steel_pcp_ordensfabitens.turnosteel,horaent_forno";

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
            ->setCellValue('A3', 'Usuário:' )
            ->setCellValue('B3', "$usu" )
            ->setCellValue('A4','Data:')
            ->setCellValue('B4',"$dataEmis")
            ->setCellValue('A5','Hora:')
            ->setCellValue('B5',"$hora")
            ->setCellValue('F2', 'Filtros escolhidos' )
            ->setCellValue('F3', 'Turno' )
            ->setCellValue('G3', "$sTurnoSteel" )
            ->setCellValue('H3', 'Forno' )
            ->setCellValue('I3', "$sFornodes" )
            ->setCellValue('F4', 'Data Inicial' )
            ->setCellValue('G4', "$dtinicial" )
            ->setCellValue('F5', 'Data Final' )
            ->setCellValue('G5', "$dtfinal" )
            ->setCellValue('H4', 'CNPJ' )
            ->setCellValue('I4', "$iEmpCodigo" )
            ->setCellValue('H5', 'Empresa' )
            ->setCellValue('I5', "$sEmpDescricao" );
        
if ($bRes) {
//titulos
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A7', 'OP' )
            ->setCellValue('B7', 'DATA OP' )
            ->setCellValue('C7', 'DT.ENTRADA' )
            ->setCellValue('D7', 'H.ENTRADA' )
            ->setCellValue('E7', 'DT.SAIDA' )
            ->setCellValue('F7', 'H.SAIDA' )
            ->setCellValue('G7', 'TURNO' )
            ->setCellValue('H7', 'EQUIPAMENTO' )
            ->setCellValue('I7', 'SERVIÇO' )
            ->setCellValue('J7', 'CLIENTE' )
            ->setCellValue('K7', 'PESO' );
}

$Pesototal = 0;
$aPesoEficEq = array();
$aPesoEq = array();
$aPesoTur = array();
$iPesoT1 = 0;
$iPesoT2 = 0;
$iPesoT3 = 0;
$iPesoT4 = 0;
$iPesoG = 0;
$iPesoF = 0;

$sForno = '';
$sTurno = '';

$ik=8;

while ($row = $dadosRela->fetch(PDO::FETCH_ASSOC)) {
    //IF que realiza contagem de peso para os gráficos
    if (($sForno == '' || $sForno != $row['fornodes']) && !isset($aPesoEq[$row['fornodes']])) {
        $aPesoEq[$row['fornodes']] = [$row['peso'], $row['fornodes']];
        $aPesoEficEq[$row['fornodes']] = [$row['peso'], $row['fornodes'], $row['minutosd'] + $row['minutosh'], (float) number_format($row['eficienciaHora'], 2, ',', '.'), $row['fornocod']];
    } else {
        $aPesoEq[$row['fornodes']] = [$aPesoEq[$row['fornodes']][0] + $row['peso'], $row['fornodes']];
        $aPesoEficEq[$row['fornodes']] = [$aPesoEficEq[$row['fornodes']][0] + $row['peso'], $row['fornodes'], $aPesoEficEq[$row['fornodes']][2] + ($row['minutosd'] + $row['minutosh']), (float) number_format($aPesoEficEq[$row['fornodes']][3], 2, ',', '.'), $row['fornocod']];
    }

    $sForno = $row['fornodes'];
    if ($bRes) {
                
        $iOp = $row['op'];
        $dData = $row['data'];
        $dDataEnt = $row['dataent_forno'];
        $dHoraEnt = $row['horaent_forno'];
        $dDataSaida = $row['datasaida_forno'];
        $dHoraSaida = $row['horasaida_forno'];
        $sTurnoSteel = $row['turnoSteel'];
        $sFornoDes = $row['fornodes'];
        $sTratDes = $row['tratdes'];
        $sEmpFantasia = $row['emp_fantasia'];
        $iPeso = number_format($row['peso'], 2, ',', '.');
        
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($ik), "$iOp" )
            ->setCellValue('B'.($ik), "$dData" )
            ->setCellValue('C'.($ik), "$dDataEnt" )
            ->setCellValue('D'.($ik), "$dHoraEnt" )
            ->setCellValue('E'.($ik), "$dDataSaida" )
            ->setCellValue('F'.($ik), "$dHoraSaida" )
            ->setCellValue('G'.($ik), "$sTurnoSteel" )
            ->setCellValue('H'.($ik), "$sFornoDes" )
            ->setCellValue('I'.($ik), "$sTratDes" )
            ->setCellValue('J'.($ik), "$sEmpFantasia" )
            ->setCellValue('K'.($ik), "$iPeso" );
    }
    $ik++;
    $Pesototal = ($row['peso'] + $Pesototal);

    if (!isset($aPesoTur[$row['turnoSteel']])) {
        $aPesoTur[$row['turnoSteel']] = [$row['peso'], $row['turnoSteel']];
    } else {
        $aPesoTur[$row['turnoSteel']] = [$aPesoTur[$row['turnoSteel']][0] + $row['peso'], $row['turnoSteel']];
    }
    $nTempFiltroH = $row['diferencaFiltro'] / 60;
}

$Pesototal = number_format($Pesototal, 2, ',', '.');
if ($bRes) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.($ik), 'Peso Total: ' )
            ->setCellValue('K'.($ik), "$Pesototal" );
} else {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('J'.($ik), 'Peso Total Produzido: ' )
            ->setCellValue('K'.($ik), "$Pesototal" );
}

$ik = $ik+2;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($ik-1), 'Tabela de Eficiência:' )
            ->setCellValue('A'.($ik), 'Equipamento' )
            ->setCellValue('B'.($ik), 'Eficiencia fixa' )
            ->setCellValue('C'.($ik), 'Produção no Período' )
            ->setCellValue('D'.($ik), 'Projeção S/H. paradas' )
            ->setCellValue('E'.($ik), 'Projeção C/H. paradas' )
            ->setCellValue('F'.($ik), 'Total H. Paradas' )
            ->setCellValue('G'.($ik), 'Eficiência(%)' );
$ik++;
if (isset($nTempFiltroH)) {
    if ($nTempFiltroH == 0) {
        $nTempFiltroH = 24;
    } else {
        $nTempFiltroH = $nTempFiltroH + 24;
    }
} else {
    $nTempFiltroH = 24;
}

$nEficiencia = 0;
//Apresenta a tabela de eficiencia por equipamento
foreach ($aPesoEficEq as $key) {
    $nTempFiltroH1 = $nTempFiltroH;
    $sSqlh = "SELECT sum(horasparadas) AS totalhoras FROM STEEL_PCP_HorasParadas "
            . "WHERE "
            . "dataini between '" . $dtinicial . "' AND '" . $dtfinal . "' "
            . "and datafim between '" . $dtinicial . "' AND '" . $dtfinal . "' "
            . "and fornocod ='" . $key[4] . "'";
    $dadosHora = $PDO->query($sSqlh);
    $rowH = $dadosHora->fetch(PDO::FETCH_ASSOC);

    if ($rowH != null) {
        $nTempFiltroH1 = $nTempFiltroH1 - $rowH['totalhoras'];
        $iHorasTotal = $rowH['totalhoras'];
        if ($iHorasTotal >= 24) {
            $qDias = (int) ($iHorasTotal / 24);
            $qHoras = (int) ($iHorasTotal % 24);
            $qMin = round(((($iHorasTotal - ($qDias * 24)) - $qHoras) * 60), 0);
            $sTempoParada = $qDias . "dia(s) " . $qHoras . "h e " . $qMin . "min.";
        } else {
            if ($iHorasTotal < 24 && $iHorasTotal >= 1) {
                $qHoras = (int) ($iHorasTotal);
                $qMin = round((($iHorasTotal - $qHoras) * 60), 0);
                $sTempoParada = $qHoras . "h(s) e " . $qMin . "min.";
            } else {
                $qMin = (int) (($iHorasTotal) * 60);
                $sTempoParada = $qMin . " minutos";
            }
        }
    } else {
        $sTempoParada = '';
    }
    if ($key[3] != 0) {
        $nEfDias = ($nTempFiltroH1) * $key[3];
        $nEficiencia = ($key[0] / $nEfDias) * 100;
    }

    $sEquip = $key[1];
    $sEfiFix  = number_format($key[3], 2, ',', '.') . 'Kg/H';
    $sProdPer = number_format($key[0], 2, ',', '.');
    $sProjSh = number_format($key[3] * $nTempFiltroH, 2, ',', '.');
    $sProjCh = number_format($key[3] * $nTempFiltroH1, 2, ',', '.');
    $sTotalHp = $sTempoParada;
    $sEfi = number_format($nEficiencia, 2, ',', '.') . '%';
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.($ik), "$sEquip" )
            ->setCellValue('B'.($ik), "$sEfiFix" )
            ->setCellValue('C'.($ik), "$sProdPer" )
            ->setCellValue('D'.($ik), "$sProjSh" )
            ->setCellValue('E'.($ik), "$sProjCh" )
            ->setCellValue('F'.($ik), "$sTotalHp" )
            ->setCellValue('G'.($ik), "$sEfi" );
    $ik++;
    $nEficiencia = 0;
}


// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20); 
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(8); 
//
// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Relatório produção');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Relatório de produção.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

 