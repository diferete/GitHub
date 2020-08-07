<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_QUAL_AcaoEficazApont extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_QUAL_AcaoEficazApont');
    }

    public function antesDeCriarConsulta($sParametros = null) {
        parent::antesDeCriarConsulta($sParametros);

        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if (count($aCampos) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aCampos['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aCampos['nr']);
        }
    }

    public function sendaDadosCampos($sDados) {
        $aDados = explode(',', $sDados);

        $sChave = htmlspecialchars_decode($aDados[1]);
        $aChaveAq = array();
        parse_str($sChave, $aChaveAq);

        if (count($aChaveAq) > 0) {
            $this->Persistencia->adicionaFiltro('filcgc', $aChaveAq['filcgc']);
            $this->Persistencia->adicionaFiltro('nr', $aChaveAq['nr']);
            $this->Persistencia->adicionaFiltro('seq', $aChaveAq['seq']);
            $this->Model = $this->Persistencia->consultarWhere();

            $this->Model->setAcao(str_replace("\n", " ", $this->Model->getAcao()));
            $this->Model->setAcao(str_replace("'", "\'", $this->Model->getAcao()));
            $this->Model->setAcao(str_replace("\r", "", $this->Model->getAcao()));

            $this->Model->setObs(str_replace("\n", " ", $this->Model->getObs()));
            $this->Model->setObs(str_replace("'", "\'", $this->Model->getObs()));
            $this->Model->setObs(str_replace("\r", "", $this->Model->getObs()));

            echo '$("#' . $aDados[2] . '").val("' . $this->Model->getSeq() . '");';


            echo '$("#' . $aDados[4] . '").val("' . $this->Model->getDataprev() . '");';
            echo '$("#' . $aDados[5] . '").val("' . $this->Model->getAcao() . '");';
            echo '$("#' . $aDados[6] . '").val("' . $this->Model->getDatareal() . '");';
            echo '$("#' . $aDados[7] . '").val("' . $this->Model->getObs() . '");';

            echo '$("#' . $aDados[8] . '").val("' . $this->Model->getEficaz() . '").trigger("change");';
        } else {
            echo '$("#' . $aDados[2] . '").val("");';
        }
    }

    public function apontaEfi($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRet = $this->Persistencia->apontaEfi();
        if ($aRet[0]) {
            $oMensagem = new Mensagem('Sucesso', 'Finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_AcaoEficazApont","getDadosGrid","' . $aDados[1] . '","criaConsultaEf");';
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao finalizar plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function apontaRetEfi($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRet = $this->Persistencia->retEfi();
        if ($aRet[0]) {
            $oMensagem = new Mensagem('Sucesso', 'Retornado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo 'requestAjax("' . $aDados[0] . '","MET_QUAL_AcaoEficazApont","getDadosGrid","' . $aDados[1] . '","criaConsultaEf");';
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

}
