<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ViewDELX_MOE_Moeda extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.', 'moe_codigo');
        $oDes = new CampoConsulta('Descrição', 'moe_descricao');
        $oPad = new CampoConsulta('Padrão', 'moe_padrao');
        $oSim = new CampoConsulta('Símbolo', 'moe_simbolo');
        $oSing = new CampoConsulta('Des.Singular', 'moe_descricaosingular');
        $oPlur = new CampoConsulta('Des.Plural', 'moe_descricaoplural');


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);


        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes, $oPad, $oSim, $oSing, $oPlur);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Cod.', 'moe_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Descrição', 'moe_descricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPad = new Campo('Padrão', 'moe_padrao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSim = new Campo('Símbolo', 'moe_simbolo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSing = new Campo('Des.Singular', 'moe_descricaosingular', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPlur = new Campo('Des.Plural', 'moe_descricaoplural', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod, $oDes, $oPad, $oSim, $oSing, $oPlur));
    }

}
