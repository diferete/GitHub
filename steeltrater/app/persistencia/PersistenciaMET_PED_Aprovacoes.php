<?php

/*
 * Implementa a classe persistencia MET_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaMET_PED_Aprovacoes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.PED01');


        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('pdcnro', 'pdcnro', true, true, true);
        $this->adicionaRelacionamento('empcod', 'empcod');
        $this->adicionaRelacionamento('empdes', 'empdes');
        $this->adicionaRelacionamento('pdcsituaca', 'pdcsituaca');
        $this->adicionaRelacionamento('pdcfutaut', 'pdcfutaut');
        $this->adicionaRelacionamento('pdcimplant', 'pdcimplant');
        $this->adicionaRelacionamento('pdcusu', 'pdcusu');
        $this->adicionaRelacionamento('pdcfrevalo', 'pdcfrevalo');
        $this->adicionaRelacionamento('totalipi', 'totalipi');
        $this->adicionaRelacionamento('desconto', 'desconto');
        $this->adicionaRelacionamento('valortotal', 'valortotal');

        $this->setBConsultaManual(true);

        $this->adicionaGroupBy('filcgc');
        $this->adicionaGroupBy('pdcnro');
        $this->adicionaGroupBy('empcod');
        $this->adicionaGroupBy('rex_maquinas.widl.EMP01.empdes');
        $this->adicionaGroupBy('pdcfutaut');
        $this->adicionaGroupBy('pdcimplant');
        $this->adicionaGroupBy('pdcsituaca');
        $this->adicionaGroupBy('pdcfrevalo');
        $this->adicionaGroupBy('pdcusu');

        $this->adicionaFiltro('pdcfutaut', $_SESSION['nomedelsoft']);

        $this->setSTop(25);
    }

    public function consultaManual() {
        parent::consultaManual();

        $sSql = "select "
                . "top 50 "
                . "rex_maquinas.widl.PED01.filcgc as 'rex_maquinas.widl.PED01.filcgc', "
                . "rex_maquinas.widl.PED01.pdcnro as 'rex_maquinas.widl.PED01.pdcnro', "
                . "rex_maquinas.widl.PED01.empcod as 'rex_maquinas.widl.PED01.empcod', "
                . "rex_maquinas.widl.PED01.pdcfutaut as 'rex_maquinas.widl.PED01.pdcfutaut', "
                . "rex_maquinas.widl.PED01.pdcsituaca as 'rex_maquinas.widl.PED01.pdcsituaca',  "
                . "rex_maquinas.widl.EMP01.empdes as 'rex_maquinas.widl.PED01.empdes',  "
                . "convert(varchar, pdcimplant, 103) as 'rex_maquinas.widl.PED01.pdcimplant', "
                . "pdcusu as 'rex_maquinas.widl.PED01.pdcusu', "
                . "pdcfrevalo as 'rex_maquinas.widl.PED01.pdcfrevalo',  "
                . "round(sum(pdcproqtdp * pdcprovlru * (pdcproipia/100)),2) as 'rex_maquinas.widl.PED01.totalipi', "
                . "round(sum(((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100) * pdcdescont/100), 2) as 'rex_maquinas.widl.PED01.desconto', "
                . "round(sum((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100), 2) as 'rex_maquinas.widl.PED01.valortotal' "
                . "from rex_maquinas.widl.PED01(nolock) "
                . "left outer join rex_maquinas.widl.EMP01(nolock) "
                . "on rex_maquinas.widl.PED01.empcod = rex_maquinas.widl.EMP01.empcod "
                . "left outer join rex_maquinas.widl.PEDC01(nolock) "
                . "on rex_maquinas.widl.PED01.filcgc = rex_maquinas.widl.PEDC01.filcgc "
                . "and rex_maquinas.widl.PED01.pdcnro = rex_maquinas.widl.PEDC01.pdcnro ";

        $this->adicionaOrderBy('pdcnro', 1);
        return $sSql;
    }

    public function gerenPedidoCompra($sit, $aCampos) {

        switch ($aCampos['cnpj']) {
            case 75483040000211:
                date_default_timezone_set('America/Sao_Paulo');
                if ($sit == 'A') {
                    $sData = date('d/m/Y');
                    $sHora = date('H:i:s');
                    $sSit = 0;
                } elseif ($sit == 'R') {
                    $sData = '01/01/1753';
                    $sHora = '';
                    $sSit = "'R'";
                }
                $sSql = "update rex_maquinas.widl.PED01 "
                        . "set "
                        . "pdcsituaca = " . $sSit . ","
                        . "pdcaut = '" . $aCampos['usunome'] . "',"
                        . "pdcdta = '" . $sData . "',"
                        . "pdchra = '" . $sHora . "' "
                        . "where filcgc = 75483040000211 "
                        . "and pdcnro = " . $aCampos['nrped'] . "";
                $aRetorno = $this->executaSql($sSql);
                return $aRetorno;

            case 75483040000130:
                date_default_timezone_set('America/Sao_Paulo');
                if ($sit == 'A') {
                    $sData = date('d/m/Y');
                    $sHora = date('H:i:s');
                    $sSit = 0;
                } elseif ($sit == 'R') {
                    $sData = '01/01/1753';
                    $sHora = '';
                    $sSit = 'R';
                }
                $sSql = "update rex_maquinas.widl.PED01 "
                        . "set "
                        . "pdcsituaca = " . $sSit . ","
                        . "pdcaut = '" . $aCampos['usunome'] . "',"
                        . "pdcdta = '" . $sData . "',"
                        . "pdchra = '" . $sHora . "' "
                        . "where filcgc = 75483040000130 "
                        . "and pdcnro = " . $aCampos['nrped'] . "";
                $aRetorno = $this->executaSql($sSql);
                return $aRetorno;
        }
    }

    public function getSituaca($aDados) {
        $sSql = "select "
                . "pdcsituaca "
                . "from rex_maquinas.widl.PED01 "
                . "where filcgc = " . $aDados['filcgc'] . ""
                . "and pdcnro = " . $aDados['pdcnro'];
        $oObjSituaca = $this->consultaSql($sSql);
        return $oObjSituaca->pdcsituaca;
    }

}
