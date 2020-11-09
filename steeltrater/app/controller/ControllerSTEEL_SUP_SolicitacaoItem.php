<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerSTEEL_SUP_SolicitacaoItem extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('STEEL_SUP_SolicitacaoItem');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        
        $oModel = Fabrica::FabricarModel('STEEL_SUP_Solicitacao');
        $oPers = Fabrica::FabricarPersistencia('STEEL_SUP_Solicitacao');
        $oPers->setModel($oModel);
        $oPers->adicionaFiltro('FIL_Codigo', $aChave[0]);
        $oPers->adicionaFiltro('SUP_SolicitacaoSeq', $aChave[1]);
        $oModel = $oPers->consultarWhere();

        $aCampos[] = $oModel->getFIL_Codigo();
        $aCampos[] = $oModel->getSUP_SolicitacaoSeq();

        $this->View->setAParametrosExtras($aCampos);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aParam1 = explode(',', $this->getParametros());
        $aParam = $this->View->getAParametrosExtras();
        if (count($aParam) > 0) {
            $this->Persistencia->adicionaFiltro('FIL_Codigo', $aParam[0]);
            $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aParam[1]);
            $this->Persistencia->setChaveIncremento(false);
        } else {
            $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aParam1[0]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('SUP_SolicitacaoItemSeq', $this->Model->getSUP_SolicitacaoItemSeq());
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);

        $sScript = '$("#' . $sForm . '").each(function(){this.reset();});';
        echo $sScript;
    }

    public function antesDeCriarTela($sParametros = null) {
        parent::antesDeCriarTela($sParametros);

        $oPrioridades = $this->Persistencia->buscaPrioridades();
        
        $this->View->setOObjTela($oPrioridades);
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $value) {
            $aCampoAtual = explode('=', $value);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }
        $this->Persistencia->setChaveIncremento(false);
    }

    public function buscaDadosUnidade($sDados) {
        $aDados = $this->getArrayCampostela();
        if ($aDados['PRO_Codigo'] == '') {
            exit;
        } else {
            $aIdCampos = explode(',', $sDados);

            $oRetorno = $this->Persistencia->buscaDadosUnidade($aDados);

            $script = '$("#' . $aIdCampos[0] . '").val("' . trim($oRetorno->pro_unidademedida) . '")';
            echo $script;
        }
    }

}
