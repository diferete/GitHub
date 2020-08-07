<?php

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');
require_once('../../biblioteca/Utilidades/Util.php');

/**
 * FAZ O TRATAMENTO DAS DATAS
 */
$date = new DateTime($_REQUEST['dataini']);
$dataInicial = $date->format('Y-m-d');
$date = new DateTime($_REQUEST['datafim']);
$dataFinal = $date->format('Y-m-d');

/**
 * CAPTURA DEMAIS DADOS
 */


$sFiltroSql ="where (tbnf.nfdataemiss between '".$dataInicial."' and '".$dataFinal."')
and tbpessoa.empcodigo = 2
group by grudes
order by total_grupo ";



$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("RelatorioCustos.jrxml");
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   