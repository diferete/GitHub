<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_QUAL_QualCausa extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_QualCausa');
        $this->setControllerDetalhe('MET_QUAL_QualPlan');
        $this->setSMetodoDetalhe('criaQualAqPlan');
    }

    /**
     * Cria tela 
     * @param type $sDados
     * @param type $sCampos
     */
    public function criaPainelCausa($sDados, $sCampos) {
        $aDados = explode(',', $sDados);
        $aCampos = explode(',', $sCampos);
         if ($aDados[6] != '') {
            $this->View->setSRotina($aDados[6]);
        }
        $this->pkDetalhe($aCampos);
        $this->parametros = $sCampos;

        $this->View->criaTela();
        $this->View->getTela()->setSRender($aDados[3]);
        //define o retorno somente do form
        $this->View->getTela()->setBSomanteForm(true);
        //seta o controler na view
        $this->View->setTelaController($this->View->getController());
        $this->View->adicionaBotoesEtapas($aDados[0], $aDados[1], $aDados[2], $aDados[3], $aDados[4], $aDados[5], $this->getControllerDetalhe(), $this->getSMetodoDetalhe(), $aDados[6]);
        //carrega campos 
        $oDiagramaCausa = Fabrica::FabricarController('MET_QUAL_DiagramaCausa');
        $oDiagramaCausa->Persistencia->adicionaFiltro('filcgc', $aCampos[0]);
        $oDiagramaCausa->Persistencia->adicionaFiltro('nr', $aCampos[1]);

        $oDiagramaCausa->Model = $oDiagramaCausa->Persistencia->consultarWhere();

        $this->Model->setFilcgc($oDiagramaCausa->Model->getFilcgc());
        $this->Model->setNr($oDiagramaCausa->Model->getNr());
        $this->Model->setMatprimades($oDiagramaCausa->Model->getMatprimades());
        $this->Model->setMetododes($oDiagramaCausa->Model->getMetododes());
        $this->Model->setMaodeobrades($oDiagramaCausa->Model->getMaodeobrades());
        $this->Model->setEquipamentodes($oDiagramaCausa->Model->getEquipamentodes());
        $this->Model->setMeioambientedes($oDiagramaCausa->Model->getMeioambientedes());
        $this->Model->setMedidades($oDiagramaCausa->Model->getMedidades());

        foreach ($this->View->getTela()->getCampos() as $oCampo) {
            $sValor = $oCampo->getNome();

            switch ($sValor) {
                case 'filcgc': '';
                    break;

                case 'nr': '';
                    break;

                default : $this->verificaCarregarCampo($oCampo);
            }
        }

        $this->View->getTela()->getRender();
    }

    public function pkDetalhe($aChave) {
        parent::pkDetalhe($aChave);
        $aCampos = $aChave;
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

        return $aCampos;
    }

    public function afterInsert() {
        parent::afterInsert();

        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        //$sRetorno = "$('#".$aDados[4]."').fileinput('clear');";
        // echo $sRetorno;
        //atualiza ocorrencias
        $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();

        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc, $sNr, $sSeq);

        //marca o campo select
        $sTrigger = '$("#' . $aDados[4] . '").val("Matéria prima").trigger("change");';
        echo $sTrigger;


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
        //marca o campo select
        $sTrigger = '$("#' . $aDados[4] . '").val("Matéria prima").trigger("change");';
        echo $sTrigger;

        $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();

        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc, $sNr, $sSeq);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterDelete() {
        parent::afterDelete();

        $sFilcgc = $this->Model->getFilcgc();
        $sNr = $this->Model->getNr();
        $sSeq = $this->Model->getSeq();

        $aRet = $this->Persistencia->atualizaOcorrencia($sFilcgc, $sNr, $sSeq);

        $aRetorno = array();
        $aRetorno[0] = true;
        $aRetorno[1] = '';
        return $aRetorno;
    }

    public function afterResetForm($sDados) {
        parent::afterResetForm($sDados);

        foreach ($_REQUEST['parametros'] as $key => $value) {
            $aDados = explode(',', $value);
        }
        //marca o campo select
        $sTrigger = '$("#' . $aDados[4] . '").val("Matéria prima").trigger("change");';
        echo $sTrigger;
    }

    public function carregaCausa($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[1]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $this->Persistencia->adicionaFiltro('seq', $aCamposChave['seq']);

        $oDados = $this->Persistencia->consultarWhere();

        $oDados->setPq1(str_replace("\n", " ", $oDados->getPq1()));
        $oDados->setPq1(str_replace("'", "\'", $oDados->getPq1()));
        $oDados->setPq1(str_replace("\r", "", $oDados->getPq1()));
        $oDados->setPq1(str_replace('"', '\"', $oDados->getPq1()));

        $oDados->setPq2(str_replace("\n", " ", $oDados->getPq2()));
        $oDados->setPq2(str_replace("'", "\'", $oDados->getPq2()));
        $oDados->setPq2(str_replace("\r", "", $oDados->getPq2()));
        $oDados->setPq2(str_replace('"', '\"', $oDados->getPq2()));

        $oDados->setPq3(str_replace("\n", " ", $oDados->getPq3()));
        $oDados->setPq3(str_replace("'", "\'", $oDados->getPq3()));
        $oDados->setPq3(str_replace("\r", "", $oDados->getPq3()));
        $oDados->setPq3(str_replace('"', '\"', $oDados->getPq3()));

        $oDados->setPq4(str_replace("\n", " ", $oDados->getPq4()));
        $oDados->setPq4(str_replace("'", "\'", $oDados->getPq4()));
        $oDados->setPq4(str_replace("\r", "", $oDados->getPq4()));
        $oDados->setPq4(str_replace('"', '\"', $oDados->getPq4()));

        $oDados->setPq5(str_replace("\n", " ", $oDados->getPq5()));
        $oDados->setPq5(str_replace("'", "\'", $oDados->getPq5()));
        $oDados->setPq5(str_replace("\r", "", $oDados->getPq5()));
        $oDados->setPq5(str_replace('"', '\"', $oDados->getPq5()));

        echo '$("#' . $aDados[2] . '").val("' . $oDados->getPq1() . '");';
        echo '$("#' . $aDados[3] . '").val("' . $oDados->getPq2() . '");';
        echo '$("#' . $aDados[4] . '").val("' . $oDados->getPq3() . '");';
        echo '$("#' . $aDados[5] . '").val("' . $oDados->getPq4() . '");';
        echo '$("#' . $aDados[6] . '").val("' . $oDados->getPq5() . '");';
    }

}
