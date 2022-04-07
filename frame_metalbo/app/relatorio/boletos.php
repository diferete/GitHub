<?php
require '../../biblioteca/bol/autoloader.php';
include("../../includes/Config.php");

use OpenBoleto\Banco\Itau;
use OpenBoleto\Banco\Bradesco;
use OpenBoleto\Banco\Caixa;
use OpenBoleto\Agente;

$dcto = $_REQUEST['recdocto'];
$parcela = $_REQUEST['recparnro'];
$prnro = $_REQUEST['recprnro'];
$cnpj = $_REQUEST['empcod'];
$banco = $_REQUEST['recprbconr'];

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
        . "DATEDIFF(day,CONVERT (date, SYSDATETIME()),widl.REC0012.recprdtpro) as dias,"
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

switch ($banco) {
    case in_array($banco, array('329', '0029', '0157', '10464', '11369', '1515', '1570', '2938', '329')): //itau
        verificaVencimento($row['dias']);
        verificaNossoNumero(trim($row['recprnrobc']));
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
            'conta' => trim($aConta[0]), // 5 dígitos
            // Parâmetro obrigatório somente se a carteira for
            // 107, 122, 142, 143, 196 ou 198
            //'codigoCliente' => 12345, // 5 dígitos
            'numeroDocumento' => $row['recdocto'] . '/ ' . $row['recparnro'], // 7 dígitos
            // Parâmetros recomendáveis
            //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
            'contaDv' => trim($aConta[1]),
            //'agenciaDv' => 1,
            'descricaoDemonstrativo' => array(// Até 5
            ),
            'instrucoes' => array(''
            ),
            // Parâmetros opcionais
            //'resourcePath' => '../resources',
            'moeda' => Itau::MOEDA_REAL,
            'dataDocumento' => new DateTime($row['recdtemiss']),
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
            'dias_vencimento' => $row['dias'],
        ));



        break;

    case in_array($banco, array('0006', '0009', '0070', '0071', '0077', '0777', '1171')): //bradesco
        verificaVencimento($row['dias']);
        verificaNossoNumero(trim($row['recprnrobc']));
        $sacado = new Agente($row['empdes'], $cnpj, $row['empend'], $row['cidcep'], $row['cidnome'], $row['estcod']); /* quem paga */
        $cedente = new Agente('METALBO INDUSTRIA DE FIXADORES METÁLICOS LTDA', '75.483.040/0001-30', 'R DUQUE DE CAXIAS 50', '89.178-000', 'Braço do Trombudo', 'SC'); /* quem recebe */

        if (strlen(rtrim($row['recprnrobc'])) > 11) {
            $nnm = substr(rtrim($row['recprnrobc']), 0, -1);
        } else {
            $nnm = rtrim($row['recprnrobc']);
        }
        $aConta = explode('-', $row['bcoconta']);
        $aAgencia = explode('-', $row['bcoagencia']);

        if (strlen(rtrim($aAgencia[0])) > 4) {
            $aAgencia[0] = substr(rtrim($aAgencia[0]), 0, -1);
        } else {
            $aAgencia[0] = rtrim($aAgencia[0]);
        }

        /*
          if ($row['recprcarco'] < 3) {
          $row['recprcarco'] = str_pad($row['recprcarco'], 3, '0', STR_PAD_LEFT);
          } */

        $boleto = new Bradesco(array(
            // Parâmetros obrigatórios
            'dataVencimento' => new DateTime($row['recprdtpro']),
            'valor' => number_format($row['recprvlr'], 2, '.', ''),
            'sequencial' => $nnm, // Até 11 dígitos
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => trim($aAgencia[0]), // Até 4 dígitos
            'carteira' => $row['recprcarco'], // 3, 6 ou 9
            'conta' => trim($aConta[0]), // Até 7 dígitos
            // Parâmetros recomendáveis
            //'logoPath' => 'http://empresa.com.br/logo.jpg', // Logo da sua empresa
            'contaDv' => trim($aConta[1]),
            'agenciaDv' => trim($aAgencia[1]),
            //'carteiraDv' => 1,
            'descricaoDemonstrativo' => array(// Até 5
            ),
            'instrucoes' => array('',
            ),
            // Parâmetros opcionais
            //'resourcePath' => '../resources',
            //'cip' => '000', // Apenas para o Bradesco
            'moeda' => Bradesco::MOEDA_REAL,
            'dataDocumento' => new DateTime($row['recdtemiss']),
            //'dataProcessamento' => new DateTime(),
            //'contraApresentacao' => true,
            //'pagamentoMinimo' => 23.00,
            //'aceite' => 'N',
            //'especieDoc' => 'DM',
            'numeroDocumento' => $row['recdocto'] . '/ ' . $row['recparnro'], // 7 dígitos
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

        break;
    default :
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <title>Boleto Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            </head>
            <body>
                <table style="font-family: Verdana, Arial, Helvetica, sans-serif;margin: 100px;font-size: -webkit-xxx-large;text-align: center;font-weight: bold;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <div>
                                            <span>BANCO NÃO SUPORTADO NO MOMENTO</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        <?php
        exit;
}

echo $boleto->getOutput();

function verificaNossoNumero($nnm) {
    if ($nnm == '' || $nnm == null) {
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <title>Boleto Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            </head>
            <body>
                <table style="font-family: Verdana, Arial, Helvetica, sans-serif;margin: 100px;font-size: -webkit-xxx-large;text-align: center;font-weight: bold;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <div >
                                            <span>
                                                NÃO POSSUI NOSSO NÚMERO! Verifique se os dados cadastrais do CLIENTE estão atualizados ou aguarde a remessa...
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        <?php
        exit;
    }
}

function verificaVencimento($dias) {
    if ($dias < 0) {
        ?>
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
        <html>
            <head>
                <title>Boleto Online</title>
                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            </head>
            <body>
                <table style="font-family: Verdana, Arial, Helvetica, sans-serif;margin: 100px;font-size: -webkit-xxx-large;text-align: center;font-weight: bold;">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <div >
                                            <span>
                                                BOLETO VENCIDO! Verificar com financeiro ou gerar nova via com valores atualizados no sistema do BANCO...
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        <?php
        exit;
    }
}
?>

