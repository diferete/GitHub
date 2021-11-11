<?php

require '../../biblioteca/bol/autoloader.php';
include("../../includes/Config.php");

use OpenBoleto\Banco\Itau;
use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Agente;

$dcto = $_REQUEST['recdocto'];
$parcela = $_REQUEST['recparnro'];
$prnro = $_REQUEST['recprnro'];
$cnpj = $_REQUEST['empcod'];


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select "
        . "widl.REC001.empcod,"
        . "widl.EMP01.empdes,"
        . "widl.emp01.empend,"
        . "widl.emp01.cidcep,"
        . "widl.emp01.empendbair,"
        . "widl.cid01.cidnome,"
        . "widl.cid01.estcod,"
        . "widl.REC001.recdtemiss,"
        . "widl.REC001.recdocto,"
        . "widl.REC0012.recparnro,"
        . "widl.REC0012.recprcarco,"
        . "widl.REC0012.recprnrobc,"
        . "recprnro,"
        . "widl.REC0012.recprdtpro,"
        . "widl.REC0012.recprdtpgt,"
        . "widl.REC0012.recprvlr,"
        . "widl.REC0012.recprvlpgt,"
        . "widl.REC0012.recprindtr,"
        . "widl.REC0012.recprbconr,"
        . "widl.REC0012.recprbconr,"
        . "widl.BANCOS.bcoagencia,"
        . "widl.BANCOS.bcoconta "
        . "from widl.REC001(nolock) "
        . "left outer join widl.REC0012(nolock) "
        . "on widl.REC001.recdocto = widl.REC0012.recdocto "
        . "left outer join widl.EMP01(nolock) "
        . "on widl.REC001.empcod = widl.EMP01.empcod "
        . "left outer join  widl.BANCOS(nolock) "
        . "on widl.REC0012.recprbconr = widl.BANCOS.bconro "
        . "left outer join widl.cid01(nolock)  "
        . "on widl.emp01.cidcep = widl.cid01.cidcep "
        . "WHERE "
        . "widl.REC001.empcod = '" . $cnpj . "' "
        . "and widl.REC001.recdocto = '" . $dcto . "' "
        . "and widl.REC0012.recparnro =  " . $parcela . " "
        . "and widl.REC0012.recprnro = " . $prnro . " "
        . "and recprdtpgt = '1753-01-01' "
        . "and widl.REC001.recdocto NOT LIKE 'T%' "
        . "and widl.REC001.recdocto NOT LIKE 'D%' "
        . "and widl.REC001.filcgc = '75483040000211' "
        . "and tpdcod in (1,3) "
        . "ORDER BY recprdtpro ";
$dados = $PDO->query($sSql);

$row = $dados->fetch(PDO::FETCH_ASSOC);

if (strlen(rtrim($row['recprnrobc'])) > 8) {
    $nnm = substr(rtrim($row['recprnrobc']), 0, -1);
} else {
    $nnm = rtrim($row['recprnrobc']);
}

$aConta = explode('-', $row['bcoconta']);

$sacado = new Agente($row['empdes'], $cnpj, $row['empend'], $row['cidcep'], $row['cidnome'], $row['estcod']); /* quem paga */
$cedente = new Agente('METALBO INDUSTRIA DE FIXADORES METÁLICOS LTDA', '75.483.040/0001-30', 'R DUQUE DE CAXIAS 50', '89.178-000', 'Braço do Trombudo', 'SC'); /* quem recebe */

$boleto = new Itau(array(
    // Parâmetros obrigatórios
    'dataVencimento' => new DateTime($row['recprdtpro']),
    'valor' => number_format($row['recprvlr'], 2, '.', ''),
    'sequencial' => $nnm, // 8 dígitos
    'sacado' => $sacado,
    'cedente' => $cedente,
    'agencia' => trim($row['bcoagencia']), // 4 dígitos
    'carteira' => $row['recprcarco'], // 3 dígitos
    'conta' => $aConta[0], // 5 dígitos
    // Parâmetro obrigatório somente se a carteira for
    // 107, 122, 142, 143, 196 ou 198
    //'codigoCliente' => 12345, // 5 dígitos
    'numeroDocumento' => $row['recdocto'] . '/ ' . $row['recparnro'], // 7 dígitos
    // Parâmetros recomendáveis
    //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
    'contaDv' => $aConta[1],
    //'agenciaDv' => 1,
    'descricaoDemonstrativo' => array(// Até 5
    ),
    'instrucoes' => array(// Até 8
        'Após o vencimento cobrar mora de R$4,19 ao dia',
        'Protestar após 20 dias corridos do vencimento',
        'Cobrança escritural',
    ),
    // Parâmetros opcionais
    //'resourcePath' => '../resources',
    'moeda' => Itau::MOEDA_REAL,
    //'dataDocumento' => new DateTime(),
    //'dataProcessamento' => new DateTime(),
    //'contraApresentacao' => true,
    //'pagamentoMinimo' => 23.00,
    //'aceite' => 'N',
    'especieDoc' => 'DMI',
    'usoBanco' => '',
        //'layout' => 'layout.phtml',
        //'logoPath' => 'http://boletophp.com.br/img/opensource-55x48-t.png',
        //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
        //'descontosAbatimentos' => 123.12,
        //'moraMulta' => 123.12,
        //'outrasDeducoes' => 123.12,
        //'outrosAcrescimos' => 123.12,
        //'valorCobrado' => 123.12,
        //'valorUnitario' => 123.12,
        //'quantidade' => 1,
        ));

echo $boleto->getOutput();
