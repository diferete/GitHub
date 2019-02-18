<?php

/*
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * * */

class ViewDELX_FIS_Cnae extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oCnaeCod = new CampoConsulta('Cod.Cnae', 'fis_cnaecodigo', CampoConsulta::TIPO_TEXTO);

        $oCnaeDes = new CampoConsulta('Descrição', 'fis_cnaedescricao', CampoConsulta::TIPO_TEXTO);

        $oFilCNAECod = new Filtro($oCnaeCod, Filtro::CAMPO_TEXTO);
        $oFilCNAEDes = new Filtro($oCnaeDes, Filtro::CAMPO_TEXTO);

        $this->addFiltro($oFilCNAECod, $oFilCNAEDes);
        $this->addCampos($oCnaeCod, $oCnaeDes);
    }

    public function criaTela() {
        parent::criaTela();
        
        $oCnaeCod = new Campo('Cod.Cnae', 'fis_cnaecodigo', Campo::TIPO_TEXTO,1,1,12,12);

        $oCnaeDes = new Campo('Descrição', 'fis_cnaedescricao', Campo::TIPO_TEXTAREA,4,4,12,12);
        $oCnaeDes->setILinhasTextArea(3);

        $this->addCampos($oCnaeCod, $oCnaeDes);
    }

}
