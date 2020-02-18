<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class ViewDELX_PRO_Subgrupo extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Grupo', 'pro_grupocodigo');
        $oSubgrupo = new CampoConsulta('Sub.Grupo', 'pro_subgrupocodigo');
        $oDescricao = new CampoConsulta('Descrição', 'pro_subgrupodescricao');
        $oDescricaofiltro = new Filtro($oDescricao, Filtro::CAMPO_TEXTO, 7, 7, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(FALSE);
        $this->addCampos($oCodigo, $oSubgrupo, $oDescricao);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSubgrupo = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDescricao = new Campo('Descrição', 'pro_subgrupodescricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);

        $this->addCampos(array($oCodigo, $oSubgrupo, $oDescricao));
    }

}
