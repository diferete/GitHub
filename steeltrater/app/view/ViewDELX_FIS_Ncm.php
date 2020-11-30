<?php

/*
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * */

class ViewDELX_FIS_Ncm extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oNcmCod = new CampoConsulta('Cod.NCM', 'fis_ncmcodigo', CampoConsulta::TIPO_TEXTO);

        $oNcmDes = new CampoConsulta('Descrição', 'fis_ncmdescricao', CampoConsulta::TIPO_TEXTO);

        $oFilNCMCod = new Filtro($oNcmCod, Filtro::CAMPO_TEXTO,3,3,3,3);
        $oFilNCMDes = new Filtro($oNcmDes, Filtro::CAMPO_TEXTO,5,5,5,5);

        $this->addFiltro($oFilNCMCod, $oFilNCMDes);
        $this->addCampos($oNcmCod, $oNcmDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oNcmCod = new Campo('Cod.NCM', 'fis_ncmcodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oNcmDes = new Campo('Descrição', 'fis_ncmdescricao', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oNcmDes->setILinhasTextArea(3);

        $this->addCampos($oNcmCod, $oNcmDes);
    }

}
