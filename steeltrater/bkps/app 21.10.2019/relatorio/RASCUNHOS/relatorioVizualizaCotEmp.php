<?php

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');

$teste = $_REQUEST['cotcod'];
$teste2 = $_REQUEST['Pessoa_codigo'];

if((isset($_REQUEST['cotcod']))and(isset($_REQUEST['Pessoa_codigo']))){
    $sFiltroSql ="where tbcotiten.cotcod = ".$_REQUEST['cotcod']
                 ." and tbcotitencomp.pescodigo = ".$_REQUEST['Pessoa_codigo']
                 ." and tbpessoa.empcodigo = 2 "
                 ." order by tbcotiten.cotseq";
}

$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("vizualizaCotEmp.jrxml");
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

