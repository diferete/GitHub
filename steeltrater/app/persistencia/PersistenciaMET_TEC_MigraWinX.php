<?php

/**
 * Implementa persistencia da classe MET_TEC_MigraWinX
 * 
 * @author Alexandre W de Souza
 * @since 01/10/2018
 * ** */
class PersistenciaMET_TEC_MigraWinX extends Persistencia {

    public function __construct() {
        parent::__construct();
    }

    public function migraProd($sDados) {

        if ($sDados == 'Grupo') {
            $sSql = "insert into PRO_GRUPO "
                    . "select grucod,grudes,"
                    . "'04' as pro_grupoTipo,"
                    . "'E' as Prod_GrupoTipoControle,'0' as Pro_tipoDespesa,"
                    . "'0' as pro_tipoReceita,'N' as GRS_grupoPH,"
                    . "'' as pro_grupocomprador,'N' as pro_grupoContLote,"
                    . "'S' as pro_grupoMovEstoque,'' as pro_grupoTipoCusto"
                    . " from rex_maquinas.widl.PROD04 "
                    . "where grucod not in (select PRO_GrupoCodigo from PRO_GRUPO)";

            $aLog = $this->executaSql($sSql);
        }

        if ($sDados == 'SubGrupo') {

            $sSql = "insert into PRO_GRUPOSUBGRUPO"
                    . " select grucod,subcod,subdes,"
                    . "'N' as pro_TIPOCONTROLE,"
                    . "'0' as Prod_TIPODESPESA,'0' as Pro_TIPORECEITA,"
                    . "'0' as pro_FATCORSEQ,'N' as GRS_SUBgrupoPH,"
                    . "'0' as PRO_SUBCCT,'0' as pro_SUBgrupoComprador,"
                    . "'N' as pro_grupoContLote,'' as pro_grupoMovEstoque,"
                    . "'' as pro_grupoTipoCusto"
                    . " from rex_maquinas.widl.PROD05"
                    . " where grucod not in (select PRO_GrupoCodigo from PRO_GRUPOSUBGRUPO)";

            $aLog = $this->executaSql($sSql);
        }

        if ($sDados == 'Familia') {
            $sSql = "insert into PRO_GRUPOSUBGRUPOFAMILIA"
                    . " select grucod,subcod,famcod,famdes,"
                    . "'N' as pro_TIPOCONTROLE,'0' as Prod_TIPODESPESA,"
                    . "'0' as Pro_TIPORECEITA,'' as pro_FamComprador,"
                    . "'N' as pro_FamContLote,'' as GRS_FamMovEstoque,"
                    . "'' as pro_FamTipoCusto"
                    . " from rex_maquinas.widl.PROD04a "
                    . "where grucod not in (select PRO_GrupoCodigo from PRO_GRUPOSUBGRUPOFAMILIA)";

            $aLog = $this->executaSql($sSql);
        }

        if ($sDados == 'SubFamilia') {
            $sSql = "insert into PRO_GRUPOSUBGRUPOFAMILIASUBFAM"
                    . " select grucod,subcod,famcod,famsub,famsdes,fampaddes,"
                    . "'' as pro_SubFamProDescTec, 'N' as pro_subFamProFormataDesc,"
                    . "'N' as pro_SubFamTipoControle,'0' as pro_SubFamTipoDespesa,"
                    . "'0' as pro_SubFamTipoReceita,'' as pro_SubFamProdBase,"
                    . "'0' as pro_subFamSeqProd,'' as pro_subFamComprador,"
                    . "'N' as pro_SubFamControleLote,'' as pro_subFamMovEstoque,"
                    . "'' as pro_subFamTipoCusto "
                    . "from rex_maquinas.widl.PROD04a1 "
                    . "where grucod not in (select PRO_GrupoCodigo from PRO_GRUPOSUBGRUPOFAMILIASUBFAM)";

            $aLog = $this->executaSql($sSql);
        }
        if ($aLog[0] == true) {
            $LogNome = date('d-m-Y H-i-s');
            $meuArquivo = $sDados . $LogNome . '-PdoSuccess.txt';
            $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'steeltrater/LOGS/GrupSubGrupFamSubFam/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
            $data = $LogNome . '-> Importação de ' . $sDados . ' conclúida com sucesso';
            fwrite($gerenciaArquivo, $data);
            fclose($gerenciaArquivo);
        } else {
            $LogNome = date('d-m-Y H-i-s');
            $meuArquivo = $sDados . $LogNome . '-PdoErro.txt';
            $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'steeltrater/LOGS/GrupSubGrupFamSubFam/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
            $data = $aLog[1];
            fwrite($gerenciaArquivo, $data);
            fclose($gerenciaArquivo);
        }
    }

    public function migraProdGeral($sDados) {

        if ($sDados == 'pro_geral') {
            $sSqlLimpaProd01 = "delete prod01";
            $this->executaSql($sSqlLimpaProd01);

            $sSqlInsertProd01 = "insert into prod01 "
                    . "select * from rex_maquinas.widl.prod01 "
                    . "where grucod in (12,13)";
            $oRetornoInsert = $this->executaSql($sSqlInsertProd01);

            if ($oRetornoInsert == true) {
                $sSqlDiferencaCampos = "select procod from prod01"
                        . " where procod not in (select pro_codigo from PRO_PRODUTO) and grucod in (12,13)"
                        . " order by prodata desc";
                $result = $this->getObjetoSql($sSqlDiferencaCampos);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $sCodForm = trim($row['procod']);
                    $sSql = "insert into PRO_PRODUTO([PRO_Codigo]
                    ,[PRO_GrupoCodigo]
                    ,[PRO_Descricao]
                    ,[PRO_PesoLiquido]
                    ,[PRO_PesoBruto]
                    ,[PRO_UnidadeMedida]
                    ,[PRO_SubGrupoCodigo]
                    ,[PRO_FamiliaCodigo]
                    ,[PRO_MVA]
                    ,[PRO_Composto]
                    ,[PRO_Origem]
                    ,[PRO_SubFamiliaCodigo]
                    ,[PRO_DescricaoTecnica]
                    ,[PRO_DiasValidade]
                    ,[PRO_Volume]
                    ,[PRO_ComprimentoLiquido]
                    ,[PRO_LarguraLiquido]
                    ,[PRO_EspessuraLiquido]
                    ,[PRO_ComprimentoBruto]
                    ,[PRO_LarguraBruto]
                    ,[PRO_EspessuraBruto]
                    ,[PRO_Dimensoes]
                    ,[PRO_DimensoesUnidade]
                    ,[PRO_DimensoesConversor]
                    ,[PRO_Receituario]
                    ,[PRO_CodigoAntigo]
                    ,[PRO_CadastroUsuario]
                    ,[PRO_CadastroDataHora]
                    ,[PRO_AlteracaoUsuario]
                    ,[PRO_AlteracaoDataHora]
                    ,[PRO_Lote]
                    ,[PRO_EmbalagemRetornavel]
                    ,[PRO_Imagem]
                    ,[PRO_DimensoesUndConversor]
                    ,[PRO_Generico]
                    ,[PRO_Grade]
                    ,[PRO_Ncm]
                    ,[PRO_Sequencia]
                    ,[PRO_ImagemFileType]
                    ,[PRO_ImagemFileName]
                    ,[FIS_LC11603PrincipalCodigo]
                    ,[FIS_LC11603SecundarioCodigo]
                    ,[FIS_GeneroItemCodigo]
                    ,[PRO_TipoLigacao]
                    ,[PRO_GrupoTensao]
                    ,[PRO_PerigosoONU]
                    ,[PRO_PerigosoNome]
                    ,[PRO_PerigosoClasse]
                    ,[PRO_PerigosoEmbalagem]
                    ,[PRO_PerigosoPontoFulgor]
                    ,[FIS_CNAECodigo]
                    ,[PRO_CompostoValor]
                    ,[PRO_InventarioSequencia]
                    ,[PRO_ProdutoTipoProducao]
                    ,[PRO_ProdutoTipoCalculo]
                    ,[PRO_ProdutoVinculadoCodigo]
                    ,[PRO_Transgenico]
                    ,[PRO_TipoControle]
                    ,[PRO_TipoCusto]
                    ,[PRO_ProdutoTipoValidaCodigoBar]
                    ,[FIS_SIMPSCANCGrupoCodigo]
                    ,[FIS_SIMPSCANCProdutoCodigo]
                    ,[PRO_SIMPSCANCINPMInicial]
                    ,[PRO_SIMPSCANCINPMFinal]
                    ,[PRO_SIMPSCANCCalculoImposto]
                    ,[PRO_ClasseConsumo]
                    ,[PRO_TipoAssinante]
                    ,[PRO_TipoUtilizacao]
                    ,[PRO_ClassificacaoItem]
                    ,[PRO_Letra]
                    ,[PRO_DescricaoEstrutura]
                    ,[PRO_CoProduto]
                    ,[PRO_DimensoesGradeFormula]
                    ,[PRO_TipoValidade]
                    ,[PRO_GarantiaTempo]
                    ,[PRO_GarantiaTempoTipo]
                    ,[PRO_GarantiaTipo]
                    ,[PRO_Referencia]
                    ,[PRO_ProdutoControlado]
                    ,[FIS_AgrupamentoCodigo]
                    ,[PRO_TipoProduto]
                    ,[PRO_TipoVolume]
                    ,[PRO_LoteSequencial]
                    ,[QLD_ProdutoFrequenciaInspecao]
                    ,[QLD_ProdutoRegimeCodigo]
                    ,[QLD_ProdutoNivelCodigo]
                    ,[QLD_ProdutoSkipLoteCodigo]
                    ,[QLD_ProdutoExameCodigo]
                    ,[QLD_ProdutoNaoAtualizaAutoRegi]
                    ,[PRO_ProdutoObsoleto]
                    ,[PRO_MascaraLote]
                    ,[PRO_ImportadoEstrutura]
                    ,[PRO_TipoCalculoDecimal]
                    ,[PRO_CasasDecimais]
                    ,[PRO_ProdutoBovinos]
                    ,[PRO_ProdutoVacina]
                    ,[PRO_ProdutoVacinaCodigo]
                    ,[PRO_VolumeM3]
                    ,[GRS_AgrotoxicoClasseToxicologi]
                    ,[GRS_AgrotoxicoRegistroMinister]
                    ,[GRS_AgrotoxicoGrauRisco]
                    ,[GRS_ClasseRiscoCodigo]
                    ,[GRS_AgrotoxicoPrincipioAtivo]
                    ,[GRS_AgrotoxicoTripliceLavagem]
                    ,[GRS_AgrotoxicoINDEA]
                    ,[GRS_AgrotoxicoFabricante]
                    ,[GRS_AgrotoxicoEnderecoFabrican]
                    ,[GRS_AgrotoxicoTelefoneEmergenc]
                    ,[GRS_AgrotoxicoNumeroSOSCOTEC]
                    ,[GRS_AgrotoxicoBulaArquivo]
                    ,[GRS_AgrotoxicoBulaArquivoNome]
                    ,[GRS_AgrotoxicoBulaArquivoTipo]
                    ,[PRO_ProdutoPrioridadeComposto]
                    ,[PRO_ProdutoControlaSerie]
                    ,[PRO_ProdutoFastCommerce]
                    ,[PRO_ProdutoMedidaComprimento]
                    ,[GRS_AgrotoxicoCarencia]
                    ,[PRO_Fantasma]
                    ,[PRO_UnidadeCodigo]
                    ,[PRO_DestacaNFSe]
                    ,[CMB_ProdutoReducaoST]
                    ,[DII_ProdutoBeneficio]
                    ,[PRO_ProdutoPAtivo]
                    ,[PRO_ProdutoDescNFe]
                    ,[PRO_PerigosoNumeroRisco]
                    ,[PRO_MascaraQualidade]
                    ,[PRO_ProdutoFilialFaturamento]
                    ,[PRO_VolumePC]
                    ,[PRO_TipoColuna]
                    ,[PRO_ProdutoCEST]
                    ,[PRO_ProdutoFCIRevenda]
                    ,[FIS_ProdutoCompra]
                    ,[PRO_ProdutoDrawback]
                    ,[TMS_ProdutoPredominante]
                    ,[PRO_ProdutoPerigosoQtdMinima])
                    select procod,
                    grucod,
                    prodes,
                    propesliq,
                    propesprat,
                    pround,
                    subcod,
                    famcod,
                    '0.000000' as PRO_MVA,
                    'N'as PRO_Composto,
                    proorigem, 
                    famsub,
                    prodestec,
                    propervali,
                    provolume,
                    '0' as PRO_ComprimentoLiquido,
                    '0' as PRO_LarguraLiquido,
                    '0' as PRO_EspessuraLiquido,
                    '0' as PRO_ComprimentoBruto,
                    '0' as PRO_LarguraBruto,
                    '0' as PRO_EspessuraBruto,
                    'N' as PRO_Dimensoes,
                    '' as PRO_DimensoesUnidade,
                    '0.000000000' as PRO_DimensoesConversor,
                    'N' as PRO_Receituario,
                    proantigo,
                    prousu,
                    prodata,
                    proausu,
                    proadata,
                    'N' as PRO_Lote,
                    'N' as PRO_EmbalagemRetornavel,
                    null as PRO_Imagem,
                    '0.000000000' as PRO_DimensoesUndConversor,
                    'N' as PRO_Generico,
                    'N' as PRO_Grade,
                    rtrim(proclasfis)+'-',
                    '0' as PRO_Sequencia,
                    '' as PRO_ImagemFileType,
                    '' as PRO_ImagemFileName,
                    '0' as FIS_LC11603PrincipalCodigo,
                    '0' as FIS_LC11603SecundarioCodigo,
                    '' as FIS_GeneroItemCodigo,
                    '0' as PRO_TipoLigacao,
                    '' as PRO_GrupoTensao,
                    '' as PRO_PerigosoONU,
                    '' as PRO_PerigosoNome,
                    '' as PRO_PerigosoClasse,
                    '' as PRO_PerigosoEmbalagem,
                    '' as PRO_PerigosoPontoFulgor,
                    '' as FIS_CNAECodigo,/*CNAE*/
                    'N' as PRO_CompostoValor,
                    '0' as PRO_InventarioSequencia,
                    'P' as PRO_ProdutoTipoProducao,
                    'A' as PRO_ProdutoTipoCalculo,
                    '' as PRO_ProdutoViculadoCodigo,
                    'N' as PRO_Transgenico,
                    'E' as PRO_TipoControle,
                    'M' as PRO_TipoCusto,
                    'N' as PRO_ProdutoTipoValidaCodigoBar,
                    '0' as FIS_SIMPSCANCGrupoCodigo,
                    '0' as FIS_SIMPSCANProdutoCodigo,
                    '0.000000' as PRO_SIMPSCANCINPMInicial,
                    '0.000000' as PRO_SIMPSCANCINPMFinal,
                    'N' as PRO_SIMPSCANCCalculoImposto,
                    '0' as PRO_ClasseConsumo,
                    '0' as PRO_TipoAssinante,
                    '6' as PRO_tipoUtilizacao,
                    '' as PRO_ClassificacaoItem,
                    '' as PRO_Letra,
                    '' as PRO_DescricaoEstrutura,
                    'N' as PRO_CoProduto,
                    '' as PRO_DimensoesGradeFormula,
                    'M' as PRO_tipoValidade,
                    '0' as PRO_GarantiaTempo,
                    '0' as PRO_GarantiaTempoTipo,
                    'S' as PRO_GarantiaTipo,
                    '' as PRO_Referencia,
                    'N' as PRO_ProdutoControlado,
                    '0' as FIS_AgrupamentoCodigo,
                    '0' as PRO_TipoProduto,
                    '0' as PRO_TipoVolume,
                    '0' as PRO_LoteSequencial,
                    'N' as QLD_ProdutoFrequencialInspecao,
                    '0' as QLD_ProdutoRegimeCodigo,
                    '0' as QLD_ProdutoNivelCodigo,
                    '0' as QLD_ProdutoSkipLoteCodigo,
                    '0' as QLD_ProdutoExameCodigo,
                    'N' as QLD_ProdutoNaoAtualizaAutoRegi,
                    'N' as PRO_ProdutoObsoleto,
                    '' as PRO_MascaraLote,
                    'N' as PRO_ImportadoEstrutura,
                    'A' as PRO_TipoCalculoDecima,
                    '0' as PRO_CasasDecimais,
                    'N' as PRO_ProdutoBovinos,
                    'N' as PRO_ProdutoVacina,
                    '' as PROD_ProdutoVacinaCodigo,
                    '0.000000000' as PRO_VolumeM3,
                    '' as GRS_AgrotoxicoClasseToxicologi,
                    '0' as GRS_AgrotoxicoRegistroMinister,
                    '0' as GRS_AgrotoxicoGrauRisco,
                    '' as GRS_ClasseRiscoCodigo,
                    '' as GRS_AgrotoxicoPrincipioAtivo,
                    'N' as GRS_AgrotoxicoTripliceLavagem,
                    '' as GRS_agrotoxicoINDEA,
                    '' as GRS_AgrotoxicoFabricante,
                    '' as GRS_AgrotoxicoEnderecoFabrican,
                    '' as GRS_AgrotoxicoTelefoneEmergenc,
                    '' as GRS_AgrotocicoNumeroSOSCOTEC,
                    null as GRS_AgrotoxicoBulaArquivo,
                    '' as GRS_AgrotoxicoBulaArquivoNome,
                    '' as GRS_AgrotoxicoBulaArquivoTipo,
                    '0' as PRO_ProdutoPrioridadeComposto,
                    'N' as PRO_ProdutoControlaSeria,
                    'N' as PRO_ProdutoFastCommerce,
                    'MM' as PRO_ProdutoMedidaComprimento,
                    '' as GRS_AgrotoxicoCarencia,
                    'N' as PRO_Fantasma,
                    '0' as PRO_UnidadeCodigo,
                    'N' as PRO_DestacaNFSE,
                    'N' as CMB_ProdutoReducaoST,
                    'X' as DLL_ProdutoBeneficio,
                    '0' as PRO_ProduoPAtivo,
                    '' as PRO_ProdutoDescNfe,
                    '' as PRO_PerigosoNumeroRisco,
                    '' as PRO_MascaraQualidade,
                    '0' as PRO_ProdutoFilialFaturamento,
                    '0.000000' as PRO_VolumePC,
                    '0' as PRO_TipoColuna,
                    procest,
                    'N' as PRO_ProdutoFCIRevenda,
                    null as FIS_ProdutoCompra,
                    null as PRO_ProdutoDrawback,
                    null as TMS_ProdutoPredominante,
                    null as PRO_ProdutoPerigosQtdMinima 
                    from prod01 where procod ='" . $sCodForm . "'";


                    $aStringLog = $this->executaSql($sSql);

                    $i = mt_rand(00, 9999999999);
                    $LogNome = date('d-m-Y H-i-s') . $i;
                    if ($aStringLog[0] == true) {
                        $meuArquivo = $LogNome . '-PdoLogProd.txt';
                        $data = $LogNome . '-> Migração do item ' . $sCodForm . ' conclúida com sucesso';
                    } else {
                        $meuArquivo = $LogNome . '-PdoLogERRO.txt';
                        $data = $aStringLog[1];
                    }
                    $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'steeltrater/LOGS/ProdFilialProd/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
                    fwrite($gerenciaArquivo, $data);
                    fclose($gerenciaArquivo);
                }
            }
        }


        if ($sDados == 'pro_filial') {
            $aCNPJ = array(
                0 => '5572480000189',
                1 => '8993358000174',
                2 => '10540966000175',
                3 => '75483040000130',
                4 => '75483040000211',
                5 => '83781641000158'
            );
            $sSqlLimpaProd01 = "delete prod01";
            $this->executaSql($sSqlLimpaProd01);

            $sSqlInsertProd01 = "insert into prod01 "
                    . "select * from rex_maquinas.widl.prod01 "
                    . "where grucod in (12,13)";
            $oRetornoInsert = $this->executaSql($sSqlInsertProd01);

            if ($oRetornoInsert == true) {
                $sSqlDiferencaCampos = "select * from prod01"
                        . " where procod not in (select pro_codigo from pro_produtofilial) and grucod in (12,13)"
                        . " order by prodata desc";
                $result = $this->getObjetoSql($sSqlDiferencaCampos);
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    $sCodForm = trim($row['procod']);
                    foreach ($aCNPJ as $keyemp => $empcod) {
                        $sSql = "insert into pro_produtofilial
                        select '" . $empcod . "' as FIL_Codigo,
                        procod as PRO_Codigo,
                        '1' as PRO_FilialPrioridade,
                        case when probloqpro ='S' then CONVERT(varchar,CONVERT (date, SYSDATETIME()),103) else '1753-01-01 00:00:00.000' end as PRO_FilialDtBloqueado,
                        promovEst as PRO_FilialEstoque,
                        estqtdmini as PRO_FilialEstMinimo,
                        '0' as PRO_FilialEstMinimoDias, 
                        '0.000000' as PRO_FilialEstMaximo,
                        '0' as PRO_FilialEstMaximoDias,
                        '2009-09-04 00:00:00.000' as PRO_FilialDtInventarioRota,
                        '' as PRO_FilialMRPPlanejamento,
                        'A' as PRO_FilialMRPTipoOrdem,
                        '0' as PRO_filialMRPDiasCompra,
                        '0' as PRO_FilialMRPDiasProducao,
                        '0' as PRO_FilialMRPDiasQualidade,
                        '0' as PRO_FilialMRPDiasFornecedor,
                        'Q' as PRO_FilialEstMinimoTipo,
                        '0' as PRO_FilialEstMinimoPeriodo,
                        '0.000000' as PRO_FilialMRPLoteMinimoQtd,
                        '0.000000' as PRO_FilialMRPLoteMultiploQtd,
                        '0' as PRO_FilialMRPDiasAgrupamento,
                        '' as PRO_FilialComprador,
                        '0.000000' as PRO_FilialLoteProducaoQtd,
                        '0.000000' as PRO_FilialCompraPercDifValor,
                        '0.000000' as PRO_FilialCompraPercDifQtd,
                        '2009-09-04 00:00:00.000' as PRO_FilialInvRotativoData,
                        '' as PRO_FilialCodigoFINAME,
                        '' as PRO_FilialDescricaoFINAME,
                        '0' as PRO_FilialReferenciaSerieFilial,
                        '0' as PRO_FilialReferenciaSerie,
                        'N' as PRO_FilialItemComposto,
                        'Q' as PRO_FilialControlaSaldo,
                        'N' as PRO_FilialReservaEstoqueEstrut,
                        'P' as PRO_FilialMRPAcao,
                        '0.000000' as PRO_FilialQuantidadeMultPadrao,
                        '' as PRO_FilialEspeciePadrao,
                        '0.000000' as PRO_FilialEspecieCapacidade,
                        '0.000000' as PRO_FilialQtdProdutividade,
                        '0.000000' as PRO_FilialPerCustoProduto,
                        'N' as PRO_FilialVeiculo,
                        'S' as PRO_FilialConsQtdeProdCoProdut,
                        probloqmot as PRO_FilialMotivoBloqueio,
                        NULL as CMB_ProdutoCustoValor,
                        '0.000000' as PRO_FilialEstPontoRep,
                        '0' as PRO_FilialMRPFilial,
                        '04' as PRO_ProdutoFilialGrupoTipo,
                        'N' as PRO_FilialNegativo
                        from prod01 where procod ='" . $sCodForm . "' ";

                        $aStringLog = $this->executaSql($sSql);

                        $i = mt_rand(00, 9999999999);
                        $LogNome = date('d-m-Y H-i-s' . $i);
                        if ($aStringLog[0] == true) {
                            $meuArquivo = $LogNome . '-PdoLogProdFilial.txt';
                            $data = $LogNome . '-> Migração do item ' . $sCodForm . ' para CNPJ ' . $empcod . ' conclúida com sucesso';
                        } else {
                            $meuArquivo = $LogNome . '-PdoLogERRO.txt';
                            $data = $aStringLog[1];
                        }
                        $gerenciaArquivo = fopen($_SERVER['DOCUMENT_ROOT'] . 'GitHub/steeltrater/LOGS/ProdFilialProd/' . $meuArquivo, 'w') or die('Cannot open file:  ' . $meuArquivo);
                        fwrite($gerenciaArquivo, $data);
                        fclose($gerenciaArquivo);
                    }
                }
            }
        }
    }

}
