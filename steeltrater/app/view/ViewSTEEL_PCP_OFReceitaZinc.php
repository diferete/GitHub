<?php

/*
 * Classe de alteração da receita zincagem na ordens fabricação
 * @author Cleverton Hoffmann
 * @since 25/02/2021
 */

class ViewSTEEL_PCP_OFReceitaZinc extends View {

    public function criaTela() {
        parent::criaTela();

        $oOp = new Campo('Op nr.', 'op', Campo::TIPO_TEXTO, 1,1);
        $oOp->setBCampoBloqueado(true);

        $oReceitaZinc = new Campo('Cod. Receita Zincagem', 'receita_zinc', Campo::TIPO_BUSCADOBANCOPK, 2,2);
        $oReceitaZinc->setId('Zincar');

        $oReceitaZincDes = new Campo('Des.Rec.Zincagem', 'receita_zincdesc', Campo::TIPO_BUSCADOBANCO, 5,5);
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

        $oTipo = new Campo('Tipo OP', 'tipoOrdem', Campo::CAMPO_SELECTSIMPLE, 3, 3, 3, 3);
        $oTipo->addItemSelect('TZ', 'Têmpera / Zincagem');
       // $oTipo->addItemSelect('Z', 'Zincagem');
        
        $oDescLabel = new Campo('<p><h5 style="color:red">*OP com situação finalizada será colocada em processo</h5></p>','des', Campo::TIPO_LABEL, 2, 2, 2, 2);
        $oDescLabel->setApenasTela(true);
                
        $oPesoCesto = new Campo('Peso Cesto', 'PesoDoCesto', Campo::TIPO_DECIMAL, 1,1);
        $oPesoCesto->setSCorFundo(Campo::FUNDO_AMARELO);
        $oPesoCesto->setId('PesoCestoId');
        
        $oL1 = new Campo('', 'l1', Campo::TIPO_LINHABRANCO);
        $oL1->setApenasTela(true);
        
        $oSituacao = new Campo('Situação', 'situacao', Campo::TIPO_TEXTO, 1,1);
        $oSituacao->setSValor('Processo');
        $oSituacao->setBCampoBloqueado(true);

        $this->addCampos(array($oOp, $oReceitaZinc, $oReceitaZincDes, $oPesoCesto, $oSituacao, $oDescLabel), $oL1, $oTipo);
    }

}
