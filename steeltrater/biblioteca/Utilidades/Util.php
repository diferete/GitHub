<?php

/**
 * Classe que implementa várias funcões Uteis para o dia-a-dia
 * 
 * @author Everton Porath
 * @since 20/11/2013
 */
class Util {

    //constantes para máscaras de valores
    const MASCARA_CPF = '###.###.###-##';
    const MASCARA_CNPJ = '##.###.###/####-##';
    const MASCARA_FONE = '(##) ####-####';
    const MASCARA_CEP = '#####-###';
    const MASCARA_NCM = '####.##.##-###';

    function maskNew($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            }
            else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public function getHoraAtual() {
        $h = (float) (date('H') * 3600);
        $m = (float) (date('i') * 60);
        $s = (float) (date('s') * 1);
        $horaAtual = ($h + $m + $s);

        return $horaAtual;
    }

    public function getYear() {

        $sYear = date("Y");
        return $sYear;
    }

    public function getHoraAtualS() {
        date_default_timezone_set('America/Sao_Paulo');
        $horaAtual = date('H:i:s');

        return $horaAtual;
    }

    public static function getDataAtual() {
        date_default_timezone_set('America/Sao_Paulo');
        return date("d/m/Y");
    }

    public static function getDataAtualYMD() {
        date_default_timezone_set('America/Sao_Paulo');
        return date("Y-m-d");
    }

    public static function getDataHoraAtual() {
        date_default_timezone_set('America/Sao_Paulo');
        return date("c");
    }

    public static function getUltimoDiaMes($mes = null, $ano = null) {
        if (!isset($mes)) {
            $mes = date("m");
        }
        if (!isset($ano)) {
            $ano = date("Y");
        }
        $ultimo_dia = date("t", mktime(0, 0, 0, $mes, '01', $ano)); // Mágica, plim!        
        return "$ultimo_dia/$mes/$ano";
    }

    public static function getPrimeiroDiaMes($mes = null, $ano = null) {
        if (!isset($mes)) {
            $mes = date("m");
        }
        if (!isset($ano)) {
            $ano = date("Y");
        }
        return "01/$mes/$ano";
    }

    /**
     * Se for informado true no segundo parâmetro, o resultado será ?dois reais?.Se for informado false, o resultado será ?dois?.     
     */
    public static function valorPorExtenso($valor = 0, $complemento = true, $tipoMoeda = 1) {
        $moedaSingular = "real";
        $moedaPlural = "reais";
        if ($tipoMoeda == self::Dolar) {
            $moedaSingular = "dolar";
            $moedaPlural = "dolares";
        }

        $singular = array("centavo", $moedaSingular, "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", $moedaPlural, "mil", "milhões", "bilhões", "trilhões", "quatrilhões");

        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "tres", "quatro", "cinco", "seis", "sete", "oito", "nove");

        $z = 0;

        $valor = number_format($valor, 2, ".", ".");
        $inteiro = explode(".", $valor);
        for ($i = 0; $i < count($inteiro); $i++)
            for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
                $inteiro[$i] = "0" . $inteiro[$i];

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;) 
        $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
        for ($i = 0; $i < count($inteiro); $i++) {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count($inteiro) - 1 - $i;
            if ($complemento == true) {
                $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
                if ($valor == "000")
                    $z++;
                elseif ($z > 0)
                    $z--;
                if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
                    $r .= (($z > 1) ? " de " : "") . $plural[$t];
            }
            if ($r)
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }

        return($rt ? $rt : "zero");
    }

    public static function dataAtualPorExtenso() {
        $listaMes = array("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
        $dia = date('d');
        $mes = date('m');
        $ano = date('Y');
        return $dia . " de " . $listaMes[$mes - 1] . " de " . $ano;
    }

    public static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                $maskared .= $val[$k++];
            } else {
                $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

    public static function formataMoeda($valor) {
        $aDecimais = explode('.', $valor);
        $iQtdDecimais = strlen($aDecimais[1]) < 2 ? 2 : strlen($aDecimais[1]);

        return number_format($valor, $iQtdDecimais, ",", ".");
    }

    public static function formataSqlDecimal($valor) {
        $iValor = bcdiv($valor, 1, 2);
        $aDecimais = explode('.', $iValor);
        $sValor = $aDecimais[0] . ',' . $aDecimais[1];
        return $sValor;
    }

    public static function removeAcentos($sString) {

        $sTabAcento = array(
            'Á' => 'a',
            'Í' => 'i',
            'Ó' => 'o',
            'Ú' => 'u',
            'É' => 'e',
            'Ä' => 'a',
            'Ï' => 'i',
            'Ö' => 'o',
            'Ü' => 'u',
            'Ë' => 'e',
            'À' => 'a',
            'Ì' => 'i',
            'Ò' => 'o',
            'Ù' => 'u',
            'È' => 'e',
            'Ã' => 'a',
            'Õ' => 'o',
            'Â' => 'a',
            'Î' => 'i',
            'Ô' => 'o',
            'Û' => 'u',
            'Ê' => 'e',
            'á' => 'a',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'é' => 'e',
            'ä' => 'a',
            'ï' => 'i',
            'ö' => 'o',
            'ü' => 'u',
            'ë' => 'e',
            'à' => 'a',
            'ì' => 'i',
            'ò' => 'o',
            'ù' => 'u',
            'è' => 'e',
            'ã' => 'a',
            'õ' => 'o',
            'â' => 'a',
            'î' => 'i',
            'ô' => 'o',
            'û' => 'u',
            'ê' => 'e',
            'Ç' => 'c',
            'ç' => 'c'
        );
        return strtr($sString, $sTabAcento);
    }

    /**
     * Função que checa se uma string possui uma data válida
     * 
     * @param timestamp $dDateTime
     * @return boolean
     */
    public static function isValidDate($dDateTime) {
        if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", (string) $dDateTime, $aData)) {
            if (checkdate($aData[2], $aData[3], $aData[1])) {
                return true;
            }
        }
        return false;
    }

    /**
     * retorna data para inserção no mysql
     */
    public function dataMysql($dData) {
        $date = implode('-', array_reverse(explode('/', $dData)));

        return $date;
    }

    /**
     * Converte data do padrão Americano/SQL com traços para Brasileiro com barras em situações específicas
     * 
     * @param string $sData Recebe string data para converter
     * */
    public static function validaDateTime($sData) {
        if (strtotime($sData)) {
            $aData = explode(" ", $sData);
            $sDataConvertida = Util::converteData($aData[0]);

            $data = explode("/", $sDataConvertida); // fatia a string $dat em pedados, usando / como referência
            $d = $data[0];
            $m = $data[1];
            $y = $data[2];

            // verifica se a data é válida!
            // 1 = true (válida)
            // 0 = false (inválida)
            $res = checkdate($m, $d, $y);
            if ($res == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function converteData($sData) {
        $aData = explode(" ", $sData);
        $data = explode('-', $aData[0]);
        $d = $data[2];
        $m = $data[1];
        $a = $data[0];

        $sDataConvertida = $d . "/" . $m . "/" . $a;

        return $sDataConvertida;
    }

    /**
     * testa se o formato é data
     */
    public function ValidaData($dat) {
        $data = explode("/", "$dat"); // fatia a string $dat em pedados, usando / como referência
        $d = $data[0];
        $m = $data[1];
        $y = $data[2];

        // verifica se a data é válida!
        // 1 = true (válida)
        // 0 = false (inválida)
        $res = checkdate($m, $d, $y);
        if ($res == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Escapa aspas para situações onde usa setSValor()
     * 
     * @param string $sString Recebe string para escapar aspas
     * */
    public static function limpaString($sString) {

        $sString = str_replace("\n", " ", $sString);
        $sString = str_replace("'", "\'", $sString);
        $sString = str_replace('"', '\"', $sString);
        $sString = str_replace("\r", "", $sString);
        $sString = rtrim($sString);
        $sString = ltrim($sString);

        return $sString;
    }

    /**
     * Validates Time in 24 hour format (e.g. 20:32).
     *
     * @param string  $time Valor a ser verificado;
     * Retorna 1 = true;
     * Retorna 0 = false;
     */
    public static function isTime($time) {
        $sReturn = preg_match("#([0-1]{1}[0-9]{1}|[2]{1}[0-3]{1}):[0-5]{1}[0-9]{1}#", $time);
        return $sReturn;
    }

    /**
     * arruma valores para salvar no banco
     */
    public static function ValorSql($valor) {
        $verificaPonto = ".";
        if (strpos("[" . $valor . "]", "$verificaPonto")):
            $valor = str_replace('.', '', $valor);
            $valor = str_replace(',', '.', $valor);
        else:
            $valor = str_replace(',', '.', $valor);
        endif;

        return $valor;
    }

    public static function formataHora($sHora) {
        if ($sHora == null || $sHora == '') {
            return $sHora;
        } else {

            $hora = explode(':', $sHora);
            $h = $hora[0];
            $m = $hora[1];

            $sHoraConvert = $h . ":" . $m;
            return $sHoraConvert;
        }
    }

    public static function getDataOtem() {
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");

        $sDate = date("d/m/Y", mktime(0, 0, 0, $mes, $dia - 1, $ano));


        date_default_timezone_set('America/Sao_Paulo');
        return $sDate; //date($dia.'/'.$mes.'/'.$ano);
    }

    public static function getDataOtemDiaUm() {
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");

        if ($dia == '01') {
            $sDate = date("d/m/Y", mktime(0, 0, 0, $mes, $dia, $ano));
        } else {
            $sDate = date("d/m/Y", mktime(0, 0, 0, $mes, $dia - 1, $ano));
        }

        date_default_timezone_set('America/Sao_Paulo');
        return $sDate; //date($dia.'/'.$mes.'/'.$ano);
    }

    /**
     * Retorna data de sexta se for segunda se não retorna data ontem
     */
    public function dataSextaSegunda() {
        $dia = date("d");
        $mes = date('m');
        $ano = date('Y');
        $dt = DateTime::createFromFormat('j/n/Y', "$dia/$mes/$ano");
        $diaAtual = date_format($dt, 'N');




        if ((date_format($dt, 'N') === '1')) {
            return $sDate = date("d/m/Y", mktime(0, 0, 0, $mes, $dia - 3, $ano));
        } else {
            return $sDate = date("d/m/Y", mktime(0, 0, 0, $mes, $dia - 1, $ano));
        }
    }

}

?>