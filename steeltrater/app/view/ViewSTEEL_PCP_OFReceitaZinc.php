<?php

/*
 * Classe de alteração da receita zincagem na ordens fabricação
 * @author Cleverton Hoffmann
 * @since 25/02/2021
 */

class ViewSTEEL_PCP_OFReceitaZinc extends View {

    public function criaTela() {
        parent::criaTela();

        $oOp = new Campo('Op nr.', 'op', Campo::TIPO_TEXTO, 1);
        $oOp->setBCampoBloqueado(true);

        $oReceitaZinc = new Campo('Cod. Receita Zincagem', 'receita_zinc', Campo::TIPO_BUSCADOBANCOPK, 2);
        $oReceitaZinc->setId('Zincar');

        $oReceitaZincDes = new Campo('Des.Rec.Zincagem', 'receita_zincdesc', Campo::TIPO_BUSCADOBANCO, 5);
        $oReceitaZincDes->setBOculto(true);
        $oReceitaZincDes->setSIdPk($oReceitaZinc->getId());
        $oReceitaZincDes->setClasseBusca('STEEL_PCP_Receitas');
        $oReceitaZincDes->addCampoBusca('cod', '', '');
        $oReceitaZincDes->addCampoBusca('peca', '', '');
        $oReceitaZincDes->setSIdTela($this->getTela()->getId());
        $oReceitaZincDes->setId('ZincarDes');

        $oReceitaZinc->setClasseBusca('STEEL_PCP_Receitas');
        $oReceitaZinc->setSCampoRetorno('cod', $this->getTela()->getId());
        $oReceitaZinc->addCampoBusca('peca', $oReceitaZincDes->getId(), $this->getTela()->getId());

        $sCallBack = 'requestAjax("' . $this->getTela()->getId() . '-form","STEEL_PCP_OFReceitaZinc","verificaTipoZincagem","");';
        $oReceitaZinc->addEvento(Campo::EVENTO_SAIR, $sCallBack);

        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_TEXTO, 1);
        $oSituacao->setBCampoBloqueado(true);

        $this->addCampos(array($oOp, $oReceitaZinc, $oReceitaZincDes, $oSituacao));
    }

}
