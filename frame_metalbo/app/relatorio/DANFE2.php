<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$aDados = array();
$aDados[0] = $_REQUEST['nfsfilcgc'];
$aDados[1] = $_REQUEST['nfsnfnro'];
$aDados[2] = $_REQUEST['nfsnfser'];

require '../../biblioteca/NFE/vendor/autoload.php';

include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

use NFePHP\DA\NFe\Danfe;

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = $sSql = "select nfsnfechv, nfsnfesit, nfsdtemiss, nfsclicgc, nfsdtsaida, nfshrsaida "
        . "from widl.NFC001 "
        . "where nfsfilcgc = '" . $aDados[0] . "' "
        . "and nfsnfnro = '" . $aDados[1] . "' "
        . "and nfsnfser = '" . $aDados[2] . "' ";

$dadosSql = $PDO->query($sSql);
$aDadosNF = $dadosSql->fetch(PDO::FETCH_ASSOC);

$sDirXml = buscaDirXML($aDadosNF, $aDados);

$xml = file_get_contents($sDirXml);

$logo = 'data://text/plain;base64,' . base64_encode(file_get_contents('../../biblioteca/assets/images/logo.jpg'));

$horaSaida = $aDadosNF['nfshrsaida'];
$dataSaida = date('d/m/Y', strtotime($aDadosNF['nfsdtsaida']));
$dataEmiss = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
$aData = explode('/', $dataSaida);
if ($aData[2] == '1753') {
    $dataSaida = '';
}

try {
    $danfe = new Danfe($xml);
    $danfe->debugMode(false);
    $danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');

    $danfe->monta($horaSaida, $dataSaida, $logo);

    $pdf = $danfe->render();
    //o pdf porde ser exibido como view no browser
    //salvo em arquivo
    //ou setado para download forçado no browser 
    //ou ainda gravado na base de dados
    header('Content-Type: application/pdf');
    echo $pdf;
} catch (InvalidArgumentException $e) {
    echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
}

///////////////////////////////////////////////// métodos adicionais////////////////////////////////////////////////////////
function buscaDirXML($aDadosNF, $aDados) {
    $sDir = '\\\sistema_metalbo\Delonei\Notas\\';
    if ($aDados[0] == '75483040000211') {
        $sDir = $sDir . '75483040000211-FILIAL';
    }
    if ($aDados[0] == '75483040000130') {
        $sDir = $sDir . '75483040000130-REX';
    }
    $sData = date('d/m/Y', strtotime($aDadosNF['nfsdtemiss']));
    $aPastasDir = explode('/', $sData);

    //Ano e mês
    $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

    $sSit = $aDadosNF['nfsnfesit'];

    $sDir = $sDir . '\\' . trim($aDadosNF['nfsnfechv']) . '-nfeProc.xml';


    return $sDir;
}
