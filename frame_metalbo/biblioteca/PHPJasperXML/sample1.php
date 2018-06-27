<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc.php");
include_once ('setting.php');






$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=true;
$PHPJasperXML->arrayParameter=array("parameter1"=>1);
$PHPJasperXML->load_xml_file("sample1.jrxml");

$PHPJasperXML->transferDBtoArray('127.0.0.1','root','','producao');
$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>
