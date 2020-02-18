<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 26/06/2018
 */

class ViewDELX_CID_IbgeCidade extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Cod.Cidade', 'cid_ibgecidadecodigo');
        $oDes = new CampoConsulta('Cidade', 'cid_ibgecidadedescricao');
        $oCodigofiltro = new Filtro($oCod, Filtro::CAMPO_TEXTO_IGUAL, 5, 5, 12, 12, false);
        $oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oCodigofiltro, $oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Cod.CidadeIBGE', 'cid_ibgecidadecodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oDes = new Campo('Cidade', 'cid_ibgecidadedescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $this->addCampos(array($oCod, $oDes));
    }

}
