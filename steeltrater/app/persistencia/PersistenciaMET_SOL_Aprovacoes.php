<?php

/*
 * Implementa a classe persistencia MET_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaMET_SOL_Aprovacoes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('rex_maquinas.widl.SOL01');

        $this->adicionaRelacionamento('filcgc', 'Pessoa.empcod', false, false, false);
        $this->adicionaRelacionamento('filcgc', 'filcgc', true, true);
        $this->adicionaRelacionamento('solcod', 'solcod', true, true, true);
        $this->adicionaRelacionamento('soldata', 'soldata');
        $this->adicionaRelacionamento('solobs', 'solobs');
        $this->adicionaRelacionamento('solususoli', 'solususoli');
        $this->adicionaRelacionamento('solusuapro', 'solusuapro');
        $this->adicionaRelacionamento('solsituaca', 'solsituaca');
        $this->adicionaRelacionamento('soldtaapro', 'soldtaapro');
        $this->adicionaRelacionamento('solpedido', 'solpedido');
        $this->adicionaRelacionamento('solusu', 'solusu');
        $this->adicionaRelacionamento('ccnro', 'ccnro');
        $this->adicionaRelacionamento('solctad', 'solctad');
        $this->adicionaRelacionamento('solctac', 'solctac');
        $this->adicionaRelacionamento('solpdvnro', 'solpdvnro');
        $this->adicionaRelacionamento('solsimcod', 'solsimcod');
        $this->adicionaRelacionamento('solsms', 'solsms');
        $this->adicionaRelacionamento('solarecod', 'solarecod');
        $this->adicionaRelacionamento('sollocent', 'sollocent');
        $this->adicionaRelacionamento('solaprovad', 'solaprovad');
        $this->adicionaRelacionamento('solhraapro', 'solhraapro');
        $this->adicionaRelacionamento('solreglib', 'solreglib');
        $this->adicionaRelacionamento('solmrpnroc', 'solmrpnroc');



        $this->adicionaOrderBy('solcod', 1);
        $this->setSTop(50);
    }

    public function gerenSolicitacaoCompra($sSit, $aCampos) {

        switch ($aCampos['cnpj']) {
            case 75483040000130:
                date_default_timezone_set('America/Sao_Paulo');
                $sData = date('d/m/Y');
                $sHora = date('H:i:s');

                $sSql = "update rex_maquinas.widl.SOL01 "
                        . "set solsituaca = '" . $sSit . "',"
                        . "solusuapro = '" . $aCampos['usunome'] . "',"
                        . "soldtaapro = '" . $sData . "',"
                        . "solhraapro = '" . $sHora . "' "
                        . "where filcgc  = 75483040000130 "
                        . "and solcod = " . $aCampos['nrsol'] . "";

                $aRetorno = $this->executaSql($sSql);
                return $aRetorno;

            case 75483040000211:
                date_default_timezone_set('America/Sao_Paulo');
                $sData = date('d/m/Y');
                $sHora = date('H:i:s');

                $sSql = "update rex_maquinas.widl.SOL01 "
                        . "set solsituaca = '" . $sSit . "',"
                        . "solusuapro = '" . $aCampos['usunome'] . "',"
                        . "soldtaapro = '" . $sData . "',"
                        . "solhraapro = '" . $sHora . "' "
                        . "where filcgc  = 75483040000211 "
                        . "and solcod = " . $aCampos['nrsol'] . "";

                $aRetorno = $this->executaSql($sSql);
                return $aRetorno;
        }
    }

}
