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
            $this->Persistencia->adicionaFiltro('FIL_Codigo', $aParam1[0]);
            $this->Persistencia->adicionaFiltro('SUP_SolicitacaoSeq', $aParam1[1]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('FIL_Codigo', $this->Model->getFIL_Codigo());
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

    public function buscaDadosProd($sDados) {
        $aDados = $this->getArrayCampostela();
        if ($aDados['PRO_Codigo'] == '') {
            exit;
        } else {
            $aIdCampos = explode(',', $sDados);

            $oRetorno = $this->Persistencia->buscaDadosProd($aDados);

            $script = '$("#' . $aIdCampos[0] . '").val("' . trim($oRetorno->pro_unidademedida) . '")';
            echo $script;
        }
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $this->carregaDefault();

        $oQnt = $this->Model->getSUP_SolicitacaoItemComQtd();

        if ($oQnt == '' || $oQnt == null || $oQnt == '0.00' || $oQnt == '0,00') {
            $oMsg = new Mensagem('Atenção', 'Favor inserir uma quantidade diferente de 0,00!', Mensagem::TIPO_WARNING, '8000');
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $this->carregaDefault();

        $oQnt = $this->Model->getSUP_SolicitacaoItemComQtd();

        if ($oQnt == '' || $oQnt == null || $oQnt == '0.00' || $oQnt == '0,00') {
            $oMsg = new Mensagem('Atenção', 'Favor inserir uma quantidade diferente de 0,00!', Mensagem::TIPO_WARNING, '8000');
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    /*
     * Funcao para pegar valores padroes das cargas da classe
     */

    public function carregaDefault() {

        $aDados = array();
        $aDados['PRO_Codigo'] = $this->Model->getPRO_Codigo();
        $oParamDados = $this->Persistencia->buscaDadosProd($aDados);

        $this->Model->setSUP_SolicitacaoItemComConv(1);
        $this->Model->setSUP_SolicitacaoItemQtd($this->Model->getSUP_SolicitacaoItemComQtd());
        $this->Model->setSUP_SolicitacaoItemComUnd($this->Model->getSUP_SolicitacaoItemUnidade());
        $this->Model->setSUP_SolicitacaoItemReferencia('');
        $this->Model->setSUP_SolicitacaoItemValor(0);
        $this->Model->setSUP_SolicitacaoItemDimUnidade('');
        $this->Model->setSUP_SolicitacaoItemDataAprVerb('1753-01-01 00:00:00.000');
        $this->Model->setSUP_SolicitacaoItemValorTotal('0');
        $this->Model->setSUP_SolicitacaoItemDimPecas(0);
        $this->Model->setSUP_SolicitacaoItemDimComprime(0);
        $this->Model->setSUP_SolicitacaoItemDimLargura(0);
        $this->Model->setSUP_SolicitacaoItemDimEspessur(0);

        $this->Model->setSUP_SolicitacaoItemPesoLiq($oParamDados->pro_pesoliquido);
        $this->Model->setSUP_SolicitacaoItemPesoBru($oParamDados->pro_pesobruto);

        $this->Model->setSUP_SolicitacaoItemGrade('');
        $this->Model->setSUP_SolicitacaoItemPlano(0);
        $this->Model->setSUP_SolicitacaoItemConta(null);
        $this->Model->setSUP_SolicitacaoItemProjeto(null);
        $this->Model->setSUP_SolicitacaoItemOriTipo('N');
        $this->Model->setSUP_SolicitacaoItemOriNumero(0);
        $this->Model->setSUP_SolicitacaoItemOriItem(0);
        $this->Model->setSUP_SolicitacaoItemConversor('');
        $this->Model->setSUP_SolicitacaoItemDimConv(0);
        $this->Model->setSUP_SolicitacaoItemDimUndConv(0);
        $this->Model->setSUP_SolicitacaoItemDimGQtd(0);
        $this->Model->setSUP_SolicitacaoItemDimGFormula('');
        $this->Model->setSUP_SolicitacaoItemDimGExpres('');
        $this->Model->setSUP_SolicitacaoItemPosicao(null);
    }

}
