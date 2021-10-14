<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewSTEEL_CCT_CentroCusto
 *
 * @author Alexandre
 */
class ViewSTEEL_CCT_CentroCusto extends View {

    public function __construct() {
        parent::__construct();
    }

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaFiltro(true);
        $this->getTela()->setBMostraFiltro(true);

        $oCCT_Codigo = new CampoConsulta('Código', 'cct_codigo');
        $oCCT_Descricao = new CampoConsulta('Descricao', 'cct_descricao');

        $oFIL_CCT_Codigo = new Filtro($oCCT_Codigo, Filtro::CAMPO_TEXTO, 1, 1, 12, 12);

        $this->addFiltro($oFIL_CCT_Codigo);

        $this->addCampos($oCCT_Codigo, $oCCT_Descricao);
    }

    public function criaTela() {
        parent::criaTela();

        $sCod = $this->getAParametrosExtras();

        $oCCT_Codigo = new Campo('Código', 'cct_codigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCCT_Codigo->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 8, 12);
        $oCCT_Codigo->setBFocus(true);

        $oCCT_Descricao = new Campo('Descrição', 'cct_descricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oCCT_Descricao->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 5, 60);
        $oCCT_Descricao->setBUpperCase(true);

        $oOldCod = new Campo('', 'cod', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oOldCod->setApenasTela(true);
        $oOldCod->setSValor($sCod);
        $oOldCod->setBOculto(true);

        $oCCT_Classificacao = new Campo('Classificação', 'CCT_Classificacao', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCCT_Classificacao->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório', 9, 60);

        $oCCT_Tipo = new Campo('Tipo', 'CCT_Tipo', Campo::CAMPO_SELECTSIMPLE, 1, 1, 12, 12);
        $oCCT_Tipo->addItemSelect('A', 'Analítico');
        $oCCT_Tipo->addItemSelect('S', 'Sintético');

        $oCCT_DtInicialVigencia = new Campo('Dt.Ini Vigência', 'CCT_VigenciaInicial', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oCCT_DtInicialVigencia->setSValor(date('d/m/Y'));
        $oCCT_DtInicialVigencia->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório');


        $oCCT_DtFinalVigencia = new Campo('Dt.Fim Vigência', 'CCT_VigenciaFinal', Campo::TIPO_DATA, 2, 2, 12, 12);
        $oCCT_DtFinalVigencia->addValidacao(false, Validacao::TIPO_STRING, 'Campo obrigatório');

        $oCCT_QuantMesFechamento = new Campo('Quantidade de meses para cálculo automático no fechamento', 'CCT_QtdMesesMedia', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oCCT_QuantMesFechamento->setSValor('0');

        $this->addCampos($oOldCod, array($oCCT_Codigo, $oCCT_Descricao), array($oCCT_Classificacao, $oCCT_Tipo), array($oCCT_DtInicialVigencia, $oCCT_DtFinalVigencia), $oCCT_QuantMesFechamento);
    }

}
