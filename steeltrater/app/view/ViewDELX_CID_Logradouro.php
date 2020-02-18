<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 19/06/2018
 */

class ViewDELX_CID_Logradouro extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPaiscodigo = new CampoConsulta('Cod.País', 'cid_paiscodigo');
        $oCep = new CampoConsulta('CEP', 'cid_logradourocep');
        $oRua = new CampoConsulta('Rua', 'cid_logradourorua');
        $oCidade = new CampoConsulta('Cidade', 'cid_logradourobairro');
        $oCidadecodigo = new CampoConsulta('Cod.Cidade', 'cid_logradourocidadecodigo');
        $oCepfiltro = new Filtro($oCep, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oRuafiltro = new Filtro($oRua, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);
        $oCidadefiltro = new Filtro($oCidade, Filtro::CAMPO_TEXTO, 3, 3, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCepfiltro, $oCidadefiltro, $oRuafiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oPaiscodigo, $oCep, $oRua, $oCidade, $oCidadecodigo);
    }

    public function criaTela() {
        parent::criaTela();


        $oPaiscodigo = new Campo('Cod.País', 'cid_paiscodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oCep = new Campo('CEP', 'cid_logradourocep', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oRua = new Campo('Rua', 'cid_logradourorua', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oCidade = new Campo('Cidade', 'cid_logradourobairro', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCidadecodigo = new Campo('Cod.Cidade', 'cid_logradourocidadecodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $this->addCampos(array($oPaiscodigo, $oCep, $oRua, $oCidade, $oCidadecodigo));
    }

}
