<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerQualAta extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('QualAta');
    }

    public function apontAta($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $this->carregaModel($aCamposTela);

        $aRetorno = $this->Persistencia->inserir();
        //insere os filtros 
        $this->Persistencia->adicionafiltro('filcgc', $aCampos['filcgc']);
        $this->Persistencia->adicionafiltro('nr', $aCampos['nr']);
        $iCont = $this->Persistencia->getcount();
        $iCont ++;
        if ($aRetorno[0]) {
            $oMensagem = new Mensagem('Sucesso', 'Inserido com sucesso!', Mensagem::TIPO_SUCESSO);
            echo $oMensagem->getRender();
            $sLimpa = '$("#' . $aDados[0] . '").each (function(){ this.reset();});';
            echo $sLimpa;
            echo '$("#' . $aDados[2] . '").val("' . $iCont . '");';
            echo 'requestAjax("' . $aDados[0] . '","QualAta","getDadosGrid","' . $aDados[1] . '","consultaAta");';
            echo "$('#" . $aDados[3] . "').fileinput('clear');";
        } else {
            $oMensagem = new Modal('Problema', 'Problemas ao retorna plano de ação' . $aRetorno[1], Modal::TIPO_ERRO, false, true, true);
            echo $oMensagem->getRender();
        }
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

    public function excluirAta($sDados) {

        $aDados = explode(',', $sDados);
        $aRetorno[0] = true;
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aChave = explode(',', $sChave);

        $this->Persistencia->iniciaTransacao();
        $this->carregaModelString($aChave[0]);
        $this->Model = $this->Persistencia->consultar();

        $aRetorno = $this->Persistencia->excluir(true);
        if ($aRetorno[0]) {
            $this->Persistencia->commit();
            $oMensagemSucesso = new Mensagem('Sucesso!', 'Seu registro foi deletado...', Mensagem::TIPO_SUCESSO);
            echo $oMensagemSucesso->getRender();
            echo 'requestAjax("' . $aDados[0] . '","QualAta","getDadosGrid","' . $aDados[1] . '","consultaAta");';
        } else {
            $oMensagemErro = new Mensagem('Falha', 'O registro não foi excluído!', Mensagem::TIPO_ERROR);
            echo $oMensagemErro->getRender();
        }
    }

}
