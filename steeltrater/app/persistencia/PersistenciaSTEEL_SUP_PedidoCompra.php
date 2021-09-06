<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PersistenciaSTEEL_SUP_PedidoCompra extends Persistencia {

    public function __construct() {
        parent::__construct();


        $this->setTabela('SUP_PEDIDO');

        $this->adicionaRelacionamento('FIL_Codigo', 'FIL_Codigo', true, true);
        $this->adicionaRelacionamento('SUP_PedidoSeq', 'SUP_PedidoSeq', true, true, true);
        $this->adicionaRelacionamento('SUP_PedidoFornecedor', 'DELX_CAD_Pessoa.emp_codigo', false, false);
        $this->adicionaRelacionamento('SUP_PedidoFornecedor', 'SUP_PedidoFornecedor');
        $this->adicionaRelacionamento('SUP_PedidoRepresentante', 'SUP_PedidoRepresentante');
        $this->adicionaRelacionamento('SUP_PedidoNegociador', 'SUP_PedidoNegociador');
        $this->adicionaRelacionamento('SUP_PedidoTransportador', 'SUP_PedidoTransportador');
        $this->adicionaRelacionamento('SUP_PedidoSituacao', 'SUP_PedidoSituacao');
        $this->adicionaRelacionamento('SUP_PedidoObservacao', 'SUP_PedidoObservacao');
        $this->adicionaRelacionamento('SUP_PedidoMoeda', 'SUP_PedidoMoeda');
        $this->adicionaRelacionamento('SUP_PedidoMoedaData', 'SUP_PedidoMoedaData');
        $this->adicionaRelacionamento('SUP_PedidoMoedaValor', 'SUP_PedidoMoedaValor');
        $this->adicionaRelacionamento('SUP_PedidoTipo', 'SUP_PedidoTipo');
        $this->adicionaRelacionamento('SUP_PedidoTipoFrete', 'SUP_PedidoTipoFrete');
        $this->adicionaRelacionamento('SUP_PedidoVlrFrete', 'SUP_PedidoVlrFrete');
        $this->adicionaRelacionamento('SUP_PedidoVlrDespesa', 'SUP_PedidoVlrDespesa');
        $this->adicionaRelacionamento('SUP_PedidoVlrSeguro', 'SUP_PedidoVlrSeguro');
        $this->adicionaRelacionamento('SUP_PedidoVlrDesconto', 'SUP_PedidoVlrDesconto');
        $this->adicionaRelacionamento('SUP_PedidoPerDesconto', 'SUP_PedidoPerDesconto');
        $this->adicionaRelacionamento('SUP_PedidoContrato', 'SUP_PedidoContrato');
        $this->adicionaRelacionamento('SUP_PedidoNotaAviso', 'SUP_PedidoNotaAviso');
        $this->adicionaRelacionamento('SUP_PedidoData', 'SUP_PedidoData');
        $this->adicionaRelacionamento('SUP_PedidoUsuario', 'SUP_PedidoUsuario');
        $this->adicionaRelacionamento('SUP_PedidoTipoMovimento', 'SUP_PedidoTipoMovimento');
        $this->adicionaRelacionamento('SUP_PedidoHora', 'SUP_PedidoHora');
        $this->adicionaRelacionamento('SUP_PedidoContato', 'SUP_PedidoContato');
        $this->adicionaRelacionamento('SUP_PedidoCondicaoPag', 'SUP_PedidoCondicaoPag');
        $this->adicionaRelacionamento('SUP_PedidoDestino', 'SUP_PedidoDestino');
        $this->adicionaRelacionamento('SUP_PedidoTipoDesconto', 'SUP_PedidoTipoDesconto');
        $this->adicionaRelacionamento('SUP_PedidoValorProduto', 'SUP_PedidoValorProduto');
        $this->adicionaRelacionamento('SUP_PedidoValorServico', 'SUP_PedidoValorServico');
        $this->adicionaRelacionamento('SUP_PedidoValorTotal', 'SUP_PedidoValorTotal');
        $this->adicionaRelacionamento('SUP_PedidoIdentificador', 'SUP_PedidoIdentificador');
        $this->adicionaRelacionamento('SUP_PedidoValorDescontoServico', 'SUP_PedidoValorDescontoServico');
        $this->adicionaRelacionamento('SUP_PedidoSeqAprovacao', 'SUP_PedidoSeqAprovacao');
        $this->adicionaRelacionamento('SUP_PedidoValorTotalDesconto', 'SUP_PedidoValorTotalDesconto');
        $this->adicionaRelacionamento('SUP_PedidoMRP', 'SUP_PedidoMRP');
        $this->adicionaRelacionamento('SUP_PedidoMoedaValorNeg', 'SUP_PedidoMoedaValorNeg');
        $this->adicionaRelacionamento('SUP_PedidoPessoaEntrega', 'SUP_PedidoPessoaEntrega');
        $this->adicionaRelacionamento('SUP_PedidoPessoaEntregaEnd', 'SUP_PedidoPessoaEntregaEnd');
        $this->adicionaRelacionamento('SUP_PedidoEntregaObs', 'SUP_PedidoEntregaObs');
        $this->adicionaRelacionamento('SUP_PedidoSitEnvEmailForn', 'SUP_PedidoSitEnvEmailForn');
        $this->adicionaRelacionamento('SUP_PedidoPessoaFaturamento', 'SUP_PedidoPessoaFaturamento');
        $this->adicionaRelacionamento('SUP_PedidoPessoaFaturamentoEnd', 'SUP_PedidoPessoaFaturamentoEnd');
        $this->adicionaRelacionamento('SUP_PedidoFaturamentoObs', 'SUP_PedidoFaturamentoObs');
        $this->adicionaRelacionamento('SUP_PedidoContratoEntregaFutur', 'SUP_PedidoContratoEntregaFutur');
        $this->adicionaRelacionamento('SUP_PedidoUsuNegacao', 'SUP_PedidoUsuNegacao');
        $this->adicionaRelacionamento('SUP_PedidoDataHoraNegacao', 'SUP_PedidoDataHoraNegacao');
        $this->adicionaRelacionamento('SUP_PedidoCCTCod', 'SUP_PedidoCCTCod');
        $this->adicionaRelacionamento('SUP_PedidoFornecedorEnd', 'SUP_PedidoFornecedorEnd');
        $this->adicionaRelacionamento('SUP_PedidoLiberadoAprovacao', 'SUP_PedidoLiberadoAprovacao');
        $this->adicionaRelacionamento('SUP_PedidoFornecedorAssociado', 'SUP_PedidoFornecedorAssociado');
        $this->adicionaRelacionamento('SUP_PedidoChassi', 'SUP_PedidoChassi');
        $this->adicionaRelacionamento('SUP_PedidoKM', 'SUP_PedidoKM');
        $this->adicionaRelacionamento('SUP_PedidoNSG', 'SUP_PedidoNSG');
        $this->adicionaRelacionamento('SUP_PedidoTipoControle', 'SUP_PedidoTipoControle');
        $this->adicionaRelacionamento('SUP_PedidoTipoPEC', 'SUP_PedidoTipoPEC');
        $this->adicionaRelacionamento('SUP_PedidoVia', 'SUP_PedidoVia');
        $this->adicionaRelacionamento('SUP_PedidoVlrAcrescimo', 'SUP_PedidoVlrAcrescimo');
        $this->adicionaRelacionamento('SUP_PedidoDataValidade', 'SUP_PedidoDataValidade');
        $this->adicionaRelacionamento('SUP_PedidoBxPrevisao', 'SUP_PedidoBxPrevisao');

        /*         * **************************************************************************
          $this->adicionaRelacionamento('SUP_PedidoOrcamento', 'SUP_PedidoOrcamento');
          $this->adicionaRelacionamento('SUP_PedidoEnvEmaForn', 'SUP_PedidoEnvEmaForn');
          $this->adicionaRelacionamento('SUP_PedidoCondicaoPagDescritiv', 'SUP_PedidoCondicaoPagDescritiv');
          $this->adicionaRelacionamento('FIN_FormaPagamentoCodigo', 'FIN_FormaPagamentoCodigo');
          $this->adicionaRelacionamento('SUP_PedidoUsuarioAprovador', 'SUP_PedidoUsuarioAprovador');
          $this->adicionaRelacionamento('SUP_PedidoEquipamento', 'SUP_PedidoEquipamento');
          $this->adicionaRelacionamento('SUP_PedidoUsuarioResponsavel', 'SUP_PedidoUsuarioResponsavel');
         * **************************************************************************** */

        $this->adicionaOrderBy('sup_pedidoseq', 1);
        $this->adicionaFiltro('FIL_Codigo', '8993358000174');
        $this->adicionaJoin('DELX_CAD_Pessoa', null, 1, 'SUP_PedidoFornecedor', 'emp_codigo');
        $this->setSTop(75);
    }

    public function afterInsert($aCampos) {
        parent::afterInsert($aCampos);

        $sSql = "update tec_sequencia set tec_sequencianumero = " . $aCampos['sup_pedidoseq'] . " "
                . "where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='SUP_PEDIDO'";

        $this->executaSql($sSql);
    }

    /* APLICATIVO */

    public function buscaBadgePedCompras($oDados) {
        /**
         * Contador de pedidos aguardando aprovação
         */
        $aRetorno = array();
        if ($oDados->usucodigo == 22) {
            $sSql = "select COUNT(*) as total from sup_pedido(nolock) where sup_pedidosituacao = 'A' and fil_codigo = '8993358000174' ";
            $s = $this->consultaSql($sSql);
        } else {
            $s->total = 0;
        }

        /* matriz e filial */
        $sSql = "select usunomedelsoft from met_tec_usuario(nolock) where usucodigo = " . $oDados->usucodigo;
        $oUsuNomeDelsoft = $this->consultaSql($sSql);

        $sSql = "select count(*) as total from rex_maquinas.widl.PED01(nolock) where pdcsituaca = 'N' and pdcfutaut ='" . $oUsuNomeDelsoft->usunomedelsoft . "' and filcgc = '75483040000211'";
        $f = $this->consultaSql($sSql);

        $sSql = "select count(*) as total from rex_maquinas.widl.PED01(nolock) where pdcsituaca = 'N' and pdcfutaut ='" . $oUsuNomeDelsoft->usunomedelsoft . "' and filcgc = '75483040000130'";
        $m = $this->consultaSql($sSql);

        $aRetorno['steeltrater'] = $s->total;
        $aRetorno['filial'] = $f->total;
        $aRetorno['matriz'] = $m->total;

        return $aRetorno;
    }

    public function getPedidosCompra($cnpj, $usucodigo) {

        switch ($cnpj) {
            case 8993358000174:
                if ($usucodigo == 22) {
                    $aDados = array();
                    $aPedidos = array();
                    $aRetorno = array();
                    $iContador = 0;

                    $sSql = "select top 50 "
                            . "sup_pedido.sup_pedidoseq,"
                            . "sup_pedidovlrdesconto,"
                            . "sup_pedidovalordescontoservico,"
                            . "convert(varchar,sup_pedidodata,103) as sup_pedidodata,"
                            . "emp_pessoa.emp_razaosocial as fornecedor,"
                            . "sup_pedidovalortotal,"
                            . "sup_pedidousuario,"
                            . "sup_pedidovlrfrete,"
                            . "sup_pedidoobservacao,"
                            . "sup_pedidoimpostovalor "
                            . "from sup_pedido(nolock) "
                            . "left outer join emp_pessoa(nolock) "
                            . "on sup_pedido.sup_PedidoFornecedor = emp_pessoa.emp_codigo "
                            . "left outer join usu_usuario(nolock) "
                            . "on sup_pedido.sup_pedidousuario = usu_usuario.usu_codigo "
                            . "left outer join sup_pedidoimposto(nolock) "
                            . "on sup_pedido.sup_pedidoseq = sup_pedidoimposto.sup_pedidoseq "
                            . "and sup_pedido.fil_codigo = sup_pedidoimposto.fil_codigo "
                            . "where sup_pedidosituacao = 'A' "
                            . "and sup_pedido.fil_codigo = 8993358000174 "
                            . "order by sup_pedido.sup_pedidoseq desc ";

                    $result = $this->getObjetoSql($sSql);
                    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                        $aDados['nr'] = $row->sup_pedidoseq;
                        $aDados['data'] = $row->sup_pedidodata;
                        $aDados['fornecedor'] = $row->fornecedor;
                        $aDados['valorTotal'] = number_format($row->sup_pedidovalortotal, 3, ',', '.');
                        $aDados['usuario'] = $row->sup_pedidousuario;
                        $aDados['observacao'] = $row->sup_pedidoobservacao;
                        $aDados['valorFrete'] = number_format($row->sup_pedidovlrfrete, 3, ',', '.');
                        $aDados['ipi'] = number_format($row->sup_pedidoimpostovalor, 3, ',', '.');
                        $aDados['descontos'] = number_format($row->sup_pedidovlrdesconto + $row->sup_pedidovalordescontoservico, 3, ',', '.');
                        $aDados['cnpj'] = $cnpj;
                        $aRetornoItens = $this->getDadosItens($cnpj, $row->sup_pedidoseq);
                        $aDados['itens'] = $aRetornoItens;
                        $aPedidos[] = $aDados;
                        $iContador++;
                    }
                    $aRetorno['empresa'] = 'SteelTrater';
                    $aRetorno['pedidos'] = $aPedidos;
                    $aRetorno['contador'] = $iContador;
                    break;
                } else {
                    $aRetorno['empresa'] = 'SteelTrater';
                    $aRetorno['pedidos'] = '';
                    $aRetorno['contador'] = 0;
                    break;
                }

            case 75483040000211:
                $aDados = array();
                $aPedidos = array();
                $aRetorno = array();
                $iContador = 0;

                $sSql = "select usunomedelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
                $oUsuNomeDelsoft = $this->consultaSql($sSql);

                $sSql = "select "
                        . "rex_maquinas.widl.PED01.filcgc,"
                        . "pdcfutaut,"
                        . "convert(varchar, pdcimplant, 103) as pdcimplant,"
                        . "rex_maquinas.widl.PED01.pdcnro as pdcnro,"
                        . "empdes as fornecedor,"
                        . "pdcusu,"
                        . "pdcfrevalo,"
                        . "CAST(pdcobs as VARCHAR(MAX)) AS pdcobs,"
                        . "round(sum(pdcproqtdp * pdcprovlru * (pdcproipia/100)),2) as totalipi,"
                        . "round(sum(((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100) * pdcdescont/100), 2) as desconto,"
                        . "round(sum((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100), 2)as valortotal "
                        . "from rex_maquinas.widl.PED01(nolock) "
                        . "left outer join rex_maquinas.widl.EMP01(nolock) "
                        . "on rex_maquinas.widl.PED01.empcod = rex_maquinas.widl.EMP01.empcod "
                        . "left outer join rex_maquinas.widl.PEDC01(nolock) "
                        . "on rex_maquinas.widl.PED01.filcgc = rex_maquinas.widl.PEDC01.filcgc "
                        . "and rex_maquinas.widl.PED01.pdcnro = rex_maquinas.widl.PEDC01.pdcnro "
                        . "where "
                        . "pdcsituaca = 'N' "
                        . "and pdcfutaut = '" . $oUsuNomeDelsoft->usunomedelsoft . "' "
                        . "and rex_maquinas.widl.PED01.filcgc = 75483040000211"
                        . "group by "
                        . "rex_maquinas.widl.PED01.filcgc,"
                        . "pdcfutaut,"
                        . "pdcimplant,"
                        . "rex_maquinas.widl.PED01.pdcnro,"
                        . "rex_maquinas.widl.EMP01.empdes,"
                        . "rex_maquinas.widl.PED01.pdcsituaca,"
                        . "pdcfrevalo,"
                        . "CAST(pdcobs as VARCHAR(MAX)),"
                        . "rex_maquinas.widl.PED01.pdcusu "
                        . "order by "
                        . "rex_maquinas.widl.PED01.pdcnro desc";
                $result = $this->getObjetoSql($sSql);
                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aDados['nr'] = $row->pdcnro;
                    $aDados['data'] = $row->pdcimplant;
                    $aDados['fornecedor'] = $row->fornecedor;
                    $aDados['valorTotal'] = number_format($row->valortotal, 3, ',', '.');
                    $aDados['usuario'] = $row->pdcusu;
                    $aDados['observacao'] = trim($row->pdcobs);
                    $aDados['valorFrete'] = number_format($row->pdcfrevalo, 3, ',', '.');
                    $aDados['ipi'] = number_format($row->totalipi, 3, ',', '.');
                    $aDados['descontos'] = number_format($row->desconto, 3, ',', '.');
                    $aDados['cnpj'] = $cnpj;
                    $aRetornoItens = $this->getDadosItens($cnpj, $row->pdcnro);
                    $aDados['itens'] = $aRetornoItens;
                    $aPedidos[] = $aDados;
                    $iContador++;
                }
                $aRetorno['empresa'] = 'Metalbo Filial';
                $aRetorno['pedidos'] = $aPedidos;
                $aRetorno['contador'] = $iContador;
                break;
            case 75483040000130:
                $aDados = array();
                $aPedidos = array();
                $aRetorno = array();
                $iContador = 0;

                $sSql = "select usunomedelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
                $oUsuNomeDelsoft = $this->consultaSql($sSql);

                $sSql = "select "
                        . "rex_maquinas.widl.PED01.filcgc,"
                        . "pdcfutaut,"
                        . "convert(varchar, pdcimplant, 103) as pdcimplant,"
                        . "rex_maquinas.widl.PED01.pdcnro as pdcnro,"
                        . "empdes as fornecedor,"
                        . "pdcusu,"
                        . "pdcsomatpr,"
                        . "pdcfrevalo,"
                        . "CAST(pdcobs as VARCHAR(MAX)) AS pdcobs,"
                        . "round(sum(pdcproqtdp * pdcprovlru * (pdcproipia/100)),2) as totalipi,"
                        . "round(sum(((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100) * pdcdescont/100), 2) as desconto,"
                        . "round(sum((pdcproqtdp*pdcprovlru) +(pdcproqtdp*pdcprovlru)*pdcproipia/100), 2)as valortotal "
                        . "from rex_maquinas.widl.PED01(nolock) "
                        . "left outer join rex_maquinas.widl.EMP01(nolock) "
                        . "on rex_maquinas.widl.PED01.empcod = rex_maquinas.widl.EMP01.empcod "
                        . "left outer join rex_maquinas.widl.PEDC01(nolock) "
                        . "on rex_maquinas.widl.PED01.filcgc = rex_maquinas.widl.PEDC01.filcgc "
                        . "and rex_maquinas.widl.PED01.pdcnro = rex_maquinas.widl.PEDC01.pdcnro "
                        . "where pdcsituaca = 'N' "
                        . "and pdcfutaut = '" . $oUsuNomeDelsoft->usunomedelsoft . "' "
                        . "and rex_maquinas.widl.PED01.filcgc = 75483040000130"
                        . "group by "
                        . "rex_maquinas.widl.PED01.filcgc,"
                        . "pdcfutaut,"
                        . "pdcimplant,"
                        . "rex_maquinas.widl.PED01.pdcnro,"
                        . "rex_maquinas.widl.EMP01.empdes,"
                        . "rex_maquinas.widl.PED01.pdcsituaca,"
                        . "pdcsomatpr,"
                        . "pdcfrevalo,"
                        . "CAST(pdcobs as VARCHAR(MAX)),"
                        . "rex_maquinas.widl.PED01.pdcusu "
                        . "order by "
                        . "rex_maquinas.widl.PED01.pdcnro desc";
                $result = $this->getObjetoSql($sSql);
                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aDados['nr'] = $row->pdcnro;
                    $aDados['data'] = $row->pdcimplant;
                    $aDados['fornecedor'] = $row->fornecedor;
                    $aDados['valorTotal'] = number_format($row->valortotal, 3, ',', '.');
                    $aDados['usuario'] = $row->pdcusu;
                    $aDados['observacao'] = trim($row->pdcobs);
                    $aDados['valorFrete'] = number_format($row->pdcfrevalo, 3, ',', '.');
                    $aDados['ipi'] = number_format($row->totalipi, 3, ',', '.');
                    $aDados['descontos'] = number_format($row->desconto, 3, ',', '.');
                    $aDados['cnpj'] = $cnpj;
                    $aRetornoItens = $this->getDadosItens($cnpj, $row->pdcnro);
                    $aDados['itens'] = $aRetornoItens;
                    $aPedidos[] = $aDados;
                    $iContador++;
                }
                $aRetorno['empresa'] = 'Metalbo Matriz';
                $aRetorno['pedidos'] = $aPedidos;
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
                        . "sup_pedidoitemdescricao,"
                        . "sup_pedidoitemcomqtd,"
                        . "sup_pedidoitemunidade,"
                        . "sup_pedidoitemvalor "
                        . "from sup_pedidoitem(nolock) "
                        . "where sup_pedidoseq = " . $nr . " "
                        . "and fil_codigo = " . $cnpj . " ";
                $result = $this->getObjetoSql($sSqlItens);

                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aI['codigo'] = trim($row->pro_codigo);
                    $aI['itemdescricao'] = $row->sup_pedidoitemdescricao;
                    $aI['itemqtd'] = number_format($row->sup_pedidoitemcomqtd, 3, ',', '.');
                    $aI['itemvalor'] = number_format($row->sup_pedidoitemvalor, 3, ',', '.');
                    $aI['itemvalortotal'] = number_format($row->sup_pedidoitemvalor * $row->sup_pedidoitemcomqtd, 3, ',', '.');
                    $aI['itemunidade'] = $row->sup_pedidoitemunidade;
                    $aComprasAnt = $this->getDadosComprasAnteriores($cnpj, $nr, trim($row->pro_codigo));
                    if (!empty($aComprasAnt)) {
                        $aI['antigos'] = $aComprasAnt;
                    }
                    $aRetorno[] = $aI;
                }
                return $aRetorno;

            case 75483040000211:
                $aRetorno = array();
                $aI = array();
                $sSqlItens = "select "
                        . "prodes,"
                        . "pround,"
                        . "pdcproqtdp,"
                        . "pdcprovlru "
                        . "from rex_maquinas.widl.PEDC01(nolock) "
                        . "left outer join rex_maquinas.widl.PROD01(nolock) "
                        . "on rex_maquinas.widl.PEDC01.procod = rex_maquinas.widl.PROD01.procod "
                        . "where pdcnro = " . $nr . " "
                        . "and filcgc = " . $cnpj . " ";
                $result = $this->getObjetoSql($sSqlItens);

                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aI['codigo'] = trim($row->procod);
                    $aI['itemdescricao'] = $row->prodes;
                    $aI['itemqtd'] = number_format($row->pdcproqtdp, 3, ',', '.');
                    $aI['itemvalor'] = number_format($row->pdcprovlru, 3, ',', '.');
                    $aI['itemvalortotal'] = number_format($row->pdcprovlru * $row->pdcproqtdp, 3, ',', '.');
                    $aI['itemunidade'] = $row->pround;
                    $aRetorno[] = $aI;
                }
                return $aRetorno;

            case 75483040000130:
                $aRetorno = array();
                $aI = array();
                $sSqlItens = "select "
                        . "prodes,"
                        . "pround,"
                        . "pdcproqtdp,"
                        . "pdcprovlru "
                        . "from rex_maquinas.widl.PEDC01(nolock) "
                        . "left outer join rex_maquinas.widl.PROD01(nolock) "
                        . "on rex_maquinas.widl.PEDC01.procod = rex_maquinas.widl.PROD01.procod "
                        . "where pdcnro = " . $nr . " "
                        . "and filcgc = " . $cnpj . " ";
                $result = $this->getObjetoSql($sSqlItens);

                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aI['codigo'] = trim($row->procod);
                    $aI['itemdescricao'] = $row->prodes;
                    $aI['itemqtd'] = number_format($row->pdcproqtdp, 3, ',', '.');
                    $aI['itemvalor'] = number_format($row->pdcprovlru, 3, ',', '.');
                    $aI['itemvalortotal'] = number_format($row->pdcprovlru * $row->pdcproqtdp, 3, ',', '.');
                    $aI['itemunidade'] = $row->pround;
                    $aRetorno[] = $aI;
                }
                return $aRetorno;
        }
    }

    public function getDadosComprasAnteriores($cnpj, $nr, $codigo) {
        switch ($cnpj) {
            case 8993358000174:
                $aRetorno = array();
                $aI = array();
                $sSql = "select top 5 "
                        . "sup_pedidoseq,"
                        . "sup_pedidoitemcomqtd,"
                        . "sup_pedidoitemvalor,"
                        . "sup_pedidoitemvalortotal "
                        . "from sup_pedidoitem "
                        . "where fil_codigo = " . $cnpj . " "
                        . "and pro_codigo = " . $codigo . " "
                        . "and sup_pedidoseq < " . $nr . " "
                        . "order by sup_pedidoseq desc";
                $result = $this->getObjetoSql($sSql);
                while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                    $aI['nr'] = $row->sup_pedidoseq;
                    $aI['itemqtd'] = number_format($row->sup_pedidoitemcomqtd, 3, ',', '.');
                    $aI['itemvalor'] = number_format($row->sup_pedidoitemvalor, 3, ',', '.');
                    $aI['itemvalortotal'] = number_format($row->sup_pedidoitemvalor * $row->sup_pedidoitemcomqtd, 3, ',', '.');
                    $aRetorno[] = $aI;
                }
                return $aRetorno;

            case 75483040000211:


                break;
            case 75483040000130:


                break;
        }
    }

    public function gerenPedidoCompra($sit, $nr, $cnpj, $usucodigo) {

        $bParam = $this->verificaPedSituaca($nr, $cnpj);

        if (!$bParam) {
            $aRetorno[0] = false;
            $aRetorno[1] = 'C';
            return $aRetorno;
        } else {
            switch ($cnpj) {
                case 8993358000174:
                    date_default_timezone_set('America/Sao_Paulo');
                    $sData = date('Y-m-d 00:00:00.000');
                    $sHora = date('Y-m-d H:i:s' . '.000');

                    $sSql = "select usunomeDelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
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
                            . "and SUP_PedidoSeq = " . $nr . "";
                    $aRetorno = $this->executaSql($sSqlUpdateCabecalho);
                    if ($aRetorno[0]) {
                        // tabela de itens
                        $sSqlUpdateItens = "update "
                                . "SUP_PEDIDOITEM "
                                . "set SUP_PedidoItemSituacao = '" . $sSit . "' "
                                . "where FIL_Codigo = " . $cnpj . " "
                                . "and SUP_PedidoSeq = " . $nr . "";
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
                                    . "" . $nr . ","
                                    . "(select (case when max(SUP_AprovacaoHistSeq) is null then 1 else max(SUP_AprovacaoHistSeq)+1 end) as SEQ from SUP_APROVACAOHIST where FIL_Codigo = " . $cnpj . " and SUP_AprovacaoHistPedidoSeq = " . $nr . "),"
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

                case 75483040000211:
                    date_default_timezone_set('America/Sao_Paulo');
                    $sSql = "select usunomeDelsoft from met_tec_usuario(nolock) where usucodigo = " . $usucodigo;
                    $oUsuNomeDelsoft = $this->consultaSql($sSql);
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
                            . "pdcaut = '" . $oUsuNomeDelsoft->usunomedelsoft . "',"
                            . "pdcdta = '" . $sData . "',"
                            . "pdchra = '" . $sHora . "' "
                            . "where filcgc = 75483040000211 "
                            . "and pdcnro = " . $nr . "";
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
                            . "pdcaut = 'IVO',"
                            . "pdcdta = '" . $sData . "',"
                            . "pdchra = '" . $sHora . "' "
                            . "where filcgc = 75483040000130 "
                            . "and pdcnro = " . $nr . "";
                    $aRetorno = $this->executaSql($sSql);
                    return $aRetorno;
            }
        }
    }

    public function buscaCondPag() {
        $sSql = "select cpg_codigo,cpg_descricao from CPG_CondicaoPagamento";
        $sth = $this->getObjetoSql($sSql);
        $aRetorno = array();
        while ($aCondPag = $sth->fetch(PDO::FETCH_ASSOC)) {
            $aRetorno[] = $aCondPag;
        }
        return $aRetorno;
    }

    public function verificaPedSituaca($nr, $cnpj) {
        $sSql = "select "
                . "COUNT(*) as total "
                . "from sup_pedido(nolock) "
                . "where sup_pedidosituacao = 'A' "
                . "and fil_codigo = '" . $cnpj . "' "
                . "and sup_pedidoseq = " . $nr . "";
        $oCount = $this->consultaSql($sSql);

        if ($oCount->total == 0) {
            return false;
        } else {
            return true;
        }
    }

}
