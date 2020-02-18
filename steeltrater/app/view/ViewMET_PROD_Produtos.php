<?php

/*
 * Classe que implementa os models da DELX_CAD_Pessoa
 * 
 * @author Cleverton Hoffmann
 * @since 13/06/2018
 */

class ViewMET_PROD_Produtos extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $oCodigo = new CampoConsulta('Código', 'pro_codigo');
        $oDescricao = new CampoConsulta('Descrição', 'pro_descricao');
        $oDescricaofiltro = new Filtro($oDescricao, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);
        $oUnidademedida = new CampoConsulta('Unidade de Medida', 'pro_unidademedida');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(TRUE);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oCodigo, $oDescricao, $oUnidademedida);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Código', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCodigo->setSCorFundo(Campo::FUNDO_AMARELO);
        $oDescricao = new Campo('Descrição', 'pro_descricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oDescricao->setSCorFundo(Campo::FUNDO_AMARELO);
        $oUnidademedida = new Campo('Un', 'pro_unidademedida', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUnidademedida->setSCorFundo(Campo::FUNDO_AMARELO);

        $this->addCampos(array($oCodigo, $oDescricao, $oUnidademedida));
    }

}
