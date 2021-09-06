<?php

/*
 * Implementa a classe persistencia STEEL_PED_Aprovacoes
 * @author Alexandre de Souza
 * @since 18/08/2021
 */

class PersistenciaSTEEL_PED_Aprovacoes extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('SUP_PEDIDO');

        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_PedidoSeq', 'SUP_PedidoSeq', true, true, true);
        $this->adicionaRelacionamento('SUP_PedidoFornecedor', 'DELX_CAD_Pessoa.emp_codigo', false, false);
        $this->adicionaRelacionamento('SUP_PedidoFornecedor', 'SUP_PedidoFornecedor');
        $this->adicionaRelacionamento('sup_pedidorepresentante', 'sup_pedidorepresentante');
        $this->adicionaRelacionamento('sup_pedidonegociador', 'sup_pedidonegociador');
        $this->adicionaRelacionamento('sup_pedidotransportador', 'sup_pedidotransportador');
        $this->adicionaRelacionamento('sup_pedidosituacao', 'sup_pedidosituacao');
        $this->adicionaRelacionamento('sup_pedidoobservacao', 'sup_pedidoobservacao');
        $this->adicionaRelacionamento('sup_pedidomoeda', 'sup_pedidomoeda');
        $this->adicionaRelacionamento('sup_pedidomoedadata', 'sup_pedidomoedadata');
        $this->adicionaRelacionamento('sup_pedidomoedavalor', 'sup_pedidomoedavalor');
        $this->adicionaRelacionamento('sup_pedidotipo', 'sup_pedidotipo');
        $this->adicionaRelacionamento('sup_pedidotipofrete', 'sup_pedidotipofrete');
        $this->adicionaRelacionamento('sup_pedidovlrfrete', 'sup_pedidovlrfrete');
        $this->adicionaRelacionamento('sup_pedidovlrdespesa', 'sup_pedidovlrdespesa');
        $this->adicionaRelacionamento('sup_pedidovlrseguro', 'sup_pedidovlrseguro');
        $this->adicionaRelacionamento('sup_pedidovlrdesconto', 'sup_pedidovlrdesconto');
        $this->adicionaRelacionamento('sup_pedidoperdesconto', 'sup_pedidoperdesconto');
        $this->adicionaRelacionamento('sup_pedidocontrato', 'sup_pedidocontrato');
        $this->adicionaRelacionamento('sup_pedidonotaaviso', 'sup_pedidonotaaviso');
        $this->adicionaRelacionamento('sup_pedidodata', 'sup_pedidodata');
        $this->adicionaRelacionamento('sup_pedidousuario', 'sup_pedidousuario');
        $this->adicionaRelacionamento('sup_pedidotipomovimento', 'sup_pedidotipomovimento');
        $this->adicionaRelacionamento('sup_pedidohora', 'sup_pedidohora');
        $this->adicionaRelacionamento('sup_pedidocontato', 'sup_pedidocontato');
        $this->adicionaRelacionamento('sup_pedidocondicaopag', 'sup_pedidocondicaopag');
        $this->adicionaRelacionamento('sup_pedidodestino', 'sup_pedidodestino');
        $this->adicionaRelacionamento('sup_pedidotipodesconto', 'sup_pedidotipodesconto');
        $this->adicionaRelacionamento('sup_pedidovalorproduto', 'sup_pedidovalorproduto');
        $this->adicionaRelacionamento('sup_pedidovalorservico', 'sup_pedidovalorservico');
        $this->adicionaRelacionamento('sup_pedidovalortotal', 'sup_pedidovalortotal');
        $this->adicionaRelacionamento('sup_pedidoidentificador', 'sup_pedidoidentificador');
        $this->adicionaRelacionamento('sup_pedidovalordescontoservico', 'sup_pedidovalordescontoservico');
        $this->adicionaRelacionamento('sup_pedidoseqaprovacao', 'sup_pedidoseqaprovacao');
        $this->adicionaRelacionamento('sup_pedidovalortotaldesconto', 'sup_pedidovalortotaldesconto');
        $this->adicionaRelacionamento('sup_pedidomrp', 'sup_pedidomrp');
        $this->adicionaRelacionamento('sup_pedidomoedavalorneg', 'sup_pedidomoedavalorneg');
        $this->adicionaRelacionamento('sup_pedidopessoaentrega', 'sup_pedidopessoaentrega');
        $this->adicionaRelacionamento('sup_pedidopessoaentregaend', 'sup_pedidopessoaentregaend');
        $this->adicionaRelacionamento('sup_pedidoentregaobs', 'sup_pedidoentregaobs');
        $this->adicionaRelacionamento('sup_pedidositenvemailforn', 'sup_pedidositenvemailforn');
        $this->adicionaRelacionamento('sup_pedidopessoafaturamento', 'sup_pedidopessoafaturamento');
        $this->adicionaRelacionamento('sup_pedidopessoafaturamentoend', 'sup_pedidopessoafaturamentoend');
        $this->adicionaRelacionamento('sup_pedidofaturamentoobs', 'sup_pedidofaturamentoobs');
        $this->adicionaRelacionamento('sup_pedidocontratoentregafutur', 'sup_pedidocontratoentregafutur');
        $this->adicionaRelacionamento('sup_pedidousunegacao', 'sup_pedidousunegacao');
        $this->adicionaRelacionamento('sup_pedidodatahoranegacao', 'sup_pedidodatahoranegacao');
        $this->adicionaRelacionamento('sup_pedidocctcod', 'sup_pedidocctcod');
        $this->adicionaRelacionamento('sup_pedidofornecedorend', 'sup_pedidofornecedorend');
        $this->adicionaRelacionamento('sup_pedidoliberadoaprovacao', 'sup_pedidoliberadoaprovacao');
        $this->adicionaRelacionamento('sup_pedidofornecedorassociado', 'sup_pedidofornecedorassociado');
        $this->adicionaRelacionamento('sup_pedidochassi', 'sup_pedidochassi');
        $this->adicionaRelacionamento('sup_pedidokm', 'sup_pedidokm');
        $this->adicionaRelacionamento('sup_pedidonsg', 'sup_pedidonsg');
        $this->adicionaRelacionamento('sup_pedidotipocontrole', 'sup_pedidotipocontrole');
        $this->adicionaRelacionamento('sup_pedidotipopec', 'sup_pedidotipopec');
        $this->adicionaRelacionamento('sup_pedidovia', 'sup_pedidovia');
        $this->adicionaRelacionamento('sup_pedidovlracrescimo', 'sup_pedidovlracrescimo');
        $this->adicionaRelacionamento('sup_pedidodatavalidade', 'sup_pedidodatavalidade');
        $this->adicionaRelacionamento('sup_pedidobxprevisao', 'sup_pedidobxprevisao');

        $this->adicionaOrderBy('sup_pedidoseq', 1);
        $this->adicionaFiltro('FIL_Codigo', '8993358000174');
        $this->adicionaJoin('DELX_CAD_Pessoa', null, 1, 'SUP_PedidoFornecedor', 'emp_codigo');
        $this->setSTop(75);
    }

    public function gerenPedidoCompra($sit, $aCampos) {

        switch ($aCampos['cnpj']) {
            case 8993358000174:
                date_default_timezone_set('America/Sao_Paulo');
                $sData = date('Y-m-d 00:00:00.000');
                $sHora = date('Y-m-d H:i:s' . '.000');

                if ($sit == 'A') {
                    $sHistorico = 'APROVAR';
                    $sSit = 'L';
                    $iAprovacao = 2;
                } elseif ($sit == 'R') {
                    $sHistorico = 'REPROVAR';
                    $sSit = 'R';
                    $iAprovacao = 6;
                }
                /* tabela de cabeçalho */
                $sSqlUpdateCabecalho = "update "
                        . "SUP_PEDIDO "
                        . "set SUP_PedidoSituacao = '" . $sSit . "',"
                        . "SUP_PedidoSeqAprovacao = " . $iAprovacao . ""
                        . "where FIL_Codigo = 8993358000174 "
                        . "and SUP_PedidoSeq = " . $aCampos['nrped'] . "";
                $aRetorno = $this->executaSql($sSqlUpdateCabecalho);
                if ($aRetorno[0]) {
                    // tabela de itens
                    $sSqlUpdateItens = "update "
                            . "SUP_PEDIDOITEM "
                            . "set SUP_PedidoItemSituacao = '" . $sSit . "' "
                            . "where FIL_Codigo = 8993358000174 "
                            . "and SUP_PedidoSeq = " . $aCampos['nrped'] . "";
                    $aRetorno = $this->executaSql($sSqlUpdateItens);
                    if ($aRetorno[0]) {
                        // tabela de histórico
                        $sSqlInsertHistorico = "SET DATEFORMAT ymd;"
                                . "insert into SUP_APROVACAOHIST("
                                . "FIL_Codigo,"
                                . "SUP_AprovacaoHistPedidoSeq,"
                                . "SUP_AprovacaoHistSeq,"
                                . "SUP_AprovacaoHistData,"
                                . "SUP_AprovacaoHistPedidoSituaca,"
                                . "SUP_AprovacaoHistUsuarioCodigo,"
                                . "SUP_AprovacaoHistObs,"
                                . "SUP_AprovacaoHistDataHora,"
                                . "SUP_AprovacaoHistAcao,"
                                . "SUP_AprovacaoHistEmails"
                                . ")values("
                                . "8993358000174,"
                                . "" . $aCampos['nrped'] . ","
                                . "(select ("
                                . "case "
                                . "when max(SUP_AprovacaoHistSeq) is null "
                                . "then 1 else max(SUP_AprovacaoHistSeq)+1 end) as SEQ "
                                . "from SUP_APROVACAOHIST "
                                . "where FIL_Codigo = 8993358000174 "
                                . "and SUP_AprovacaoHistPedidoSeq = " . $aCampos['nrped'] . "),"
                                . "CAST(N'" . $sData . "' AS DateTime),"
                                . "'" . $sSit . "',"
                                . "'" . $aCampos['usunome'] . "',"
                                . "'',"
                                . "NULL,"
                                . "'" . $sHistorico . "',"
                                . "'NULL')";
                        $aRetorno = $this->executaSql($sSqlInsertHistorico);
                    }
                }
                return $aRetorno;

            case 75483040000211:
                date_default_timezone_set('America/Sao_Paulo');
                if ($sit == 'a') {
                    $sData = date('d/m/Y');
                    $sHora = date('H:i:s');
                    $sSit = 0;
                } elseif ($sit == 'r') {
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
                if ($sit == 'a') {
                    $sData = date('d/m/Y');
                    $sHora = date('H:i:s');
                    $sSit = 0;
                } elseif ($sit == 'r') {
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

}
