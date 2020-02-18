<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 04/12/2018
 */

class ViewMET_TEC_Sequencia extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oSeqTab = new CampoConsulta('Sequencia Tabela', 'tec_sequenciatabela');
        $oSeqFil = new CampoConsulta('Sequencia Filial', 'tec_sequenciafilial');
        $oSeq = new CampoConsulta('Sequencia Número', 'tec_sequencianumero');

        $oDescricaofiltro = new Filtro($oSeqTab, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);
        $oCodigofiltro = new Filtro($oSeqFil, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigofiltro, $oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oSeqTab, $oSeqFil, $oSeq);
    }

    public function criaTela() {
        parent::criaTela();

        $oSeqTab = new Campo('Sequencia Tabela', 'tec_sequenciatabela', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSeqFil = new Campo('Sequencia Filial', 'tec_sequenciafilial', Campo::TIPO_DECIMAL, 2, 2, 12, 12);
        $oSeq = new Campo('Sequencia Número', 'tec_sequencianumero', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $this->addCampos(array($oSeqTab, $oSeqFil, $oSeq));
    }

}
