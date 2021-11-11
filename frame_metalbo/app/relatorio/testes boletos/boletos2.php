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
        . "widl.REC001.recdtemiss,"
        . "widl.REC001.recdocto,"
        . "widl.REC0012.recparnro,"
        . "widl.REC0012.recprcarco,"
        . "widl.REC0012.recprnrobc,"
        . "recprnro,"
        . "convert(varchar, widl.REC0012.recprdtpro, 103) as 'recprdtpro',"
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

$nossoNumero = trim($row['recprnrobc']);
$dataVenc = $row['recprdtpro'];

$valor = zeroFill(number_format($row['recprvlr'], 2, '', ''), 10);
$agencia = trim($row['bcoagencia']);
$carteira = substr($row['recprcarco'], 1, 1) . '.' . substr($row['recprcarco'], 1, 3);

$parte1 = '3419' . $carteira . substr($nossoNumero, 0, 2) . modulo_10('3419' . $row['recprcarco']);
//34191.12192 59554.742938 82968.330009 2 87850000222118
$teste = modulo_10(substr($nossoNumero, 1) . $agencia);
$parte2 = substr($nossoNumero, 2, 5) . '.' . substr($nossoNumero, 7, 2) . substr($agencia, 0, 3) . modulo_10(substr($nossoNumero, 0, 2) . $agencia);
$parte3 = '82968.33000' . modulo_10('8296833000');
$modulo = modulo_11('3419' . vencimento($dataVenc) . $valor . $row['recprcarco'] . $nossoNumero . '2938296833000');
if ($modulo['resto'] == 0 || $modulo['resto'] == 1 || $modulo['resto'] == 10) {
    $dv = 1;
} else {
    $dv = 11 - $modulo['resto'];
}
$parte4 = vencimento($dataVenc) . $valor;
$linhaDig = $parte1 . ' ' . $parte2 . ' ' . $parte3 . ' ' . $dv . ' ' . $parte4;

function vencimento($dataVenc) {
    $DataInicial = ('07/10/1997');
    $dias = ($dataVenc - $DataInicial);
    return $dias;
}

function zeroFill($valor, $digitos) {
    if (strlen($valor) > $digitos) {
        return $valor;
    }
    return str_pad($valor, $digitos, '0', STR_PAD_LEFT);
}

function modulo_10($nossoNumero) {

    $numtotal10 = 0;
    $fator = 2;

    //  Separacao dos numeros.
    for ($i = strlen($nossoNumero); $i > 0; $i--) {
        //  Pega cada numero isoladamente.
        $numeros[$i] = substr($nossoNumero, $i - 1, 1);
        //  Efetua multiplicacao do numero pelo (falor 10).
        $temp = $numeros[$i] * $fator;
        $temp0 = 0;
        foreach (preg_split('// ', $temp, -1, PREG_SPLIT_NO_EMPTY) as $v) {
            $temp0 += $v;
        }
        $parcial10[$i] = $temp0; // $numeros[$i] * $fator;
        //  Monta sequencia para soma dos digitos no (modulo 10).
        $numtotal10 += $parcial10[$i];
        if ($fator == 2) {
            $fator = 1;
        } else {
            // Intercala fator de multiplicacao (modulo 10).
            $fator = 2;
        }
    }

    $remainder = $numtotal10 % 10;
    $digito = 10 - $remainder;

    // Make it zero if check digit is 10.
    $digito = ($digito == 10) ? 0 : $digito;

    return $digito;

    /*
      Function TForm1.Calculo_DV(sCodStr: String): Integer;
      var
      i, x, ASomar, Soma: integer;
      Produto : String;
      begin
      x : = 2;
      Soma : = 0;
      for i : = length(sCodStr) downto 1 do
      begin
      Produto : = IntToStr(StrToInt(sCodStr[i])*x);
      if StrToInt(Produto) > 9 then
      ASomar : = StrToInt(Produto[1])+StrToInt(Produto[2])
      else
      ASomar : = StrToInt(Produto);

      Soma : = Soma + ASomar;
      if x = 2 then x : = 1 else x : = 2;
      end;

      Result : = 10-(Soma Mod 10);
      if Result > 9 then Result : = 0;

      end; */
}

function modulo_11($numero, $base = 9) {

    $fator = 2;
    $soma = 0;
    // Separacao dos numeros.
    for ($i = strlen($numero); $i > 0; $i--) {
        //  Pega cada numero isoladamente.
        $numeros[$i] = substr($numero, $i - 1, 1);
        //  Efetua multiplicacao do numero pelo falor.
        $parcial[$i] = $numeros[$i] * $fator;
        //  Soma dos digitos.
        $soma += $parcial[$i];
        if ($fator == $base) {
            //  Restaura fator de multiplicacao para 2.
            $fator = 1;
        }
        $fator++;
    }
    $result = array(
        'digito' => ($soma * 10) % 11,
        // Remainder.
        'resto' => $soma % 11,
    );
    if ($result['digito'] == 10) {
        $result['digito'] = 0;
    }
    return $result;

    /*
      Function TForm1.DigitoVerificador(sCodStr: String): Integer;
      var Soma, X, i : Integer;
      begin
      X : = 2;
      Soma : = 0;
      For i : = Length(sCodStr) downto 1 do
      begin
      Soma : = Soma + (StrToInt(sCodStr[i]) * X);
      inc(X);
      IF X = 10 Then X : = 2;
      end;

      Result : = 11 - (Soma mod 11);
      IF Result > 9 Then
      IF Length(sCodStr) = 43 Then
      Result : = 1
      else
      Result : = 0;
      end;
     */
}
