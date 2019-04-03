<?php

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');
require_once('../../biblioteca/Utilidades/Util.php');

$dataini= $_REQUEST['dataini'];
$datafim= $_REQUEST['datafim'];
$funcod = $_REQUEST['Fun_funcod'];
$funEmpresa = $_REQUEST['funempresa'];

$date = new DateTime($dataini);
$dataInicial = $date->format('Y-m-d');

$date = new DateTime($datafim);
$dataFinal = $date->format('Y-m-d');


//" where (tbnf.nfdataemiss between '".$dataInicial."' and '".$dataFinal."')";
//$sFiltroSql =" WHERE fundata >=".$data."";

$sFiltroSql = " where (fundata between '".$dataInicial."' and '".$dataFinal."') ";
if ($_REQUEST['Fun_funcod']){
  $sFiltroSql .= " and tbfunhoras.funcod ='".$funcod."'";  
}
if ($_REQUEST['funempresa']){
    if ($funEmpresa !='T'){
    $sFiltroSql.=" and funempresa ='".$funEmpresa."' ";
    }
}
 $sFiltroSql .=" GROUP BY tbfunhoras.funcod,fundata ORDER BY funnome,fundata";



$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("ApuraHorasMes.jrxml");
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



