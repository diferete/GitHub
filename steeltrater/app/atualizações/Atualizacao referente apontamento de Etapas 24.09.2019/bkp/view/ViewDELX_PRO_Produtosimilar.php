<?php

/*
 * @author Alexandre W de Souza
 * @since 25/09/2018
 */

class ViewDELX_PRO_Produtosimilar extends View {

    public function criaConsulta() {
        parent::criaConsulta();

        $this->setBScrollInf(false);
        $this->setBUsaCarrGrid(true);
        $this->setUsaAcaoExcluir(false);
        $this->setUsaAcaoVisualizar(true);

        $oCodigo = new CampoConsulta('Cod.Prod.', 'pro_codigo', CampoConsulta::TIPO_TEXTO);
        $oCodSimilar = new CampoConsulta('Cod.Similar', 'pro_similarcodigo', CampoConsulta::TIPO_TEXTO);
        $oSimilarObs = new CampoConsulta('Obs.', 'pro_similarobservacao', CampoConsulta::TIPO_TEXTO);

        $oFilCod = new Filtro($oCodigo, Filtro::CAMPO_TEXTO);
        $oFilCodSim = new Filtro($oCodSimilar, Filtro::CAMPO_TEXTO);

        $this->addFiltro($oFilCod, $oFilCodSim);
        $this->addCampos($oCodigo, $oCodSimilar, $oSimilarObs);
    }

    public function criaTela() {
        parent::criaTela();


        $oCodigo = new Campo('Cod.Prod.', 'pro_codigo', Campo::TIPO_TEXTO, 2, 2, 12, 12);

        $oSimilarCod = new Campo('Cod.Similar', 'pro_similarcodigo', Campo::TIPO_BUSCADOBANCOPK, 2, 2, 12, 12);
        $oSimilarCod->setClasseBusca('DELX_PRO_Produtos');
        $oSimilarCod->setSCampoRetorno('pro_codigo', $this->getTela()->getid());

        $oSimilarDes = new Campo('Des.do Similar', '', Campo::TIPO_TEXTO, 4, 4, 12, 12);
        $oSimilarDes->setBCampoBloqueado(true);
        $oSimilarDes->setApenasTela(true);

        $oSimilarUn = new Campo('Un.Medida', '', Campo::TIPO_TEXTO, 1, 1, 12, 12);
        $oSimilarUn->setBCampoBloqueado(true);
        $oSimilarUn->setApenasTela(true);

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","DELX_PRO_Produtosimilar","buscaDados","' . $oSimilarDes->getId() . ',' . $oSimilarUn->getId() . '");';

        $oSimilarCod->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oSimilarObs = new Campo('Obs.', 'pro_similarobservacao', Campo::TIPO_TEXTO, 4, 4, 12, 12);

        $this->addCampos($oCodigo, $oSimilarCod, array($oSimilarDes, $oSimilarUn), $oSimilarObs);
    }

}
