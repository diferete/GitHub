<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersistenciaSTEEL_CCT_CentroCusto
 *
 * @author Alexandre
 */
class PersistenciaSTEEL_CCT_CentroCusto extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('CCT_CENTROCUSTO');

        $this->adicionaRelacionamento('cct_codigo', 'cct_codigo', true, true, true);
        $this->adicionaRelacionamento('cct_descricao', 'cct_descricao');
        $this->adicionaRelacionamento('STEEL_CCT_CentroCustoFilial', 'STEEL_CCT_CentroCustoFilial', false, false);
        $this->adicionaRelacionamento('CCT_Classificacao', 'CCT_Classificacao');
        $this->adicionaRelacionamento('CCT_Tipo', 'CCT_Tipo');
        $this->adicionaRelacionamento('CCT_VigenciaInicial', 'CCT_VigenciaInicial');
        $this->adicionaRelacionamento('CCT_VigenciaFinal', 'CCT_VigenciaFinal');
        $this->adicionaRelacionamento('CCT_QtdMesesMedia', 'CCT_QtdMesesMedia');
        /**/
        $this->adicionaRelacionamento('CCT_Produtivo', 'CCT_Produtivo');
        $this->adicionaRelacionamento('PEO_CentroCustoORC', 'PEO_CentroCustoORC');
        $this->adicionaRelacionamento('PEO_CentroCustoDRT', 'PEO_CentroCustoDRT');
        $this->adicionaRelacionamento('PEO_CentroCustoPEO', 'PEO_CentroCustoPEO');
        $this->adicionaRelacionamento('PEO_CentroCustoBLV', 'PEO_CentroCustoBLV');
        $this->adicionaRelacionamento('MNT_CentroCustoAbreOS', 'MNT_CentroCustoAbreOS');
        $this->adicionaRelacionamento('MNT_CentroCustoApontaOS', 'MNT_CentroCustoApontaOS');
        $this->adicionaRelacionamento('PEO_CentroCustoOCE', 'PEO_CentroCustoOCE');
        $this->adicionaRelacionamento('MNT_CentroCustoCriticidade', 'MNT_CentroCustoCriticidade');
        $this->adicionaRelacionamento('MNT_CentroCustoArea', 'MNT_CentroCustoArea');
        $this->adicionaRelacionamento('MNT_CentroCustoTipoAprovacao', 'MNT_CentroCustoTipoAprovacao');
        $this->adicionaRelacionamento('MNT_CentroCustoAprovAutomatica', 'MNT_CentroCustoAprovAutomatica');
        $this->adicionaRelacionamento('ESP_HolambraCCTFilialDestino', 'ESP_HolambraCCTFilialDestino');
        $this->adicionaRelacionamento('ESP_HolambraCCTPlanoDestino', 'ESP_HolambraCCTPlanoDestino');
        $this->adicionaRelacionamento('ESP_HolambraCCTContaDestino', 'ESP_HolambraCCTContaDestino');

        $this->adicionaJoin('STEEL_CCT_CentroCustoFilial');

        $this->adicionaFiltro('STEEL_CCT_CentroCustoFilial.fil_codigo', '8993358000174');

        $this->adicionaOrderBy('cct_codigo', 1);
    }

    public function insertFilial($aCampos) {
        $sSql = "insert into CCT_CENTROCUSTOFILIAL "
                . "("
                . "cct_codigo,"
                . "fil_codigo"
                . ")"
                . "values"
                . "("
                . "" . $aCampos['cct_codigo'] . ","
                . "8993358000174"
                . ")";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

    public function updateFilial($aCampos) {
        $sSql = "update CCT_CENTROCUSTOFILIAL "
                . "set cct_codigo = " . $aCampos['cct_codigo'] . ","
                . "fil_codigo = 8993358000174 "
                . "where cct_codigo = " . $aCampos['cod'] . " "
                . "and fil_codigo = 8993358000174";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
