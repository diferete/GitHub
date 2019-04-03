<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/*include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc.php");*/

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');


//include_once ('setting.php');




$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array();
$PHPJasperXML->load_xml_file("sample6.jrxml");

$server = 'localhost';
$user = 'root';
$pass = 'M@quinas';
$db = 'rg_construtora';

$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I"); //page output method I:standard output D:Download file, F =save as filename and submit 2nd parameter as destinate file name /$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file



?>
