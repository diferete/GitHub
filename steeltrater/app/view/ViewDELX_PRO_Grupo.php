<?php

/*
 * Classe que implementa as views 
 * 
 * @author Cleverton Hoffmann
 * @since 15/06/2018
 */

class ViewDELX_PRO_Grupo extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oCodigo = new CampoConsulta('Grupo', 'pro_grupocodigo');
        $oGrupo = new CampoConsulta('Descrição', 'pro_grupodescricao');
        $oDescricaofiltro = new Filtro($oGrupo, Filtro::CAMPO_TEXTO, 5, 5, 12, 12, false);

        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoAlterar(false);
        $this->setUsaAcaoIncluir(false);
        $this->setUsaAcaoVisualizar(true);
        $this->addFiltro($oDescricaofiltro);

        $this->setBScrollInf(FALSE);
        $this->addCampos($oCodigo, $oGrupo);
    }

    public function criaTela() {
        parent::criaTela();

        $oCodigo = new Campo('Grupo', 'pro_grupocodigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);
        $oGrupo = new Campo('Descrição', 'pro_grupodescricao', Campo::TIPO_TEXTO, 5, 5, 12, 12);

        $this->addCampos(array($oCodigo, $oGrupo));
    }

}
