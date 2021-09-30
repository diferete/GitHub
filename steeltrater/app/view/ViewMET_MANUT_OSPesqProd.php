<?php 
 /*
 * Implementa a classe view MET_MANUT_OSPesqProd
 * @author Cleverton Hoffmann
 * @since 27/09/2021
 */
 
class ViewMET_MANUT_OSPesqProd extends View {
 
    public function __construct() {
        parent::__construct();
       }
 
     public function criaConsulta() {
        parent::criaConsulta();


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(false);
        $this->getTela()->setBMostraFiltro(true);

        //$this->getTela()->setiAltura(400);
        $this->getTela()->setILarguraGrid(2300);
        $this->getTela()->setBGridResponsivo(false);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oCodigo = new CampoConsulta('Código', 'pro_codigo');
        $oDescricao = new CampoConsulta('Descrição', 'pro_descricao');

        $oGrupoCod = new CampoConsulta('Grupo', 'pro_grupocodigo');

        $oGrupoDes = new CampoConsulta('Descrição', 'DELX_PRO_Grupo.pro_grupodescricao');

        $oSubGrupoCod = new CampoConsulta('SubGrupo', 'DELX_PRO_Subgrupo.pro_subgrupocodigo');

        $oSubGrupoDes = new CampoConsulta('Descrição', 'DELX_PRO_Subgrupo.pro_subgrupodescricao');

        $oFamiliaCod = new CampoConsulta('Família', 'DELX_PRO_Familia.pro_familiacodigo');

        $oFamiliaDes = new CampoConsulta('Descrição', 'DELX_PRO_Familia.pro_familiadescricao');

        $oSubFamiliaCod = new CampoConsulta('SubFamília', 'DELX_PRO_Subfamilia.pro_subfamiliacodigo');

        $oSubFamiliaDes = new CampoConsulta('Descrição', 'DELX_PRO_Subfamilia.pro_subfamiliadescricao');

        $oUnidadeMedCod = new CampoConsulta('Un.Medida', 'pro_unidademedida');

        $oPesoLiq = new CampoConsulta('Peso líquido', 'pro_pesoliquido', CampoConsulta::TIPO_DECIMAL);

        $oPesoBruto = new CampoConsulta('Peso bruto', 'pro_pesobruto', CampoConsulta::TIPO_DECIMAL);


        $oCodigofiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12);
        $oDescricaofiltro = new Filtro($oDescricao, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, true);

        $oFilGrupo = new Filtro($oGrupoCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilGrupo->setSClasseBusca('DELX_PRO_Grupo');
        $oFilGrupo->setSCampoRetorno('pro_grupocodigo', $this->getTela()->getSId());
        $oFilGrupo->setSIdTela($this->getTela()->getSId());

        $oFilSubGrupo = new Filtro($oSubGrupoCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilSubGrupo->setSClasseBusca('DELX_PRO_Subgrupo');
        $oFilSubGrupo->setSCampoRetorno('pro_subgrupocodigo', $this->getTela()->getSId());
        $oFilSubGrupo->setSIdTela($this->getTela()->getSId());
        $oFilSubGrupo->setSParamBuscaPk($oFilGrupo->getId());

        $oFilFamilia = new Filtro($oFamiliaCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilFamilia->setSClasseBusca('DELX_PRO_Familia');
        $oFilFamilia->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getSId());
        $oFilFamilia->setSIdTela($this->getTela()->getSId());
        $oFilFamilia->setSParamBuscaPk($oFilGrupo->getId() . ',' . $oFilSubGrupo->getId());

        $oFilSubFamilia = new Filtro($oSubFamiliaCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilSubFamilia->setSClasseBusca('DELX_PRO_Subfamilia');
        $oFilSubFamilia->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getSId());
        $oFilSubFamilia->setSIdTela($this->getTela()->getSId());
        $oFilSubFamilia->setSParamBuscaPk($oFilGrupo->getId() . ',' . $oFilSubGrupo->getId() . ',' . $oFilFamilia->getId());

        $this->addFiltro($oCodigofiltro, $oDescricaofiltro, $oFilGrupo, $oFilSubGrupo, $oFilFamilia, $oFilSubFamilia);
        $this->addCampos($oCodigo, $oDescricao, $oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes, $oFamiliaCod, $oFamiliaDes, $oSubFamiliaCod, $oSubFamiliaDes, $oUnidadeMedCod, $oPesoLiq, $oPesoBruto
        );
    }
 
//    public function criaTela() { 
//        parent::criaTela();
// 
//
//        $oPRO_Codigo = new Campo('PRO_Codigo', 'PRO_Codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_GrupoCodigo = new Campo('PRO_GrupoCodigo', 'PRO_GrupoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Descricao = new Campo('PRO_Descricao', 'PRO_Descricao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PesoLiquido = new Campo('PRO_PesoLiquido', 'PRO_PesoLiquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_PesoBruto = new Campo('PRO_PesoBruto', 'PRO_PesoBruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_UnidadeMedida = new Campo('PRO_UnidadeMedida', 'PRO_UnidadeMedida', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_SubGrupoCodigo = new Campo('PRO_SubGrupoCodigo', 'PRO_SubGrupoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_FamiliaCodigo = new Campo('PRO_FamiliaCodigo', 'PRO_FamiliaCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_MVA = new Campo('PRO_MVA', 'PRO_MVA', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_Composto = new Campo('PRO_Composto', 'PRO_Composto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Origem = new Campo('PRO_Origem', 'PRO_Origem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_SubFamiliaCodigo = new Campo('PRO_SubFamiliaCodigo', 'PRO_SubFamiliaCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DescricaoTecnica = new Campo('PRO_DescricaoTecnica', 'PRO_DescricaoTecnica', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DiasValidade = new Campo('PRO_DiasValidade', 'PRO_DiasValidade', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_Volume = new Campo('PRO_Volume', 'PRO_Volume', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ComprimentoLiquido = new Campo('PRO_ComprimentoLiquido', 'PRO_ComprimentoLiquido', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_LarguraLiquido = new Campo('PRO_LarguraLiquido', 'PRO_LarguraLiquido', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_EspessuraLiquido = new Campo('PRO_EspessuraLiquido', 'PRO_EspessuraLiquido', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_ComprimentoBruto = new Campo('PRO_ComprimentoBruto', 'PRO_ComprimentoBruto', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_LarguraBruto = new Campo('PRO_LarguraBruto', 'PRO_LarguraBruto', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_EspessuraBruto = new Campo('PRO_EspessuraBruto', 'PRO_EspessuraBruto', Campo::TIPO_MONEY, 1, 1, 12, 12);
//        $oPRO_Dimensoes = new Campo('PRO_Dimensoes', 'PRO_Dimensoes', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DimensoesUnidade = new Campo('PRO_DimensoesUnidade', 'PRO_DimensoesUnidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DimensoesConversor = new Campo('PRO_DimensoesConversor', 'PRO_DimensoesConversor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_Receituario = new Campo('PRO_Receituario', 'PRO_Receituario', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CodigoAntigo = new Campo('PRO_CodigoAntigo', 'PRO_CodigoAntigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CadastroUsuario = new Campo('PRO_CadastroUsuario', 'PRO_CadastroUsuario', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CadastroDataHora = new Campo('PRO_CadastroDataHora', 'PRO_CadastroDataHora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_AlteracaoUsuario = new Campo('PRO_AlteracaoUsuario', 'PRO_AlteracaoUsuario', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_AlteracaoDataHora = new Campo('PRO_AlteracaoDataHora', 'PRO_AlteracaoDataHora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Lote = new Campo('PRO_Lote', 'PRO_Lote', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_EmbalagemRetornavel = new Campo('PRO_EmbalagemRetornavel', 'PRO_EmbalagemRetornavel', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Imagem = new Campo('PRO_Imagem', 'PRO_Imagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DimensoesUndConversor = new Campo('PRO_DimensoesUndConversor', 'PRO_DimensoesUndConversor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_Generico = new Campo('PRO_Generico', 'PRO_Generico', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Grade = new Campo('PRO_Grade', 'PRO_Grade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Ncm = new Campo('PRO_Ncm', 'PRO_Ncm', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Sequencia = new Campo('PRO_Sequencia', 'PRO_Sequencia', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ImagemFileType = new Campo('PRO_ImagemFileType', 'PRO_ImagemFileType', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ImagemFileName = new Campo('PRO_ImagemFileName', 'PRO_ImagemFileName', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_LC11603PrincipalCodigo = new Campo('FIS_LC11603PrincipalCodigo', 'FIS_LC11603PrincipalCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_LC11603SecundarioCodigo = new Campo('FIS_LC11603SecundarioCodigo', 'FIS_LC11603SecundarioCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_GeneroItemCodigo = new Campo('FIS_GeneroItemCodigo', 'FIS_GeneroItemCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoLigacao = new Campo('PRO_TipoLigacao', 'PRO_TipoLigacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_GrupoTensao = new Campo('PRO_GrupoTensao', 'PRO_GrupoTensao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoONU = new Campo('PRO_PerigosoONU', 'PRO_PerigosoONU', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoNome = new Campo('PRO_PerigosoNome', 'PRO_PerigosoNome', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoClasse = new Campo('PRO_PerigosoClasse', 'PRO_PerigosoClasse', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoEmbalagem = new Campo('PRO_PerigosoEmbalagem', 'PRO_PerigosoEmbalagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoPontoFulgor = new Campo('PRO_PerigosoPontoFulgor', 'PRO_PerigosoPontoFulgor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_CNAECodigo = new Campo('FIS_CNAECodigo', 'FIS_CNAECodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CompostoValor = new Campo('PRO_CompostoValor', 'PRO_CompostoValor', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_InventarioSequencia = new Campo('PRO_InventarioSequencia', 'PRO_InventarioSequencia', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ProdutoTipoProducao = new Campo('PRO_ProdutoTipoProducao', 'PRO_ProdutoTipoProducao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoTipoCalculo = new Campo('PRO_ProdutoTipoCalculo', 'PRO_ProdutoTipoCalculo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoVinculadoCodigo = new Campo('PRO_ProdutoVinculadoCodigo', 'PRO_ProdutoVinculadoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Transgenico = new Campo('PRO_Transgenico', 'PRO_Transgenico', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoControle = new Campo('PRO_TipoControle', 'PRO_TipoControle', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoCusto = new Campo('PRO_TipoCusto', 'PRO_TipoCusto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoTipoValidaCodigoBar = new Campo('PRO_ProdutoTipoValidaCodigoBar', 'PRO_ProdutoTipoValidaCodigoBar', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_SIMPSCANCGrupoCodigo = new Campo('FIS_SIMPSCANCGrupoCodigo', 'FIS_SIMPSCANCGrupoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_SIMPSCANCProdutoCodigo = new Campo('FIS_SIMPSCANCProdutoCodigo', 'FIS_SIMPSCANCProdutoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_SIMPSCANCINPMInicial = new Campo('PRO_SIMPSCANCINPMInicial', 'PRO_SIMPSCANCINPMInicial', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_SIMPSCANCINPMFinal = new Campo('PRO_SIMPSCANCINPMFinal', 'PRO_SIMPSCANCINPMFinal', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_SIMPSCANCCalculoImposto = new Campo('PRO_SIMPSCANCCalculoImposto', 'PRO_SIMPSCANCCalculoImposto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ClasseConsumo = new Campo('PRO_ClasseConsumo', 'PRO_ClasseConsumo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoAssinante = new Campo('PRO_TipoAssinante', 'PRO_TipoAssinante', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoUtilizacao = new Campo('PRO_TipoUtilizacao', 'PRO_TipoUtilizacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ClassificacaoItem = new Campo('PRO_ClassificacaoItem', 'PRO_ClassificacaoItem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Letra = new Campo('PRO_Letra', 'PRO_Letra', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DescricaoEstrutura = new Campo('PRO_DescricaoEstrutura', 'PRO_DescricaoEstrutura', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CoProduto = new Campo('PRO_CoProduto', 'PRO_CoProduto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DimensoesGradeFormula = new Campo('PRO_DimensoesGradeFormula', 'PRO_DimensoesGradeFormula', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoValidade = new Campo('PRO_TipoValidade', 'PRO_TipoValidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_GarantiaTempo = new Campo('PRO_GarantiaTempo', 'PRO_GarantiaTempo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_GarantiaTempoTipo = new Campo('PRO_GarantiaTempoTipo', 'PRO_GarantiaTempoTipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_GarantiaTipo = new Campo('PRO_GarantiaTipo', 'PRO_GarantiaTipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Referencia = new Campo('PRO_Referencia', 'PRO_Referencia', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoControlado = new Campo('PRO_ProdutoControlado', 'PRO_ProdutoControlado', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_AgrupamentoCodigo = new Campo('FIS_AgrupamentoCodigo', 'FIS_AgrupamentoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoProduto = new Campo('PRO_TipoProduto', 'PRO_TipoProduto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoVolume = new Campo('PRO_TipoVolume', 'PRO_TipoVolume', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LoteSequencial = new Campo('PRO_LoteSequencial', 'PRO_LoteSequencial', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oQLD_ProdutoFrequenciaInspecao = new Campo('QLD_ProdutoFrequenciaInspecao', 'QLD_ProdutoFrequenciaInspecao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oQLD_ProdutoRegimeCodigo = new Campo('QLD_ProdutoRegimeCodigo', 'QLD_ProdutoRegimeCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oQLD_ProdutoNivelCodigo = new Campo('QLD_ProdutoNivelCodigo', 'QLD_ProdutoNivelCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oQLD_ProdutoSkipLoteCodigo = new Campo('QLD_ProdutoSkipLoteCodigo', 'QLD_ProdutoSkipLoteCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oQLD_ProdutoExameCodigo = new Campo('QLD_ProdutoExameCodigo', 'QLD_ProdutoExameCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oQLD_ProdutoNaoAtualizaAutoRegi = new Campo('QLD_ProdutoNaoAtualizaAutoRegi', 'QLD_ProdutoNaoAtualizaAutoRegi', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoObsoleto = new Campo('PRO_ProdutoObsoleto', 'PRO_ProdutoObsoleto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_MascaraLote = new Campo('PRO_MascaraLote', 'PRO_MascaraLote', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ImportadoEstrutura = new Campo('PRO_ImportadoEstrutura', 'PRO_ImportadoEstrutura', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_TipoCalculoDecimal = new Campo('PRO_TipoCalculoDecimal', 'PRO_TipoCalculoDecimal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_CasasDecimais = new Campo('PRO_CasasDecimais', 'PRO_CasasDecimais', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoBovinos = new Campo('PRO_ProdutoBovinos', 'PRO_ProdutoBovinos', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoVacina = new Campo('PRO_ProdutoVacina', 'PRO_ProdutoVacina', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoVacinaCodigo = new Campo('PRO_ProdutoVacinaCodigo', 'PRO_ProdutoVacinaCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_VolumeM3 = new Campo('PRO_VolumeM3', 'PRO_VolumeM3', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoClasseToxicologi = new Campo('GRS_AgrotoxicoClasseToxicologi', 'GRS_AgrotoxicoClasseToxicologi', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoRegistroMinister = new Campo('GRS_AgrotoxicoRegistroMinister', 'GRS_AgrotoxicoRegistroMinister', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoGrauRisco = new Campo('GRS_AgrotoxicoGrauRisco', 'GRS_AgrotoxicoGrauRisco', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_ClasseRiscoCodigo = new Campo('GRS_ClasseRiscoCodigo', 'GRS_ClasseRiscoCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoPrincipioAtivo = new Campo('GRS_AgrotoxicoPrincipioAtivo', 'GRS_AgrotoxicoPrincipioAtivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoTripliceLavagem = new Campo('GRS_AgrotoxicoTripliceLavagem', 'GRS_AgrotoxicoTripliceLavagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoINDEA = new Campo('GRS_AgrotoxicoINDEA', 'GRS_AgrotoxicoINDEA', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoFabricante = new Campo('GRS_AgrotoxicoFabricante', 'GRS_AgrotoxicoFabricante', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoEnderecoFabrican = new Campo('GRS_AgrotoxicoEnderecoFabrican', 'GRS_AgrotoxicoEnderecoFabrican', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoTelefoneEmergenc = new Campo('GRS_AgrotoxicoTelefoneEmergenc', 'GRS_AgrotoxicoTelefoneEmergenc', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoNumeroSOSCOTEC = new Campo('GRS_AgrotoxicoNumeroSOSCOTEC', 'GRS_AgrotoxicoNumeroSOSCOTEC', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoBulaArquivo = new Campo('GRS_AgrotoxicoBulaArquivo', 'GRS_AgrotoxicoBulaArquivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoBulaArquivoNome = new Campo('GRS_AgrotoxicoBulaArquivoNome', 'GRS_AgrotoxicoBulaArquivoNome', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoBulaArquivoTipo = new Campo('GRS_AgrotoxicoBulaArquivoTipo', 'GRS_AgrotoxicoBulaArquivoTipo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoPrioridadeComposto = new Campo('PRO_ProdutoPrioridadeComposto', 'PRO_ProdutoPrioridadeComposto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoControlaSerie = new Campo('PRO_ProdutoControlaSerie', 'PRO_ProdutoControlaSerie', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoFastCommerce = new Campo('PRO_ProdutoFastCommerce', 'PRO_ProdutoFastCommerce', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoMedidaComprimento = new Campo('PRO_ProdutoMedidaComprimento', 'PRO_ProdutoMedidaComprimento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oGRS_AgrotoxicoCarencia = new Campo('GRS_AgrotoxicoCarencia', 'GRS_AgrotoxicoCarencia', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Fantasma = new Campo('PRO_Fantasma', 'PRO_Fantasma', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_UnidadeCodigo = new Campo('PRO_UnidadeCodigo', 'PRO_UnidadeCodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DestacaNFSe = new Campo('PRO_DestacaNFSe', 'PRO_DestacaNFSe', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oCMB_ProdutoReducaoST = new Campo('CMB_ProdutoReducaoST', 'CMB_ProdutoReducaoST', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oDII_ProdutoBeneficio = new Campo('DII_ProdutoBeneficio', 'DII_ProdutoBeneficio', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoPAtivo = new Campo('PRO_ProdutoPAtivo', 'PRO_ProdutoPAtivo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoDescNFe = new Campo('PRO_ProdutoDescNFe', 'PRO_ProdutoDescNFe', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PerigosoNumeroRisco = new Campo('PRO_PerigosoNumeroRisco', 'PRO_PerigosoNumeroRisco', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_MascaraQualidade = new Campo('PRO_MascaraQualidade', 'PRO_MascaraQualidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoFilialFaturamento = new Campo('PRO_ProdutoFilialFaturamento', 'PRO_ProdutoFilialFaturamento', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_VolumePC = new Campo('PRO_VolumePC', 'PRO_VolumePC', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_TipoColuna = new Campo('PRO_TipoColuna', 'PRO_TipoColuna', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ProdutoCEST = new Campo('PRO_ProdutoCEST', 'PRO_ProdutoCEST', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoFCIRevenda = new Campo('PRO_ProdutoFCIRevenda', 'PRO_ProdutoFCIRevenda', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_ProdutoCompra = new Campo('FIS_ProdutoCompra', 'FIS_ProdutoCompra', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoDrawback = new Campo('PRO_ProdutoDrawback', 'PRO_ProdutoDrawback', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oTMS_ProdutoPredominante = new Campo('TMS_ProdutoPredominante', 'TMS_ProdutoPredominante', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoPerigosoQtdMinima = new Campo('PRO_ProdutoPerigosoQtdMinima', 'PRO_ProdutoPerigosoQtdMinima', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ProdutoCNPJFab = new Campo('PRO_ProdutoCNPJFab', 'PRO_ProdutoCNPJFab', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_ProdutoIndEscala = new Campo('PRO_ProdutoIndEscala', 'PRO_ProdutoIndEscala', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_PrincipioAtivoSeq = new Campo('PRO_PrincipioAtivoSeq', 'PRO_PrincipioAtivoSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oNFS_LinhaProdutosSeq = new Campo('NFS_LinhaProdutosSeq', 'NFS_LinhaProdutosSeq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoVendaComEstoque = new Campo('PRO_ProdutoVendaComEstoque', 'PRO_ProdutoVendaComEstoque', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ObservacaoCliente = new Campo('PRO_ObservacaoCliente', 'PRO_ObservacaoCliente', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_Lavagem = new Campo('PRO_Lavagem', 'PRO_Lavagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LetraLavagem = new Campo('PRO_LetraLavagem', 'PRO_LetraLavagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LetraUsoCloro = new Campo('PRO_LetraUsoCloro', 'PRO_LetraUsoCloro', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LetraSecagem = new Campo('PRO_LetraSecagem', 'PRO_LetraSecagem', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LetraPassadoria = new Campo('PRO_LetraPassadoria', 'PRO_LetraPassadoria', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_LetraLavagemSeco = new Campo('PRO_LetraLavagemSeco', 'PRO_LetraLavagemSeco', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_RapportVertical = new Campo('PRO_RapportVertical', 'PRO_RapportVertical', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_RapportHorizontal = new Campo('PRO_RapportHorizontal', 'PRO_RapportHorizontal', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_ProdutoNCMICMSIPI = new Campo('FIS_ProdutoNCMICMSIPI', 'FIS_ProdutoNCMICMSIPI', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oESP_MeusPedidosPROID = new Campo('ESP_MeusPedidosPROID', 'ESP_MeusPedidosPROID', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oFIS_ProdutoGeraRegH020 = new Campo('FIS_ProdutoGeraRegH020', 'FIS_ProdutoGeraRegH020', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoPoliticaProd = new Campo('PRO_ProdutoPoliticaProd', 'PRO_ProdutoPoliticaProd', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoMaterialConcreto = new Campo('PRO_ProdutoMaterialConcreto', 'PRO_ProdutoMaterialConcreto', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oFIS_ProdutoAliquotaEfetiva = new Campo('FIS_ProdutoAliquotaEfetiva', 'FIS_ProdutoAliquotaEfetiva', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oFIS_ProdutoICMSEfetivo = new Campo('FIS_ProdutoICMSEfetivo', 'FIS_ProdutoICMSEfetivo', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oFIS_ProdutoBCICMSEfetivo = new Campo('FIS_ProdutoBCICMSEfetivo', 'FIS_ProdutoBCICMSEfetivo', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oFIS_ProdutoMVAValor = new Campo('FIS_ProdutoMVAValor', 'FIS_ProdutoMVAValor', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_DescricaoLonga = new Campo('PRO_DescricaoLonga', 'PRO_DescricaoLonga', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoKit = new Campo('PRO_ProdutoKit', 'PRO_ProdutoKit', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoExportaBalanca = new Campo('PRO_ProdutoExportaBalanca', 'PRO_ProdutoExportaBalanca', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoVolArrendar = new Campo('PRO_ProdutoVolArrendar', 'PRO_ProdutoVolArrendar', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMPercICMSNC = new Campo('PRO_DZMPercICMSNC', 'PRO_DZMPercICMSNC', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_DZMICMSCSTNC = new Campo('PRO_DZMICMSCSTNC', 'PRO_DZMICMSCSTNC', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMCFOPNC = new Campo('PRO_DZMCFOPNC', 'PRO_DZMCFOPNC', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMICMSCRegraIsento = new Campo('PRO_DZMICMSCRegraIsento', 'PRO_DZMICMSCRegraIsento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMICMSCSTIsento = new Campo('PRO_DZMICMSCSTIsento', 'PRO_DZMICMSCSTIsento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMCFOPIsento = new Campo('PRO_DZMCFOPIsento', 'PRO_DZMCFOPIsento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMICMSCRegraNC = new Campo('PRO_DZMICMSCRegraNC', 'PRO_DZMICMSCRegraNC', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMICMSCRegraContribuinte = new Campo('PRO_DZMICMSCRegraContribuinte', 'PRO_DZMICMSCRegraContribuinte', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMPercICMSContribuinte = new Campo('PRO_DZMPercICMSContribuinte', 'PRO_DZMPercICMSContribuinte', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
//        $oPRO_DZMICMSCSTContribuinte = new Campo('PRO_DZMICMSCSTContribuinte', 'PRO_DZMICMSCSTContribuinte', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_DZMCFOPContribuinte = new Campo('PRO_DZMCFOPContribuinte', 'PRO_DZMCFOPContribuinte', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oProdutoTipoValidaCodigoBarras = new Campo('ProdutoTipoValidaCodigoBarras', 'ProdutoTipoValidaCodigoBarras', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoKitOrcamento = new Campo('PRO_ProdutoKitOrcamento', 'PRO_ProdutoKitOrcamento', Campo::TIPO_TEXTO, 1, 1, 12, 12);
//        $oPRO_ProdutoMoedaPadrao = new Campo('PRO_ProdutoMoedaPadrao', 'PRO_ProdutoMoedaPadrao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
// 
//        $this->addCampos($oPRO_Codigo, $oPRO_GrupoCodigo, $oPRO_Descricao, $oPRO_PesoLiquido, $oPRO_PesoBruto, $oPRO_UnidadeMedida, $oPRO_SubGrupoCodigo, $oPRO_FamiliaCodigo, $oPRO_MVA, $oPRO_Composto, $oPRO_Origem, $oPRO_SubFamiliaCodigo, $oPRO_DescricaoTecnica, $oPRO_DiasValidade, $oPRO_Volume, $oPRO_ComprimentoLiquido, $oPRO_LarguraLiquido, $oPRO_EspessuraLiquido, $oPRO_ComprimentoBruto, $oPRO_LarguraBruto, $oPRO_EspessuraBruto, $oPRO_Dimensoes, $oPRO_DimensoesUnidade, $oPRO_DimensoesConversor, $oPRO_Receituario, $oPRO_CodigoAntigo, $oPRO_CadastroUsuario, $oPRO_CadastroDataHora, $oPRO_AlteracaoUsuario, $oPRO_AlteracaoDataHora, $oPRO_Lote, $oPRO_EmbalagemRetornavel, $oPRO_Imagem, $oPRO_DimensoesUndConversor, $oPRO_Generico, $oPRO_Grade, $oPRO_Ncm, $oPRO_Sequencia, $oPRO_ImagemFileType, $oPRO_ImagemFileName, $oFIS_LC11603PrincipalCodigo, $oFIS_LC11603SecundarioCodigo, $oFIS_GeneroItemCodigo, $oPRO_TipoLigacao, $oPRO_GrupoTensao, $oPRO_PerigosoONU, $oPRO_PerigosoNome, $oPRO_PerigosoClasse, $oPRO_PerigosoEmbalagem, $oPRO_PerigosoPontoFulgor, $oFIS_CNAECodigo, $oPRO_CompostoValor, $oPRO_InventarioSequencia, $oPRO_ProdutoTipoProducao, $oPRO_ProdutoTipoCalculo, $oPRO_ProdutoVinculadoCodigo, $oPRO_Transgenico, $oPRO_TipoControle, $oPRO_TipoCusto, $oPRO_ProdutoTipoValidaCodigoBar, $oFIS_SIMPSCANCGrupoCodigo, $oFIS_SIMPSCANCProdutoCodigo, $oPRO_SIMPSCANCINPMInicial, $oPRO_SIMPSCANCINPMFinal, $oPRO_SIMPSCANCCalculoImposto, $oPRO_ClasseConsumo, $oPRO_TipoAssinante, $oPRO_TipoUtilizacao, $oPRO_ClassificacaoItem, $oPRO_Letra, $oPRO_DescricaoEstrutura, $oPRO_CoProduto, $oPRO_DimensoesGradeFormula, $oPRO_TipoValidade, $oPRO_GarantiaTempo, $oPRO_GarantiaTempoTipo, $oPRO_GarantiaTipo, $oPRO_Referencia, $oPRO_ProdutoControlado, $oFIS_AgrupamentoCodigo, $oPRO_TipoProduto, $oPRO_TipoVolume, $oPRO_LoteSequencial, $oQLD_ProdutoFrequenciaInspecao, $oQLD_ProdutoRegimeCodigo, $oQLD_ProdutoNivelCodigo, $oQLD_ProdutoSkipLoteCodigo, $oQLD_ProdutoExameCodigo, $oQLD_ProdutoNaoAtualizaAutoRegi, $oPRO_ProdutoObsoleto, $oPRO_MascaraLote, $oPRO_ImportadoEstrutura, $oPRO_TipoCalculoDecimal, $oPRO_CasasDecimais, $oPRO_ProdutoBovinos, $oPRO_ProdutoVacina, $oPRO_ProdutoVacinaCodigo, $oPRO_VolumeM3, $oGRS_AgrotoxicoClasseToxicologi, $oGRS_AgrotoxicoRegistroMinister, $oGRS_AgrotoxicoGrauRisco, $oGRS_ClasseRiscoCodigo, $oGRS_AgrotoxicoPrincipioAtivo, $oGRS_AgrotoxicoTripliceLavagem, $oGRS_AgrotoxicoINDEA, $oGRS_AgrotoxicoFabricante, $oGRS_AgrotoxicoEnderecoFabrican, $oGRS_AgrotoxicoTelefoneEmergenc, $oGRS_AgrotoxicoNumeroSOSCOTEC, $oGRS_AgrotoxicoBulaArquivo, $oGRS_AgrotoxicoBulaArquivoNome, $oGRS_AgrotoxicoBulaArquivoTipo, $oPRO_ProdutoPrioridadeComposto, $oPRO_ProdutoControlaSerie, $oPRO_ProdutoFastCommerce, $oPRO_ProdutoMedidaComprimento, $oGRS_AgrotoxicoCarencia, $oPRO_Fantasma, $oPRO_UnidadeCodigo, $oPRO_DestacaNFSe, $oCMB_ProdutoReducaoST, $oDII_ProdutoBeneficio, $oPRO_ProdutoPAtivo, $oPRO_ProdutoDescNFe, $oPRO_PerigosoNumeroRisco, $oPRO_MascaraQualidade, $oPRO_ProdutoFilialFaturamento, $oPRO_VolumePC, $oPRO_TipoColuna, $oPRO_ProdutoCEST, $oPRO_ProdutoFCIRevenda, $oFIS_ProdutoCompra, $oPRO_ProdutoDrawback, $oTMS_ProdutoPredominante, $oPRO_ProdutoPerigosoQtdMinima, $oPRO_ProdutoCNPJFab, $oPRO_ProdutoIndEscala, $oPRO_PrincipioAtivoSeq, $oNFS_LinhaProdutosSeq, $oPRO_ProdutoVendaComEstoque, $oPRO_ObservacaoCliente, $oPRO_Lavagem, $oPRO_LetraLavagem, $oPRO_LetraUsoCloro, $oPRO_LetraSecagem, $oPRO_LetraPassadoria, $oPRO_LetraLavagemSeco, $oPRO_RapportVertical, $oPRO_RapportHorizontal, $oFIS_ProdutoNCMICMSIPI, $oESP_MeusPedidosPROID, $oFIS_ProdutoGeraRegH020, $oPRO_ProdutoPoliticaProd, $oPRO_ProdutoMaterialConcreto, $oFIS_ProdutoAliquotaEfetiva, $oFIS_ProdutoICMSEfetivo, $oFIS_ProdutoBCICMSEfetivo, $oFIS_ProdutoMVAValor, $oPRO_DescricaoLonga, $oPRO_ProdutoKit, $oPRO_ProdutoExportaBalanca, $oPRO_ProdutoVolArrendar, $oPRO_DZMPercICMSNC, $oPRO_DZMICMSCSTNC, $oPRO_DZMCFOPNC, $oPRO_DZMICMSCRegraIsento, $oPRO_DZMICMSCSTIsento, $oPRO_DZMCFOPIsento, $oPRO_DZMICMSCRegraNC, $oPRO_DZMICMSCRegraContribuinte, $oPRO_DZMPercICMSContribuinte, $oPRO_DZMICMSCSTContribuinte, $oPRO_DZMCFOPContribuinte, $oProdutoTipoValidaCodigoBarras, $oPRO_ProdutoKitOrcamento, $oPRO_ProdutoMoedaPadrao);
//    } 
}