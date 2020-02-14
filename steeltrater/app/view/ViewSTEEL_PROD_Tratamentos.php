<?php

/*
 * Implementa a view da produção da metalbo
 * 
 * @Author Avanei Martendal
 * @since 31/05/2018
 */

class ViewSTEEL_PROD_Tratamentos extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $oTratCod = new CampoConsulta('Código', 'tratcod');
        $oTratDes = new CampoConsulta('Tratamento', 'tratdes');

        $oFiltro1 = new Filtro($oTratDes, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);

        $this->addFiltro($oFiltro1);

        $this->addCampos($oTratCod, $oTratDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oTratCod = new Campo('Código', 'tratcod', Campo::TIPO_TEXTO, 1);
        $oTratDes = new Campo('Tratamento', 'tratdes', Campo::TIPO_TEXTAREA, 8);

        $this->addCampos($oTratCod, $oTratDes);
    }

}
