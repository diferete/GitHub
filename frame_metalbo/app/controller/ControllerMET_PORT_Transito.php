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

    public function beforeInsert() {
        parent::beforeInsert();

        $sModelo = $this->Model->getMotivo();

        if ($sModelo != 'Selecionar') {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        } else {
            $oMsg = new Mensagem('Atenção', 'Favor selecionar um motivo!', Mensagem::TIPO_WARNING);
            echo $oMsg->getRender();

            $aRetorno = array();
            $aRetorno[0] = false;
            $aRetorno[1] = '';
            return $aRetorno;
        }
    }

    public function afterInsert() {
        parent::afterInsert();

        $oModel = $this->Model;


        $this->Persistencia->cadPlaca($oModel);

        $this->Persistencia->cadCpf($oModel);

        if ($oModel->getMotivo() == '1') {
            $aRetorno = $this->Persistencia->geraCadastro($oModel);
            if ($aRetorno) {
                $aRetorno = array();
                $aRetorno[0] = true;
                $aRetorno[1] = '';
                return $aRetorno;
            } else {
                $aRetorno = array();
                $aRetorno[0] = false;
                $aRetorno[1] = '';
                return $aRetorno;
            }
        } else {
            $aRetorno = array();
            $aRetorno[0] = true;
            $aRetorno[1] = '';
            return $aRetorno;
        }
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
    
    public function buscaCpf($sDados) {
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        if ($aCamposChave['cpf'] == '') {
            return;
        } else {
            $this->consultaCpf($sDados);
        }
    }

    public function consultaCpf($sDados) {
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oConsulta = $this->Persistencia->consultaCpf($aCamposChave);

        echo"$('#" . $aDados[0] . "').val('" . $oConsulta->nome . "');"
        . "$('#" . $aDados[1] . "').val('" . $oConsulta->fone . "');";
    }

    public function buscaPlaca($sDados) {
        $aParam = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($_REQUEST['campos']);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $oRow = $this->Persistencia->consultaPlaca($aCamposChave['placa']);

        echo"$('#" . $aParam[0] . "').val('" . strtoupper($aCamposChave['placa']) . "');"
        . "$('#" . $aParam[1] . "').val('" . $oRow->empcod . "');"
        . "$('#" . $aParam[2] . "').val('" . $oRow->empdes . "');";
    }

    public function criaTelaModalApontamento($sDados) {
        $this->View->setSRotina(View::ACAO_ALTERAR);
        $aDados = explode(',', $sDados);
        $sChave = htmlspecialchars_decode($aDados[2]);
        $aCamposChave = array();
        parse_str($sChave, $aCamposChave);

        $this->Persistencia->adicionaFiltro('filcgc', $aCamposChave['filcgc']);
        $this->Persistencia->adicionaFiltro('nr', $aCamposChave['nr']);
        $oDados = $this->Persistencia->consultarWhere();

        if ($oDados->getSituaca() == 'Chegada' || $oDados->getSituaca() == 'Entrada') {

            $this->View->setAParametrosExtras($oDados);

            if ($oDados->getSituaca() == 'Chegada') {
                $this->View->criaModalApontaEntrada();
            }
            if ($oDados->getSituaca() == 'Entrada') {
                $this->View->criaModalApontaSaida();
            }

            //busca lista pela op
            $this->View->getTela()->setSRender($aDados[0] . '-modal');

            //renderiza a tela
            $this->View->getTela()->getRender();
        } else {
            $oMsg = new Modal('Atenção', 'Esse caminhão já seu apontamento efetuado!', Modal::TIPO_AVISO, false, true, false);
            echo "$('#criaModalApontamento-btn').click();";
            echo $oMsg->getRender();
        }
    }

    public function apontaEntrada() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaEntrada($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Entrada de veículo apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamento-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

    public function apontaSaida() {
        $aCampos = array();
        parse_str($_REQUEST['campos'], $aCampos);

        $aRetorno = $this->Persistencia->apontaSaida($aCampos);

        if ($aRetorno == true) {
            $oMsg = new Mensagem('Sucesso', 'Saída de veículo apontada com sucesso', Mensagem::TIPO_SUCESSO);
            echo "$('#criaModalApontamento-btn').click();";
        } else {
            $oMsg = new Mensagem('Erro', 'Erro ao inserir o registro, tente novamente!', Mensagem::TIPO_ERROR);
        }
        echo $oMsg->getRender();
    }

}
