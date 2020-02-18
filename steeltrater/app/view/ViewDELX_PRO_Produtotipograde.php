<?php

/*
 * 
 * @author Alexandre W de Souza
 * @sice 25/09/2018 
 */

class ViewDELX_PRO_Produtotipograde extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oCodigo = new CampoConsulta('Pro.Cod.', 'pro_codigo', CampoConsulta::TIPO_TEXTO);

        $oTipoGradeCod = new CampoConsulta('Grade Cod.', 'pto_tipogradecodigo', CampoConsulta::TIPO_TEXTO);

        $oGradeBloq = new CampoConsulta('Grade Bloq.', 'pro_produtotipogradedtbloq', CampoConsulta::TIPO_DATA);

        $oGradeObrigatorio = new CampoConsulta('Obrigatório', 'pro_produtotipogradeobrigatori', CampoConsulta::TIPO_TEXTO);

        $oFilCod = new Filtro($oCodigo, Filtro::CAMPO_TEXTO);
        $oFilGradeCOd = new Filtro($oTipoGradeCod, Filtro::CAMPO_TEXTO);

        $this->addFiltro($oFilCod,$oFilGradeCOd);
        $this->addCampos($oCodigo, $oTipoGradeCod, $oGradeBloq, $oGradeObrigatorio);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Pro.Cod.', 'pro_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oTipoGradeCod = new Campo('Grade Cod.', 'pto_tipogradecodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oGradeBloq = new Campo('Grade Bloq.', 'pro_produtotipogradedtbloq', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oGradeBloq->setSValor(date('Y-m-d H:i:s'));

        $oGradeObrigatorio = new Campo('Obrigatório', 'pro_produtotipogradeobrigatori', Campo::TIPO_SELECT, 1, 1, 12, 12);
        $oGradeObrigatorio->addItemSelect('N', 'Não');
        $oGradeObrigatorio->addItemSelect('S', 'Sim');


        $this->addCampos($oCodigo, $oTipoGradeCod, $oGradeBloq, $oGradeObrigatorio);
    }

}
