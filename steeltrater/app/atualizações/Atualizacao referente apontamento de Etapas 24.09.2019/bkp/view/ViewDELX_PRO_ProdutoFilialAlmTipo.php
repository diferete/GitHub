<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 24/09/2018
 */

class ViewDELX_PRO_ProdutoFilialAlmTipo extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oAlmCod = new CampoConsulta('Almoxarifado', 'est_almoxarifadocodigo');
        $oAlmDes = new CampoConsulta('Descrição do Almoxarifado', 'est_almoxarifadodescricao');
        $oSigla = new CampoConsulta('Sigla', 'est_almoxarifadosigla');
        $oAlmTip = new CampoConsulta('Tipo', 'est_almoxarifadotipo');
        $oFiltroDes = new Filtro($oAlmDes, Filtro::CAMPO_TEXTO, 5);
        
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(true);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oFiltroDes);

        $this->setBScrollInf(false);
        $this->addCampos($oAlmCod,$oAlmDes,$oSigla,$oAlmTip);
    }

    public function criaTela() {
        parent::criaTela();

        $oAlmCod = new Campo('Almoxarifado', 'est_almoxarifadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAlmDes = new Campo('Descrição do Almoxarifado', 'est_almoxarifadodescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oSigla = new Campo('Sigla', 'est_almoxarifadosigla', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oAlmTip = new Campo('Tipo', 'est_almoxarifadotipo', Campo::TIPO_SELECT, 3, 3, 12, 12);
        $oAlmTip->addItemSelect('A','Todos');
        /*$oAlmTip->addItemSelect(' ','Padrão');
        $oAlmTip->addItemSelect(' ','Nosso em poder de terceiros');
        $oAlmTip->addItemSelect(' ','De terceiros em nosso poder');
        $oAlmTip->addItemSelect(' ','Reserva ordem de fabricação');
        $oAlmTip->addItemSelect(' ','Reserva assistencia técnica');
        $oAlmTip->addItemSelect(' ','Em inspeção de qualidade');
        $oAlmTip->addItemSelect(' ','Regeitados em inspeção de qualidade');
        $oAlmTip->addItemSelect(' ','Bloqueado'); /////////////////////////TERMINAR FAZER
        */
        $this->addCampos(array($oAlmCod,$oAlmDes,$oSigla,$oAlmTip));
    }

}
