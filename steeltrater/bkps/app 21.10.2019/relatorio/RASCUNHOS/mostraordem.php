<?php


$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');


$cotcod = $_REQUEST['empcnpj'];
$od= $_REQUEST['odnr'];



$sFiltroSql = " where tbod.empcnpj = '".$cotcod."'
and tbod.odnr = '".$od."' ";
            
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtrosql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("mostraOrdem.jrxml");
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   
    








