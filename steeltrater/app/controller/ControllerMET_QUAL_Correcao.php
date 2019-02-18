<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_QUAL_Correcao extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_Correcao');
        $this->setControllerDetalhe('MET_QUAL_QualCausa');
        $this->setSMetodoDetalhe('criaPainelCausa');
    }

    /**
     * Cria tela 
     * @param type $sDados
     * @param type $sCampos
     */
    public function criaPainelCorrecao($sDados, $sCampos) {
        $aDados = explode(',', $sDados);
        $aCampos = explode(',', $sCampos);
        $this->pkDetalhe($aCampos);
        $this->parametros = $sCampos;

		$this->View->setSIdHideEtapa($aDados[4]);
        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $aDados[2], $aDados[3], $aDados[4], $aDados[5], $this->getControllerDetalhe(), $this->getSMetodoDetalhe());
        $this->View->getTela()->getRender();
    }

    /* Métodos de filtros below */

    public function pkDetalhe($aChave) {
        parent::pkDetalhe();
        $sTipoAcao = $this->Persistencia->buscaTipoAcao($aChave);
        $aCampos = $aChave;
        $aCampos[3] = $sTipoAcao;
        $this->View->setAParametrosExtras($aCampos);
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

    public function adicionaFiltroDet() {
        parent::adicionaFiltroDet();

        $this->Persistencia->adicionaFiltro('seq', $this->Model->getSeq());
    }

    public function acaoLimpar($sForm, $sDados) {
        parent::acaoLimpar($sDados);
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

        $this->Persistencia->setChaveIncremento(false);
    }

    public function antesCarregaDetalhe($aCampos) {
        parent::antesCarregaDetalhe($aCampos);
        echo $sRetorno;
        unset($aCampos[8]);
        return $aCampos;
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
        parent::afterUpdate();
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

        $this->Persistencia->deletaCorrecao($this->Model->getFilcgc(), $this->Model->getNr(), $this->Model->getSeq());
        $aRetorno[0] = true;

        return $aRetorno;
    }

    public function carregaProb($sDados) {
        $aDados = explode(',', $sDados);
        $aPlano = explode('=', $aDados[1]);

        $this->Persistencia->adicionaFiltro($aPlano[0], $aPlano[1]);
        $oDados = $this->Persistencia->consultarWhere();

        $oDados->setPlano(str_replace("\n", " ", $oDados->getPlano()));
        $oDados->setPlano(str_replace("'", "\'", $oDados->getPlano()));
        $oDados->setPlano(str_replace("\r", "", $oDados->getPlano()));
        $oDados->setPlano(str_replace('"', '\"', $oDados->getPlano()));

        $sPlano = $oDados->getPlano();
        echo '$("#' . $aDados[2] . '").val("' . $sPlano . '");';
    }

}
