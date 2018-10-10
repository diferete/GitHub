<?php

    header('content-type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    
    error_reporting(0);
    
    ob_start("mb_output_handler");   
    
    header("Content-Type: text/html; charset=utf-8",true);
    header("Expires: Mon, 01 Jan 1990 00:00:00 GMT");
    header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT"); 
    header("Cache-Control: no-store, no-cache, must-revalidate"); 
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
     
    session_start();
    $sPath = str_replace("\\","/",dirname(__FILE__));
    
    require_once($sPath.'/includes/Config.php');
    require_once($sPath.'/includes/Fabrica.php');
    require_once($sPath.'/biblioteca/Utilidades/Util.php');
    require_once($sPath.'/biblioteca/Utilidades/ToolsXML.php');
    require_once($sPath.'/biblioteca/Utilidades/Email.php');
    require_once ($sPath.'/biblioteca/phpexcel/Classes/PHPExcel.php');
    require_once($sPath.'/includes/Conexao.php');
    
    require_once($sPath.'/'.Config::APP_FOLDER.'/controller/Controller.php');
    require_once($sPath.'/'.Config::APP_FOLDER.'/controller/ControllerPrincipal.php');
    require_once($sPath.'/'.Config::APP_FOLDER.'/view/View.php');
    require_once($sPath.'/'.Config::APP_FOLDER.'/persistencia/Persistencia.php');
    require_once($sPath.'/'.Config::APP_FOLDER.'/persistencia/PersistenciaAcao.php');
    
    $oPrincipal = new ControllerPrincipal();
    $oPrincipal->getRequisicao();  
   ?>