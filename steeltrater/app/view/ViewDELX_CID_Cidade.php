<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ViewDELX_CID_Cidade extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPais = new CampoConsulta('Cod.País', 'cid_paiscodigo');
        $oCodcidade = new CampoConsulta('Cod.Cidade', 'cid_codigo');
        $oEstado = new CampoConsulta('Estado', 'cid_estadocodigo');
        $oCidade = new CampoConsulta('Cidade', 'cid_descricao');
        $oIBGE = new CampoConsulta('Cod.IBGE', 'cid_cidadecodibge');
        $oDescricaofiltro = new Filtro($oCidade, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);
        $oCodigofiltro = new Filtro($oCodcidade, Filtro::CAMPO_TEXTO_IGUAL, 3, 3, 12, 12, false);
        $oEstadofiltro = new Filtro($oEstado, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigofiltro, $oDescricaofiltro, $oEstadofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oPais, $oCodcidade, $oEstado, $oCidade, $oIBGE);
    }

    public function criaTela() {
        parent::criaTela();


        $oPais = new Campo('Cod.País', 'cid_paiscodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodcidade = new Campo('Cod.Cidade', 'cid_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oEstado = new Campo('Estado', 'cid_estadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCidade = new Campo('Cidade', 'cid_descricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oIBGE = new Campo('Cod.IBGE', 'cid_cidadecodibge', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oPais, $oEstado, $oCodcidade, $oCidade, $oIBGE));
    }

}
