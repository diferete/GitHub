<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018 
 */

class ViewDELX_PRO_Produtoconv extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oConvCod = new CampoConsulta('Conversor', 'pro_convcodigo', CampoConsulta::TIPO_TEXTO);
        $oConvUn = new CampoConsulta('Un.Conversão', 'pro_convunidade', CampoConsulta::TIPO_TEXTO);

        $oFilConvCod = new Filtro($oConvCod, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilConvUn = new Filtro($oConvUn, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addFiltro($oFilConvCod, $oFilConvUn);
        $this->addCampos($oConvCod, $oConvUn);
    }

    public function criaTela() {
        parent::criaTela();

        $oConvCod = new Campo('Conversor', 'pro_convcodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oUnidadeMedCod = new Campo('Un.Medida', 'pro_convunidade', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oUnidadeMedCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oUnidadeMedDes = new Campo('Descrição', 'pro_unidademedidadescricao', Campo::TIPO_BUSCADOBANCO, 3, 3, 12, 12);
        $oUnidadeMedDes->setSIdPk($oUnidadeMedCod->getId());
        $oUnidadeMedDes->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedida', '', '');
        $oUnidadeMedDes->addCampoBusca('pro_unidademedidadescricao', '', '');
        $oUnidadeMedDes->setSIdTela($this->getTela()->getid());
        $oUnidadeMedDes->setBCampoBloqueado(true);
        $oUnidadeMedDes->setApenasTela(true);

        $oUnidadeMedCod->setClasseBusca('DELX_PRO_UnidadeMedida');
        $oUnidadeMedCod->setSCampoRetorno('pro_unidademedida', $this->getTela()->getId());
        $oUnidadeMedCod->addCampoBusca('pro_unidademedidadescricao', $oUnidadeMedDes->getId(), $this->getTela()->getId());

        $oFatorConv = new Campo('Fator Conv.', 'pro_convfator', Campo::TIPO_DECIMAL, 1, 1, 12, 12);

        $oConvPadrao = new Campo('Conv.Padrao', 'pro_convpadrao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oConvPadrao->addItemSelect('N', 'Não');
        $oConvPadrao->addItemSelect('S', 'Sim');

        $oConvTipo = new Campo('Tipo Conversor', 'pro_convdimensao', Campo::TIPO_SELECT, 2, 2, 12, 12);
        $oConvTipo->addItemSelect('N', 'Nenhum');
        $oConvTipo->addItemSelect('S', 'Metro Dim.');
        $oConvTipo->addItemSelect('P', 'Peça Dim.');

        $oConvPesoLq = new Campo('Peso Lq', 'pro_produtoconvpesoliq', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $oConvPesoBt = new Campo('Peso Bt', 'pro_produtoconvpesobruto', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $oProCod = new Campo('Prod.Controle', 'pro_convproduto', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oProCod->setClasseBusca('DELX_PRO_Produtos');
        $oProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getid());

        $this->addCampos($oConvCod, array($oUnidadeMedCod, $oUnidadeMedDes), $oFatorConv, $oConvPadrao, $oConvPesoBt, $oConvPesoLq, $oProCod);
    }

}
