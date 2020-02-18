<?php

/*
 * Implementa classe
 * 
 * @author Alexandre W. de Souza
 * @since 24/09/2018
 * * */

class ViewDELX_FIS_Generoitem extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oGeneroItemCod = new CampoConsulta('Cod.Genero Item', 'fis_generoitemcodigo', CampoConsulta::TIPO_TEXTO);

        $oGeneroItemDes = new CampoConsulta('Descrição', 'fis_generoitemdescricao', CampoConsulta::TIPO_TEXTO);

        $oFilGeneroItemCod = new Filtro($oGeneroItemCod, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFilGeneroItemDes = new Filtro($oGeneroItemDes, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->addFiltro($oFilGeneroItemCod, $oFilGeneroItemDes);
        $this->addCampos($oGeneroItemCod, $oGeneroItemDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oGeneroItemCod = new Campo('Cod.Genero Item', 'fis_generoitemcodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oGeneroItemDes = new Campo('Descrição', 'fis_generoitemdescricao', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oGeneroItemDes->setILinhasTextArea(3);

        $this->addCampos($oGeneroItemCod, $oGeneroItemDes);
    }

}
