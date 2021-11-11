<?php
include("../../includes/Config.php");

$dcto = '390854-2'; //
$parcela = '2';
$prnro = '2';
$cnpj = '000616577000122'; //000616577000122


$PDO = new PDO("sqlsrv:server=" . Config::HOST_BD . "," . Config::PORTA_BD . "; Database=" . Config::NOME_BD, Config::USER_BD, Config::PASS_BD);
$sSql = "select "
        . "widl.REC001.empcod,"
        . "widl.EMP01.empdes,"
        . "widl.emp01.empend,"
        . "widl.emp01.cidcep,"
        . "widl.emp01.empendbair,"
        . "widl.cid01.cidnome,"
        . "widl.cid01.estcod,"
        . "convert(varchar,widl.REC001.recdtemiss,103) as 'recdtemiss',"
        . "widl.REC001.recdocto,"
        . "widl.REC0012.recparnro,"
        . "widl.REC0012.recprcarco,"
        . "widl.REC0012.recprnrobc,"
        . "recprnro,"
        . "convert(varchar,widl.REC0012.recprdtpro,103) as 'recprdtpro',"
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

$codigobanco = '341'; // O Itau sempre será este número
$agencia = trim($row['bcoagencia']);
$conta = substr($row['bcoconta'], 0, 5);  // 5 posições sem dígito
$carteira = $row['recprcarco']; // A sem registro é 175 para o Itaú
$moeda = '9'; // Sempre será 9 pois deve ser em Real
$nossonumero = substr(ltrim(rtrim($row['recprnrobc'])), 0, 8); // Número de controle do Emissor (pode usar qq número de até 8 digitos);
$data = $row['recdtemiss']; // Data de emissão do boleto
$vencimento = $row['recprdtpro']; // Data no formato dd/mm/yyyy
$valor = number_format($row['recprvlr'], 2, '.', ''); // Colocar PONTO no formato REAIS.CENTAVOS (ex: 666.01)
// NOS CAMPOS ABAIXO, PREENCHER EM MAIÚSCULAS E DESPREZAR ACENTUAÇÃO, CEDILHAS E
// CARACTERES ESPECIAIS (REGRAS DO BANCO)

$cedente = 'OVERSYS ASSESSORIA E CONSULTORIA LTDA';

$sacado = 'ORGANIZACOES TABARAJA';
$endereco_sacado = 'RUA DA RUA, 666';
$cidade = 'UBERLANDIA';
$estado = 'MG';
$cep = '38400-000';
$cpf_cnpj = 'CPF 000.000.000-00';

$instrucoes1 = 'COBRAR 10, 90 POR DIA DE ATRASO';
$instrucoes2 = 'NAO ACEITAR DEPOIS DE 15/02';
$instrucoes3 = 'SUJEITO A PROTESTO';
$instrucoes4 = '';
$instrucoes5 = 'WWW.POSER.COM.BR';

// FIM DA ÁREA DE CONFIGURAÇÃO




function zeroFill($valor, $digitos) {
    if (strlen($valor) > $digitos) {
        return $valor;
    }
    return str_pad($valor, $digitos, '0', STR_PAD_LEFT);
}

function Modulo11($valor) {
    $total = 0;
    $multiplicador = '4329876543298765432987654329876543298765432';
    for ($i = 0; $i <= 42; $i++) {
        $parcial = $valor[$i] * $multiplicador[$i];
        $total += $parcial;
    }
    $resultado = 11 - ($total % 11);
    if (($resultado >= 10) || ($resultado == 0)) {
        $resultado = 1;
    }

    return $resultado;
}

function calculaDAC($CalculaDAC) {
    $tamanho = strlen($CalculaDAC);
    $multiplicador = 2;
    $total = 0;
    for ($i = $tamanho - 1; $i >= 0; $i--) {
        $parcial = strval($CalculaDAC[$i] * $multiplicador);
        if ($parcial >= 10) {
            $parcial = $parcial[0] + $parcial[1];
        }
        $total += $parcial;
        if ($multiplicador !== 2) {
            $multiplicador = 2;
        } else {
            $multiplicador = 1;
        }
    }
    $total = 10 - ($total % 10);
    if ($total >= 10) {
        $total = 0;
    }
    return $total;
}

function calculaValor($valor) {
    $valor = str_replace('.', '', $valor);
    return str_repeat('0', (10 - strlen($valor))) . $valor;
}

function calculaNossoNumero($valor) {
    return str_repeat('0', (8 - strlen($valor))) . $valor;
}

function calculaFatorVencimento($dia, $mes, $ano) {
    $vencimento = mktime(0, 0, 0, $mes, $dia, $ano) - mktime(0, 0, 0, 07, 03, 2000);
    return ($vencimento / 86400) + 1000;
}

// CALCULO DO CODIGO DE BARRAS (SEM O DAC VERIFICADOR)
$codigo_barras = $codigobanco . $moeda . calculaFatorVencimento(substr($vencimento, 0, 2), substr($vencimento, 3, 2), substr($vencimento, 6, 4));
$codigo_barras .= calculaValor($valor) . $carteira . calculaNossoNumero($nossonumero) . calculaDAC($carteira . calculaNossoNumero($nossonumero)) . $agencia . $conta . calculaDAC($agencia . $conta) . '000';



// CALCULO DA LINHA DIGIT�VEL
$parte1 = $codigobanco . $moeda . substr($carteira, 0, 1) . substr($carteira, 1, 2) . substr(calculaNossoNumero($nossonumero), 0, 2);
$parte1 = substr($parte1, 0, 5) . '.' . substr($parte1, 5, 4) . calculaDAC($parte1);

$parte2 = substr(calculaNossoNumero($nossonumero), 2, 5) . substr(calculaNossoNumero($nossonumero), 7, 1) . calculaDAC($carteira . calculaNossoNumero($nossonumero)) . substr($agencia, 0, 3);
$parte2 = substr($parte2, 0, 5) . '.' . substr($parte2, 5, 5) . calculaDAC($parte2);

$parte3 = substr($agencia, 3, 1) . $conta . calculaDAC($agencia . $conta) . '000';
$parte3 = substr($parte3, 0, 5) . '.' . substr($parte3, 5, 8) . calculaDAC($parte3);

$parte5 = calculaFatorVencimento(substr($vencimento, 0, 2), substr($vencimento, 3, 2), substr($vencimento, 6, 4)) . calculaValor($valor);

$numero_boleto = $parte1 . ' ' . $parte2 . ' ' . $parte3 . ' ' . Modulo11($codigo_barras) . ' ' . $parte5;

// INSERÇÃO DO DAC NO CODIGO DE BARRAS

$codigo_barras = substr($codigo_barras, 0, 4) . Modulo11($codigo_barras) . substr($codigo_barras, 4, 43);

print $numero_boleto;
exit;
// IMPRESS�O DOS RESULTADOS OBTIDOS
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <title>Boleto Online</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <style type="text/css">
            <!--
            .style1 {
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-size: 12px;
                font-weight: bold;
            }
            .style3 {font-size: 12px; font-family: Verdana, Arial, Helvetica, sans-serif;}
            .style5 {
                font-size: 10px;
                font-family: Verdana, Arial, Helvetica, sans-serif;
                font-weight: bold;
            }
            .style7 {font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
            body {
                margin-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
            }
            -->
        </style>
    </head>

    <body>
        <table width="700"  border="0" cellpadding="0" cellspacing="1">
            <tr>
                <td bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2" rowspan="2" valign="bottom"><img src="img/logo-itau.gif" width="124" height="43"><img src="img/codigobanco-itau.gif" width="86" height="43"></td>
                            <td width="45%" valign="bottom"><div align="right"><img src="img/logo-oversys.gif" width="124" height="50"></div></td>
                        </tr>
                        <tr>
                            <td valign="bottom"><div align="right"><span class="style1">Recibo do Sacado</span></div></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td bgcolor="#FFFFFF"><table width="100%" height="315"  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr bgcolor="#FFFFFF">
                            <td colspan="3" valign="bottom" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td colspan="2"><img src="img/fundo-localpag.gif" width="210" height="17"></td>
                                    </tr>
                                    <tr>
                                        <td width="6">&nbsp;</td>
                                        <td width="438" class="style3">AT&Eacute; O VENCIMENTO, PREFERENCIALMENTE NO ITAU OU BANERJ<br>
                                            APOS O VENCIMENTO, SOMENTE NO ITAU OU BANERJ</td>
                                    </tr>
                                </table></td>
                            <td width="250" valign="top" bgcolor="#FFFFFF"><div align="center" class="style1">
                                    <div align="right">
                                        <table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                            <tr>
                                                <td colspan="2"><div align="left"><img src="img/fundo-vencimento.gif" width="150" height="17"></div></td>
                                            </tr>
                                            <tr>
                                                <td width="96%"><div align="right"><span class="style3"><? print $vencimento; ?></span></div></td>
                                                <td width="4%">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td colspan="3" valign="bottom" class="style3"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td colspan="2"><img src="img/fundo-cedente.gif" width="210" height="17"></td>
                                    </tr>
                                    <tr>
                                        <td width="6">&nbsp;</td>
                                        <td width="438" class="style3"><? print $cedente; ?></td>
                                    </tr>
                                </table></td>
                            <td width="250" valign="bottom" class="style3"><div align="right">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td colspan="2"><div align="left"><img src="img/fundo-agencia.gif" width="150" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td width="96%"><div align="right" class="style3"><? print $agencia; ?>/<? print $conta; ?>-<? print calculaDAC($agencia.$conta); ?></div></td>
                                            <td width="4%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </div></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td width="150" height="32" valign="top" class="style3"><div align="center">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td><div align="left"><img src="img/fundo-data.gif" width="103" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div align="center" class="style3"><? print $data; ?></div></td>
                                        </tr>
                                    </table>
                                </div></td>
                            <td width="150" valign="top" class="style3"><div align="center">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td><div align="left"><img src="img/fundo-especiedoc.gif" width="103" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div align="center" class="style3">DM</div></td>
                                        </tr>
                                    </table>
                                </div></td>
                            <td width="150" height="32" valign="top" class="style3"><div align="center">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td><div align="left"><img src="img/fundo-aceite.gif" width="103" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td><div align="center" class="style3">N</div></td>
                                        </tr>
                                    </table>
                                </div></td>
                            <td width="250" height="28" valign="bottom" class="style3"><div align="right">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td colspan="2"><div align="left"><img src="img/fundo-nossonum.gif" width="150" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td width="96%"><div align="right" class="style3"><? print $carteira; ?>/<? print calculaNossoNumero($nossonumero); ?>-<? print calculaDAC($agencia.$conta.$carteira.calculaNossoNumero($nossonumero)); ?></div></td>
                                            <td width="4%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </div></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td width="150" height="32" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td><div align="left"><img src="img/fundo-usobanco.gif" width="103" height="17"></div></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div align="center"></div></td>
                                    </tr>
                                </table></td>
                            <td width="150" height="32" valign="top" bgcolor="#FFFFFF" class="style3"><div align="center">
                                    <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                        <tr>
                                            <td><div align="left"><img src="img/fundo-carteira.gif" width="103" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div align="center" class="style3">175</div></td>
                                        </tr>
                                    </table>
                                </div></td>
                            <td width="150" height="32" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td><div align="left"><img src="img/fundo-especie.gif" width="103" height="17"></div></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div align="center" class="style3">R$</div></td>
                                    </tr>
                                </table></td>
                            <td width="250" height="28" valign="bottom" bgcolor="#FFFFFF" class="style3"><div align="right" class="style1">
                                    <table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                        <tr>
                                            <td colspan="2"><div align="left"><img src="img/fundo-valor.gif" width="150" height="17"></div></td>
                                        </tr>
                                        <tr>
                                            <td width="96%"><div align="right" class="style3"><? print str_replace('.',', ',$valor); ?></div></td>
                                            <td width="4%">&nbsp;</td>
                                        </tr>
                                    </table>
                                </div></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td height="90" colspan="3" rowspan="3" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td colspan="2"><img src="img/fundo-instrucoes.gif" width="437" height="17"></td>
                                    </tr>
                                    <tr>
                                        <td width="6">&nbsp;</td>
                                        <td width="438"><span class="style3"><span class="style7"><? print $instrucoes1; ?><br>
                                                    <? print $instrucoes2; ?><br>
                                                    <? print $instrucoes3; ?><br>
                                                    <? print $instrucoes4; ?><br>
                                                    <? print $instrucoes5; ?></span></span></td>
                                    </tr>
                                </table></td>
                            <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><div align="left"><img src="img/fundo-desconto.gif" width="150" height="17"></div></td>
                                    </tr>
                                    <tr>
                                        <td width="96%"><div align="right"></div></td>
                                        <td width="4%">&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><div align="left"><img src="img/fundo-multa.gif" width="150" height="17"></div></td>
                                    </tr>
                                    <tr>
                                        <td width="96%"><div align="right"></div></td>
                                        <td width="4%">&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                    <tr>
                                        <td colspan="2"><div align="left"><img src="img/fundo-valorcobrado.gif" width="150" height="17"></div></td>
                                    </tr>
                                    <tr>
                                        <td width="96%"><div align="right"></div></td>
                                        <td width="4%">&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                            <td colspan="4" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                    <tr>
                                        <td colspan="3"><img src="img/fundo-sacado.gif" width="104" height="17"></td>
                                    </tr>
                                    <tr>
                                        <td width="10">&nbsp;</td>
                                        <td width="434"><span class="style3"><? print $sacado; ?><br>
                                                <? print $endereco_sacado; ?> <br>
                                                <? print $cep; ?> <? print $cidade; ?>-<? print $estado; ?></span></td>
                                        <td width="250"><span class="style3"><? print $cpf_cnpj; ?></span></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td bgcolor="#FFFFFF"><div align="right"><img src="img/fundo-autenticacao.gif" width="134" height="18"></div></td>
            </tr>
            <tr>
                <td height="25" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
            <tr>
                <td height="5" bgcolor="#FFFFFF"><img src="img/linha-corte.gif" width="700" height="1"></td>
            </tr>
        </table>
        <table width="700"  border="0" cellpadding="0" cellspacing="1">
            <tr>
                <td colspan="2" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td colspan="2" rowspan="2"><img src="img/logo-itau.gif" width="124" height="43"><img src="img/codigobanco-itau.gif" width="86" height="43"></td>
                            <td width="72%" valign="bottom"><div align="right"></div></td>
                        </tr>
                        <tr>
                            <td valign="bottom"><div align="right"><span class="style5"><? print $numero_boleto; ?></span></div></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td colspan="2" bgcolor="#FFFFFF"><table width="100%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
                        <tr>
                            <td valign="top" bgcolor="#FFFFFF">          <table width="100%" height="315"  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                                    <tr bgcolor="#FFFFFF">
                                        <td colspan="3" valign="bottom" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td colspan="2"><img src="img/fundo-localpag.gif" width="210" height="17"></td>
                                                </tr>
                                                <tr>
                                                    <td width="6">&nbsp;</td>
                                                    <td width="438" class="style3">AT&Eacute; O VENCIMENTO, PREFERENCIALMENTE NO ITAU OU BANERJ<br>
                                                        APOS O VENCIMENTO, SOMENTE NO ITAU OU BANERJ</td>
                                                </tr>
                                            </table></td>
                                        <td width="250" valign="top" bgcolor="#FFFFFF"><div align="center" class="style1">
                                                <div align="right">
                                                    <table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                                        <tr>
                                                            <td colspan="2"><div align="left"><img src="img/fundo-vencimento.gif" width="150" height="17"></div></td>
                                                        </tr>
                                                        <tr>
                                                            <td width="96%"><div align="right"><span class="style3"><? print $vencimento; ?></span></div></td>
                                                            <td width="4%">&nbsp;</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td colspan="3" valign="bottom" class="style3"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td colspan="2"><img src="img/fundo-cedente.gif" width="210" height="17"></td>
                                                </tr>
                                                <tr>
                                                    <td width="6">&nbsp;</td>
                                                    <td width="438" class="style3"><? print $cedente; ?></td>
                                                </tr>
                                            </table></td>
                                        <td width="250" valign="bottom" class="style3"><div align="right">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td colspan="2"><div align="left"><img src="img/fundo-agencia.gif" width="150" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="96%"><div align="right" class="style3"><? print $agencia; ?>/<? print $conta; ?>-<? print calculaDAC($agencia.$conta); ?></div></td>
                                                        <td width="4%">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td width="150" height="32" valign="top" class="style3"><div align="center">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td><div align="left"><img src="img/fundo-data.gif" width="103" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div align="center" class="style3"><? print $data; ?></div></td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                        <td width="150" valign="top" class="style3"><div align="center">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td><div align="left"><img src="img/fundo-especiedoc.gif" width="103" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div align="center" class="style3">DM</div></td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                        <td width="150" height="32" valign="top" class="style3"><div align="center">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td><div align="left"><img src="img/fundo-aceite.gif" width="103" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td><div align="center" class="style3">N</div></td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                        <td width="250" height="28" valign="bottom" class="style3"><div align="right">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td colspan="2"><div align="left"><img src="img/fundo-nossonum.gif" width="150" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="96%"><div align="right" class="style3"><? print $carteira; ?>/<? print calculaNossoNumero($nossonumero); ?>-<? print calculaDAC($agencia.$conta.$carteira.calculaNossoNumero($nossonumero)); ?></div></td>
                                                        <td width="4%">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td width="150" height="32" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td><div align="left"><img src="img/fundo-usobanco.gif" width="103" height="17"></div></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div align="center"></div></td>
                                                </tr>
                                            </table></td>
                                        <td width="150" height="32" valign="top" bgcolor="#FFFFFF" class="style3"><div align="center">
                                                <table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                    <tr>
                                                        <td><div align="left"><img src="img/fundo-carteira.gif" width="103" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div align="center" class="style3">175</div></td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                        <td width="150" height="32" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td><div align="left"><img src="img/fundo-especie.gif" width="103" height="17"></div></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div align="center" class="style3">R$</div></td>
                                                </tr>
                                            </table></td>
                                        <td width="250" height="28" valign="bottom" bgcolor="#FFFFFF" class="style3"><div align="right" class="style1">
                                                <table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                                    <tr>
                                                        <td colspan="2"><div align="left"><img src="img/fundo-valor.gif" width="150" height="17"></div></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="96%"><div align="right" class="style3"><? print str_replace('.',', ',$valor); ?></div></td>
                                                        <td width="4%">&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </div></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td height="90" colspan="3" rowspan="3" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td colspan="2"><img src="img/fundo-instrucoes.gif" width="437" height="17"></td>
                                                </tr>
                                                <tr>
                                                    <td width="6">&nbsp;</td>
                                                    <td width="438"><span class="style3"><span class="style7"><? print $instrucoes1; ?><br>
                                                                <? print $instrucoes2; ?><br>
                                                                <? print $instrucoes3; ?><br>
                                                                <? print $instrucoes4; ?><br>
                                                                <? print $instrucoes5; ?></span></span></td>
                                                </tr>
                                            </table></td>
                                        <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td colspan="2"><div align="left"><img src="img/fundo-desconto.gif" width="150" height="17"></div></td>
                                                </tr>
                                                <tr>
                                                    <td width="96%"><div align="right"></div></td>
                                                    <td width="4%">&nbsp;</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td colspan="2"><div align="left"><img src="img/fundo-multa.gif" width="150" height="17"></div></td>
                                                </tr>
                                                <tr>
                                                    <td width="96%"><div align="right"></div></td>
                                                    <td width="4%">&nbsp;</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td width="250" height="28" valign="bottom" class="style3"><table width="100%"  border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td colspan="2"><div align="left"><img src="img/fundo-valorcobrado.gif" width="150" height="17"></div></td>
                                                </tr>
                                                <tr>
                                                    <td width="96%"><div align="right"></div></td>
                                                    <td width="4%">&nbsp;</td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr bgcolor="#FFFFFF">
                                        <td colspan="4" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="1">
                                                <tr>
                                                    <td colspan="3"><img src="img/fundo-sacado.gif" width="104" height="17"></td>
                                                </tr>
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="428"><span class="style3"><? print $sacado; ?><br>
                                                            <? print $endereco_sacado; ?> <br>
                                                            <? print $cep; ?> <? print $cidade; ?>-<? print $estado; ?></span></td>
                                                    <td width="250"><span class="style3"><? print $cpf_cnpj; ?></span></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td width="425" bgcolor="#FFFFFF"><img src="codigodebarra.php?valor=<? print $codigo_barras; ?>"></td>
                <td width="315" valign="top" bgcolor="#FFFFFF"><div align="right"><img src="img/fundo-autenticacao2.gif" width="274" height="17"></div></td>
            </tr>
        </table>
        <p>&nbsp;</p>
    </body>
</html>