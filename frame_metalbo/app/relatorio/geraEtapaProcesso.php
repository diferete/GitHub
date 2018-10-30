<?php

/**
 * 
 * ***/


// Diretórios
require '../../biblioteca/pdfjs/pdf_js.php';
include("../../includes/Config.php");

$sUserRel = $_REQUEST['userRel'];
date_default_timezone_set('America/Sao_Paulo');
$sData = date('d/m/Y');
$sHora = date('H:i');