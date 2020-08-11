<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualAqApont extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualAqApont');
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
            $this->Model->setPlano(str_replace("\n", " ", $this->Model->getPlano()));
            $this->Model->setPlano(str_replace("'", "\'", $this->Model->getPlano()));
            $this->Model->setPlano(str_replace("\r", "", $this->Model->getPlano()));

            $this->Model->setObsfim(str_replace("\n", " ", $this->Model->getObsfim()));
            $this->Model->setObsfim(str_replace("'", "\'", $this->Model->getObsfim()));
            $this->Model->setObsfim(str_replace("\r", "", $this->Model->getObsfim()));


            echo "$('#" . $aDados[2] . "').val('" . $this->Model->getSeq() . "');";
            echo "$('#" . $aDados[3] . "').val('" . $this->Model->getPlano() . "');";
            echo "$('#" . $aDados[4] . "').val('" . $this->Model->getDatafim() . "');";
            echo "$('#" . $aDados[5] . "').val('" . $this->Model->getObsfim() . "');";
        } else {
            echo "$('#" . $aDados[2] . "').val('');";
        }
    }

    public function apontaPlanoAcao($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        $aRet = $this->Persistencia->apontaPlano();
        if ($aRet[0]) {
            $oMensagem = new Mensagem('Sucesso', 'Finalizado com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo 'requestAjax("' . $aDados[0] . '","QualAqApont","getDadosGrid","' . $aDados[1] . '","criaConsutaApont");';
            $sRetorno = "$('#" . $aDados[2] . "').fileinput('clear');";
            echo $sRetorno;
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao finalizar plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
    }

    public function apontaRetAberto($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);
        if ($aCampos['seq'] == '') {
            $oMensagem = new Modal('Problema', 'Selecione um registro para retornar!', Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        } else {
            $aRet = $this->Persistencia->retPlano();
            if ($aRet[0]) {
                $oMensagem = new Mensagem('Sucesso', 'Retornado com sucesso!', Mensagem::TIPO_SUCESSO);
                echo $oMensagem->getRender();
                $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
                echo $sLimpa;
                echo 'requestAjax("' . $aDados[0] . '","QualAqApont","getDadosGrid","' . $aDados[1] . '","criaConsutaApont");';
            } else {
                $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
                echo $oMensagem->getRender();
            }
        }
    }

}
