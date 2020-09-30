<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_TEC_Updates extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_TEC_Updates');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $aChave[1] = $this->Persistencia->getDadosVersao($aChave);
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aParam1 = explode(',', $this->getParametros());
        $aParam = $this->View->getAParametrosExtras();
        if (count($aParam) > 0) {
            $this->Persistencia->adicionaFiltro('seq', $aParam[0]);
        } else {
            $this->Persistencia->adicionaFiltro('seq', $aParam1[0]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();
        $this->Persistencia->adicionaFiltro('sequpdates', $this->Model->getSeqUpdates());
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);

        $sScript = '$("#' . $sForm . '").each(function(){this.reset();});';
        echo $sScript;
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[1]);
        foreach ($aCampos as $key => $value) {
            $aCampoAtual = explode('=', $value);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }
    }

    public function beforeInsert() {
        parent::beforeInsert();

        $sQuemVe = $this->Model->getTodos();
        if ($sQuemVe == 'true') {
            $this->Model->setCodsetor(00);
            $this->Model->setDescsetor('TODOS');
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function beforeUpdate() {
        parent::beforeUpdate();

        $sQuemVe = $this->Model->getTodos();
        if ($sQuemVe == 'true') {
            $this->Model->setCodsetor(00);
            $this->Model->setDescsetor('TODOS');
        }

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        unset($aCampos[7]);
        return $aCampos;
    }

    public function getDadosUpdates() {
        $aVersoes = $this->Persistencia->getDadosVersoes();
        return $aVersoes;
    }

}
