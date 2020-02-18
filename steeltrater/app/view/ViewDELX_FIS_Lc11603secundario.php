<?php

/**
 * Implementa View da classe DELX_PRO_Lc110603secundario
 * @author Alexandre W de Souza
 * @since 26/09/2018
 * ** */
class ViewDELX_FIS_Lc11603secundario extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->getTela()->setILarguraGrid(2000);
        $this->getTela()->setBGridResponsivo(false);

        $oCodPrincipal = new CampoConsulta('Cod.Pri.', 'fis_lc11603principalcodigo');

        $oCodSecundario = new CampoConsulta('Cod.Sec.', 'fis_lc11603secundariocodigo');

        $oSecDescricao = new CampoConsulta('Descrição', 'fis_lc11603secundariodescricao');

        $oServico = new CampoConsulta('Serviço', 'fis_lc11603codigoservico');

        $oPercentual = new CampoConsulta('Percentual', 'fis_lc11603secundariopercentua');

        $oFilCodPrincipal = new Filtro($oCodPrincipal, Filtro::CAMPO_TEXTO);
        $oFilCodSecundario = new Filtro($oCodSecundario, Filtro::CAMPO_TEXTO);
        $oFilSecDesc = new Filtro($oSecDescricao, Filtro::CAMPO_TEXTO);

        $this->addFiltro($oFilCodPrincipal, $oFilCodSecundario, $oFilSecDesc);
        $this->addCampos($oCodPrincipal, $oCodSecundario, $oSecDescricao, $oServico, $oPercentual);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodPrincipal = new Campo('Cod.Pri.', 'fis_lc11603principalcodigo', Campo::TIPO_BUSCADOBANCOPK, 1, 1, 12, 12);
        $oCodPrincipal->setClasseBusca('DELX_FIS_Lc11603principal');
        $oCodPrincipal->setSCampoRetorno('fis_lc11603principalcodigo', $this->getTela()->getid());

        $oCodSecundario = new Campo('Cod.Sec.', 'fis_lc11603secundariocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oSecDescricao = new Campo('Descrição - Somente maíusculas', 'fis_lc11603secundariodescricao', Campo::TIPO_TEXTAREA, 12, 12, 12, 12);
        $oSecDescricao->setILinhasTextArea(3);

        $oServico = new Campo('Serviço', 'fis_lc11603codigoservico', Campo::TIPO_TEXTO, 1, 1, 12, 12);

        $oPercentual = new Campo('Percentual', 'fis_lc11603secundariopercentua', Campo::TIPO_DECIMAL, 2, 2, 12, 12);

        $this->addCampos(array($oCodPrincipal, $oCodSecundario), $oServico, $oPercentual, $oSecDescricao);
    }

}
