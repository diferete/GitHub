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
        $this->setUsaAcaoVisualizar(true);

        $oNcmCod = new CampoConsulta('Cod.NCM', 'fis_ncmcodigo', CampoConsulta::TIPO_TEXTO);

        $oNcmDes = new CampoConsulta('Descrição', 'fis_ncmdescricao', CampoConsulta::TIPO_TEXTO);

        $oFilNCMCod = new Filtro($oNcmCod, Filtro::CAMPO_TEXTO, 3, 3, 3, 3);
        $oFilNCMDes = new Filtro($oNcmDes, Filtro::CAMPO_TEXTO, 5, 5, 5, 5);

        $this->addFiltro($oFilNCMCod, $oFilNCMDes);
        $this->addCampos($oNcmCod, $oNcmDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oNcmCod = new Campo('Cod.NCM', 'fis_ncmcodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oNcmCod->setBNCM(true);
        $oNcmCod->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', '1');

        $oNcmDes = new Campo('Descrição', 'fis_ncmdescricao', Campo::TIPO_TEXTAREA, 4, 4, 12, 12);
        $oNcmDes->setILinhasTextArea(3);

        $oLinha = new Campo('', 'linha', Campo::TIPO_LINHA, 12, 12, 12, 12);
        $oLinha->setApenasTela(true);

        $oCap = new Campo('Capítulo -  11 (11)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oCap->setApenasTela(true);

        $oPos = new Campo('Posição -  22 (1122)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oPos->setApenasTela(true);

        $oSubPos = new Campo('Subposição -  33 (1122.33)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oSubPos->setApenasTela(true);

        $oItem = new Campo('Item -  4 (1122.33.4)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oItem->setApenasTela(true);

        $oSubItem = new Campo('Subitem -  5 (1122.33.45)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oSubItem->setApenasTela(true);

        $oExcecao = new Campo('Exceção -  666 (1122.33.45-666)', 'cap', Campo::TIPO_LABEL, 3, 3, 12, 12);
        $oExcecao->setApenasTela(true);

        $this->addCampos($oNcmCod, $oNcmDes, $oLinha, $oCap, $oPos, $oSubPos, $oItem, $oSubItem, $oExcecao);
    }

}
