<?php
include_once('../../biblioteca/PHPJasperXML/class/tcpdf/tcpdf.php');
include_once("../../biblioteca/PHPJasperXML/class/PHPJasperXML.inc.php");



$PHPJasperXML = new PHPJasperXML();
//$PHPJasperXML->debugsql=true;
//$PHPJasperXML->arrayParameter=array("parameter1"=>1);
$PHPJasperXML->load_xml_file("Blank_A4.jrxml");

//$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");