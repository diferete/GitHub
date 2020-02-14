<?php

/*
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * */

class ViewDELX_FIS_Lc11603principal extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oPrincipalCod = new CampoConsulta('Cod.Principal', 'fis_lc11603principalcodigo', CampoConsulta::TIPO_TEXTO);

        $oPrincipalDes = new CampoConsulta('Descrição', 'fis_lc11603principaldescricao', CampoConsulta::TIPO_TEXTO);

        $oFilPrincipalCod = new Filtro($oPrincipalCod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFilPrincipalDes = new Filtro($oPrincipalDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFilPrincipalCod, $oFilPrincipalDes);
        $this->addCampos($oPrincipalCod, $oPrincipalDes);
    }

    public function criaTela() {
        parent::criaTela();


        $oPrincipalCod = new Campo('Cod.Principal', 'fis_lc11603principalcodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oPrincipalDes = new Campo('Descrição', 'fis_lc11603principaldescricao', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oPrincipalDes->setILinhasTextArea(3);

        $this->addCampos($oPrincipalCod, $oPrincipalDes);
    }

}
