<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ViewDELX_CID_Estado extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodpais = new CampoConsulta('Cod.país', 'cid_paiscodigo');
        $oCodestado = new CampoConsulta('Cod.Estado', 'cid_estadocodigo');
        $oDescricao = new CampoConsulta('Descrição', 'cid_estadodescricao');
        $oIbge = new CampoConsulta('IBGE', 'cid_estadoibge');
        $oIntra = new CampoConsulta('Aliquota Intra.', 'cid_estadoaliquotaintra');
        $oInter = new CampoConsulta('Aliquota Inter.', 'cid_estadoaliquotainter');
        $oDescricaofiltro = new Filtro($oDescricao, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCodpais, $oCodestado, $oDescricao, $oIbge, $oIntra, $oInter);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodpais = new Campo('Cod.país', 'cid_paiscodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oCodestado = new Campo('Cod.Estado', 'cid_estadocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDescricao = new Campo('Descrição', 'cid_estadodescricao', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oIbge = new Campo('IBGE', 'cid_estadoibge', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oIntra = new Campo('Aliquota Intra', 'cid_estadoaliquotaintra', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oInter = new Campo('Aliquota Inter', 'cid_estadoaliquotainter', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $this->addCampos(array($oCodpais, $oCodestado, $oDescricao, $oIbge, $oIntra, $oInter));
    }

}
