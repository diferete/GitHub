<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ControllerMET_PORT_Transito extends Controller {

    public function __construct() {
        $this->carregaClassesMvc('MET_PORT_Transito');
    }

    public function antesAlterar($sParametros = null) {
        parent::antesAlterar($sParametros);

        $sChave = htmlspecialchars_decode($sParametros[0]);
        $this->carregaModelString($sChave);
        $this->Model = $this->Persistencia->consultar();

        $oSit = $this->Model->getSituaca();

        if ($oSit == 'Saída') {
            $oMensagem = new Modal('Atenção!', 'O trânsito Nº' . $this->Model->getNr() . ' não pode ser modificadao somente visualizado!', Modal::TIPO_ERRO, false, true, true);
            $this->setBDesativaBotaoPadrao(true);
            echo $oMensagem->getRender();
        }
    }

    public function buscaPlaca($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaPlaca($aCamposChave['placa']);

        echo"$('#" . $aParam[0] . "').val('" . strtoupper($aCamposChave['placa']) . "');"
        . "$('#" . $aParam[1] . "').val('" . $oRow->empcod . "');"
        . "$('#" . $aParam[2] . "').val('" . $oRow->empdes . "');"
        . "$('#" . $aParam[3] . "').val('" . $oRow->descsetor . "');"
        . "$('#" . $aParam[4] . "').val('" . $oRow->modelo . "');"
        . "$('#" . $aParam[5] . "').val('" . $oRow->cor . "');";
    }

    public function criaTelaModalApontaSaida($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'Saída') {
            $oMsg = new Modal('Atenção', 'Esse caminhão já teve sua saída apontada!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontaSaida-btn').click();";
            echo $oMsg->getRender();
        } else {
            $this->View->setAParametrosExtras($oDados);

            $this->View->criaModalApontaSaida();
            //busca lista pela op

            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        }
    }

    public function apontaSaida($sDados) {
        $aDados = explode(',', $sDados);
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de veículo apondata com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontaSaida-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

}
