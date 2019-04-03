<?php

class ViewMET_CAD_Setores extends View {

    public function criaTela() {
        parent::criaTela();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oCodSetor = new CampoConsulta('Código', 'codsetor');
        $oDescSetor = new CampoConsulta('Descrição', 'descsetor');

        $this->addCampos($oCodSetor, $oDescSetor);
    }

}
