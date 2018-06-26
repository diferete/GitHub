<?php

class ViewSetor extends View {

    public function criaTela() {
        parent::criaTela();
    }

    public function criaConsulta() {
        parent::criaConsulta();
              

        $oCodSetor = new CampoConsulta('Código', 'codsetor');
        $oDescSetor = new CampoConsulta('Descrição', 'descsetor');

        $oFilSetor = new Filtro($oDescSetor, Filtro::CAMPO_TEXTO,4,4,12,12);

        $this->addFiltro($oFilSetor);        
        $this->addCampos($oCodSetor, $oDescSetor);
        
    }

}
