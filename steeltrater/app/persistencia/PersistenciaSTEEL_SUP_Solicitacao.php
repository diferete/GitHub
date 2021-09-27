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

    public function buscaBadgeSolCompras($oDados) {
        /**
         * Contador de pedidos aguardando aprovação
         */
        $aRetorno = array();

        $sSql = "select COUNT(*) as total from sup_solicitacao(nolock) where sup_solicitacaosituacao = 'A' and fil_codigo = '8993358000174' ";
        $s = $this->consultaSql($sSql);

        /* matriz */
        $sSql = "select count(*) as total from rex_maquinas.widl.SOL01(nolock) where solsituaca = 'I' and filcgc = '75483040000130'";
        $m = $this->consultaSql($sSql);

        /* $aRetorno['filial'] = $f->total; */
        $aRetorno['matriz'] = $m->total;
        $aRetorno['steeltrater'] = $s->total;

        return $aRetorno;
    }

    public function getDadosSolicitacaoCompras($cnpj) {

        switch ($cnpj) {
            case 8993358000174:
                $aDados = array();
                $aSolicitacoes = array();
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
                    $aRetornoItens = $this->getDadosItens($cnpj, $row->sup_solicitacaoseq);
                    $aDados['itens'] = $aRetornoItens;
                    $aDados['cnpj'] = '8993358000174';
                    $aSolicitacoes[] = $aDados;
                    $iContador++;
                }
                $aRetorno['empresa'] = 'SteelTrater';
                $aRetorno['solicitacoes'] = $aSolicitacoes;
                $aRetorno['contador'] = $iContador;
                break;

            case 75483040000130:
                $aDados = array();
                $aSolicitacoes = array();
                $aRetorno = array();
                $iContador = 0;

                /* $sSql = "select usunomedelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
                  $oUsuNomeDelsoft = $this->consultaSql($sSql); */

                $sSql = "select "
                        . "solcod, "
                        . "soldata, "
                        . "solususoli,"
                        . "solobs "
                        . "from rex_maquinas.widl.SOL01(nolock) "
                        . "where solsituaca = 'I' "
                        . "and filcgc = '75483040000130' "
                        . "order by solcod desc";
                $result = $this->getObjetoSql($sSql);
                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aDados['nr'] = $row->solcod;
                    $aData = explode(' ', $row->soldata);
                    $aDados['data'] = Util::converteData($aData[0]);
                    $aDados['observacao'] = $row->solobs;
                    $aDados['solicitante'] = $row->solususoli;
                    $aRetornoItens = $this->getDadosItens($cnpj, $row->solcod);
                    $aDados['itens'] = $aRetornoItens;
                    $aDados['cnpj'] = '75483040000130';
                    $aSolicitacoes[] = $aDados;
                    $iContador++;
                }
                $aRetorno['empresa'] = 'Matriz';
                $aRetorno['solicitacoes'] = $aSolicitacoes;
                $aRetorno['contador'] = $iContador;
                break;
        }
        return $aRetorno;
    }

    public function getDadosItens($cnpj, $nr) {

        switch ($cnpj) {
            case 8993358000174:

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

                    $aI['cnpj'] = '8993358000174';
                    $aRetorno[] = $aI;
                }
                return $aRetorno;

            case 75483040000130:
                $aRetorno = array();
                $aI = array();
                $sSqlItens = "select "
                        . "rex_maquinas.widl.PROD01.procod,"
                        . "prodes,"
                        . "solproqtda,"
                        . "pround "
                        . "from rex_maquinas.widl.SOLC01(nolock) "
                        . "left outer join rex_maquinas.widl.PROD01(nolock) "
                        . "on rex_maquinas.widl.SOLC01.procod = rex_maquinas.widl.PROD01.procod "
                        . "where solcod = " . $nr . " "
                        . "and filcgc = 75483040000130";
                $result = $this->getObjetoSql($sSqlItens);

                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aI['codigo'] = trim($row->procod);
                    $aI['itemdescricao'] = $row->prodes;
                    $aI['itemqtd'] = number_format($row->solproqtda, 3, ',', '.');
                    $aI['itemunidade'] = $row->pround;

                    $aI['cnpj'] = '75483040000130';
                    $aRetorno[] = $aI;
                }
                return $aRetorno;
        }
    }

    public function getQuantidades($nr, $cod, $cnpj) {

        switch ($cnpj) {
            case 8993358000174:

                $sSql = "select "
                        . "sup_solicitacaoitemcomqtd as qnt "
                        . "from sup_solicitacaoitem(nolock) "
                        . "where SUP_SolicitacaoSeq = " . $nr . " "
                        . "and PRO_Codigo = " . $cod . " "
                        . "and fil_codigo = 8993358000174";
                $oResult = $this->consultaSql($sSql);
                return number_format($oResult->qnt, 3, ',', '.');
            case 75483040000130:

                $sSql = "select "
                        . "solproqtda as qnt "
                        . "from rex_maquinas.widl.SOLC01(nolock) "
                        . "where solcod = " . $nr . " "
                        . "and procod = " . $cod . " "
                        . "and filcgc = 75483040000130";
                $oResult = $this->consultaSql($sSql);
                return number_format($oResult->qnt, 3, ',', '.');
        }
    }

    public function alteraQuantidades($nr, $cod, $qnt, $cnpj) {

        $qntd = str_replace('.', '', $qnt);
        $qntd = number_format($qntd, 0, '', '');

        switch ($cnpj) {
            case 8993358000174:

                $sSql = "update sup_solicitacaoitem "
                        . "set sup_solicitacaoitemcomqtd = " . $qntd . ", "
                        . "sup_solicitacaoitemqtd = " . $qntd . " "
                        . "where SUP_SolicitacaoSeq = " . $nr . " "
                        . "and  PRO_Codigo = " . $cod . " "
                        . "and fil_codigo = 8993358000174";
                $aRetorno = $this->executaSql($sSql);

                return $aRetorno;
            case 75483040000130:
                $sSql = "update rex_maquinas.widl.SOLC01 "
                        . "set solproqtda = " . $qntd . ", "
                        . "solproqtdp = " . $qntd . " "
                        . "where solcod = " . $nr . " "
                        . "and procod = " . $cod . " "
                        . "and filcgc = 75483040000130";
                $aRetorno = $this->executaSql($sSql);

                return $aRetorno;
        }
    }

    public function gerenSolicitacaoCompra($sit, $nr, $usucodigo, $cnpj) {


        $sSql = "select usunomeDelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
        $oUsuNomeDelsoft = $this->consultaSql($sSql);

        $bParam = $this->verificaSolSituaca($nr, $cnpj);

        if (!$bParam) {
            $aRetorno[0] = false;
            $aRetorno[1] = 'C';
            return $aRetorno;
        } else {
            switch ($cnpj) {
                case 8993358000174:
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
                            . "and solcod = " . $nr . "";

                    $aRetorno = $this->executaSql($sSql);
                    return $aRetorno;
            }
        }
    }

    public function verificaSolSituaca($nr, $cnpj) {
        $sSql = "select "
                . "COUNT(*) as total "
                . "from sup_solicitacao(nolock) "
                . "where sup_solicitacaosituacao = 'A' "
                . "and fil_codigo = '" . $cnpj . "' "
                . "and sup_solicitacaoseq = " . $nr . "";
        $oCount = $this->consultaSql($sSql);

        if ($oCount->total == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function updateSitMontagem($oObjDadosSol) {
        $sSql = "update sup_solicitacao set "
                . "sup_solicitacaosituacao = 'M', "
                . "SUP_SolicitacaoFaseApr = 99 "
                . "where fil_codigo = " . $oObjDadosSol->getFIL_Codigo() . " "
                . "and sup_solicitacaoseq = " . $oObjDadosSol->getSUP_SolicitacaoSeq() . " "
                . "and sup_solicitacaosituacao = 'A' ";
        $this->executaSql($sSql);
    }

    public function getSituacoes($aDados) {
        $sSql = "select * from sup_solicitacao "
                . "where fil_codigo = " . $aDados['FIL_Codigo'] . " "
                . "and sup_solicitacaoseq = " . $aDados['SUP_SolicitacaoSeq'] . "";
        $oRetorno = $this->consultaSql($sSql);
        return $oRetorno;
    }

    public function liberaSolicitacao($aDados) {
        $sSql = "update sup_solicitacao set "
                . "sup_solicitacaosituacao = 'A', "
                . "SUP_SolicitacaoFaseApr = 1 "
                . "where fil_codigo = " . $aDados['FIL_Codigo'] . " "
                . "and sup_solicitacaoseq = " . $aDados['SUP_SolicitacaoSeq'] . " "
                . "and sup_solicitacaosituacao = 'M'";
        $aRetorno = $this->executaSql($sSql);
        return $aRetorno;
    }

}
