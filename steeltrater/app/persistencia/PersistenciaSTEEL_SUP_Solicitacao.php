<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_Solicitacao extends Persistencia {

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

        $this->adicionaFiltro('FIL_Codigo', '8993358000174');

        $this->adicionaJoin('DELX_FIL_Empresa', null, 1, 'FIL_Codigo', 'fil_codigo');

        $this->adicionaOrderBy('SUP_SolicitacaoSeq', 1);
        $this->setSTop(25);
    }

    public function afterInsert($aCampos) {
        parent::afterInsert($aCampos);

        $sSql = "update tec_sequencia set tec_sequencianumero = " . $aCampos['sup_solicitacaoseq'] . " "
                . "where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='SUP_Solicitacao'";

        $this->executaSql($sSql);
    }

    public function getDadosSolicitacaoCompras() {

        $aDados = array();
        $aPedidos = array();
        $aRetorno = array();
        $iContador = 0;

        $sSql = "select "
                . "sup_solicitacaoseq,"
                . "sup_solicitacaodatahora,"
                . "sup_solicitacaousucadastro,"
                . "sup_solicitacaoobservacao "
                . "from SUP_SOLICITACAO(nolock) "
                . "where FIL_Codigo = 8993358000174 "
                . "and SUP_SolicitacaoSituacao = 'A' "
                . "order by sup_solicitacaoseq desc";

        $result = $this->getObjetoSql($sSql);
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['nr'] = $row->sup_solicitacaoseq;
            $aData = explode(' ', $row->sup_solicitacaodatahora);
            $aDados['data'] = Util::converteData($aData[0]);
            $aDados['observacao'] = $row->sup_solicitacaoobservacao;
            $aDados['solicitante'] = $row->sup_solicitacaousucadastro;
            $aRetornoItens = $this->getDadosItens($row->sup_solicitacaoseq);
            $aDados['itens'] = $aRetornoItens;
            $aPedidos[] = $aDados;
            $iContador++;
        }
        $aRetorno['solicitacoes'] = $aPedidos;
        $aRetorno['contador'] = $iContador;

        return $aRetorno;
    }

    public function getDadosItens($nr) {
        $aRetorno = array();
        $aI = array();
        $sSqlItens = "select "
                . "pro_codigo,"
                . "sup_solicitacaoitemdescricao,"
                . "sup_solicitacaoitemcomqtd,"
                . "sup_solicitacaoitemunidade "
                . "from sup_solicitacaoitem(nolock) "
                . "where sup_solicitacaoseq = " . $nr . " "
                . "and fil_codigo = 8993358000174";
        $result = $this->getObjetoSql($sSqlItens);

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aI['codigo'] = trim($row->pro_codigo);
            $aI['itemdescricao'] = $row->sup_solicitacaoitemdescricao;
            $aI['itemqtd'] = number_format($row->sup_solicitacaoitemcomqtd, 3, ',', '.');
            $aI['itemunidade'] = $row->sup_solicitacaoitemunidade;
            $aRetorno[] = $aI;
        }
        return $aRetorno;
    }

    public function getQuantidades($nr, $cod) {
        $sSql = "select "
                . "sup_solicitacaoitemcomqtd as qnt "
                . "from sup_solicitacaoitem(nolock) "
                . "where SUP_SolicitacaoSeq = " . $nr . " and PRO_Codigo = " . $cod . "";
        $oResult = $this->consultaSql($sSql);
        return number_format($oResult->qnt, 3, ',', '.');
    }

    public function alteraQuantidades($nr, $cod, $qnt) {

        $qntd = str_replace('.', '', $qnt);
        $qntd = number_format($qntd, 0, '', '');


        $sSql = "update sup_solicitacaoitem "
                . "set sup_solicitacaoitemcomqtd = " . $qntd . ", "
                . "sup_solicitacaoitemqtd = " . $qntd . " "
                . "where SUP_SolicitacaoSeq = " . $nr . " and  PRO_Codigo = " . $cod . "";
        $aRetorno = $this->executaSql($sSql);

        return $aRetorno;
    }

    public function gerenSolicitacaoCompra($sit, $nr, $usucodigo) {

        $sSql = "select usunomeDelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
        $oUsuNomeDelsoft = $this->consultaSql($sSql);
        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('Y-m-d H:i:s' . '.000');

        if ($sit == 'a') {
            $sSit = 'L';
            $sHistorico = 'LIBERADO';
            $iAprovacao = 2;
        } elseif ($sit == 'r') {
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
                . "and sup_solicitacaoseq = " . $nr . "";
        $aRetorno = $this->executaSql($sSqlUpdateCabecalho);
        if ($aRetorno[0]) {
            // tabela de itens
            $sSqlUpdateItens = "update "
                    . "sup_solicitacaoitem "
                    . "set sup_solicitacaoitemsituacao = '" . $sSit . "' "
                    . "where fil_codigo = 8993358000174 "
                    . "and sup_solicitacaoseq = " . $nr . "";
            $aRetorno = $this->executaSql($sSqlUpdateItens);
            if ($sit == 'a' && $aRetorno[0]) {
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
                        . "" . $nr . ","
                        . "(select ("
                        . "case "
                        . "when max(sup_solicitacaoaprhistseq) is null "
                        . "then 1 else max(sup_solicitacaoaprhistseq)+1 end) as SEQ from sup_solicitacaoaprhist "
                        . "where fil_codigo = 8993358000174 "
                        . "and sup_solicitacaoseq = " . $nr . "),"
                        . "CAST(N'" . $sData . "' AS DateTime),"
                        . "'" . $sSit . "',"
                        . "'" . $oUsuNomeDelsoft->usunomedelsoft . "',"
                        . "'',"
                        . "'" . $sHistorico . "')";
                $aRetorno = $this->executaSql($sSqlInsertHistorico);
            }
        }
        return $aRetorno;
    }

}
