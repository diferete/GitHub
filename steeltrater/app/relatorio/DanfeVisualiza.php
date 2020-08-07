<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$aDados = array();
$aDados[0] = $_REQUEST['NFS_NotaFiscalFilial'];
$aDados[1] = $_REQUEST['NFS_NotaFiscalSeq'];

require '../../biblioteca/NFE/vendor/autoload.php';

include("../../includes/Config.php");
include("../../includes/Fabrica.php");
include("../../biblioteca/Utilidades/Email.php");

use NFePHP\DA\NFe\Danfe;

$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = $sSql = "select nfs_notafiscalnfechave, nfs_notafiscaldataemissao, nfs_notafiscaldatasaida, nfs_notafiscalhorasaida "
        . "from nfs_notafiscal "
        . "where nfs_notafiscalfilial = '" . $aDados[0] . "' "
        . "and nfs_notafiscalseq = '" . $aDados[1] . "' ";

$dadosSql = $PDO->query($sSql);
$aDadosNF = $dadosSql->fetch(PDO::FETCH_ASSOC);

$sDirXml = buscaDirXML($aDadosNF, $aDados);

$xml = file_get_contents($sDirXml);

$logo = 'data://text/plain;base64,' . base64_encode(file_get_contents('../../biblioteca/assets/images/logo.jpg'));

$horaSaida = date('H:i:s', strtotime($aDadosNF['nfs_notafiscalhorasaida']));
$dataSaida = date('d/m/Y', strtotime($aDadosNF['nfs_notafiscaldatasaida']));
$dataEmiss = date('d/m/Y', strtotime($aDadosNF['nfs_notafiscaldataemissao']));
$aData = explode('/', $dataSaida);
if ($aData[2] == '1753') {
    $dataSaida = '';
}
try {
    $danfe = new Danfe($xml);
    $danfe->debugMode(false);
    //$danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');

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
    $sDir = '\\\metalbobase\c$\Delsoft\DelsoftX\DelsoftNFe\nfe\8993358000174-STEELTRATER\\';

    $sData = date('d/m/Y', strtotime($aDadosNF['nfs_notafiscaldataemissao']));
    $aPastasDir = explode('/', $sData);

    //Ano e mês
    $sDir = $sDir . '\\' . $aPastasDir[2] . '-' . $aPastasDir[1] . '\\' . $aPastasDir[0] . '\\Proc';

    $sDir = $sDir . '\\' . trim($aDadosNF['nfs_notafiscalnfechave']) . '-nfeProc.xml';

    return $sDir;
}
