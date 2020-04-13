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
        if ($aDados[6] != '') {
            $this->View->setSRotina($aDados[6]);
        }

		$this->View->setSIdHideEtapa($aDados[4]);
        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $aDados[2], $aDados[3], $aDados[4], $aDados[5], $this->getControllerDetalhe(), $this->getSMetodoDetalhe(), $aDados[6]);
        $this->View->getTela()->getRender();
    }

    /* Métodos de filtros below */

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

        $this->Persistencia->setChaveIncremento(false);
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $sTipoAcao = $this->Persistencia->buscaTipoAcao($aChave);
        $aCampos = $aChave;
        $aCampos[3] = $sTipoAcao;
        $this->View->setAParametrosExtras($aCampos);
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

    public function criaTelaModalApontaCorrecao($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $aChave = explode('&', $aDados[2]);
        $aFilcgc = explode('=', $aChave[0]);
        $aNr = explode('=', $aChave[1]);
        $aSeq = explode('=', $aChave[2]);

        $aParam = array();
        $aParam[0] = $aFilcgc[1];
        $aParam[1] = $aNr[1];
        $aParam[2] = $aSeq[1];

        $this->Persistencia->adicionaFiltro('filcgc', $aParam[0]);
        $this->Persistencia->adicionaFiltro('nr', $aParam[1]);
        $this->Persistencia->adicionaFiltro('seq', $aParam[2]);
        $oDados = $this->Persistencia->consultarWhere();


        $this->View->setAParametrosExtras($oDados);

        $this->View->criaModalApontaCorrecao();
        //busca lista pela op

        $this->View->getTela()->setSRender($aDados[0] . '-modal');

        //renderiza a tela
        $this->View->getTela()->getRender();
}

    public function apontaCorrecao($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['dtaponta'] != null && $aCampos['apontamento'] != null) {
            $aRet = $this->Persistencia->apontaCorrecao();
            if ($aRet[0]) {
                $oMensagem = new Mensagem('Sucesso', 'Finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
                $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
                echo $sLimpa;
                echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_Correcao","getDadosGrid","' . $aDados[1] . '","criaConsutaApont");';
                $sRetorno = "$('#" . $aDados[2] . "').fileinput('clear');";
                echo $sRetorno;
            } else {
                $oMensagem = new Modal('Problema', 'Problemas ao finalizar' . $aRet[1], Modal::TIPO_ERRO, false, true, true);
            }
        } else {
            $oMensagem = new Mensagem('Aviso', 'Favor preencher todos os campos', Mensagem::TIPO_WARNING);
        }
        echo $oMensagem->getRender();
    }

    public function apontaRetAberto($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['seq'] == '') {
            $oMensagem = new Modal('Problema', 'Selecione um registro para retornar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            $aRet = $this->Persistencia->retCorrecao();
            if ($aRet[0]) {
                $oMensagem = new Mensagem('Sucesso', 'Retornado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
                echo $sLimpa;
                echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_Correcao","getDadosGrid","' . $aDados[1] . '","criaConsutaApont");';
            } else {
                $oMensagem = new Modal('Problema', 'Problemas ao retornar para aberto' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

}
