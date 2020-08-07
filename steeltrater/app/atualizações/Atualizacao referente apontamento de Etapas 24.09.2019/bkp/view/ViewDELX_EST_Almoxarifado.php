<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 23/10/2018
 */

class ViewDELX_EST_Almoxarifado extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodAlm = new CampoConsulta('Almoxarifado Cód.', 'est_almoxarifadocodigo');
        $oDescAlm = new CampoConsulta('Descrição', 'est_almoxarifadodescricao');
        $oCodigofiltro = new Filtro($oCodAlm,Filtro::CAMPO_TEXTO_IGUAL,3);
        $oDescricaofiltro = new Filtro($oDescAlm, Filtro::CAMPO_TEXTO, 2);

        $this->setUsaAcaoExcluir(true);
        $this->setUsaAcaoAlterar(true);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigofiltro,$oDescricaofiltro);
        
        $this->addCampos($oCodAlm,$oDescAlm);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodAlm = new Campo('Almoxarifado Cód.', 'est_almoxarifadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescAlm = new Campo('Descrição', 'est_almoxarifadodescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
     
        $this->addCampos(array($oCodAlm,$oDescAlm));
    }

}
