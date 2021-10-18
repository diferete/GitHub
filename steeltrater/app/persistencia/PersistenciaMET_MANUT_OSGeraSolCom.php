<?php

/*
 * Implementa a classe persistencia MET_MANUT_OSGeraSolCom
 * @author Cleverton Hoffmann
 * @since 20/09/2021
 */

class PersistenciaMET_MANUT_OSGeraSolCom extends Persistencia {

    public function __construct() {
        parent::__construct();

        $this->setTabela('MET_MANUT_OSMaterial');
        $this->adicionaRelacionamento('fil_codigo', 'fil_codigo', true, true);
        $this->adicionaRelacionamento('nr', 'nr', true, true);
        $this->adicionaRelacionamento('cod', 'cod', true, true);
        $this->adicionaRelacionamento('seq', 'seq', true, true);
        $this->adicionaRelacionamento('codmat', 'codmat');
        $this->adicionaRelacionamento('descricaomat', 'descricaomat');
        $this->adicionaRelacionamento('usermatcod', 'usermatcod');
        $this->adicionaRelacionamento('usermatdes', 'usermatdes');
        $this->adicionaRelacionamento('quantidade', 'quantidade');
        $this->adicionaRelacionamento('obsmat', 'obsmat');
        $this->adicionaRelacionamento('datamat', 'datamat');
        $this->adicionaRelacionamento('processoCompra', 'processoCompra');
        $this->adicionaRelacionamento('numero', 'numero', true, true, true);
        $this->adicionaRelacionamento('quantMatSol', 'quantMatSol');

        $this->adicionaOrderBy('numero', 1);

        $this->setSTop('50');
    }

    /**
     * Gera a solicitação de compras automática conforme os materias selecionados das OS
     * @param type $aDadosOS
     * @param type $sOSs
     * @param type $sCodMaqs
     * @return type
     */
    public function geraSolicOS($aDadosOS, $sOSs, $sCodMaqs) {
        //Busca auto incremento da tabela cabeçalho
        $oSup = Fabrica::FabricarController('STEEL_SUP_Solicitacao');
        $inc = $oSup->retornaValuInc();
        $oUsuNomeDelsoft = $_SESSION['nomedelsoft'];
        date_default_timezone_set('America/Sao_Paulo');
        $sData = date('Y-m-d H:i:s' . '.000', strtotime('+ 5 days'));

        //Parte que insere a cabeçalho
        $sSql = "SET DATEFORMAT ymd;
                 INSERT INTO SUP_SOLICITACAO (FIL_Codigo, SUP_SolicitacaoSeq, SUP_SolicitacaoDataHora, SUP_SolicitacaoObservacao, SUP_SolicitacaoUsuCadastro, 
                 SUP_SolicitacaoTipo, SUP_SolicitacaoSituacao, SUP_SolicitacaoFaseApr, SUP_SolicitacaoMRP, SUP_SolicitacaoCCTCod)
                 VALUES (8993358000174," . $inc . ", CAST(N'" . $sData . "' AS DateTime),'USO CONFORME A NECESSIDADE DAS OS " . $sOSs . " NOS EQUIPAMENTOS " . $sCodMaqs . "','" . $oUsuNomeDelsoft . "','E', 'M', '99', '0', '0') ";

        $aRetorno = $this->executaSql($sSql);

        //Parte que adiciona seq na tabela de sequenciamento
        $sSql2 = "update tec_sequencia set tec_sequencianumero = " . $inc . " "
                . "where tec_sequenciaFilial = '8993358000174' and tec_sequenciaTabela ='SUP_Solicitacao'";

        $this->executaSql($sSql2);

        //Se inserido a cabeçalho insere os itens da solicitação
        if ($aRetorno[0]) {

            $sData1 = date('Y-m-d H:i:s' . '.000', strtotime('+ 5 days'));
            $sData2 = date('Y-m-d H:i:s' . '.000', strtotime('+ 15 days'));

            foreach ($aDadosOS as $key => $value) {
                //Busca autoincremento manual de acordo com a sequencia gerada na classe cabeçalho   
                $sSql5 = 'SELECT COALESCE(MAX(SUP_SolicitacaoItemSeq),0)+1 AS proximo FROM SUP_SolicitacaoItem where SUP_SolicitacaoSeq = ' . $inc;
                $obj = $this->consultaSql($sSql5);
                $inc1 = $obj->proximo;

                //Busca item tabela de material das OS
                $oMatOS = Fabrica::FabricarController('MET_MANUT_OSMaterial');
                $oMatOS->Persistencia->adicionaFiltro('fil_codigo', $value['fil_codigo']);
                $oMatOS->Persistencia->adicionaFiltro('nr', $value['nr']);
                $oMatOS->Persistencia->adicionaFiltro('seq', $value['seq']);
                $oMatOS->Persistencia->adicionaFiltro('cod', $value['cod']);
                $oDadosMatOS = $oMatOS->Persistencia->consultarWhere();

                //Busca a descrição da unidade na tabela de produtos
                $oPro = Fabrica::FabricarController('DELX_PRO_Produtos');
                $oPro->Persistencia->adicionaFiltro('pro_codigo', $oDadosMatOS->getCodmat());
                $oDadosPro = $oPro->Persistencia->consultarWhere();

                //Busca a centro de custo da máquina
                $oContMaq = Fabrica::FabricarController('MET_CAD_Maquinas');
                $oContMaq->Persistencia->adicionaFiltro('fil_codigo', $value['fil_codigo']);
                $oContMaq->Persistencia->adicionaFiltro('codigoMaq', $value['cod']);
                $oMaqDados = $oContMaq->Persistencia->consultarWhere();
                $cct_custo = $oMaqDados->getCct_codigo();

                //Preenche a observação adicional caso o material seja diversos
                $sObs = '';
                if ($oDadosMatOS->getCodmat() == 0) {
                    $sObs = ". Material: " . $oDadosMatOS->getObsmat();
                }

                $sSql1 = "SET DATEFORMAT ymd;"
                        . "INSERT INTO SUP_SOLICITACAOITEM ("
                        . "FIL_Codigo, SUP_SolicitacaoSeq, SUP_SolicitacaoItemSeq, PRO_Codigo, SUP_PrioridadeCodigo, SUP_SolicitacaoItemDescricao, SUP_SolicitacaoItemUnidade,SUP_SolicitacaoItemDimPecas, SUP_SolicitacaoItemDimComprime, SUP_SolicitacaoItemDimLargura, "
                        . "SUP_SolicitacaoItemDimEspessur, SUP_SolicitacaoItemComQtd, SUP_SolicitacaoItemComConv,SUP_SolicitacaoItemComUnd, SUP_SolicitacaoItemQtd, SUP_SolicitacaoItemDataNecessi, SUP_SolicitacaoItemUsuSol, SUP_SolicitacaoItemUsuCom, SUP_SolicitacaoItemObservacao,"
                        . "SUP_SolicitacaoItemReferencia, SUP_SolicitacaoItemValor, SUP_SolicitacaoItemPesoLiq, SUP_SolicitacaoItemPesoBru, SUP_SolicitacaoItemDimUnidade, SUP_SolicitacaoItemDataAprVerb, SUP_SolicitacaoItemValorTotal, SUP_SolicitacaoItemSituacao,"
                        . "SUP_SolicitacaoItemGrade, SUP_SolicitacaoItemTipoDespCod, SUP_SolicitacaoItemCCTCodigo, SUP_SolicitacaoItemPlano, SUP_SolicitacaoItemConta, SUP_SolicitacaoItemProjeto, SUP_SolicitacaoItemOriTipo, SUP_SolicitacaoItemOriNumero, SUP_SolicitacaoItemOriItem,"
                        . "SUP_SolicitacaoItemConversor,SUP_SolicitacaoItemDimConv, SUP_SolicitacaoItemDimUndConv, SUP_SolicitacaoItemDimGQtd, SUP_SolicitacaoItemDimGFormula, SUP_SolicitacaoItemDimGExpres, SUP_SolicitacaoItemDataEntrega,SUP_SolicitacaoItemPosicao, "
                        . "SUP_SolicitacaoItemPesoLiqTot, SUP_SolicitacaoItemPesoBruTot, SUP_SolicitacaoItemValorPrevis, SUP_SolicitacaoItemCalculaDim"
                        . ")"
                        . "VALUES"
                        . "("
                        . "8993358000174, " . $inc . ", " . $inc1 . ", " . $oDadosMatOS->getCodmat() . ", 1, '" . str_replace("'", "''", $oDadosMatOS->getDescricaomat()) . "', '" . $oDadosPro->getPro_unidademedida() . "', 0, 0, 0, 0, " . $oDadosMatOS->getQuantMatSol() . ", "
                        . "1, '" . $oDadosPro->getPro_unidademedida() . "', " . $oDadosMatOS->getQuantMatSol() . ",  CAST(N'" . $sData1 . "' AS DateTime), '" . $oUsuNomeDelsoft . "', 'Amanda.Pisetta', "
                        . "'Referente ao material seq " . $value['seq'] . " da OS nº " . $value['nr'] . " para a máquina " . $value['cod'] . $sObs . "', NULL, 0, 0, 0,NULL, '1753-01-01 00:00:00.000', 0, "
                        . "'A', NULL, 649, " . $cct_custo . ", 0, NULL, NULL,'N', 0, 0, NULL,0, 0, 0, NULL, NULL,  CAST(N'" . $sData2 . "' AS DateTime), NULL, NULL, NULL, NULL, NULL) ";
                $aRetorno1 = $this->executaSql($sSql1);

                //Alteração da situação para SOLICITADO do item, após a inserção do mesmo na solicitação
                if ($aRetorno1[0]) {
                    $sSql3 = "update MET_MANUT_OSMaterial set processoCompra = 'SOLICITADO' "
                            . "where fil_codigo = '" . $value['fil_codigo'] . "' and nr ='" . $value['nr'] . "' and seq = '" . $value['seq'] . "' and cod = '" . $value['cod'] . "'";
                    $this->executaSql($sSql3);
                }
            }

            return $aRetorno1;
        }
    }

}
