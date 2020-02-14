<?php

/**
 * Implementa View da classe
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class ViewDELX_PRO_Produtocoproduto extends View {

    public function criaConsulta() {
        parent::criaConsulta();
        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oSeq = new CampoConsulta('Seq.', 'pro_coprodutoseq', CampoConsulta::TIPO_TEXTO);
        $oCodigo = new CampoConsulta('Código', 'pro_codigo', CampoConsulta::TIPO_TEXTO);
        $oCoProCod = new CampoConsulta('Co-Prod.Cod.', 'pro_coprodutocodigo', CampoConsulta::TIPO_TEXTO);

        $oFilSeq = new Filtro($oSeq, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilCodigo = new Filtro($oCodigo, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);
        $oFilCoProCod = new Filtro($oCoProCod, Filtro::CAMPO_TEXTO, 1, 1, 12, 12, false);

        $this->addFiltro($oFilSeq, $oFilCodigo, $oFilCoProCod);
        $this->addCampos($oSeq, $oCodigo, $oCoProCod);
    }

    public function criaTela() {
        parent::criaTela();

        $oSeq = new Campo('Seq.', 'pro_coprodutoseq', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCodigo = new Campo('Código', 'pro_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oCoProCod = new Campo('Co-Prod.Cod.', 'pro_coprodutocodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oCoProCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo não pode estar em branco!', '0');

        $oCoProGrade = new Campo('Co-Prod.Grade', 'pro_coprodutograde', Campo::TIPO_BUSCADOBANCO, 2, 2, 12, 12);
        $oCoProGrade->setSIdPk($oCoProCod->getId());
        $oCoProGrade->setClasseBusca('DELX_PRO_Produtos');
        $oCoProGrade->addCampoBusca('pro_codigo', '', '');
        $oCoProGrade->addCampoBusca('pro_grade', '', '');
        $oCoProGrade->setSIdTela($this->getTela()->getid());
        $oCoProGrade->setBCampoBloqueado(true);

        $oCoProCod->setClasseBusca('DELX_PRO_Produtos');
        $oCoProCod->setSCampoRetorno('pro_codigo', $this->getTela()->getId());
        $oCoProCod->addCampoBusca('pro_grade', $oCoProGrade->getId(), $this->getTela()->getId());

        $oCoProQt = new Campo('Co-Prod.Qt.', 'pro_coprodutoquantidade', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $oCoProMotivo = new Campo('Motivo', 'pro_coprodutomotivo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCoProMotivo->setBCampoBloqueado(true);

        $this->addCampos(array($oSeq, $oCodigo), array($oCoProCod, $oCoProGrade), $oCoProQt, $oCoProMotivo);
    }

}
