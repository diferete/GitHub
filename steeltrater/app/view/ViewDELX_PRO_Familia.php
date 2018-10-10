<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ViewDELX_PRO_Familia extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Grupo', 'pro_grupocodigo');
        $oSubgrupo = new CampoConsulta('Sub.Grupo', 'pro_subgrupocodigo');
        $oFamilia = new CampoConsulta('Família', 'pro_familiacodigo');
        $oSubfamilia = new CampoConsulta('Descrição', 'pro_familiadescricao');

        $oDescricaofiltro = new Filtro($oSubfamilia, Filtro::CAMPO_TEXTO, 7);
        $oCodigoFiltro = new Filtro($oCodigo, Filtro::CAMPO_TEXTO);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigoFiltro, $oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);
        $this->addCampos($oCodigo, $oSubgrupo, $oFamilia, $oSubfamilia);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodigo = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSubgrupo = new Campo('Sub.Grupo', 'pro_subgrupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oFamilia = new Campo('Família', 'pro_familiacodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSubfamilia = new Campo('Descrição', 'pro_familiadescricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);

        $this->addCampos(array($oCodigo, $oSubgrupo, $oFamilia, $oSubfamilia));
    }

}
