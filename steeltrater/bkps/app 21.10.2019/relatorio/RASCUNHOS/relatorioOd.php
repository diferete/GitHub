<?php


$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
//require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');


$odcod = $_REQUEST['odcod'];
$od_Odcod = $_REQUEST['Od_odcod'];
$param = '';
$param =(isset($odcod )) ? $odcod : $od_Odcod;


$sFiltroSql = " where tbod.odcod =".$param."
and tbpessoa.empcodigo = 2
order by tboditen.odseq";
            
$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("vizualizaOd.jrxml");
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   
    










