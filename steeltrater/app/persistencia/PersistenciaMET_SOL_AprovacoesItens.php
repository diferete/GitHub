<?php

/*
 * Implementa a classe persistencia MET_SOL_AprovacoesItens
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaMET_SOL_AprovacoesItens extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.SOLC01');

        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('solcod', 'solcod', true, true);
        $this->adicionaRelacionamento('solproseq', 'solproseq', true, true, true);
        $this->adicionaRelacionamento('solproqtda', 'solproqtda');

        $this->adicionaRelacionamento('procod', 'procod', true);
        $this->adicionaRelacionamento('procod', 'Produto.procod');

        $this->adicionaOrderBy('solproseq', 1);
        $this->adicionaJoin('Produto');
    }

    public function alteraQt($sValor, $sCNPJ, $sSeq, $sItemSeq) {
        $sSql = "update rex_maquinas.widl.SOLC01 "
                . "set solproqtda = '" . $sValor . "',"
                . "solproqtdp = '" . $sValor . "' "
                . "where filcgc = " . $sCNPJ . " "
                . "and solcod = " . $sSeq . " "
                . "and solproseq = " . $sItemSeq . " ";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
