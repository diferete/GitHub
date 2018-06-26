<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

try {
    $conn = new PDO('mysql:host=192.168.0.141;dbname=steelmov', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

date_default_timezone_set('America/Sao_Paulo');
$sDataAnt = date('Y-m-d', strtotime('-7 days'));
$sData = date('Y-m-d');

$data = $conn->query("select * from steelmov_forno where dtent between '" . $sDataAnt . "' and '" . $sData . "' ");
$aRetorno = array();
$aDadosRet = array();
while ($oRow = $data->fetch(PDO::FETCH_OBJ)) {
    $aDadosRet['nr'] = $oRow->nr;
    $aDadosRet['ofsteel'] = $oRow->ofsteel;
    $aDadosRet['procodCod'] = $oRow->procodCod;
    $aDadosRet['prodes'] = $oRow->prodes;
    $aDadosRet['empcod'] = $oRow->empcod;
    $aDadosRet['empdes'] = $oRow->empdes;
    $aDadosRet['ofcliente'] = $oRow->ofcliente;
    $aDadosRet['dtent'] = $oRow->dtent;
    $aDadosRet['horaent'] = $oRow->horaent;
    $aDadosRet['forno'] = $oRow->forno;
    $aDadosRet['sit'] = $oRow->sit;
    $aDadosRet['dtsaida'] = $oRow->dtsaida;
    $aDadosRet['horasaida'] = $oRow->horasaida;
    $aRetorno[] = $aDadosRet;
}

echo json_encode($aRetorno);

