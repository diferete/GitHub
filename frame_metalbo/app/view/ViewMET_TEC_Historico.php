<?php

/**
 * Implementa view da classe MET_TEC_Historico
 * @author Alexandre W de Souza
 * @since 09/10/2018
 * ** */
class ViewMET_TEC_Historico extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoVisualizar(true);
        $this->setUsaAcaoIncluir(false);

        $this->setBScrollInf(false);
        $this->getTela()->setBUsaCarrGrid(true);

        $oSeq = new CampoConsulta('Seq.', 'seq');

        $oUsuario = new CampoConsulta('Usuário', 'usunome');

        $oData = new CampoConsulta('Data', 'data', CampoConsulta::TIPO_DATA);

        $oHora = new CampoConsulta('Hora', 'hora');

        $oClasse = new CampoConsulta('Classe', 'classe');


        $oFilSeq = new Filtro($oSeq, Filtro::CAMPO_INTEIRO, 2, 2, 12, 12);
        $oFilClasse = new Filtro($oClasse, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);
        $oFilUsuario = new Filtro($oUsuario, Filtro::CAMPO_TEXTO, 2, 2, 12, 12);


        $this->addFiltro($oFilSeq, $oFilClasse, $oFilUsuario);
        $this->addCampos($oSeq, $oClasse, $oUsuario, $oData, $oHora);
    }

    public function criaTela() {
        parent::criaTela();

        $oSeq = new Campo('Seq.', 'seq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSeq->setBCampoBloqueado(true);

        $oUsuCodigo = new Campo('Usuário', 'usucodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oUsuCodigo->setBCampoBloqueado(true);

        $oUsuNome = new Campo('Usuário', 'usunome', Campo::TIPO_TEXTO, 3, 3, 12, 12);
        $oUsuNome->setBCampoBloqueado(true);

        $oData = new Campo('Data', 'data', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oData->setBCampoBloqueado(true);

        $oHora = new Campo('Hora', 'hora', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oHora->setBCampoBloqueado(true);

        $oClasse = new Campo('Classe', 'classe', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oClasse->setBCampoBloqueado(true);

        $oHistorico = new Campo('Alterações', 'historico', Campo::TIPO_HISTORICO, 5, 5, 12, 12);
        $oHistorico->setILinhasTextArea(4);
        $oHistorico->setBCampoBloqueado(true);

        $this->addCampos(array($oSeq, $oData, $oHora), array($oClasse, $oUsuCodigo, $oUsuNome), $oHistorico);
    }

}
