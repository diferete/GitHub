<?php

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');

$rDataInicial = $_REQUEST['datainicial'];
$rDataFinal = $_REQUEST['datafin'];

$Data1 = new DateTime($rDataInicial);
$dataInicial = $Data1->format('Y-m-d');

$Data2 = new DateTime(($rDataFinal));
$dataFinal = $Data2->format('Y-m-d');


$sFiltroSql = " where pesdatacad between '".$dataInicial."' and '".$dataFinal."'";

//where pesdatacad between '2016-04-15' and '2016-04-19'

$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("report1.jrxml"); //report1 está apenas como este
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   