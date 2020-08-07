<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 18/06/2018
 */

class ViewDELX_CID_Pais extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Código', 'cid_paiscodigo');
        $oPais = new CampoConsulta('País','cid_paisdescricao');
        $oCep = new CampoConsulta ('CEP','cid_paisusacep');
        $oIbge = new CampoConsulta('IBGE', 'cid_paisibge');
        $oDescricaofiltro = new Filtro($oPais, Filtro::CAMPO_TEXTO,7);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCodigo, $oPais, $oCep, $oIbge);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodigo = new Campo('Código', 'cid_paiscodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oPais = new Campo('País','cid_paisdescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oCep = new Campo('CEP','cid_paisusacep', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oIbge = new Campo('IBGE', 'cid_paisibge', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCodigo, $oPais, $oCep, $oIbge));
    }

}