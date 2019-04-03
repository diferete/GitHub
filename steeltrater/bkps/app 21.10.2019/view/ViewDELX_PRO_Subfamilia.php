<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ViewDELX_PRO_Subfamilia extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Grupo', 'pro_grupocodigo');
        $oSubgrupo = new CampoConsulta('Sub.Grupo', 'pro_subgrupocodigo');
        $oFamilia = new CampoConsulta('Família', 'pro_familiacodigo');
        $oSubfamilia = new CampoConsulta('Sub.Família', 'pro_subfamiliacodigo');
        $oDescricao = new CampoConsulta('Descrição', 'pro_subfamiliadescricao');
        $oDescricaofiltro = new Filtro($oDescricao, Filtro::CAMPO_TEXTO,7);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(TRUE);
        $this->addCampos($oCodigo, $oSubgrupo, $oFamilia, $oSubfamilia, $oDescricao);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodigo = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSubgrupo = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oFamilia = new Campo('Família', 'pro_familiacodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSubfamilia = new Campo('Sub.Família', 'pro_subfamiliacodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescricao = new Campo('Descrição', 'pro_subfamiliadescricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);

        $this->addCampos(array($oCodigo, $oSubgrupo, $oFamilia, $oSubfamilia,$oDescricao));
    }

}
