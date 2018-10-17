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
        $this->getTela()->setBGridResponsivo(true);

        $oCaracteristicaCod = new CampoConsulta('Pro.Cod', 'pro_caracteristicacodigo', CampoConsulta::TIPO_TEXTO);

        $oCaracteristicaDes = new CampoConsulta('Característica', 'pro_caracteristicadescricao', CampoConsulta::TIPO_TEXTO);

        $oVlrCaracte = new CampoConsulta('Vlr.Caracte', 'pro_caracteristicavlrdefinidos', CampoConsulta::TIPO_TEXTO);

        $oFilCaractCod = new Filtro($oCaracteristicaCod, Filtro::CAMPO_TEXTO, 10, 10, 12, 12);
        $oFilCaractDes = new Filtro($oCaracteristicaDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);
        $oFilCaractDes2 = new Filtro($oCaracteristicaDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, true);
        $oFilCaractDes3 = new Filtro($oCaracteristicaDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);

        $this->addFiltro($oFilCaractCod, $oFilCaractDes, $oFilCaractDes2, $oFilCaractDes3);
        $this->addCampos($oCaracteristicaCod, $oCaracteristicaDes, $oVlrCaracte);
    }

    public function criaTela() {
        parent::criaTela();

        $this->setBGravaHistorico(true);

        $oCaracteristicaCod = new Campo('Pro.Cod', 'pro_caracteristicacodigo', Campo::TIPO_TEXTO);

        $oCaracteristicaDes = new Campo('Característica', 'pro_caracteristicadescricao', Campo::TIPO_TEXTO);

        $oVlrCaracte = new Campo('Vlr.Caracte', 'pro_caracteristicavlrdefinidos', Campo::TIPO_TEXTO);

        $oHistorico = new Campo('Alterações', 'historico', Campo::TIPO_HISTORICO);
        $oHistorico->setILinhasTextArea(4);
        $oHistorico->setApenasTela(true);

        $this->addCampos(array($oCaracteristicaCod, $oCaracteristicaDes, $oVlrCaracte), $oHistorico);
    }

}
