<?php

/*
 * Classe que implementa as views STEEL_PCP_Produtos
 * 
 * @author Cleverton Hoffmann
 * @since 01/02/2019
 */

class ViewSTEEL_PCP_Produtos extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oBotaoModal = new CampoConsulta('', 'apontar', CampoConsulta::TIPO_MODAL, CampoConsulta::ICONE_EDIT);
        $oBotaoModal->setBHideTelaAcao(true);
        $oBotaoModal->setILargura(15);
        $oBotaoModal->setSTitleAcao('Produto Filial!');
        $oBotaoModal->addAcao('STEEL_PCP_ProdutoFilial', 'criaTelaModalFilialProd', 'modalFilialProd', '');
        $this->addModais($oBotaoModal);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);

        $this->getTela()->setiAltura(800);
        // $this->getTela()->setILarguraGrid(2300);
        $this->getTela()->setBGridResponsivo(false);

        $this->setBScrollInf(true);
        $this->getTela()->setBUsaCarrGrid(true);

        $oCodigo = new CampoConsulta('Código', 'pro_codigo');

        $oRefCliente = new CampoConsulta('Referencia', 'pro_referencia');

        $oDescricao = new CampoConsulta('Descrição', 'pro_descricao');

        $oNcm = new campoConsulta('NCM', 'pro_ncm');

        $oGrupoCod = new CampoConsulta('Grupo', 'pro_grupocodigo');

        $oGrupoDes = new CampoConsulta('Descrição', 'DELX_PRO_Grupo.pro_grupodescricao');

        $oSubGrupoCod = new CampoConsulta('SubGrupo', 'DELX_PRO_Subgrupo.pro_subgrupocodigo');

        $oSubGrupoDes = new CampoConsulta('Descrição', 'DELX_PRO_Subgrupo.pro_subgrupodescricao');

        $oFamiliaCod = new CampoConsulta('Família', 'DELX_PRO_Familia.pro_familiacodigo');

        $oFamiliaDes = new CampoConsulta('Descrição', 'DELX_PRO_Familia.pro_familiadescricao');

        $oSubFamiliaCod = new CampoConsulta('SubFamília', 'DELX_PRO_Subfamilia.pro_subfamiliacodigo');

        $oSubFamiliaDes = new CampoConsulta('Descrição', 'DELX_PRO_Subfamilia.pro_subfamiliadescricao');

        $oUnidadeMedCod = new CampoConsulta('UN', 'pro_unidademedida');

        $oPesoLiq = new CampoConsulta('Peso líquido', 'pro_pesoliquido', CampoConsulta::TIPO_DECIMAL);

        $oPesoBruto = new CampoConsulta('Peso bruto', 'pro_pesobruto', CampoConsulta::TIPO_DECIMAL);

        $oBloqueio = new CampoConsulta('Data Bloqueio', 'STEEL_PCP_ProdutoFilial.pro_filialdtbloqueado');
        $oBloqueio->addComparacao('1753-01-01 00:00:00.000', CampoConsulta::COMPARACAO_DIFERENTE, CampoConsulta::COR_VERMELHO, CampoConsulta::MODO_COLUNA, false, '');

        $oMotivoBloqueio = new CampoConsulta('Motivo Bloqueio', 'STEEL_PCP_ProdutoFilial.pro_filialmotivobloqueio');


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

        $oFiltroReferencia = new Filtro($oRefCliente, Filtro::CAMPO_TEXTO_IGUAL, 2);

        $this->addFiltro($oCodigofiltro, $oDescricaofiltro, $oFilGrupo, $oFilSubGrupo, $oFilFamilia, $oFilSubFamilia, $oFiltroReferencia);
        $this->addCampos($oBotaoModal, $oCodigo, $oRefCliente, $oDescricao, $oNcm, $oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes, $oUnidadeMedCod, $oBloqueio
        ); // $oPesoLiq,$oBloqueio,$oMotivoBloqueio,$oSubFamiliaCod, $oSubFamiliaDes,$oSubGrupoCod, $oSubGrupoDes, $oFamiliaCod, $oFamiliaDes,   
    }

    public function criaTela() {
        parent::criaTela();
        $sAcao = $this->getSRotina();
        if ($sAcao == 'acaoIncluir') {
            $this->setBTela(true);
        }
        //parametros passando de outra tela
        $oDados = $this->getAParametrosExtras();
        //-------------------------------------------------    



        $oTab = new TabPanel();
        $oAbaGeral = new AbaTabPanel('Cadastro Simplificado de produtos SteelTrater');
        $oAbaGeral->setBActive(true);

        $this->addLayoutPadrao('Aba');
        //--------------------------------------------------
        $oCodigo = new Campo('Produto', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodigo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oCodigo->setBCampoBloqueado(true);

        //----------------------------------------------------
        $oDescricao = new Campo('Descrição do Produto', 'pro_descricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        $oDescricao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDescricao->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco', '5');
        if (method_exists($oDados, 'getProdes')) {
            $oDescricao->setSValor($oDados->getProdes());
        }
        $oDescricao->setBFocus(true);
        $oDescricao->setBUpperCase(true);

        //--------------------------------------------------------
        $oUsuCad = new Campo('Usuário do Cadastro', 'pro_cadastrousuario', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oUsuCad->setSValor($_SESSION['nomedelsoft']);
        $oUsuCad->setBCampoBloqueado(true);

        $oDataHoraCad = new Campo('Data Cadastro', 'pro_cadastrodatahora', Campo::TIPO_DATA, 2, 2, 2, 2);
        $oDataHoraCad->setBCampoBloqueado(true);

        $oUsuAlt = new campo('Usuário Alteração', 'pro_alteracaousuario', Campo::TIPO_TEXTO, 2, 2, 2, 2);
        $oUsuAlt->setBCampoBloqueado(true);

        $oDataHoraAlt = new Campo('Data Alteração', 'pro_alteracaodatahora', Campo::TIPO_DATA, 2, 2, 2, 2);
        $oDataHoraAlt->setBCampoBloqueado(true);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA);
        $oLinha->setApenasTela(true);
        //--------------------------------------------------------
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Aba Geral
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Grupo
        $oGrupoCod = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oGrupoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        if (method_exists($oDados, 'getProdes')) {
            $oGrupoCod->setSValor('102');
        }
        //-----------------------------------------------------------

        $oGrupoDes = new Campo('Descrição', 'DELX_PRO_Grupo.pro_grupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oGrupoDes->setSIdPk($oGrupoCod->getId());
        $oGrupoDes->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoDes->addCampoBusca('pro_grupocodigo', '', '');
        $oGrupoDes->addCampoBusca('pro_grupodescricao', '', '');
        $oGrupoDes->setSIdTela($this->getTela()->getid());
        $oGrupoDes->setBCampoBloqueado(true);
        if (method_exists($oDados, 'getProdes')) {
            $oGrupoDes->setSValor('STEELTRATER PRODUTO CLIENTES');
        }

        $oGrupoCod->setClasseBusca('DELX_PRO_Grupo');
        $oGrupoCod->setSCampoRetorno('pro_grupocodigo', $this->getTela()->getId());
        $oGrupoCod->addCampoBusca('pro_grupodescricao', $oGrupoDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------

        $oSubGrupoCod = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oSubGrupoCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        if (method_exists($oDados, 'getProdes')) {
            $oSubGrupoCod->setSValor('1');
        }

        $oSubGrupoDes = new Campo('Descrição', 'DELX_PRO_Subgrupo.pro_subgrupodescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubGrupoDes->setSIdPk($oSubGrupoCod->getId());
        $oSubGrupoDes->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoDes->addCampoBusca('pro_subgrupocodigo', '', '');
        $oSubGrupoDes->addCampoBusca('pro_subgrupodescricao', '', '');
        $oSubGrupoDes->setSIdTela($this->getTela()->getid());
        $oSubGrupoDes->setBCampoBloqueado(true);
        if (method_exists($oDados, 'getProdes')) {
            $oSubGrupoDes->setSValor('PRODUTO CLIENTES');
        }


        $oSubGrupoCod->setClasseBusca('DELX_PRO_Subgrupo');
        $oSubGrupoCod->setSCampoRetorno('pro_subgrupocodigo', $this->getTela()->getId());
        $oSubGrupoCod->addCampoBusca('pro_subgrupodescricao', $oSubGrupoDes->getId(), $this->getTela()->getId());

        //----------------------------------------------------------------

        $oFamiliaCod = new Campo('Família', 'pro_familiacodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oFamiliaCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        if (method_exists($oDados, 'getProdes')) {
            $oFamiliaCod->setSValor('1');
        }

        $oFamiliaDes = new Campo('Descrição', 'DELX_PRO_Familia.pro_familiadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFamiliaDes->setSIdPk($oFamiliaCod->getId());
        $oFamiliaDes->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaDes->addCampoBusca('pro_familiacodigo', '', '');
        $oFamiliaDes->addCampoBusca('pro_familiadescricao', '', '');
        $oFamiliaDes->setSIdTela($this->getTela()->getid());
        $oFamiliaDes->setBCampoBloqueado(true);
        if (method_exists($oDados, 'getProdes')) {
            $oFamiliaDes->setSValor('PRODUTO CLIENTES');
        }


        $oFamiliaCod->setClasseBusca('DELX_PRO_Familia');
        $oFamiliaCod->setSCampoRetorno('pro_familiacodigo', $this->getTela()->getId());
        $oFamiliaCod->addCampoBusca('pro_familiadescricao', $oFamiliaDes->getId(), $this->getTela()->getId());

        //-----------------------------------------------------------------------

        $oSubFamiliaCod = new Campo('Sub.Fam', 'pro_subfamiliacodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oSubFamiliaCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        if (method_exists($oDados, 'getProdes')) {
            $oSubFamiliaCod->setSValor('1');
        }

        $oSubFamiliaDes = new Campo('Descrição', 'DELX_PRO_Subfamilia.pro_subfamiliadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oSubFamiliaDes->setSIdPk($oSubFamiliaCod->getId());
        $oSubFamiliaDes->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliacodigo', '', '');
        $oSubFamiliaDes->addCampoBusca('pro_subfamiliadescricao', '', '');
        $oSubFamiliaDes->setSIdTela($this->getTela()->getid());
        $oSubFamiliaDes->setBCampoBloqueado(true);
        if (method_exists($oDados, 'getProdes')) {
            $oSubFamiliaDes->setSValor('PRODUTO CLIENTES');
        }

        $oSubFamiliaCod->setClasseBusca('DELX_PRO_Subfamilia');
        $oSubFamiliaCod->setSCampoRetorno('pro_subfamiliacodigo', $this->getTela()->getId());
        $oSubFamiliaCod->addCampoBusca('pro_subfamiliadescricao', $oSubFamiliaDes->getId(), $this->getTela()->getId());

        //-------------------------------------------------------------------------

        $oUnidadeMedCod = new Campo('Un.Medida', 'pro_unidademedida', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUnidadeMedCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');
        $oUnidadeMedCod->setBUpperCase(true);
        if (method_exists($oDados, 'getProdes')) {
            $oUnidadeMedCod->setSValor('KG');
        }

        $oUnidadeMedDes = new Campo('Descrição', 'DELX_PRO_UnidadeMedida.pro_unidademedidadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oUnidadeMedDes->setSIdPk($oUnidadeMedCod->getId());
        $oUnidadeMedDes->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedida', '', '');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedidadescricao', '', '');
        $oUnidadeMedDes->setSIdTela($this->getTela()->getid());
        if (method_exists($oDados, 'getProdes')) {
            $oUnidadeMedDes->setSValor('Quilograma');
        }

        $oUnidadeMedCod->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedCod->setSCampoRetorno('pro_unidademedida', $this->getTela()->getId());
        $oUnidadeMedCod->addCampoBusca('pro_unidademedidadescricao', $oUnidadeMedDes->getId(), $this->getTela()->getId());

        //------------------------------------------------------------------------

        $oTipoControle = new Campo('Tipo Controle do Estoque', 'pro_tipocontrole', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oTipoControle->addItemSelect('E', 'Estoque Total');
        $oTipoControle->addItemSelect('F', 'Estoque Físico');
        $oTipoControle->addItemSelect('D', 'Débito Direto');
        $oTipoControle->addItemSelect('C', 'Consignado');

        //------------------------------------------------------------------------

        $oPesoLiq = new Campo('Peso líquido', 'pro_pesoliquido', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPesoLiq->setSValor('0');

        //------------------------------------------------------------------------

        $oPesoBruto = new Campo('Peso bruto', 'pro_pesobruto', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPesoBruto->setSValor('0');

        //-------------------------------------------------------------------------

        $oVolume = new Campo('Volume', 'pro_volume', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oVolume->setSValor('0');

        //--------------------------------------------------------------------------

        $oPcUnidade = new Campo('Pçs unidade', 'pro_volumepc', Campo::TIPO_DECIMAL, 1, 1, 12, 12);
        $oPcUnidade->setSValor('0');

        //---------------------------------------------------------------------------

        $oCodAnt = new Campo('Cod.antigo "Dados Adicionais" <span class="badge badge-warning">Informar CNPJ em produtos de clientes</span>', 'pro_codigoantigo', Campo::TIPO_TEXTO, 5, 5, 12, 12);
        if (method_exists($oDados, 'getProdes')) {
            $oCodAnt->setSValor($oDados->getEmpcod());
        }

        //---------------------------------------------------------------------------

        $oDescTecProd = new Campo('Desc. técnica', 'pro_descricaotecnica', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oDescTecProd->setILinhasTextArea(3);


        //---------------------------------------------------------------------------

        $oReferencia = new Campo('Referência', 'pro_referencia', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oReferencia->setSCorFundo(Campo::FUNDO_AMARELO);
        if (method_exists($oDados, 'getProcod')) {
            $oReferencia->setSValor($oDados->getProcod());
        }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Aba Inf. Fiscal
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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
        $oProNCM->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!');
        $oProNCM->setBNCM(true);
        if (method_exists($oDados, 'getNcm')) {
            $oProNCM->setSValor($oDados->getNcm());
        }

        $oFIS_GeneroItemCodigo = new campo('Genero', 'fis_generoitemcodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oFIS_GeneroItemCodigo->addValidacao(false, Validacao::TIPO_STRING, '', '2');

        $oFIS_GeneroItemDescricao = new campo('Descrição', 'fis_generoitemdescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oFIS_GeneroItemDescricao->setSIdPk($oFIS_GeneroItemCodigo->getId());
        $oFIS_GeneroItemDescricao->setClasseBusca('DELX_FIS_Generoitem');
        $oFIS_GeneroItemDescricao->addCampoBusca('fis_generoitemcodigo', '', '');
        $oFIS_GeneroItemDescricao->addCampoBusca('fis_generoitemdescricao', '', '');
        $oFIS_GeneroItemDescricao->setSIdTela($this->getTela()->getid());
        $oFIS_GeneroItemDescricao->setApenasTela(true);
        $oFIS_GeneroItemDescricao->setBCampoBloqueado(true);

        $oFIS_GeneroItemCodigo->setClasseBusca('DELX_FIS_Generoitem');
        $oFIS_GeneroItemCodigo->setSCampoRetorno('fis_generoitemcodigo', $this->getTela()->getid());
        $oFIS_GeneroItemCodigo->addCampoBusca('fis_generoitemdescricao', $oFIS_GeneroItemDescricao->getId(), $this->getTela()->getid());


        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_Produtos","validaNCM","' . $oProNCM->getId() . ',' . $oFIS_GeneroItemCodigo->getId() . '");';

        $oProNCM->addEvento(Campo::EVENTO_SAIR, $sCallBack);



        //Campos Abas
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $oAbaGeral->addCampos($oReferencia, $oLinha, array($oGrupoCod, $oGrupoDes, $oSubGrupoCod, $oSubGrupoDes), $oLinha, array($oFamiliaCod, $oFamiliaDes, $oSubFamiliaCod, $oSubFamiliaDes), $oLinha, array($oUnidadeMedCod, $oUnidadeMedDes, $oTipoControle), $oLinha, array($oPesoLiq, $oPesoBruto, $oVolume, $oPcUnidade), $oLinha, $oCodAnt, $oLinha, $oDescTecProd, $oProOrigem, $oProNCM, array($oFIS_GeneroItemCodigo, $oFIS_GeneroItemDescricao));

        $oTab->addItems($oAbaGeral);
        $this->addCampos(
                array($oCodigo, $oDescricao,), $oLinha, $oTab, $oLinha, array($oUsuCad, $oDataHoraCad), array($oUsuAlt, $oDataHoraAlt));
    }

}
