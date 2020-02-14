<?php

/**
 * Implementa view da classe DELX_PRO_Principioativo
 * 
 * @author Alexandre W de Souza
 * @since 08/10/2018
 * ** */
class ViewDELX_PRO_Principioativo extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $oPrincAtivoSeq = new CampoConsulta('Seq.', 'pro_principioativoseq');
        $oPrincAtivoDesc = new CampoConsulta('Descrição', 'pro_principioativodescricao');

        $oFilSeq = new Filtro($oPrincAtivoSeq, Filtro::CAMPO_TEXTO, 2, 2, 12, 12, false);
        $oFilDesc = new Filtro($oPrincAtivoDesc, Filtro::CAMPO_TEXTO, 4, 4, 12, 12, false);

        $this->addFiltro($oFilSeq, $oFilDesc);
        $this->addCampos($oPrincAtivoSeq, $oPrincAtivoDesc);
    }

    public function criaTela() {
        parent::criaTela();

        $oPrincAtivoSeq = new Campo('Seq.', 'pro_principioativoseq', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oPrincAtivoSeq->setBCampoBloqueado(true);

        $oPrincAtivoDesc = new Campo('Descrição', 'pro_principioativodescricao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $this->addCampos($oPrincAtivoSeq, $oPrincAtivoDesc);
    }

}
