<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require '../../biblioteca/NFE/vendor/autoload.php';
//include '../../biblioteca/fpdf/fpdf.php';

use NFePHP\DA\NFe\Danfe;

$xml = file_get_contents(__DIR__ . '/xml/42200275483040000211550020003244391673717673.xml');

try {
    $danfe = new Danfe($xml);
    $danfe->debugMode(false);
    $danfe->creditsIntegratorFooter('WEBNFe Sistemas - http://www.webenf.com.br');
    //$danfe->monta($logo);
     $pdf = $danfe->render();
    //o pdf porde ser exibido como view no browser
    //salvo em arquivo
    //ou setado para download forçado no browser 
    //ou ainda gravado na base de dados
    header('Content-Type: application/pdf');
    echo $pdf;
    //header('Content-Type: application/pdf');
} catch (InvalidArgumentException $e) {
    echo "Ocorreu um erro durante o processamento :" . $e->getMessage();
}