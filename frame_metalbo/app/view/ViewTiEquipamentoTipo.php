<?php

/**
 * Description of ViewEquipamentoTiTipo
 *
 * @author Carlos
 */
class ViewTiEquipamentoTipo extends View {

    public function criaConsulta() {
        parent::criaConsulta();


        $this->getTela()->setILarguraGrid(1800);

        $oEquipTipCod = new CampoConsulta('Código', 'eqtipcod');
        $oEquipTipCod->setILargura(80);
        $oEquipDesc = new CampoConsulta('Descrição', 'eqtipdescricao');
        $oEquipDesc->setILargura(800);


        $oFilEqpDesc = new Filtro($oEquipDesc, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $this->addFiltro($oFilEqpDesc);

        $this->addCampos($oEquipTipCod, $oEquipDesc);
    }

    public function criaTela() {
        parent::criaTela();


        $oEquipDesc = new Campo('Tipo de equipamento', 'eqtipdescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $oEquipTipCod = new Campo('Código', 'eqtipcod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oEquipTipCod->setBCampoBloqueado(true);
        $oEquipTipCod->setBFocus(true);

        $this->addCampos(array($oEquipTipCod, $oEquipDesc));
    }

}
