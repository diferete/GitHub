<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 04/07/2018
 */

class ViewDELX_MOT_Motivo extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'mot_motivocodigo');
        $oTip = new CampoConsulta('Tipo', 'mot_motivotipo');
        $oDes = new CampoConsulta('Descrição', 'mot_motivodescricao');

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);

        $this->setBScrollInf(false);
        $this->addCampos($oCod,$oTip,$oDes);
    }

    public function criaTela() {
        parent::criaTela();

        $oCod = new Campo('Código', 'mot_motivocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oTip = new Campo('Tipo', 'mot_motivotipo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Código', 'mot_motivodescricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);

        $this->addCampos(array($oCod,$oTip,$oDes));
    }

}
