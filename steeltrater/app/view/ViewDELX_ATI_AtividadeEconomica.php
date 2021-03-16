<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 27/06/2018
 */

class ViewDELX_ATI_AtividadeEconomica extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'ati_codigo');
        $oDes = new CampoConsulta('Descrição', 'ati_descricao');
        $oCla = new CampoConsulta('Cod.Class', 'ati_atividadeeconomicacodclass');
        $oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes, $oCla);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Código', 'ati_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Descrição', 'ati_descricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCla = new Campo('Cod.Class', 'ati_atividadeeconomicacodclass', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCod, $oDes, $oCla));
    }

}
