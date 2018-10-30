<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ViewDELX_PRO_Produtos extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

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

        $oFilFamilia = new Filtro($oFamiliaCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilFamilia->setSClasseBusca('DELX_PRO_Familia');
        $oFilFamilia->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getSId());
        $oFilFamilia->setSIdTela($this->getTela()->getSId());

        $oFilSubFamilia = new Filtro($oSubFamiliaCod, Filtro::CAMPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oFilSubFamilia->setSClasseBusca('DELX_PRO_Subfamilia');
        $oFilSubFamilia->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getSId());
        $oFilSubFamilia->setSIdTela($this->getTela()->getSId());

        $this->addFiltro($oCodigofiltro, $oDescricaofiltro, $oFilGrupo, $oFilSubGrupo, $oFilFamilia, $oFilSubFamilia);
        $this->addCampos($oCodigo, $oDescricao, $oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes, $oFamiliaCod, $oFamiliaDes, $oSubFamiliaCod, $oSubFamiliaDes, $oUnidadeMedCod, $oPesoLiq, $oPesoBruto
        );
    }

    public function criaTela() {
        parent::criaTela();

        $sAcao = $this->getSRotina();

        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Geral');
        $oAbaGeral->setBActive(true);

        $this->addLayoutPadrao('Aba');

        $oCodigo = new Campo('Produto', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodigo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodigo->addValidacao(false, Validacao::TIPO_INTEIRO, 'Campo não pode estar em branco', '0');

        $oDescricao = new Campo('Descrição do Produto', 'pro_descricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oDescricao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDescricao->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco', '5');

        $oUsuCad = new Campo('Usuário do Cadastro', 'pro_cadastrousuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCad->setSValor($_SESSION['nomedelsoft']);
        $oUsuCad->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHABRANCO);
        $oLinha->setApenasTela(true);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Aba Geral
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Grupo
        $oGrupoCod = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        if ($_SESSION['filcgc'] == '8993358000174') {
            $oGrupoCod->setSValor('24');
            $oGrupoCod->setBCampoBloqueado(true);
        }
        $oGrupoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');


        $oGrupoDes = new Campo('Descrição', 'DELX_PRO_Grupo.pro_grupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDes->setSIdPk($oGrupoCod->getId());
        $oGrupoDes->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoDes->addCampoBusca('pro_grupocodigo', '', '');
        $oGrupoDes->addCampoBusca('pro_grupodescricao', '', '');
        $oGrupoDes->setSIdTela($this->getTela()->getid());
        $oGrupoDes->setBCampoBloqueado(true);

        $oGrupoCod->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoCod->setSCampoRetorno('pro_grupocodigo', $this->getTela()->getId());
        $oGrupoCod->addCampoBusca('pro_grupodescricao', $oGrupoDes->getId(), $this->getTela()->getId());

        //Sub Grupo
        $oSubGrupoCod = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oSubGrupoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oSubGrupoDes = new Campo('Descrição', 'DELX_PRO_Subgrupo.pro_subgrupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDes->setSIdPk($oSubGrupoCod->getId());
        $oSubGrupoDes->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoDes->addCampoBusca('pro_subgrupocodigo', '', '');
        $oSubGrupoDes->addCampoBusca('pro_subgrupodescricao', '', '');
        $oSubGrupoDes->setSIdTela($this->getTela()->getid());
        $oSubGrupoDes->setBCampoBloqueado(true);

        $oSubGrupoCod->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoCod->setSCampoRetorno('pro_subgrupocodigo', $this->getTela()->getId());
        $oSubGrupoCod->addCampoBusca('pro_subgrupodescricao', $oSubGrupoDes->getId(), $this->getTela()->getId());

        //Família
        $oFamiliaCod = new Campo('Família', 'pro_familiacodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oFamiliaCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oFamiliaDes = new Campo('Descrição', 'DELX_PRO_Familia.pro_familiadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDes->setSIdPk($oFamiliaCod->getId());
        $oFamiliaDes->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaDes->addCampoBusca('pro_familiacodigo', '', '');
        $oFamiliaDes->addCampoBusca('pro_familiadescricao', '', '');
        $oFamiliaDes->setSIdTela($this->getTela()->getid());
        $oFamiliaDes->setBCampoBloqueado(true);

        $oFamiliaCod->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaCod->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getId());
        $oFamiliaCod->addCampoBusca('pro_familiadescricao', $oFamiliaDes->getId(), $this->getTela()->getId());

        //Sub Família
        $oSubFamiliaCod = new Campo('Sub.Fam', 'pro_subfamiliacodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oSubFamiliaCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oSubFamiliaDes = new Campo('Descrição', 'DELX_PRO_Subfamilia.pro_subfamiliadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDes->setSIdPk($oSubFamiliaCod->getId());
        $oSubFamiliaDes->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliacodigo', '', '');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliadescricao', '', '');
        $oSubFamiliaDes->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDes->setBCampoBloqueado(true);

        $oSubFamiliaCod->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaCod->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getId());
        $oSubFamiliaCod->addCampoBusca('pro_subfamiliadescricao', $oSubFamiliaDes->getId(), $this->getTela()->getId());

        //Un Medida
        $oUnidadeMedCod = new Campo('Un.Medida', 'pro_unidademedida', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUnidadeMedCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oUnidadeMedDes = new Campo('Descrição', 'DELX_PRO_UnidadeMedida.pro_unidademedidadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oUnidadeMedDes->setSIdPk($oUnidadeMedCod->getId());
        $oUnidadeMedDes->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedida', '', '');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedidadescricao', '', '');
        $oUnidadeMedDes->setSIdTela($this->getTela()->getid());
        $oUnidadeMedDes->setBCampoBloqueado(true);

        $oUnidadeMedCod->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedCod->setSCampoRetorno('pro_unidademedida', $this->getTela()->getId());
        $oUnidadeMedCod->addCampoBusca('pro_unidademedidadescricao', $oUnidadeMedDes->getId(), $this->getTela()->getId());

        $oTipoControle = new Campo('Tipo Controle do Estoque', 'pro_tipocontrole', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoControle->addItemSelect('E', 'Estoque Total');
        $oTipoControle->addItemSelect('F', 'Estoque Físico');
        $oTipoControle->addItemSelect('D', 'Débito Direto');
        $oTipoControle->addItemSelect('C', 'Consignado');

        $oTipoCusto = new Campo('Tipo Custo', 'pro_tipocusto', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoCusto->addItemSelect('M', 'Custo Médio');
        $oTipoCusto->addItemSelect('F', 'Custo Padrão');
        $oTipoCusto->addItemSelect('P', 'PEPS');
        $oTipoCusto->addItemSelect('U', 'UEPS');
        $oTipoCusto->addItemSelect('O', 'Custo Online');

        $oPesoLiq = new Campo('Peso líquido', 'pro_pesoliquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oPesoBruto = new Campo('Peso bruto', 'pro_pesobruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oVolume = new Campo('Volume', 'pro_volume', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oPcUnidade = new Campo('Pçs unidade', 'pro_volumepc', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oCodAnt = new Campo('Cod. antigo', 'pro_codigoantigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oDescTecProd = new Campo('Desc. técnica', 'pro_descricaotecnica', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescTecProd->setILinhasTextArea(3);

        $oReferencia = new Campo('Referência', 'pro_referencia', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oValidade = new Campo('Validade', 'pro_diasvalidade', Campo::TIPO_TEXTO, 1, 1, 12, 12);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oFieldSpec = new FieldSet('Especificações');
        $oFieldSpec->setOculto(true);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oTipoValidade = new Campo('Período', 'pro_tipovalidade', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoValidade->addItemSelect('D', 'Dias');
        $oTipoValidade->addItemSelect('M', 'Meses');
        $oTipoValidade->addItemSelect('A', 'Anos');

        $oTipoProd = new Campo('Tipo produção(IPPT)', 'pro_produtotipoproducao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoProd->addItemSelect('P', 'Própria');
        $oTipoProd->addItemSelect('T', 'Terceiro');

        $oTipoCalc = new Campo('Tipo cálculo(IAT)', 'pro_produtotipocalculo', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoCalc->addItemSelect('A', 'Arredondamento');
        $oTipoCalc->addItemSelect('T', 'Truncamento');

        $oTipoValConf = new Campo('Valida na conferência', 'pro_produtotipovalidacodigobar', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oTipoValConf->addItemSelect('U', 'Código de barras unitáriamente');
        $oTipoValConf->addItemSelect('T', 'Código de Barras Total');
        $oTipoValConf->addItemSelect('S', 'Sem Código de Barras');

        //Principio ativo
        $oPrincAtivoCod = new Campo('Prncípio Atv.', 'pro_produtopativo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oPrincAtivoCod->setClasseBusca('DELX_PRO_Principioativo');
        $oPrincAtivoCod->setSCampoRetorno('pro_principioativoseq', $this->getTela()->getid());
        $oPrincAtivoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oPrincAtivoCod->setSValor('0');

        //Produto vinculado
        $oCodProdVinculado = new Campo('Prod.Vinculado', 'pro_produtovinculadocodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCodProdVinculado->setClasseBusca('DELX_PRO_ProdutoFilial');
        $oCodProdVinculado->setSCampoRetorno('pro_codigo', $this->getTela()->getid());

        $oProGenerico = new campo('Genérico', 'pro_generico', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProGenerico->addItemSelect('N', 'Não');
        $oProGenerico->addItemSelect('S', 'Sim');

        $oControlLote = new campo('Cont.por Lote', 'pro_lote', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oControlLote->addItemSelect('N', 'Não');
        $oControlLote->addItemSelect('S', 'Sim');

        $oValorComp = new campo('Preço Val.Comp.', 'pro_compostovalor', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oValorComp->addItemSelect('N', 'Não');
        $oValorComp->addItemSelect('S', 'Sim');

        $oEmbRetorna = new campo('Emb.Retornável', 'pro_embalagemretornavel', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oEmbRetorna->addItemSelect('N', 'Não');
        $oEmbRetorna->addItemSelect('S', 'Sim');

        $oGrade = new campo('Grade', 'pro_grade', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oGrade->addItemSelect('N', 'Não');
        $oGrade->addItemSelect('S', 'Sim');

        $oProCoProd = new campo('Usa Co-Prod.na Produção', 'pro_coproduto', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProCoProd->addItemSelect('N', 'Não');
        $oProCoProd->addItemSelect('S', 'Sim');

        $oProControlado = new campo('Prod.Controlado', 'pro_produtocontrolado', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProControlado->addItemSelect('N', 'Não');
        $oProControlado->addItemSelect('S', 'Sim');

        $oProFant = new campo('Prod. Fantasma', 'pro_fantasma', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProFant->addItemSelect('N', 'Não');
        $oProFant->addItemSelect('S', 'Sim');

        $oProObsoleto = new campo('Prod.Obsoleto', 'pro_produtoobsoleto', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProObsoleto->addItemSelect('N', 'Não');
        $oProObsoleto->addItemSelect('S', 'Sim');

        $oProFCIRevenda = new Campo('Prod.de Revenda', 'pro_produtofcirevenda', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProFCIRevenda->addItemSelect('N', 'Não');
        $oProFCIRevenda->addItemSelect('S', 'Sim');

        $oProLetra = new Campo('Letra', 'pro_letra', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oProImportEstrut = new campo('Import.na estrutura', 'pro_importadoestrutura', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProImportEstrut->addItemSelect('N', 'Não');
        $oProImportEstrut->addItemSelect('S', 'Sim');

        $oControleNSerie = new Campo('Controle por N.Série', 'pro_produtocontrolaserie', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oControleNSerie->addItemSelect('N', 'Não');
        $oControleNSerie->addItemSelect('S', 'Sim');

        $oProFCommerce = new Campo('Fast Commerce', 'pro_produtofastcommerce', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProFCommerce->addItemSelect('N', 'Não');
        $oProFCommerce->addItemSelect('S', 'Sim');

        $oProReceituario = new Campo('Receituário', 'pro_receituario', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProReceituario->addItemSelect('N', 'Não');
        $oProReceituario->addItemSelect('S', 'Sim');

        $oDrawBack = new Campo('Drawback', 'pro_produtodrawback', Campo::TIPO_TEXTO, 2, 2, 12, 12);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oFieldDim = new FieldSet('Dimensões');
        $oFieldDim->setOculto(true);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oDim = new Campo('Dimensões', 'pro_dimensoes', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oDim->addItemSelect('N', 'Nenhum');
        $oDim->addItemSelect('S', 'Dim. Padrão');
        $oDim->addItemSelect('G', 'Dim. na Grade');

        //Un Medida
        $oProDimUnidade = new Campo('Tipo.Dimensão', 'pro_dimensoesunidade', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oProDimUnidade->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oProDimUnidade->setSCampoRetorno('pro_unidademedida', $this->getTela()->getid());

        $oDimConver = new Campo('Conversor das Dimen.', 'pro_dimensoesconversor', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oDimConverUnd = new Campo('Conversor Und.Prod.', 'pro_dimensoesundconversor', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCompBruto = new Campo('Comp.Bruto', 'pro_comprimentobruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oLargBruto = new Campo('Larg.Bruto', 'pro_largurabruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oEspBruto = new Campo('Espe.Bruto', 'pro_espessurabruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oCompLiquido = new Campo('Comp.Líquido', 'pro_comprimentoliquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oLargLiquido = new Campo('Larg.Líquido', 'pro_larguraliquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oEspLiquido = new Campo('Espe.Líquido', 'pro_espessuraliquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oMedComp = new Campo('Tipo Medida', 'pro_produtomedidacomprimento', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oMedComp->addItemSelect('', 'Nenhum');
        $oMedComp->addItemSelect('MM', 'Milímetros');
        $oMedComp->addItemSelect('CM', 'Centímetros');
        $oMedComp->addItemSelect('M', 'Metros');

        $oMetrosCub = new Campo('Metros Cub.', 'pro_volumem3', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oFormula = new Campo('Formula do Calculo', 'pro_dimensoesgradeformula', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oFormula->setILinhasTextArea(8);


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Aba Inf. Fiscal
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $oAbaInfFiscal = new AbaTabPanel('Inf. Fiscal');

        $oProOrigem = new Campo('Origem', 'pro_origem', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oProOrigem->addItemSelect('0', 'Nacional.');
        $oProOrigem->addItemSelect('1', '1- Estrangeira - Imp.Direta.');
        $oProOrigem->addItemSelect('2', '2 - Estrangeira - Mercado Interno.');
        $oProOrigem->addItemSelect('3', '3 - Nacional - Mercadoria ou Bem com Conteúdo de Importação Superior a  40%.');
        $oProOrigem->addItemSelect('4', '4 - Nacional - Cuja Produção Tenha Sido Feita em Conformidade com os Processos Produtivos Básicos.');
        $oProOrigem->addItemSelect('5', '5 - Nacional - Mercadoria ou Bem com Conteúdo de Importação Inferior ou Igual a 40%.');
        $oProOrigem->addItemSelect('6', '6 - Estrangeira - Importação Direta, sem Similar Nacional, Constante em Lista de Resolução CAMEX.');
        $oProOrigem->addItemSelect('7', '7 - Estrangeira - Adquirida no Mercado Interno, sem Similar Nacional, Constante em Lista de Resolução CAMEX.');
        $oProOrigem->addItemSelect('8', '8 - Nacional - Mercadoria ou bem com Conteúdo de Importação superior a 70% (setenta por cento).');


        //NCM
        $oProNCM = new Campo('NCM', 'pro_ncm', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProNCM->setClasseBusca('DELX_FIS_Ncm');
        $oProNCM->setSCampoRetorno('fis_ncmcodigo', $this->getTela()->getid());
        $oProNCM->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco', '0');

        //CNAE
        $oProCnae = new Campo('CNAE', 'fis_cnaecodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProCnae->setClasseBusca('DELX_FIS_Cnae');
        $oProCnae->setSCampoRetorno('fis_cnaecodigo', $this->getTela()->getid());

        //Principal
        $oProPrincipal = new Campo('Principal', 'fis_lc11603principalcodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oProPrincipal->setClasseBusca('DELX_FIS_Lc11603principal');
        $oProPrincipal->setSCampoRetorno('fis_lc11603principalcodigo', $this->getTela()->getid());

        //Secundario
        $oProSecundario = new Campo('Secundário', 'fis_lc11603secundariocodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oProSecundario->setClasseBusca('DELX_FIS_Lc11603secundario');
        $oProSecundario->setSCampoRetorno('fis_lc11603secundariocodigo', $this->getTela()->getid());


        //Gênero de item
        $oGeneroItem = new Campo('Genero do Item', 'fis_generoitemcodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);

        $oGeneroDes = new Campo('Descrição', 'fis_generoitemdescricao', Campo::TIPO_BUSCADOBANCO, 6, 6, 12, 12);
        $oGeneroDes->setSIdPk($oGeneroItem->getId());
        $oGeneroDes->setClasseBusca('DELX_FIS_Generoitem');
        $oGeneroDes->addCampoBusca('fis_generoitemcodigo', '', '');
        $oGeneroDes->addCampoBusca('fis_generoitemdescricao', '', '');
        $oGeneroDes->setSIdTela($this->getTela()->getid());
        $oGeneroDes->setBCampoBloqueado(true);
        $oGeneroDes->setApenasTela(true);

        $oGeneroItem->setClasseBusca('DELX_FIS_Generoitem');
        $oGeneroItem->setSCampoRetorno('fis_generoitemcodigo', $this->getTela()->getId());
        $oGeneroItem->addCampoBusca('fis_generoitemdescricao', $oGeneroDes->getId(), $this->getTela()->getId());

        $oLabel1 = new campo('SPED Fiscal ICMS/IPI (Bloco C - Registro 500 - Campo 26)', 'label1', Campo::TIPO_LABEL, 10, 10, 12, 12);
        $oLabel1->setIMarginTop(30);

        $oTipoLigacao = new Campo('Tipo Ligação', 'pro_tipoligacao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoLigacao->addItemSelect('0', 'Nenhum');
        $oTipoLigacao->addItemSelect('1', '1- Monofásico');
        $oTipoLigacao->addItemSelect('2', '2- Bifásico');
        $oTipoLigacao->addItemSelect('3', '3- Trifásico');

        $oLabel2 = new campo('SPED Fiscal ICMS/IPI (Bloco C - Registro 500 - Campo 27)', 'label2', Campo::TIPO_LABEL, 8, 8, 12, 12);
        $oLabel2->setIMarginTop(30);

        $oGrupoTensao = new Campo('Grupo Tensão', 'pro_grupotensao', Campo::TIPO_SELECT, 4, 4, 12, 12);
        $oGrupoTensao->addItemSelect('00', 'Nenhum');
        $oGrupoTensao->addItemSelect('01', '01 - A1 - Alta Tensão (230kV ou mais)');
        $oGrupoTensao->addItemSelect('02', '02 - A2 - Alta Tensão (88 a 138kV)');
        $oGrupoTensao->addItemSelect('03', '03 - A3 - Alta Tensão (69kV)');
        $oGrupoTensao->addItemSelect('04', '04 - A3a - Alta Tensão (30kV a 44kV)');
        $oGrupoTensao->addItemSelect('05', '05 - A4 - Alta Tensão (2,3kV a 25kV)');
        $oGrupoTensao->addItemSelect('06', '06 - AS - Alta Tensão Subterrâneo');
        $oGrupoTensao->addItemSelect('07', '07 - B1 - Residencial');
        $oGrupoTensao->addItemSelect('08', '08 - B1 - Residencial Baixa Renda');
        $oGrupoTensao->addItemSelect('09', '09 - B2 - Rural');
        $oGrupoTensao->addItemSelect('10', '10 - B2 - Cooperativa de Eletrificação Rural');
        $oGrupoTensao->addItemSelect('11', '11 - B2 - Serviço Público de Irrigação');
        $oGrupoTensao->addItemSelect('12', '12 - B3 - Demais Classes');
        $oGrupoTensao->addItemSelect('13', '13 - B4a - Iluminação Pública - Rede de Distribuição');
        $oGrupoTensao->addItemSelect('14', '14 - B4b - Iluminação Pública - Bulbo de Lâmpada');

        $oProUnCod = new Campo('Cod.Un. NFS-e', 'pro_unidadecodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oProDestacaNFSE = new Campo('Mat.Destacado NFS-e', 'pro_destacanfse', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oProDestacaNFSE->addItemSelect('N', 'Não');
        $oProDestacaNFSE->addItemSelect('S', 'Sim');

        $oProCodTributaria = new Campo('Cod.Subs.Tributária', 'pro_produtocest', Campo::TIPO_TEXTO, 2, 2, 12, 12);


        //Aba Filial
        $oAbaFilial = new AbaTabPanel('Filial');

        //Aba Caracteristicas
        $oAbaCaracteristicas = new AbaTabPanel('Caracter.');

        //Aba Grades
        $oAbaGrades = new AbaTabPanel('Grades');

        //Aba Cod. Barra
        $oAbaCodBarra = new AbaTabPanel('Cod.Barra');

        //Aba Conversor de Unidade
        $oAbaConvUn = new AbaTabPanel('Conv.Unidade');

        //Aba Similares
        $oAbaSimilares = new AbaTabPanel('Similares');

        //Aba Imagem
        $oAbaImagem = new AbaTabPanel('Imagem');

        //Aba Log
        $oAbaLog = new AbaTabPanel('Log da Desc.');

        //Aba Perigo
        $oAbaPerigo = new AbaTabPanel('Prod.Perigoso');

        $oNrOnu = new Campo('Nr.ONU', 'pro_perigosoonu', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oNomePerigo = new Campo('Nome p. transporte', 'pro_perigosonome', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oClasseRisco = new Campo('Classe de risco', 'pro_perigosoclasse', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oEmbGrupo = new Campo('Gr.Embalagem', 'pro_perigosoembalagem', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oPontoFulgor = new Campo('Fulgor', 'pro_perigosopontofulgor', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oDescEstrutura = new Campo('Nome.Estrutura', 'pro_descricaoestrutura', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oNrRisco = new Campo('Nr.Risco', 'pro_perigosonumerorisco', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oQuantMin = new Campo('Qt.Min.', 'pro_produtoperigosoqtdminima', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        //Aba Co-Produto
        $oAbaCoProduto = new AbaTabPanel('Co-Produto');


        if ($sAcao == 'acaoIncluir') {
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $oFieldFilial = new FieldSet('Filiais');
            $oFieldFilial->setOculto(true);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////        

            $oMatriz = new campo('Matriz', 'matriz', Campo::TIPO_CHECK, 1, 1, 6, 6);
            $oMatriz->setApenasTela(true);

            $oFilialSteel = new campo('Steeltrater', 'steeltrater', Campo::TIPO_CHECK, 1, 1, 6, 6);
            $oFilialSteel->setApenasTela(true);

            $oFeculaBoewing = new campo('Fecula Boewing ', 'fecula', Campo::TIPO_CHECK, 2, 2, 6, 6);
            $oFeculaBoewing->setApenasTela(true);

            $oFilialFecial = new campo('Fecial', 'fecial', Campo::TIPO_CHECK, 1, 1, 6, 6);
            $oFilialSteel->setApenasTela(true);

            $oFilialHedler = new campo('Hedler', 'hedler', Campo::TIPO_CHECK, 1, 1, 6, 6);
            $oFilialHedler->setApenasTela(true);


            $oFieldSpec->addCampos(
                    array($oTipoProd, $oTipoCalc), array($oTipoValConf, $oPrincAtivoCod, $oCodProdVinculado), array($oProGenerico, $oControlLote, $oValorComp, $oEmbRetorna, $oGrade, $oProCoProd), array($oProControlado, $oProFant, $oProObsoleto, $oProFCIRevenda, $oProLetra), array($oProImportEstrut, $oControleNSerie, $oProFCommerce, $oProReceituario, $oDrawBack));
            $oFieldDim->addCampos(
                    array($oDim, $oProDimUnidade), array($oDimConver, $oDimConverUnd), array($oCompBruto, $oLargBruto, $oEspBruto), array($oCompLiquido, $oLargLiquido, $oEspLiquido), array($oMedComp, $oMetrosCub), $oFormula);

            $oFieldFilial->addCampos(
                    array($oMatriz, $oFilialSteel, $oFilialHedler, $oFilialFecial, $oFeculaBoewing));

            //Campos Abas
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $oAbaGeral->addCampos(
                    array($oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes), array($oFamiliaCod, $oFamiliaDes, $oSubFamiliaCod, $oSubFamiliaDes), array($oUnidadeMedCod, $oUnidadeMedDes, $oTipoControle, $oTipoCusto), array($oPesoLiq, $oPesoBruto, $oVolume, $oPcUnidade), $oCodAnt, $oDescTecProd, array($oReferencia, $oValidade, $oTipoValidade), $oFieldSpec, $oFieldDim, $oFieldFilial);

            $oAbaInfFiscal->addCampos(
                    $oProOrigem, array($oProNCM, $oProCnae, $oProPrincipal, $oProSecundario), array($oGeneroItem, $oGeneroDes), array($oTipoLigacao, $oLabel1), array($oGrupoTensao, $oLabel2), array($oProUnCod, $oProDestacaNFSE, $oProCodTributaria));

            $oAbaPerigo->addCampos(
                    array($oNrOnu, $oNrRisco, $oClasseRisco,), array($oNomePerigo, $oDescEstrutura, $oPontoFulgor,), array($oEmbGrupo, $oQuantMin));


            $oTab->addItems($oAbaGeral, $oAbaInfFiscal/* ,$oAbaFilial,$oAbaCaracteristicas, $oAbaGrades, $oAbaCodBarra, $oAbaConvUn, $oAbaSimilares, $oAbaImagem, $oAbaLog, $oAbaPerigo, $oAbaCoProduto */);
            $this->addCampos(
                    array($oCodigo, $oDescricao, $oUsuCad), $oLinha, $oTab);
        } else {
            $oFieldSpec->addCampos(
                    array($oTipoProd, $oTipoCalc), array($oTipoValConf, $oPrincAtivoCod, $oCodProdVinculado), array($oProGenerico, $oControlLote, $oValorComp, $oEmbRetorna, $oGrade, $oProCoProd), array($oProControlado, $oProFant, $oProObsoleto, $oProFCIRevenda, $oProLetra), array($oProImportEstrut, $oControleNSerie, $oProFCommerce, $oProReceituario, $oDrawBack));
            $oFieldDim->addCampos(
                    array($oDim, $oProDimUnidade), array($oDimConver, $oDimConverUnd), array($oCompBruto, $oLargBruto, $oEspBruto), array($oCompLiquido, $oLargLiquido, $oEspLiquido), array($oMedComp, $oMetrosCub), $oFormula);

            //Campos Abas
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $oAbaGeral->addCampos(
                    array($oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes), array($oFamiliaCod, $oFamiliaDes, $oSubFamiliaCod, $oSubFamiliaDes), array($oUnidadeMedCod, $oUnidadeMedDes, $oTipoControle, $oTipoCusto), array($oPesoLiq, $oPesoBruto, $oVolume, $oPcUnidade), $oCodAnt, $oDescTecProd, array($oReferencia, $oValidade, $oTipoValidade), $oFieldSpec, $oFieldDim);

            $oAbaInfFiscal->addCampos(
                    $oProOrigem, array($oProNCM, $oProCnae, $oProPrincipal, $oProSecundario), array($oGeneroItem, $oGeneroDes), array($oTipoLigacao, $oLabel1), array($oGrupoTensao, $oLabel2), array($oProUnCod, $oProDestacaNFSE, $oProCodTributaria));

            $oAbaPerigo->addCampos(
                    array($oNrOnu, $oNrRisco, $oClasseRisco,), array($oNomePerigo, $oDescEstrutura, $oPontoFulgor,), array($oEmbGrupo, $oQuantMin));


            $oTab->addItems($oAbaGeral, $oAbaInfFiscal/* ,$oAbaFilial,$oAbaCaracteristicas, $oAbaGrades, $oAbaCodBarra, $oAbaConvUn, $oAbaSimilares, $oAbaImagem, $oAbaLog, $oAbaPerigo, $oAbaCoProduto */);
            $this->addCampos(
                    array($oCodigo, $oDescricao, $oUsuCad), $oLinha, $oTab);
        }
    }

}
