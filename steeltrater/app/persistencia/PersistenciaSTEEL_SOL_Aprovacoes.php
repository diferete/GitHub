<?php

/*
 * Implementa a classe persistencia STEEL_SOL_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaSTEEL_SOL_Aprovacoes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('SUP_Solicitacao');

        $this->adicionaRelacionamento('FIL_Codigo', 'DELX_FIL_Empresa.fil_codigo', false, false, false);
        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoSeq', 'SUP_SolicitacaoSeq', true, true, true);
        $this->adicionaRelacionamento('SUP_SolicitacaoDataHora', 'SUP_SolicitacaoDataHora');
        $this->adicionaRelacionamento('SUP_SolicitacaoObservacao', 'SUP_SolicitacaoObservacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuCadastro', 'SUP_SolicitacaoUsuCadastro');
        $this->adicionaRelacionamento('SUP_SolicitacaoObsEntrega', 'SUP_SolicitacaoObsEntrega');
        $this->adicionaRelacionamento('SUP_SolicitacaoTipo', 'SUP_SolicitacaoTipo');
        $this->adicionaRelacionamento('SUP_SolicitacaoSituacao', 'SUP_SolicitacaoSituacao');
        $this->adicionaRelacionamento('SUP_SolicitacaoFaseApr', 'SUP_SolicitacaoFaseApr');
        $this->adicionaRelacionamento('SUP_SolicitacaoMRP', 'SUP_SolicitacaoMRP');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuAprovador', 'SUP_SolicitacaoUsuAprovador');
        $this->adicionaRelacionamento('SUP_SolicitacaoCCTCod', 'SUP_SolicitacaoCCTCod');
        $this->adicionaRelacionamento('SUP_SolicitacaoDataCanc', 'SUP_SolicitacaoDataCanc');
        $this->adicionaRelacionamento('SUP_SolicitacaoUsuCanc', 'SUP_SolicitacaoUsuCanc');
        
        $this->adicionaOrderBy('SUP_SolicitacaoSeq', 1);
        $this->setSTop(50);
    }

    public function gerenSolicitacaoCompra($sit, $aCampos) {

        switch ($aCampos['cnpj']) {
            case 8993358000174:
                date_default_timezone_set('America/Sao_Paulo');
                $sData = date('Y-m-d H:i:s' . '.000');

                if ($sit == 'A') {
                    $sSit = 'L';
                    $sHistorico = 'LIBERADO';
                    $iAprovacao = 2;
                } elseif ($sit == 'R') {
                    $sSit = 'R';
                    $iAprovacao = 6;
                    $sHistorico = 'REPROVADO';
                }
                /* tabela de cabeçalho */
                $sSqlUpdateCabecalho = "update "
                        . "sup_solicitacao "
                        . "set sup_solicitacaosituacao = '" . $sSit . "',"
                        . "sup_solicitacaofaseapr = " . $iAprovacao . " "
                        . "where fil_codigo = 8993358000174 "
                        . "and sup_solicitacaoseq = " . $aCampos['nrsol'] . "";
                $aRetorno = $this->executaSql($sSqlUpdateCabecalho);
                if ($aRetorno[0]) {
                    // tabela de itens
                    $sSqlUpdateItens = "update "
                            . "sup_solicitacaoitem "
                            . "set sup_solicitacaoitemsituacao = '" . $sSit . "' "
                            . "where fil_codigo = 8993358000174 "
                            . "and sup_solicitacaoseq = " . $aCampos['nrsol'] . "";
                    $aRetorno = $this->executaSql($sSqlUpdateItens);
                    if ($sit == 'A' && $aRetorno[0]) {
                        // tabela de histórico
                        $sSqlInsertHistorico = "SET DATEFORMAT ymd;"
                                . "insert into sup_solicitacaoaprhist("
                                . "fil_codigo,"
                                . "sup_solicitacaoseq,"
                                . "sup_solicitacaoaprhistseq,"
                                . "sup_solicitacaoaprhistdata,"
                                . "sup_solicitacaoaprhistsituacao,"
                                . "sup_solicitacaoaprhistusuario,"
                                . "sup_solicitacaoaprhistobs,"
                                . "sup_solicitacaoaprhistdesc"
                                . ")values("
                                . "8993358000174,"
                                . "" . $aCampos['nrsol'] . ","
                                . "(select ("
                                . "case "
                                . "when max(sup_solicitacaoaprhistseq) is null "
                                . "then 1 else max(sup_solicitacaoaprhistseq)+1 end) as SEQ "
                                . "from sup_solicitacaoaprhist "
                                . "where fil_codigo = 8993358000174 "
                                . "and sup_solicitacaoseq = " . $aCampos['nrsol'] . "),"
                                . "CAST(N'" . $sData . "' AS DateTime),"
                                . "'" . $sSit . "',"
                                . "'" . $aCampos['usunome'] . "',"
                                . "'',"
                                . "'" . $sHistorico . "')";
                        $aRetorno = $this->executaSql($sSqlInsertHistorico);
                    }
                }
                return $aRetorno;

            case 75483040000130:
                date_default_timezone_set('America/Sao_Paulo');
                $sData = date('d/m/Y');
                $sHora = date('H:i:s');

                if ($sit == 'a') {
                    $sSit = 'A';
                } elseif ($sit == 'r') {
                    $sSit = 'R';
                }

                $sSql = "update rex_maquinas.widl.SOL01 "
                        . "set solsituaca = '" . $sSit . "',"
                        . "solusuapro = '" . $oUsuNomeDelsoft->usunomedelsoft . "',"
                        . "soldtaapro = '" . $sData . "',"
                        . "solhraapro = '" . $sHora . "' "
                        . "where filcgc  = 75483040000130 "
                        . "and solcod = " . $aCampos['nrsol'] . "";

                $aRetorno = $this->executaSql($sSql);
                return $aRetorno;
        }
    }

}
