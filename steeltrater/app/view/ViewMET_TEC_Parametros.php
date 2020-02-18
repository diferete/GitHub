<?php

/*
 * Class que implementa as views do sistema
 * 
 * @author avanei martendal
 * @since 25/08/2017
 */

class ViewMET_TEC_Parametros extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->getTela()->setILarguraGrid(1200);

        $oCodigo = new CampoConsulta('Código', 'codigo');

        $oParam = new CampoConsulta('Parametro', 'parametro');
        $oValor = new CampoConsulta('Valor', 'valor');
        $oAplic = new CampoConsulta('Aplicação', 'aplicacao');

        $oFilParam = new Filtro($oParam, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);

        $this->addFiltro($oFilParam);
        $this->addCampos($oCodigo, $oParam, $oValor, $oAplic);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new campo('Código', 'codigo', Campo::TIPO_TEXTO, 1);
        $oCodigo->setBCampoBloqueado(true);
        $oParam = new campo('Parametro', 'parametro', Campo::TIPO_TEXTO, 6);
        $oParam->setBFocus(true);
        $oValor = new Campo('Valor', 'valor', Campo::TIPO_SELECT, 3);
        $oValor->addItemSelect('Sim', 'Sim');
        $oValor->addItemSelect('Não', 'Não');
        $oAplica = new Campo('Aplicação', 'aplicacao', Campo::TIPO_TEXTAREA, 6);



        $oFilcgc = new Campo('Empresa Padrão', 'filcgc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oFilcgc->setClasseBusca('EmpRex');
        $oFilcgc->setSCampoRetorno('filcgc', $this->getTela()->getId());


        $oOfficeCod = new Campo('Escritório Rep.', 'officecod', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oOfficeCod->setClasseBusca('RepOffice');
        $oOfficeCod->setSCampoRetorno('officecod', $this->getTela()->getId());

        $this->addCampos($oCodigo, $oParam, $oValor, $oAplica, $oOfficeCod, $oFilcgc);
    }

}
