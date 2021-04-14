<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_sup_PedidoCompra extends Persistencia {

    public function __construct() {
        parent::__construct();


        $this->setTabela('sup_pedido');

        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('sup_PedidoSeq', 'sup_PedidoSeq', true, true, true);
        $this->adicionaRelacionamento('sup_PedidoFornecedor', 'DELX_CAD_Pessoa.emp_codigo', false, false);
        $this->adicionaRelacionamento('sup_PedidoFornecedor', 'sup_PedidoFornecedor');
        $this->adicionaRelacionamento('sup_PedidoRepresentante', 'sup_PedidoRepresentante');
        $this->adicionaRelacionamento('sup_PedidoNegociador', 'sup_PedidoNegociador');
        $this->adicionaRelacionamento('sup_PedidoTransportador', 'sup_PedidoTransportador');
        $this->adicionaRelacionamento('sup_PedidoSituacao', 'sup_PedidoSituacao');
        $this->adicionaRelacionamento('sup_PedidoObservacao', 'sup_PedidoObservacao');
        $this->adicionaRelacionamento('sup_PedidoMoeda', 'sup_PedidoMoeda');
        $this->adicionaRelacionamento('sup_PedidoMoedaData', 'sup_PedidoMoedaData');
        $this->adicionaRelacionamento('sup_PedidoMoedaValor', 'sup_PedidoMoedaValor');
        $this->adicionaRelacionamento('sup_PedidoTipo', 'sup_PedidoTipo');
        $this->adicionaRelacionamento('sup_PedidoTipoFrete', 'sup_PedidoTipoFrete');
        $this->adicionaRelacionamento('sup_PedidoVlrFrete', 'sup_PedidoVlrFrete');
        $this->adicionaRelacionamento('sup_PedidoVlrDespesa', 'sup_PedidoVlrDespesa');
        $this->adicionaRelacionamento('sup_PedidoVlrSeguro', 'sup_PedidoVlrSeguro');
        $this->adicionaRelacionamento('sup_PedidoVlrDesconto', 'sup_PedidoVlrDesconto');
        $this->adicionaRelacionamento('sup_PedidoPerDesconto', 'sup_PedidoPerDesconto');
        $this->adicionaRelacionamento('sup_PedidoContrato', 'sup_PedidoContrato');
        $this->adicionaRelacionamento('sup_PedidoNotaAviso', 'sup_PedidoNotaAviso');
        $this->adicionaRelacionamento('sup_PedidoData', 'sup_PedidoData');
        $this->adicionaRelacionamento('sup_PedidoUsuario', 'sup_PedidoUsuario');
        $this->adicionaRelacionamento('sup_PedidoTipoMovimento', 'sup_PedidoTipoMovimento');
        $this->adicionaRelacionamento('sup_PedidoHora', 'sup_PedidoHora');
        $this->adicionaRelacionamento('sup_PedidoContato', 'sup_PedidoContato');
        $this->adicionaRelacionamento('sup_PedidoCondicaoPag', 'sup_PedidoCondicaoPag');
        $this->adicionaRelacionamento('sup_PedidoDestino', 'sup_PedidoDestino');
        $this->adicionaRelacionamento('sup_PedidoTipoDesconto', 'sup_PedidoTipoDesconto');
        $this->adicionaRelacionamento('sup_PedidoValorProduto', 'sup_PedidoValorProduto');
        $this->adicionaRelacionamento('sup_PedidoValorServico', 'sup_PedidoValorServico');
        $this->adicionaRelacionamento('sup_PedidoValorTotal', 'sup_PedidoValorTotal');
        $this->adicionaRelacionamento('sup_PedidoIdentificador', 'sup_PedidoIdentificador');
        $this->adicionaRelacionamento('sup_PedidoValorDescontoServico', 'sup_PedidoValorDescontoServico');
        $this->adicionaRelacionamento('sup_PedidoSeqAprovacao', 'sup_PedidoSeqAprovacao');
        $this->adicionaRelacionamento('sup_PedidoValorTotalDesconto', 'sup_PedidoValorTotalDesconto');
        $this->adicionaRelacionamento('sup_PedidoMRP', 'sup_PedidoMRP');
        $this->adicionaRelacionamento('sup_PedidoMoedaValorNeg', 'sup_PedidoMoedaValorNeg');
        $this->adicionaRelacionamento('sup_PedidoPessoaEntrega', 'sup_PedidoPessoaEntrega');
        $this->adicionaRelacionamento('sup_PedidoPessoaEntregaEnd', 'sup_PedidoPessoaEntregaEnd');
        $this->adicionaRelacionamento('sup_PedidoEntregaObs', 'sup_PedidoEntregaObs');
        $this->adicionaRelacionamento('sup_PedidoSitEnvEmailForn', 'sup_PedidoSitEnvEmailForn');
        $this->adicionaRelacionamento('sup_PedidoPessoaFaturamento', 'sup_PedidoPessoaFaturamento');
        $this->adicionaRelacionamento('sup_PedidoPessoaFaturamentoEnd', 'sup_PedidoPessoaFaturamentoEnd');
        $this->adicionaRelacionamento('sup_PedidoFaturamentoObs', 'sup_PedidoFaturamentoObs');
        $this->adicionaRelacionamento('sup_PedidoContratoEntregaFutur', 'sup_PedidoContratoEntregaFutur');
        $this->adicionaRelacionamento('sup_PedidoUsuNegacao', 'sup_PedidoUsuNegacao');
        $this->adicionaRelacionamento('sup_PedidoDataHoraNegacao', 'sup_PedidoDataHoraNegacao');
        $this->adicionaRelacionamento('sup_PedidoCCTCod', 'sup_PedidoCCTCod');
        $this->adicionaRelacionamento('sup_PedidoFornecedorEnd', 'sup_PedidoFornecedorEnd');
        $this->adicionaRelacionamento('sup_PedidoLiberadoAprovacao', 'sup_PedidoLiberadoAprovacao');
        $this->adicionaRelacionamento('sup_PedidoFornecedorAssociado', 'sup_PedidoFornecedorAssociado');
        $this->adicionaRelacionamento('sup_PedidoChassi', 'sup_PedidoChassi');
        $this->adicionaRelacionamento('sup_PedidoKM', 'sup_PedidoKM');
        $this->adicionaRelacionamento('sup_PedidoNSG', 'sup_PedidoNSG');
        $this->adicionaRelacionamento('sup_PedidoTipoControle', 'sup_PedidoTipoControle');
        $this->adicionaRelacionamento('sup_PedidoTipoPEC', 'sup_PedidoTipoPEC');
        $this->adicionaRelacionamento('sup_PedidoVia', 'sup_PedidoVia');
        $this->adicionaRelacionamento('sup_PedidoVlrAcrescimo', 'sup_PedidoVlrAcrescimo');
        $this->adicionaRelacionamento('sup_PedidoDataValidade', 'sup_PedidoDataValidade');
        $this->adicionaRelacionamento('sup_PedidoBxPrevisao', 'sup_PedidoBxPrevisao');

        /*         * **************************************************************************
          $this->adicionaRelacionamento('sup_PedidoOrcamento', 'sup_PedidoOrcamento');
          $this->adicionaRelacionamento('sup_PedidoEnvEmaForn', 'sup_PedidoEnvEmaForn');
          $this->adicionaRelacionamento('sup_PedidoCondicaoPagDescritiv', 'sup_PedidoCondicaoPagDescritiv');
          $this->adicionaRelacionamento('FIN_FormaPagamentoCodigo', 'FIN_FormaPagamentoCodigo');
          $this->adicionaRelacionamento('sup_PedidoUsuarioAprovador', 'sup_PedidoUsuarioAprovador');
          $this->adicionaRelacionamento('sup_PedidoEquipamento', 'sup_PedidoEquipamento');
          $this->adicionaRelacionamento('sup_PedidoUsuarioResponsavel', 'sup_PedidoUsuarioResponsavel');
         * **************************************************************************** */

        $this->adicionaOrderBy('sup_pedidoseq', 1);
        $this->adicionaFiltro('FIL_Codigo', '8993358000174');
        $this->adicionaJoin('DELX_CAD_Pessoa', null, 1, 'sup_PedidoFornecedor', 'emp_codigo');
        $this->setSTop(75);
    }

    /**
     * Contador de pedidos aguardando aprovação
     */
    public function buscaBadgeCompras() {

        $aRetorno = array();
        $sSql = "select COUNT(*) as total from sup_pedido(nolock)   where sup_pedidosituacao = 'A' and fil_codigo = '8993358000174' ";
        $s = $this->consultaSql($sSql);

        $sSql = "select COUNT(*) as total from sup_pedido(nolock)   where sup_pedidosituacao = 'A' and fil_codigo = '75483040000211' ";
        $f = $this->consultaSql($sSql);

        $sSql = "select COUNT(*) as total from sup_pedido(nolock)   where sup_pedidosituacao = 'A' and fil_codigo = '75483040000130' ";
        $m = $this->consultaSql($sSql);

        $aRetorno['steeltrater'] = $s->total;
        $aRetorno['filial'] = $f->total;
        $aRetorno['matriz'] = $m->total;


        return $aRetorno;
    }

    public function getPedidosCompra2($dataInicial, $dataFinal, $cnpj) {

        $sSql = "select "
                . "sup_pedidoseq,"
                . "emp_pessoa.emp_razaosocial as fornecedor "
                . "from sup_pedido(nolock) "
                . "left outer join emp_pessoa(nolock) "
                . "on sup_pedido.sup_PedidoFornecedor = emp_pessoa.emp_codigo "
                . "where sup_pedidodata between '" . $dataInicial . "' and '" . $dataFinal . "' "
                . "and sup_pedidosituacao = 'A' "
                . "and fil_codigo = " . $cnpj . " "
                . "order by sup_pedidoseq desc ";

        $result = $this->getObjetoSql($sSql);

        $aDados = array();
        $aPedidos = array();
        $aRetorno = array();
        $iContador = 0;

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['sup_pedidoseq'] = $row->sup_pedidoseq;
            $aDados['fornecedor'] = $row->fornecedor;
            $aPedidos[] = $aDados;
            $iContador++;
        }
        $aRetorno['pedidos'] = $aPedidos;
        $aRetorno['contador'] = $iContador;
        switch ($cnpj) {
            case 8993358000174:
                $aRetorno['empresa'] = 'SteelTrater';
                break;
            case 75483040000211:
                $aRetorno['empresa'] = 'Metalbo Filial';
                break;
            case 75483040000130:
                $aRetorno['empresa'] = 'Metalbo Matriz';
                break;
        }
        return $aRetorno;
    }

    public function getPedidosCompra($dataInicial, $dataFinal, $cnpj) {

        $aDados = array();
        $aPedidos = array();
        $aRetorno = array();
        $iContador = 0;

        $sSql = "select "
                . "sup_pedidoseq,"
                . "convert(varchar,sup_pedidodata,103) as sup_pedidodata,"
                . "emp_pessoa.emp_razaosocial as fornecedor,"
                . "sup_pedidovalortotal,"
                . "sup_pedidousuario,"
                . "sup_pedidovlrfrete,"
                . "sup_pedidoobservacao "
                . "from sup_pedido(nolock) "
                . "left outer join emp_pessoa(nolock) "
                . "on sup_pedido.sup_PedidoFornecedor = emp_pessoa.emp_codigo "
                . "left outer join usu_usuario(nolock) "
                . "on sup_pedido.sup_pedidousuario = usu_usuario.usu_codigo "
                . "where sup_pedidodata between '" . $dataInicial . "' and '" . $dataFinal . "' "
                . "and sup_pedidosituacao = 'A' "
                . "and fil_codigo = " . $cnpj . " "
                . "order by sup_pedidoseq desc ";

        $result = $this->getObjetoSql($sSql);

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aDados['sup_pedidoseq'] = $row->sup_pedidoseq;
            $aDados['sup_pedidodata'] = $row->sup_pedidodata;
            $aDados['fornecedor'] = $row->fornecedor;
            $aDados['sup_pedidovalortotal'] = number_format($row->sup_pedidovalortotal, 2, ',', '.');
            $aDados['sup_pedidousuario'] = $row->sup_pedidousuario;
            $aDados['sup_pedidoobservacao'] = $row->sup_pedidoobservacao;
            $aDados['sup_pedidovlrfrete'] = number_format($row->sup_pedidovlrfrete, 2, ',', '.');
            $aDados['cnpj'] = $cnpj;
            $aRetornoItens = $this->getDadosItens($cnpj, $row->sup_pedidoseq);
            $aDados['itens'] = $aRetornoItens;
            $aPedidos[] = $aDados;
            $iContador++;
        }
        switch ($cnpj) {
            case 8993358000174:
                $aRetorno['empresa'] = 'SteelTrater';
                break;
            case 75483040000211:
                $aRetorno['empresa'] = 'Metalbo Filial';
                break;
            case 75483040000130:
                $aRetorno['empresa'] = 'Metalbo Matriz';
                break;
        }

        $aRetorno['pedidos'] = $aPedidos;
        $aRetorno['contador'] = $iContador;

        return $aRetorno;
    }

    public function getDadosItens($cnpj, $seq) {

        $aRetorno = array();
        $aI = array();
        $sSqlItens = "select "
                . "sup_pedidoitemdescricao,"
                . "sup_pedidoitemcomqtd,"
                . "sup_pedidoitemunidade,"
                . "sup_pedidoitemvalor "
                . "from sup_pedidoitem(nolock) "
                . "where sup_pedidoseq = " . $seq . " "
                . "and fil_codigo = " . $cnpj . " ";
        $result = $this->getObjetoSql($sSqlItens);

        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $aI['sup_pedidoitemdescricao'] = $row->sup_pedidoitemdescricao;
            $aI['sup_pedidoitemcomqtd'] = number_format($row->sup_pedidoitemcomqtd, 0, ',', '.');
            $aI['sup_pedidoitemvalor'] = number_format($row->sup_pedidoitemvalor, 2, ',', '.');
            $aI['sup_pedidoitemunidade'] = $row->sup_pedidoitemunidade;
            $aRetorno[] = $aI;
        }
        return $aRetorno;
    }

    public function gerenPedidoCompra($sit, $seq, $cnpj, $usucodigo) {

        /*
          switch ($cnpj) {
          case 8993358000174:
          ;
          break;
          case 75483040000211:
          ;
          break;
          case 75483040000130:
          ;
          break;
          } */


        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('Y-m-d 00:00:00.000');
        $sHora = date('Y-m-d H:i:s' . '.000');

        $sSql = "select usunomeDelsoft from met_tec_usuario where usucodigo = " . $usucodigo;
        $oUsuNomeDelsoft = $this->consultaSql($sSql);


        if ($sit == 'a') {
            $sHistorico = 'APROVAR';
            $sSit = 'L';
            $iAprovacao = 2;
        } elseif ($sit == 'r') {
            $sHistorico = 'REPROVAR';
            $sSit = 'R';
            $iAprovacao = 6;
        }

        /* tabela de cabeçalho */
        $sSqlUpdateCabecalho = "update "
                . "SUP_PEDIDO "
                . "set SUP_PedidoSituacao = '" . $sSit . "',"
                . "SUP_PedidoSeqAprovacao = " . $iAprovacao . ""
                . "where FIL_Codigo = " . $cnpj . " "
                . "and SUP_PedidoSeq = " . $seq . "";
        $aRetorno = $this->executaSql($sSqlUpdateCabecalho);
        if ($aRetorno[0]) {
            // tabela de itens
            $sSqlUpdateItens = "update "
                    . "SUP_PEDIDOITEM "
                    . "set SUP_PedidoItemSituacao = '" . $sSit . "' "
                    . "where FIL_Codigo = " . $cnpj . " "
                    . "and SUP_PedidoSeq = " . $seq . "";
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
                        . "" . $cnpj . ","
                        . "" . $seq . ","
                        . "(select (case when max(SUP_AprovacaoHistSeq) is null then 1 else max(SUP_AprovacaoHistSeq)+1 end) as SEQ from SUP_APROVACAOHIST where FIL_Codigo = " . $cnpj . " and SUP_AprovacaoHistPedidoSeq = " . $seq . "),"
                        . "CAST(N'" . $sData . "' AS DateTime),"
                        . "'" . $sSit . "',"
                        . "'" . $oUsuNomeDelsoft->usunomedelsoft . "',"
                        . "'',"
                        . "CAST(N'" . $sHora . "' AS DateTime),"
                        . "'" . $sHistorico . "',"
                        . "'')";
                $aRetorno = $this->executaSql($sSqlInsertHistorico);
            }
        }
        return $aRetorno;
    }

}
