<?php

/*
 * 
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ViewDELX_PRO_Caracteristica extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoVisualizar(true);

        $oCaracteristicaCod = new CampoConsulta('Pro.Cod', 'pro_caracteristicacodigo', CampoConsulta::TIPO_TEXTO);

        $oCaracteristicaDes = new CampoConsulta('Característica', 'pro_caracteristicadescricao', CampoConsulta::TIPO_TEXTO);

        $oVlrCaracte = new CampoConsulta('Vlr.Caracte', 'pro_caracteristicavlrdefinidos', CampoConsulta::TIPO_TEXTO);

        $oFilCaractCod = new Filtro($oCaracteristicaCod, Filtro::CAMPO_TEXTO);
        $oFilCaractDes = new Filtro($oCaracteristicaDes, Filtro::CAMPO_TEXTO);

        $this->addFiltro($oFilCaractCod, $oFilCaractDes);
        $this->addCampos($oCaracteristicaCod, $oCaracteristicaDes, $oVlrCaracte);
    }

    public function criaTela() {
        parent::criaTela();

        $oCaracteristicaCod = new Campo('Pro.Cod', 'pro_caracteristicacodigo', Campo::TIPO_TEXTO);

        $oCaracteristicaDes = new Campo('Característica', 'pro_caracteristicadescricao', Campo::TIPO_TEXTO);

        $oVlrCaracte = new Campo('Vlr.Caracte', 'pro_caracteristicavlrdefinidos', Campo::TIPO_TEXTO);

        $this->addCampos(array($oCaracteristicaCod, $oCaracteristicaDes, $oVlrCaracte));
    }

}
