<?php

$sPath = str_replace("\\","/",dirname(__FILE__));
require_once('../../includes/Config.php');
require_once('../../includes/Fabrica.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/tcpdf/tcpdf.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/class/PHPJasperXML.inc.php');
require_once('../../biblioteca'.Config::JASPER_FOLDER.'/setting.php');
require_once('../../biblioteca/Utilidades/Util.php');

$funcod= $_REQUEST['Fun_funcod'];

$var =  Util::getPrimeiroDiaMes();
        $date = str_replace('/', '-', $var);
        $dataInicial = date('Y-m-d', strtotime($date));

if(isset($_REQUEST['Fun_funcod'])){
    $sFiltroSql =" where tbfunhoras.funcod =".$funcod."
and fundata >= '".$dataInicial."' GROUP BY tbfunhoras.funcod,tbfunhoras.fundata";
}

$PHPJasperXML = new PHPJasperXML();
$PHPJasperXML->debugsql=false;
$aParametros[filtroSql] = $sFiltroSql;
$PHPJasperXML->arrayParameter=$aParametros;
$PHPJasperXML->load_xml_file("RelatorioFunHoras.jrxml");
$server = Config::HOST_BD;
$user = Config::USER_BD;
$pass = Config::PASS_BD;
$db = Config::NOME_BD;
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
$PHPJasperXML->outpage("I");   

