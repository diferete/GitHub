<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_ISO_FuncDesc extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_ISO_FuncDesc');
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $this->View->setAParametrosExtras($aChave);
    }

    public function adicionaFiltrosExtras() {
        parent::adicionaFiltrosExtras();
        $aparam1 = explode(',', $this->getParametros());
        $aparam = $this->View->getAParametrosExtras();
        if (count($aparam) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam[1]);
            $this->Persistencia->setChaveIncremento(false);
        } else {
            $this->Persistencia->adicionaFiltro('filcgc', $aparam1[0]);
            $this->Persistencia->adicionaFiltro('nr', $aparam1[1]);
            $this->Persistencia->setChaveIncremento(false);
        }
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sForm, $sDados);
        $aParam = explode(',', $sDados);

        //verifica se está como 
        $sScript = '$("#' . $sForm . '").each (function(){ this.reset();});';
        echo $sScript;
    }

    public function filtroReload($aChave) {
        parent::filtroReload($aChave);
        $aCampos = explode('&', $aChave);
        unset($aCampos[2]);
        foreach ($aCampos as $key => $sCampoAtual) {
            $aCampoAtual = explode('=', $sCampoAtual);
            $aModel = explode('.', $aCampoAtual[0]);
            $this->Persistencia->adicionaFiltro($aModel[0], $aCampoAtual[1]);
        }
    }

    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        unset($aCampos[8]);
        return $aCampos;
    }

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();

        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    public function afterInsert() {
        parent::afterInsert();


        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        $sRetorno = "$('#" . $aDados[4] . "').fileinput('clear');";
        echo $sRetorno;

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterUpdate() {
        parent::afterInsert();

        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        $sRetorno = "$('#" . $aDados[4] . "').fileinput('clear');";
        echo $sRetorno;

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterDelete() {
        parent::afterDelete();

        $this->Persistencia->deletaDescricao($this->Model->getFilcgc(), $this->Model->getNr(), $this->Model->getSeq());

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function carregaObs($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);

        $oDados = $this->Persistencia->consultarWhere();


        $oDados->setObservacao(str_replace("\n", " ", $oDados->getObservacao()));
        $oDados->setObservacao(str_replace("'", "\'", $oDados->getObservacao()));
        $oDados->setObservacao(str_replace("\r", "", $oDados->getObservacao()));
        $oDados->setObservacao(str_replace('"', '\"', $oDados->getObservacao()));

        echo '$("#' . $aDados[2] . '").val("' . $oDados->getObservacao() . '");';
    }

    public function afterInsertDetalhe() {
        parent::afterInsertDetalhe();

        $script = 'if ($("#GridTreinamentos-pesq").length){'
                . '$("#GridTreinamentos-pesq").click();}'
                . 'else{};';
        echo $script;

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterAlterarDetalhe() {
        parent::afterAlterarDetalhe();

        $script = 'if ($("#GridTreinamentos-pesq").length){'
                . '$("#GridTreinamentos-pesq").click();}'
                . 'else{};';
        echo $script;

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

}
