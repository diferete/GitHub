<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 25/06/2018
 */

class ViewDELX_NFS_TipoMovimento extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCod = new CampoConsulta('Código', 'nfs_tipomovimentocodigo');
        $oDes = new CampoConsulta('Descrição', 'nfs_tipomovimentodescricao');
        $oDescricaofiltro = new Filtro($oDes, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);


        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(false);
        $this->addCampos($oCod, $oDes);
    }

    public function criaTela() {
        parent::criaTela();


        $oCod = new Campo('Código', 'nfs_tipomovimentocodigo', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oDes = new Campo('Descrição', 'nfs_tipomovimentodescricao', Campo::TIPO_TEXTO, 3, 3, 12, 12);


        $this->addCampos(array($oCod, $oDes));
    }

}
