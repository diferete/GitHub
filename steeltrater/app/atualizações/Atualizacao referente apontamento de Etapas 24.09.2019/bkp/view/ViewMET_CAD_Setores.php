<?php

class ViewMET_CAD_Setores extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oCodSetor = new CampoConsulta('Código', 'codsetor');
        $oDescSetor = new CampoConsulta('Descrição', 'descsetor');

        $this->setUsaAcaoVisualizar(true);
        $this->addCampos($oCodSetor, $oDescSetor);
    }
    
    public function criaTela() {
        parent::criaTela();
        
        $oCod = new Campo('Codigo', 'codsetor', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCod->setBCampoBloqueado(true);
        $oDes = new Campo('Descrição', 'descsetor', Campo::TIPO_TEXTO, 6, 6, 12, 12);
        $oTip = new Campo('Tipo Construção', 'tipoconst', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oPis = new Campo('Piso', 'piso', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oTel = new Campo('Telhado', 'telhado', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oVen = new Campo('Ventilaçao', 'vent', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oIlu = new Campo('Iluminação', 'ilumin', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        $oObs = new Campo('Observação', 'obsSetor', Campo::TIPO_TEXTAREA, 8, 8, 12, 12);
        
        $this->addCampos(array($oCod,$oDes),$oTip,$oPis,$oTel,$oVen,$oIlu,$oIlu,$oObs);
    }

}
